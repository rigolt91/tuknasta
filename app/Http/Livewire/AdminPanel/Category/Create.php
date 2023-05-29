<?php

namespace App\Http\Livewire\AdminPanel\Category;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category as MCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends ModalComponent
{
    use AuthorizesRequests;

    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|string|unique:categories,name',
        'description' => 'required|string|max:255',
    ];

    public function store(MCategory $category)
    {
        $this->authorize('create', $category);

        $category->create($this->validate());

        $this->closeModalWithEvents([ Category::getName() => 'refreshCategories' ]);
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
