<?php

namespace App\Http\Livewire\AdminPanel\Reports;

use Livewire\Component;
use App\Models\UserPurchasedProduct;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;


class YearSales extends Component
{
    public $date;
    public $carbon;
    public $products;
    public $growth;
    public $overall_growth;
    public $full_percent;

    public function mount(Request $request)
    {
        $this->carbon = Carbon::now();
        $this->date = $request->date ?: $this->carbon->toDay()->format('Y');

        $this->products = UserPurchasedProduct::select(DB::raw('date_format(created_at, "%Y-%m") as date'), DB::raw('SUM(units * price) as amount'), DB::raw('SUM(units) as total_products'))
                            ->where('created_at', 'like' ,'%'.$this->date.'%')
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
            'chart_type' => 'polarArea',
            'model' => 'App\Models\UserPurchasedProduct',
            'report_type' => 'group_by_relationship',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'units',
            'relationship_name' => 'product',
            'group_by_field' => 'name',
            'filter_field' => 'created_at',
            'filter_period' => 'year',
            'filter_period_year' => $this->date,
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
            'filter_period' => 'year',
            'filter_period_year' => $this->date,
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
            'name' => 'Sales Per Day ',
            'chart_type' => 'pie',
            'model' => 'App\Models\UserPurchasedProduct',
            'report_type' => 'group_by_date',
            'select_raw' => '*, units * price as amount',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'amount',
            'group_by_field' => 'created_at',
            'date_format' => 'M',
            'filter_field' => 'created_at',
            'filter_period' => 'year',
            'filter_period_year' => $this->date,
            'chart_height' => '150px',
            'legend_position' => 'left',
        ];

        return new LaravelChart($options);
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.year-sales', [
            'chart_price_products' => $this->chartPriceProducts(),
            'chart_units_products' => $this->chartUnitsProducts(),
            'chart_sales_per_day' => $this->chartSalesPerDay(),
        ]);
    }
}
