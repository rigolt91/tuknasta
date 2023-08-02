<?php

namespace App\Http\Livewire\AdminPanel\Order;

use App\Models\DeliveryMethod;
use App\Models\OrderStatus;
use Livewire\Component;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderComponent extends Component
{
    public $search;
    public $order_status;
    public $date;
    public $delivery_method;

    protected $listeners = ['refreshOrders' => '$refresh'];

    public function mount(Request $request)
    {
        $this->search = $request->search;
    }

    public function show($order)
    {
        $this->emit('openModal', 'admin-panel.order.show-component', ['order' => $order]);
    }

    public function edit($order)
    {
        $this->emit('openModal', 'admin-panel.order.edit-component', ['order' => $order]);
    }

    public function delete($order)
    {
        $this->emit('openModal', 'admin-panel.order.destroy-component', ['order' => $order]);
    }

    public function generatePDFOrders()
    {
        $pdf = Pdf::loadView('livewire.admin-panel.order.print-orders', [
            'orders' => UserOrder::whereStatus($this->order_status)->whereMethod($this->delivery_method)->get(),
        ])->output();

        return response()->streamDownload(
            fn () => print($pdf), "Orders.pdf"
        );
    }

    public function render()
    {
        return view('livewire.admin-panel.order.order-component', [
            'orders' => UserOrder::joinUserContact()
                        ->whereStatus($this->order_status)
                        ->whereNumber($this->search)
                        ->whereDate($this->date)
                        ->whereMethod($this->delivery_method)
                        ->whereContact($this->search)
                        ->latest()
                        ->paginate(10),
            'order_statuses' => OrderStatus::get(),
            'delivery_methods' => DeliveryMethod::get(),
        ]);
    }
}
