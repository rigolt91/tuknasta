<?php

namespace App\Http\Livewire\AdminPanel\Category;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category as MCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Category extends Component
{
    use WithPagination, AuthorizesRequests;

    protected $listeners = ['refreshCategories' => '$refresh'];

    public function setShow(MCategory $category)
    {
        $this->authorize('update', $category);

        $category->update(['show' => !$category->show]);
    }

    public function render()
    {
        return view('livewire.admin-panel.category.category', [
            'categories' => MCategory::select('id', 'name', 'description', 'show')->paginate(10),
        ]);
    }
}
