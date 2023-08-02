<?php

namespace App\Http\Livewire\AdminPanel\Order;

use App\Models\UserOrder;
use LivewireUI\Modal\ModalComponent;

class DestroyComponent extends ModalComponent
{
    public UserOrder $order;

    public function destroy()
    {
        $this->restoreProductStock();

        $this->order->delete();

        $this->closeModalWithEvents([ OrderComponent::getName() => 'refreshOrders' ]);
    }

    public function restoreProductStock()
    {
        foreach($this->order->userPurchasedProduct as $product)
        {
            $product->product()->update(['stock' => $product->product->stock + $product->units]);
        }
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.order.destroy-component');
    }
}
