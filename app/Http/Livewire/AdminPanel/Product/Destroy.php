<?php

namespace App\Http\Livewire\AdminPanel\Product;

use LivewireUI\Modal\ModalComponent;
use App\Models\Product as MProduct;

class Destroy extends ModalComponent
{
    public $product;

    public function mount(MProduct $product)
    {
        $this->product = $product;
    }

    public function destroy()
    {
        try {
            $this->product->delete();

            $this->closeModalWithEvents([ Product::getName() => 'refreshProducts' ]);
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['Operation failed.']);
        }
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.product.destroy');
    }
}
