<?php

namespace App\Http\Livewire\AdminPanel\SubCategory;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Subcategory as MSubcategory;

class SubCategory extends Component
{
    use WithPagination;

    protected $listeners = ['refreshSubcategories' => '$refresh'];

    public function setShow(MSubcategory $subcategory)
    {
        $subcategory->update(['show' => !$subcategory->show]);
    }

    public function render()
    {
        return view('livewire.admin-panel.sub-category.sub-category', [
            'subcategories' => MSubcategory::select('id', 'name', 'category_id', 'show')->paginate(10),
        ]);
    }
}
