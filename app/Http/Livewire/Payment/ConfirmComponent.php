<?php

namespace App\Http\Livewire\Payment;

use App\Http\Traits\CartTrait;
use App\Http\Controllers\StripePaymentService;
use App\Mail\OrderShipped;
use Livewire\Component;
use App\Models\UserOrder;
use App\Models\DeliveryMethod;
use Illuminate\Support\Facades\Mail;
use App\Models\RateTransportation;

class ConfirmComponent extends Component
{
    use CartTrait;

    public $order_number;
    public $delivery_method;
    public $amount;
    public $transportation = 0;
    public $method;
    public $stripeKey;
    public $clientSecret;
    public $paymentIntentId;

    protected $listeners = ['refreshConfirm' => '$refresh'];

    public function mount($method = 1)
    {
        $this->delivery_method = DeliveryMethod::findOrFail($method);
        $this->order_number = $this->generateOrderNumber();
        $this->method = $method;
    }

    public function mountConfirm()
    {
        $this->cartsTrait();

        $this->amount = $this->total_amount;

        if($this->method == 2) {
            $rateTransportation = RateTransportation::whereMunicipality($this->contact->municipality_id)->first();
            if($rateTransportation) {
                $this->transportation = $rateTransportation->amount;
            }
        }

        if ($this->total_products == 0) {
            return redirect()->route('cart.details');
        }

        $this->stripeKey = config('services.stripe.key');

        if (!$this->paymentIntentId) {
            $stripe = app(StripePaymentService::class);
            $paymentIntent = $stripe->createPaymentIntent($this->amount + $this->transportation, $this->order_number);

            if (isset($paymentIntent->errorCode)) {
                $this->addError('payment', $paymentIntent->errorMessage);
                return;
            }

            $this->paymentIntentId = $paymentIntent->id;
            $this->clientSecret = $paymentIntent->client_secret;
        }
    }

    public function generateOrderNumber()
    {
        $number = strtoupper(substr(sha1(rand(1, 999)), 0, -30));
        $order = UserOrder::where('number', $number)->get();
        return $order->count() > 0 ? $this->generateOrderNumber() : $number;
    }

    public function paymentConfirm($paymentIntentId, StripePaymentService $stripe) {
        $paymentIntent = $stripe->retrievePaymentIntent($paymentIntentId);

        if (!isset($paymentIntent->status) || $paymentIntent->status !== 'succeeded') {
            $this->addError('payment', __('We could not verify the payment with the payment gateway.'));
            return;
        }

        $user_order = $this->user->userOrder()->create([
            'number' => $this->order_number,
            'order_status_id' => 1,
            'delivery_method_id' => $this->delivery_method->id,
            'payment' => true,
            'user_contact_id' => $this->contact->id,
            'stripe_payment_intent_id' => $paymentIntent->id,
            'amount' => $this->amount + $this->transportation,
        ]);
        $this->purchasedProduct($user_order);
        $this->emit('deleteUserJob');
        $this->emit('refreshCart');
        Mail::to($this->user)
            ->cc($this->contact)
            ->bcc(config('mail.from.address'))
            ->send(new OrderShipped($user_order));
    }

    public function purchasedProduct($user_order)
    {
        foreach ($this->user->cart as $cart) {
            $user_order->userPurchasedProduct()->create([
                'product_id' => $cart->product_id,
                'units'  => $cart->units,
                'price'  => $cart->price,
                'amount' => $cart->units*$cart->price,
            ]);

            $cart->delete();
        }
    }

    public function render()
    {
        $this->mountConfirm();
        return view('livewire.payment.confirm-component')
            ->layout('layouts.app', ['title' => __('Confirm Order')]);
    }
}
