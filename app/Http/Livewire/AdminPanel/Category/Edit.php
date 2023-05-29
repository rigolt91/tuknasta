<?php

namespace App\Http\Livewire\AdminPanel\Category;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category as MCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends ModalComponent
{
    use AuthorizesRequests;

    public $category;
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255',
    ];

    public function mount(MCategory $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->description = $category->description;
    }

    public function update()
    {
        $this->authorize('update', $this->category);

        $this->category->update($this->validate());

        $this->closeModalWithEvents([ Category::getName() => 'refreshCategories' ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.admin-panel.category.edit');
    }
}
