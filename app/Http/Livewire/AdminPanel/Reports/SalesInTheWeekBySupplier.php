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
        $this->carbon = new Carbon;
        $this->start_date = $request->start_date ?: Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
        $this->end_date = $request->end_date ?: Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->branches = Branch::all();
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.sales-in-the-week-by-supplier');
    }
}
