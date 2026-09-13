<?php

namespace App\Http\Livewire\Product;

use App\Http\Traits\ProductStartTrait;
use Livewire\Component;

class CardPreferComponent extends Component
{
    use ProductStartTrait;

    public $product;
    public $name;
    public $short_description;
    public $price;
    public $previous_price;
    public $slug;
    public $branch;
    public $starts;
    public $reviews;

    public function mount($product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->short_description = $product->short_description;
        $this->price = $product->price;
        $this->previous_price = $product->previous_price;
        $this->slug = $product->slug;
        $this->branch = $product->branch?->name;
        $this->reviews = $product->productStart
            ? $product->productStart->one + $product->productStart->two + $product->productStart->three
                + $product->productStart->four + $product->productStart->five
            : 0;
    }

    public function addProductCart($product)
    {
        $this->emit('addProductCart', $product);
    }

    public function render()
    {
        $this->starts = $this->getStarts();

        return view('livewire.product.card-prefer-component');
    }
}
