<?php

namespace App\Http\Livewire\AdminPanel\Order;

use App\Models\OrderStatus;
use Livewire\Component;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class Order extends Component
{
    public $search = '';
    public $order_status = '';
    public $status;

    protected $listeners = ['refreshOrders' => '$refresh'];

    public function mount(Request $request)
    {
        $this->search = $request->search;
    }

    public function generatePDF(UserOrder $order)
    {
        $pdf = Pdf::loadView('livewire.admin-panel.order.print', [
            'number' => $order->number,
            'status' => $order->status,
            'products' => $order->userPurchasedProduct,
            'total_products' => $order->totalProducts(),
            'total_cost' => $order->totalCost(),
            'created_at' => $order->created_at,
            'delivery_method' => $order->deliveryMethod->name,
            'contact' => $order->userContact,
        ])->output();

        return response()->streamDownload(
            fn () => print($pdf), "$order->number.pdf"
        );
    }

    public function render()
    {
        return view('livewire.admin-panel.order.order', [
            'orders' => UserOrder::join('user_contacts', 'user_orders.user_contact_id', '=', 'user_contacts.id')
                            ->select('user_orders.*', 'user_contacts.name as contact_name', 'user_contacts.last_name as contact_last_name', 'user_contacts.dni as contact_dni')
                            ->when($this->order_status, function($query) {
                                $query->where('order_status_id', $this->order_status);
                            })
                            ->when($this->search, function($query) {
                                $query->where('user_orders.number', 'like', '%'.$this->search.'%');
                                $query->orWhere('user_contacts.name', 'like', '%'.$this->search.'%');
                                $query->orWhere('user_contacts.dni', 'like', '%'.$this->search.'%');
                            })->latest()->paginate(10),
            'order_statuses' => OrderStatus::select('id', 'name')->get(),
        ]);
    }
}
