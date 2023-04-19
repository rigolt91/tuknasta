<?php

namespace App\Http\Livewire\AdminPanel\Order;

use App\Models\UserOrder;
use LivewireUI\Modal\ModalComponent;
use Barryvdh\DomPDF\Facade\Pdf;

class Show extends ModalComponent
{
    public $number;
    public $status;
    public $products;
    public $total_products;
    public $total_cost;
    public $created_at;
    public $delivery_method;
    public $contact;

    public function mount(UserOrder $order)
    {
        $this->number = $order->number;
        $this->status = $order->orderStatus->name;
        $this->products = $order->userPurchasedProduct;
        $this->total_products = $order->totalProducts();
        $this->total_cost = $order->totalCost();
        $this->created_at = $order->created_at;
        $this->delivery_method = $order->deliveryMethod->name;
        $this->contact = $order->userContact;
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
        return view('livewire.admin-panel.order.show');
    }
}
