<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;

class CardPrefer extends Component
{
    public $product;
    public $name;
    public $short_description;
    public $price;
    public $previous_price;
    public $slug;

    public function mount($product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->short_description = $product->short_description;
        $this->price = $product->price;
        $this->previous_price = $product->previous_price;
        $this->slug = $product->slug;
    }

    public function addProductCart($product)
    {
        $this->emit('addProductCart', $product);
    }

    public function render()
    {
        return view('livewire.product.card-prefer');
    }
}
