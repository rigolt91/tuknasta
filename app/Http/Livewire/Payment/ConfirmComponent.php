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
    public $cvv2cvv2;
    public $amount;

    protected $listeners = ['refreshConfirm' => '$refresh'];

    protected $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'address' => 'required|string',
        'postal_code' => 'required|numeric|digits_between:0,10',
        'order_number' => 'required|string',
        'delivery_method' => 'required',
        'card_number' => 'required|numeric|digits_between:8,16',
        'exp_date' => 'required|string|digits_between:1,5',
        'cvv2cvv2' => 'required',
        'amount' => 'required',
    ];

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

    public function paymentConfirm()
    {
        $this->validate();

        try {
            /*$data = array(
                'card_number' => $this->number,
                'exp_date'    => $this->exp_date,
                'cvv2cvv2'    => $this->cvv2cvv2,
                'first_name'  => $this->user->name,
                'last_name'   => $this->user->last_name,
                'amount'      => $this->total_amount,
                'description' => 'This is a test purchase transaction.',
            );

            $response = $uPagosDirect->postData('creditcard/sale', $data);

            if ($response->result == 0) {
                $user_order = $this->user->userOrder()->create([
                    'card_number' => $this->generateOrderNumber(),
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
            } else {
                $this->emit('openModal', 'error-modal-component', ['message' => $response->result_message]);
            }*/
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal-component', ['message' => 'Error calling µPagosDirect']);
        }
    }

    public function purchasedProduct($user_order)
    {
        foreach ($this->user->cart as $cart) {
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

        return view('livewire.payment.confirm-component');
    }
}
