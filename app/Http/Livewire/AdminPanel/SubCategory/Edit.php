<?php

namespace App\Http\Livewire\AdminPanel\SubCategory;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category;
use App\Models\Subcategory;

class Edit extends ModalComponent
{
    public $subcategory;
    public $name;
    public $category_id = '';

    protected $rules = [
        'name' => 'required|string',
        'category_id' => 'required|integer|max:255',
    ];

    public function mount(Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
        $this->name = $subcategory->name;
        $this->category_id = $subcategory->category_id;
    }

    public function update()
    {
        $validate = $this->validate();

        try {
            $this->subcategory->update($validate);

            $this->emit('refreshSubcategories');

            $this->closeModal();
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['message' => $th->getMessage()]);
        }
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
