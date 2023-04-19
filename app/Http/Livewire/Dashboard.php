<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use App\Models\Product;

class Dashboard extends Component
{
    public $search;
    public $categories;
    public $price_min;
    public $price_max;
    public $order;

    protected $listeners = [
        'filterProduct' => 'filterProduct',
        'orderProducts'  => 'orderProducts',
    ];

    public function mount()
    {
        $this->search = Request::input('search');

        $this->categories = Category::select('id')->where('show', true)->get()->modelKeys();

        $products = Product::select('price')->orderBy('price')->get();

        $this->price_min = $products->count() > 0 ? $products->first()->price : 0;
        $this->price_max = $products->count() > 0 ? $products->last()->price : 0;
        $this->order = 'name';
    }

    public function filterProduct($price_min, $price_max, $categories)
    {
        $this->categories = $categories;
        $this->price_min  = $price_min ?: $this->price_min;
        $this->price_max  = $price_max ?: $this->price_max;
    }

    public function orderProducts($order)
    {
        $this->order = $order;
    }

    public function render()
    {
        $products = Product::select('id', 'image', 'name', 'slug', 'short_description', 'price', 'previous_price')
                    ->where('name', 'LIKE', '%'.$this->search.'%')
                    ->where('price', '>=', $this->price_min)
                    ->where('price', '<=', $this->price_max)
                    ->where('show', true)
                    ->orderBy($this->order)
                    ->get();

        $products = $products->intersect(Product::whereIn('category_id', $this->categories)->get());

        return view('dashboard', ['products' => $products]);
    }
}
