<?php

namespace App\Http\Livewire\AdminPanel\Category;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category;

class Create extends ModalComponent
{
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|string|unique:categories,name',
        'description' => 'required|string|max:255',
    ];

    public function store()
    {
        $validate = $this->validate();

        try {
            Category::create($validate);

            $this->emit('refreshCategories');

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
        return view('livewire.admin-panel.category.create');
    }
}
