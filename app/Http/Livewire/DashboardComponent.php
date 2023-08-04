<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use App\Models\Product;

class DashboardComponent extends Component
{
    public $search, $category_id, $categories, $price_min, $price_max, $order = 'name';

    protected $listeners = [
        'filterProduct' => 'filterProduct',
        'orderProducts'  => 'orderProducts',
    ];

    public function mount($category_id = null)
    {
        $this->category_id = !is_null($category_id) ? $category_id : Request::input('category_id');
        $this->search = Request::input('search');

        $this->categories = Category::show(true)->get()->modelKeys();
    }

    public function filter()
    {
        $this->emit('openPanel', 'Categories', 'product.filter-component');
    }

    public function filterProduct($price_min, $price_max, $categories)
    {
        $this->categories = $categories;
        $this->price_min  = $price_min;
        $this->price_max  = $price_max;
    }

    public function orderProducts($order)
    {
        $this->order = $order;
    }

    public function render()
    {
        return view('dashboard-component', [
            'products' => Product::select('id', 'image', 'name', 'slug', 'short_description', 'price', 'previous_price', 'stock')
                ->whereInCategory($this->categories)
                ->whereCategory($this->category_id)
                ->whereName($this->search)
                ->wherePrice($this->price_min, $this->price_max)
                ->show(true)
                ->orderBy($this->order)
                ->get()
        ]);
    }
}
