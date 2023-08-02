<?php

namespace App\Http\Livewire\AdminPanel\SubCategory;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category;
use App\Models\Subcategory;

class EditComponent extends ModalComponent
{
    public Subcategory $subcategory;
    public $name;
    public $category_id = '';

    protected $rules = [
        'name' => 'required|string',
        'category_id' => 'required|integer|max:255',
    ];

    public function mount()
    {
        $this->name = $this->subcategory->name;
        $this->category_id = $this->subcategory->category_id;
    }

    public function update()
    {
        $this->subcategory->update($this->validate());

        $this->closeModalWithEvents([ SubCategoryComponent::getName() => 'refreshSubcategories' ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.admin-panel.sub-category.edit-component', [
            'categories' => Category::get(),
        ]);
    }
}
