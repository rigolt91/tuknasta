<?php

namespace App\Http\Livewire\AdminPanel\Category;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category as MCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Destroy extends ModalComponent
{
    use AuthorizesRequests;

    public $category;

    public function mount(MCategory $category)
    {
        $this->category = $category;
    }

    public function destroy()
    {
        try {
            $this->authorize('delete', $this->category);

            $this->category->delete();

            $this->closeModalWithEvents([ Category::getName() => 'refreshCategories' ]);
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['Operation failed.']);
        }
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.category.destroy');
    }
}
