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
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class AdminPanelComponent extends Component
{
    public $orders;
    public $processing;
    public $sent;
    public $delivered;
    public $products;
    public $categories;
    public $subcategories;
    public $branches;
    public $clients;
    public $purchased_products;

    public function mount()
    {
        $this->orders = UserOrder::count();
        $this->processing = OrderStatus::whereName('Procesando')->first()->userOrder()->count();
        $this->sent = OrderStatus::whereName('Enviada')->first()->userOrder()->count();
        $this->delivered = OrderStatus::whereName('Entregada')->first()->userOrder()->count();
        $this->categories = Category::count();
        $this->subcategories = Subcategory::count();
        $this->products = Product::count();
        $this->branches = Branch::count();
        $this->clients = User::count();
        $this->purchased_products = UserPurchasedProduct::sum('units');
    }

    public function chartOrders()
    {
        $options = [
            'chart_title' => 'Orders',
            'name' => 'Orders Per Month',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\UserOrder',
            'group_by_field' => 'created_at',
            'date_format' => 'F',
            'group_by_period' => 'month',
            'chart_type' => 'pie',
            'chart_color' => 'rgb(0, 128, 0, .6)',
            'chart_height' => '200px',
            'legend_position' => 'left',
        ];

        return new LaravelChart($options);
    }

    public function chartSales()
    {
        $options = [
            'chart_title' => 'Sales',
            'name' => 'Sales Per Month',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\UserPurchasedProduct',
            'group_by_field' => 'created_at',
            'date_format' => 'F',
            'group_by_period' => 'month',
            'select_raw' => '*, units * price as amount',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'amount',
            'chart_type' => 'bar',
            'chart_color' => 'rgb(6, 78, 59, .6)',
            'chart_height' => '200px',
            'legend_display' => false,
        ];

        return new LaravelChart($options);
    }

    public function chartProducts()
    {
        $options = [
            'chart_title' => 'Products',
            'name' => 'Products With More Sales',
            'chart_type' => 'pie',
            'model' => 'App\Models\UserPurchasedProduct',
            'report_type' => 'group_by_relationship',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'units',
            'relationship_name' => 'product',
            'group_by_field' => 'name',
            'chart_height' => '200px',
            'legend_position' => 'left',
        ];

        return new LaravelChart($options);
    }

    public function render()
    {
        return view('livewire.admin-panel.admin-panel-component', [
            'chart_orders' => $this->chartOrders(),
            'chart_sales' => $this->chartSales(),
            'chart_products' => $this->chartProducts(),
        ]);
    }
}
