<?php

namespace App\Http\Livewire\AdminPanel\Product;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Subcategory;

class ProductComponent extends Component
{
    use WithPagination;

    public $branch_id;
    public $subcategory_id;
    public $category_id;

    protected $listeners = ['refreshProducts' => '$refresh'];

    public function create()
    {
        $this->emit('openModal', 'admin-panel.product.create-component');
    }

    public function edit($product)
    {
        $this->emit('openModal', 'admin-panel.product.edit-component', ['product' => $product]);
    }

    public function delete($product)
    {
        $this->emit('openModal', 'admin-panel.product.destroy-component', ['product' => $product]);
    }

    public function setShow(Product $product)
    {
        $product->update(['show' => !$product->show]);
    }

    public function setRecommend(Product $product)
    {
        $product->update(['recommend' => !$product->recommend]);
    }

    public function render()
    {
        return view('livewire.admin-panel.product.product-component', [
            'products' => Product::whereBranch($this->branch_id)->whereSubcategory($this->subcategory_id)->whereCategory($this->category_id)->paginate(10),
            'branches' => Branch::get(),
            'subcategories' => Subcategory::whereCategory($this->category_id)->get(),
            'categories' => Category::get(),
        ]);
    }
}
