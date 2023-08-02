<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Category;

class FilterComponent extends Component
{
    public $categories, $selected, $price_min, $price_max;

    public function mount()
    {
        $this->categories = Category::select('id', 'name')->show(true)->get();

        $this->selected = $this->categories->modelKeys();
    }

    public function setSelected($category)
    {
        if(!in_array($category, $this->selected))
        {
            $this->selected[] = $category;
        } else {
            $key = array_search($category, $this->selected);

            unset($this->selected[$key]);

            $this->selected = array_values($this->selected);
        }
    }

    public function filterPrice()
    {
        $this->emit('filterProduct', $this->price_min, $this->price_max, $this->selected);
    }

    public function render()
    {
        return view('livewire.product.filter-component');
    }
}
