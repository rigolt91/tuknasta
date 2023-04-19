<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product as MProduct;

class Product extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        return view('livewire.product.product', [
            'products' => MProduct::select('id', 'image', 'name', 'slug', 'short_description', 'price', 'previous_price')->where('name', 'LIKE', '%'.$this->search.'%')->paginate(20),
        ]);
    }
}
