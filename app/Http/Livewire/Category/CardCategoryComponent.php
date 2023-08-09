<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;

class CardCategoryComponent extends Component
{
    public function getProducts($category)
    {
        return redirect()->route('products', ['category_id' => $category]);
    }

    public function render()
    {
        return view('livewire.category.card-category-component', [
            'categories' => Category::whereShow(true)->get()
        ]);
    }
}
