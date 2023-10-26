<?php

namespace App\Http\Livewire\AdminPanel\Reports;

use App\Models\Branch;
use App\Models\UserPurchasedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Component;

class SalesInTheWeekBySupplier extends Component
{
    public $carbon;
    public $start_date;
    public $end_date;
    public $products;
    public $growth;
    public $overall_growth;
    public $full_percent;
    public $branches;

    public function mount(Request $request)
    {
        $this->start_date = Carbon::now()->startOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        $this->end_date = Carbon::now()->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');
        $this->branches = Branch::with(['product' => function($query) {
            $query->with(['userPurchasedProduct' => function($query) {
                $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
            }]);
        }])
        ->get();
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.sales-in-the-week-by-supplier');
    }
}
