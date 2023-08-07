<?php

namespace App\Http\Livewire\Payment;

use App\Http\Traits\CartTrait;
use App\Mail\OrderShipped;
use Livewire\Component;
use App\Models\UserOrder;
use App\Models\DeliveryMethod;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UPagosDirectService;

class ConfirmComponent extends Component
{
    use CartTrait;

    public $first_name;
    public $last_name;
    public $address;
    public $postal_code;
    public $order_number;
    public $delivery_method;
    public $card_number;
    public $exp_date;
    public $cvv2cvc2;
    public $amount;

    protected $listeners = ['refreshConfirm' => '$refresh'];

    public function mount($method = 1)
    {
        $this->delivery_method = DeliveryMethod::findOrFail($method);

        $this->order_number = $this->generateOrderNumber();
    }

    public function mountConfirm()
    {
        $this->cartsTrait();

        $this->first_name = $this->user->name;
        $this->last_name = $this->user->last_name;
        $this->amount = $this->total_amount;

        if ($this->total_products == 0) {
            return redirect()->route('cart.details');
        }
    }

    public function generateOrderNumber()
    {
        $number = strtoupper(substr(sha1(rand(1, 999)), 0, -30));

        $order = UserOrder::where('number', $number)->get();

        return $order->count() > 0 ? $this->generateOrderNumber() : $number;
    }

    public function paymentConfirm() {
        $user_order = $this->user->userOrder()->create([
            'number' => $this->order_number,
            'order_status_id' => 1,
            'delivery_method_id' => $this->delivery_method->id,
            'payment' => true,
            'user_contact_id' => $this->contact->id,
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

        return view('livewire.payment.confirm-component');
    }
}
