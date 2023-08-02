<?php

namespace App\Http\Livewire\AdminPanel\SubCategory;

use LivewireUI\Modal\ModalComponent;
use App\Models\Subcategory;

class DestroyComponent extends ModalComponent
{
    public Subcategory $subcategory;

    public function destroy()
    {
        $this->subcategory->delete();

        $this->closeModalWithEvents([ SubCategoryComponent::getName() => 'refreshSubcategories' ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.sub-category.destroy-component');
    }
}
