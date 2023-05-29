<?php

namespace App\Http\Livewire\Product;

use App\Http\Traits\ProductStartTrait;
use Livewire\Component;

class Card extends Component
{
    use ProductStartTrait;

    public $product;
    public $image;
    public $name;
    public $slug;
    public $short_description;
    public $price;
    public $starts;
    public $previous_price;

    public function mount($product)
    {
        $this->product = $product;
        $this->image = $product->image;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->short_description = $product->short_description;
        $this->price = $product->price;
        $this->previous_price = $product->previous_price;
    }

    public function render()
    {
        $this->starts = $this->getStarts();

        return view('livewire.product.card');
    }
}
