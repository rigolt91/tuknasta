<?php

namespace App\Http\Livewire\AdminPanel\Category;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DestroyComponent extends ModalComponent
{
    use AuthorizesRequests;

    public Category $category;

    public function destroy()
    {
        $this->authorize('delete', $this->category);

        $this->category->delete();

        $this->closeModalWithEvents([CategoryComponent::getName() => 'refreshCategories']);
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.category.destroy-component');
    }
}
