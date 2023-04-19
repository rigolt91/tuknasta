<?php

namespace App\Http\Livewire\AdminPanel\SubCategory;

use LivewireUI\Modal\ModalComponent;
use App\Models\Subcategory;

class Destroy extends ModalComponent
{
    public $subcategory;

    public function mount(Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    public function destroy()
    {
        try {
            $this->subcategory->delete();

            $this->emit('refreshSubcategories');

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
        return view('livewire.admin-panel.sub-category.destroy');
    }
}
