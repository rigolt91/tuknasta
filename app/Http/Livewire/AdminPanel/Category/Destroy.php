<?php

namespace App\Http\Livewire\AdminPanel\Category;

use LivewireUI\Modal\ModalComponent;
use App\Models\Category;

class Destroy extends ModalComponent
{
    public $category;

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function destroy()
    {
        try {
            $this->category->delete();

            $this->emit('refreshCategories');

            $this->closeModal();
        } catch (\Throwable $th) {
            $this->emit('openModal', 'error-modal', ['message' => $th->getMessage()]);
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
