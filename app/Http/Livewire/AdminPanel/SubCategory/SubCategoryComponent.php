<?php

namespace App\Http\Livewire\AdminPanel\SubCategory;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Subcategory;

class SubCategoryComponent extends Component
{
    use WithPagination;

    protected $listeners = ['refreshSubcategories' => '$refresh'];

    public function create()
    {
        $this->emit('openModal', 'admin-panel.sub-category.create-component');
    }

    public function edit($subcategory)
    {
        $this->emit('openModal', 'admin-panel.sub-category.edit-component', ['subcategory' => $subcategory]);
    }

    public function delete($subcategory)
    {
        $this->emit('openModal', 'admin-panel.sub-category.destroy-component', ['subcategory' => $subcategory]);
    }

    public function setShow(Subcategory $subcategory)
    {
        $subcategory->update(['show' => !$subcategory->show]);
    }

    public function render()
    {
        return view('livewire.admin-panel.sub-category.sub-category-component', [
            'subcategories' => Subcategory::paginate(10),
        ]);
    }
}
