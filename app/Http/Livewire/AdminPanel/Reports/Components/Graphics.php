<?php

namespace App\Http\Livewire\AdminPanel\Reports\Components;

use Livewire\Component;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class Graphics extends Component
{
    public $date;
    public $start_date;
    public $end_date;

    public function chartUnitsProducts()
    {
        if($this->date) {
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
                'filter_period' => 'day',
                'filter_period_day' => $this->date,
                'chart_height' => '300px',
                'legend_position' => 'left',
            ];
        }elseif($this->start_date && $this->end_date){
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
                'range_date_start' => $this->start_date,
                'range_date_end' => $this->end_date,
                'chart_height' => '300px',
                'legend_position' => 'left',
            ];
        }

        return new LaravelChart($options);
    }

    public function chartPriceProducts()
    {
        if($this->date) {
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
                'filter_period' => 'day',
                'filter_period_day' => $this->date,
                'chart_height' => '300px',
                'chart_color' => 'rgb(6, 78, 59, .6)',
                'legend_display' => false,
            ];
        }elseif($this->start_date && $this->end_date) {
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
                'chart_height' => '300px',
                'chart_color' => 'rgb(6, 78, 59, .6)',
                'legend_display' => false,
            ];
        }

        return new LaravelChart($options);
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.components.graphics', [
            'chart_price_products' => $this->chartPriceProducts(),
            'chart_units_products' => $this->chartUnitsProducts(),
        ]);
    }
}
