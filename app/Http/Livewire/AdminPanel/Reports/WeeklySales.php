<?php

namespace App\Http\Livewire\AdminPanel\Reports;

use Illuminate\Http\Request;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\UserPurchasedProduct;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class WeeklySales extends Component
{
    public $carbon;
    public $start_date;
    public $end_date;
    public $products;
    public $growth;
    public $overall_growth;
    public $full_percent;

    public function mount(Request $request)
    {
        $this->carbon = new Carbon;
        $this->start_date = $request->start_date ?: Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
        $this->end_date = $request->end_date ?: Carbon::now()->startOfWeek()->format('Y-m-d');

        $this->products = UserPurchasedProduct::select(DB::raw('date_format(created_at, "%Y-%m-%d") as date'), DB::raw('SUM(units * price) as amount'), DB::raw('SUM(units) as total_products'))
                            ->whereBetween('created_at', [$this->start_date, $this->end_date])
                            ->groupBy('date')
                            ->get();
        $this->growth = $this->products->toArray();
        $this->overallGrowth();
    }

    public function overallGrowth()
    {
        $this->overall_growth = 0;
        $this->full_percent = 0;

        foreach($this->products as $key => $product)
        {
            $this->overall_growth += ($key > 0) ? ($product->amount - $this->growth[$key-1]['amount']) : $this->growth[$key]['amount'];
            $this->full_percent += ($key > 0) ? (($percent = ((($product->amount - $this->growth[$key-1]['amount'])/$product->amount) * 100)) > 0 ? $percent : 0) : 100;
        }
    }

    public function chartUnitsProducts()
    {
        $options = [
            'chart_title' => 'Units',
            'name' => 'Units Per Product',
            'chart_type' => 'pie',
            'model' => 'App\Models\UserPurchasedProduct',
            'report_type' => 'group_by_relationship',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'units',
            'relationship_name' => 'product',
            'group_by_field' => 'name',
            'filter_field' => 'created_at',
            'range_date_start' => $this->start_date,
            'range_date_end' => $this->end_date,
            'chart_height' => '150px',
            'legend_position' => 'left',
        ];

        return new LaravelChart($options);
    }

    public function chartPriceProducts()
    {
        $options = [
            'chart_title' => 'Sales',
            'name' => 'Sales By Product',
            'chart_type' => 'bar',
            'model' => 'App\Models\UserPurchasedProduct',
            'report_type' => 'group_by_relationship',
            'select_raw' => '*, units * price as amount',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'amount',
            'relationship_name' => 'product',
            'group_by_field' => 'name',
            'filter_field' => 'created_at',
            'range_date_start' => $this->start_date,
            'range_date_end' => $this->end_date,
            'chart_height' => '150px',
            'chart_color' => 'rgb(6, 78, 59, .6)',
            'legend_display' => false,
        ];

        return new LaravelChart($options);
    }

    public function chartSalesPerDay()
    {
        $options = [
            'chart_title' => 'Sales Per Day',
            'name' => 'Sales Per Day',
            'chart_type' => 'pie',
            'model' => 'App\Models\UserPurchasedProduct',
            'report_type' => 'group_by_date',
            'select_raw' => '*, units * price as amount',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'amount',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'date_format' => 'd-D',
            'filter_field' => 'created_at',
            'range_date_start' => $this->start_date,
            'range_date_end' => $this->end_date,
            'chart_height' => '150px',
            'legend_position' => 'left',
        ];

        return new LaravelChart($options);
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.weekly-sales', [
            'chart_price_products' => $this->chartPriceProducts(),
            'chart_units_products' => $this->chartUnitsProducts(),
            'chart_sales_per_day' => $this->chartSalesPerDay(),
        ]);
    }
}
