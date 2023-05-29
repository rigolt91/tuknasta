<?php

namespace App\Http\Livewire\AdminPanel\Order;

use App\Models\OrderStatus;
use App\Models\UserOrder;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    public $order;
    public $order_status;

    public function mount(UserOrder $order)
    {
        $this->order = $order;
        $this->order_status = $order->order_status_id;
    }

    public function update()
    {
        $this->order->update([ 'order_status_id' => $this->order_status ]);

        $this->closeModalWithEvents([ Order::getName() => 'refreshOrders' ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.order.edit', [
            'order_statuses' => OrderStatus::select('id', 'name')->get(),
        ]);
    }
}
