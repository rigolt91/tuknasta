<?php

namespace App\Http\Livewire\AdminPanel\Product;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product as MProduct;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Subcategory;

class Product extends Component
{
    use WithPagination;

    public $branch_id = '';
    public $subcategory_id = '';
    public $category_id = '';

    protected $listeners = ['refreshProducts' => '$refresh'];

    public function setShow(MProduct $product)
    {
        $product->update(['show' => !$product->show]);
    }

    public function setRecommend(MProduct $product)
    {
        $product->update(['recommend' => !$product->recommend]);
    }

    public function render()
    {
        return view('livewire.admin-panel.product.product', [
            'products' => MProduct::select('id', 'image', 'name', 'sku', 'short_description', 'price', 'previous_price', 'stock', 'show', 'recommend', 'subcategory_id', 'category_id', 'branch_id')
                ->where('branch_id', 'LIKE', '%'.$this->branch_id.'%')
                ->where('subcategory_id', 'LIKE', '%'.$this->subcategory_id.'%')
                ->where('category_id', 'LIKE', '%'.$this->category_id.'%')
                ->paginate(10),
            'branches' => Branch::select('id', 'name')->get(),
            'subcategories' => Subcategory::select('id', 'name')
                ->where('category_id', 'LIKE', '%'.$this->category_id.'%')
                ->get(),
            'categories' => Category::select('id', 'name')->get(),
        ]);
    }
}
