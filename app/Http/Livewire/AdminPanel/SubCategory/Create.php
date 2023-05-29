<?php

namespace App\Http\Livewire\AdminPanel\SubCategory;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category;
use App\Models\Subcategory as MSubcategory;

class Create extends ModalComponent
{
    public $name;
    public $category_id = '';

    protected $rules = [
        'name' => 'required|string|unique:subcategories,name',
        'category_id' => 'required|integer|max:255',
    ];

    public function store()
    {
            MSubcategory::create($this->validate());

            $this->closeModalWithEvents([ SubCategory::getName() => 'refreshSubcategories' ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.admin-panel.sub-category.create', [
            'categories' => Category::select('id', 'name')->get(),
        ]);
    }

}
