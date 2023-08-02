<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class ProductComponent extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        return view('livewire.product.product-component', [
            'products' => Product::select('id', 'image', 'name', 'slug', 'short_description', 'price', 'previous_price')->whereName($this->search)->paginate(20),
        ]);
    }
}
