<?php

namespace App\Http\Livewire\AdminPanel\SubCategory;

use LivewireUI\Modal\ModalComponent;
use App\Models\Subcategory as MSubcategory;

class Destroy extends ModalComponent
{
    public $subcategory;

    public function mount(MSubcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    public function destroy()
    {
        try {
            $this->subcategory->delete();

            $this->closeModalWithEvents([ SubCategory::getName() => 'refreshSubcategories' ]);
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
        return view('livewire.admin-panel.sub-category.destroy');
    }
}
