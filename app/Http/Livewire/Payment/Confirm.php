<?php

namespace App\Http\Livewire\Payment;

use App\Http\Controllers\PaymentElavon;
use App\Http\Traits\CartTrait;
use App\Mail\OrderShipped;
use Livewire\Component;
use App\Models\UserOrder;
use App\Models\DeliveryMethod;
use Illuminate\Support\Facades\Mail;

class Confirm extends Component
{
    use CartTrait;

    public $order_number;
    public $delivery_method;
    public $firstName;
    public $lastName;
    public $number;
    public $expiryMonth;
    public $expiryYear;
    public $cvv;

    protected $listeners = ['refreshConfirm' => '$refresh'];

    protected $rules = [
        'number' => 'required|numeric|digits_between:8,16',
        'expiryMonth' => 'required|date_format:m',
        'expiryYear' => 'required|digits:4|date_format:Y',
        'cvv' => 'required',
    ];

    public function mount($method = 1)
    {
        $this->delivery_method = DeliveryMethod::findOrFail($method);
        $this->order_number = $this->generateOrderNumber();
    }

    public function mountConfirm()
    {
        $this->cartsTrait();
        if($this->total_products == 0) return redirect()->route('cart.details');
    }

    public function generateOrderNumber()
    {
        $number = strtoupper(substr(sha1(rand(1,999)),0,-30));

        $order = UserOrder::where('number', $number)->get();

        return $order->count() > 0 ? $this->generateOrderNumber() : $number;
    }

    public function paymentConfirm()
    {
        $validate = $this->validate();

        try {
            $this->validate(['contact' => 'required']);

            //$payment = new PaymentElavon($this->total_amount, $validate);

            $user_order = $this->user->userOrder()->create([
                'number' => $this->generateOrderNumber(),
                'order_status_id' => 1,
                'delivery_method_id' => $this->delivery_method->id,
                'payment' => false,
                'user_contact_id' => $this->contact->id,
            ]);

            $this->purchasedProduct($user_order);

            $this->emit('deleteUserJob');

            Mail::to($this->user)
                ->cc($this->contact)
                ->bcc(config('mail.from.address'))
                ->send(new OrderShipped($user_order));

            $this->emit('openModal', 'payment.success-payment', ['message' => $payment]);

        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['message' => $th->getMessage()]);
        }
    }

    public function purchasedProduct($user_order)
    {
        foreach($this->user->cart as $cart)
        {
            $user_order->userPurchasedProduct()->create([
                'product_id' => $cart->product_id,
                'units' => $cart->units,
                'price' => $cart->price,
            ]);

            $cart->delete();
        }
    }

    public function render()
    {
        $this->mountConfirm();

        return view('livewire.payment.confirm');
    }
}
