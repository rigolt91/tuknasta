<?php

namespace App\Http\Livewire\AdminPanel\SubCategory;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category;
use App\Models\Subcategory as MSubcategory;

class Edit extends ModalComponent
{
    public $subcategory;
    public $name;
    public $category_id = '';

    protected $rules = [
        'name' => 'required|string',
        'category_id' => 'required|integer|max:255',
    ];

    public function mount(MSubcategory $subcategory)
    {
        $this->subcategory = $subcategory;
        $this->name = $subcategory->name;
        $this->category_id = $subcategory->category_id;
    }

    public function update()
    {
        $this->subcategory->update($this->validate());

        $this->closeModalWithEvents([ SubCategory::getName() => 'refreshSubcategories' ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.admin-panel.sub-category.edit', [
            'categories' => Category::select('id', 'name')->get(),
        ]);
    }
}
