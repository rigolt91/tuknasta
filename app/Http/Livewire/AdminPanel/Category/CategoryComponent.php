<?php

namespace App\Http\Livewire\AdminPanel\Category;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryComponent extends Component
{
    use WithPagination, AuthorizesRequests;

    protected $listeners = ['refreshCategories' => '$refresh'];

    public function create()
    {
        $this->emit('openModal', 'admin-panel.category.create-component');
    }

    public function edit($category)
    {
        $this->emit('openModal', 'admin-panel.category.edit-component', ['category' => $category]);
    }

    public function delete($category)
    {
        $this->emit('openModal', 'admin-panel.category.destroy-component', ['category' => $category]);
    }

    public function setShow(Category $category)
    {
        $this->authorize('update', $category);

        $category->update(['show' => !$category->show]);
    }

    public function render()
    {
        return view('livewire.admin-panel.category.category-component', [
            'categories' => Category::paginate(10),
        ]);
    }
}
