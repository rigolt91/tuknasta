<?php

namespace App\Http\Livewire\AdminPanel\Product;

use LivewireUI\Modal\ModalComponent;
use App\Models\Product;

class Destroy extends ModalComponent
{
    public $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function destroy()
    {
        try {
            $this->product->delete();

            $this->emit('refreshProducts');

            $this->closeModal();
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['message' => $th->getMessage()]);
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
