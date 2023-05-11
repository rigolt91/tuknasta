<?php

namespace App\Http\Livewire\AdminPanel\Order;

use App\Models\UserOrder;
use LivewireUI\Modal\ModalComponent;

class Destroy extends ModalComponent
{
    public $order;

    public function mount(UserOrder $order)
    {
        $this->order = $order;
    }

    public function destroy()
    {
        try {
            $this->restoreProductStock();

            $this->order->delete();

            $this->emit('refreshOrders');

            $this->closeModal();
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['message' => $th->getMessage()]);
        }
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
        return view('livewire.admin-panel.order.destroy');
    }
}
