<?php

namespace App\Http\Livewire\AdminPanel\Order;

use App\Models\OrderStatus;
use App\Models\UserOrder;
use LivewireUI\Modal\ModalComponent;

class EditComponent extends ModalComponent
{
    public UserOrder $order;
    public $status;

    public function mount()
    {
        $this->status = $this->order->order_status_id;
    }

    public function update()
    {
        $this->order->update([ 'order_status_id' => $this->status ]);

        $this->closeModalWithEvents([ OrderComponent::getName() => 'refreshOrders' ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.order.edit-component', [
            'statuses' => OrderStatus::get(),
        ]);
    }
}
