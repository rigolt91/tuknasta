<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class SearchBarComponent extends Component
{
    public $category_id;

    public function setCategory($category)
    {
        $this->category_id = $category;
    }

    public function render()
    {
        return view('livewire.search-bar-component', [
            'categories' => Category::whereShow(true)->get()
        ]);
    }
}
