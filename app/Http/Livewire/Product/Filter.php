<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;

class Filter extends Component
{
    public $categories;
    public $category_selected = [];
    public $price_min;
    public $price_max;

    public function mount()
    {
        $this->categories = Category::select('id', 'name')->where('show', true)->get();
        foreach($this->categories as $category) array_push($this->category_selected, $category->id);
    }

    public function setCategorySelected($category)
    {
        if(!in_array($category, $this->category_selected))
        {
            $this->category_selected[] = $category;
        } else {
            $key = array_search($category, $this->category_selected);
            unset($this->category_selected[$key]);
            $this->category_selected = array_values($this->category_selected);
        }
    }

    public function filterPrice()
    {
        $this->price_min = !empty($this->price_min) ? $this->price_min : Product::select('price')->orderBy('price')->get()->first()->price;
        $this->price_max = !empty($this->price_max) ? $this->price_max : Product::select('price')->orderBy('price')->get()->last()->price;

        $this->emit('filterProduct', $this->price_min, $this->price_max, $this->category_selected);
    }

    public function render()
    {
        return view('livewire.product.filter');
    }
}
