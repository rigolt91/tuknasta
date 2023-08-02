<?php

namespace App\Http\Livewire\AdminPanel\Product;

use LivewireUI\Modal\ModalComponent;
use App\Models\Product;

class DestroyComponent extends ModalComponent
{
    public Product $product;

    public function destroy()
    {
        $this->product->delete();

        $this->closeModalWithEvents([ ProductComponent::getName() => 'refreshProducts' ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.product.destroy-component');
    }
}
