<?php

namespace App\Http\Livewire\AdminPanel\Order;

use App\Models\UserContact;
use App\Models\UserOrder;
use LivewireUI\Modal\ModalComponent;
use Barryvdh\DomPDF\Facade\Pdf;

class ShowComponent extends ModalComponent
{
    public UserOrder $order;
    public $number;
    public $status;
    public $products;
    public $total_products;
    public $total_cost;
    public $created_at;
    public $delivery_method;
    public $contact;

    public function mount()
    {
        $this->number = $this->order->number;
        $this->status = $this->order->orderStatus->name;
        $this->products = $this->order->userPurchasedProduct;
        $this->total_products = $this->order->totalProducts();
        $this->total_cost = $this->order->totalCost();
        $this->created_at = $this->order->created_at;
        $this->delivery_method = $this->order->deliveryMethod->name;
        $this->contact = UserContact::withTrashed()->whereContact($this->order->user_contact_id)->first();
    }

    public function generatePDF()
    {
        $pdf = Pdf::loadView('livewire.admin-panel.order.print', [
            'number' => $this->number,
            'status' => $this->status,
            'products' => $this->products,
            'total_products' => $this->total_products,
            'total_cost' => $this->total_cost,
            'created_at' => $this->created_at,
            'delivery_method' => $this->delivery_method,
            'contact' => $this->contact,
        ])->output();

        return response()->streamDownload(
            fn () => print($pdf), "$this->number.pdf"
        );
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function render()
    {
        return view('livewire.admin-panel.order.show-component');
    }
}
