<?php

namespace App\Http\Livewire\AdminPanel\SubCategory;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category;
use App\Models\Subcategory;

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
        $validate = $this->validate();

        try {
            Subcategory::create($validate);

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
        return view('livewire.admin-panel.sub-category.create', [
            'categories' => Category::select('id', 'name')->get(),
        ]);
    }

}
