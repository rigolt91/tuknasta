<?php

namespace App\Http\Livewire\AdminPanel\Category;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category;

class Edit extends ModalComponent
{
    public $category;
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255',
    ];

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->description = $category->description;
    }

    public function update()
    {
        $validate = $this->validate();

        try {
            $this->category->update($validate);

            $this->emit('refreshCategories');

            $this->closeModal();
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['message' => $th->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin-panel.category.edit');
    }
}
