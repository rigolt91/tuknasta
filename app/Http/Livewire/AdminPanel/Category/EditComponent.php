<?php

namespace App\Http\Livewire\AdminPanel\Category;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithFileUploads;

class EditComponent extends ModalComponent
{
    use AuthorizesRequests, WithFileUploads;

    public Category $category;
    public $image;
    public $name;
    public $description;

    protected $rules = [
        'image' => 'nullable', //1 MB Max
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->image = $this->category->image;
        $this->name = $this->category->name;
        $this->description = $this->category->description;
    }

    public function update()
    {
        $this->authorize('update', $this->category);
        $this->validate();

        $image = ($this->image !== $this->category->image)
            ? $this->image->storeAs("public/categories/", substr(sha1(rand(1, 999)), 0, -30) . '.jpg')
            : $this->image;

        $this->category->update([
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
        return view('livewire.admin-panel.category.edit-component');
    }
}
