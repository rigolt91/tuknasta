<?php

namespace App\Http\Livewire\AdminPanel\Category;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithFileUploads;

class CreateComponent extends ModalComponent
{
    use AuthorizesRequests, WithFileUploads;

    public $image;
    public $name;
    public $description;

    protected $rules = [
        'image' => 'required|image|max:1024',
        'name' => 'required|string|unique:categories,name',
        'description' => 'required|string|max:255',
    ];

    public function store(Category $category)
    {
        $this->authorize('create', $category);
        $this->validate();

        $image = $this->image->storeAs("public/categories/", substr(sha1(rand(1, 999)), 0, -30) . '.jpg');

        $category->create([
            'image' => $image,
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->closeModalWithEvents([CategoryComponent::getName() => 'refreshCategories']);
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.admin-panel.category.create-component');
    }
}
