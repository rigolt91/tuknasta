<?php

namespace App\Http\Livewire\AdminPanel;

use App\Models\Branch;
use App\Models\Category;
use Livewire\Component;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\UserOrder;
use App\Models\UserPurchasedProduct;

class AdminPanel extends Component
{
    public $orders;
    public $order_statuses;
    public $order_processing;
    public $order_sent;
    public $order_delivered;
    public $products;
    public $categories;
    public $subcategories;
    public $branches;
    public $clients;
    public $purchased_products;

    public function mount()
    {
        $this->orders = UserOrder::count();
        $this->order_statuses = OrderStatus::select('name')->get();
        $this->order_processing = $this->order_statuses->where('name', 'Processing')->count();
        $this->order_sent = $this->order_statuses->where('name', 'Sent')->count();
        $this->order_delivered = $this->order_statuses->where('name', 'Delivered')->count();
        $this->categories = Category::count();
        $this->subcategories = Subcategory::count();
        $this->products = Product::count();
        $this->branches = Branch::count();
        $this->clients = User::count();
        $this->purchased_products = UserPurchasedProduct::sum('units');
    }

    public function render()
    {
        return view('livewire.admin-panel.admin-panel');
    }
}
