<?php

namespace App\Http\Livewire\AdminPanel\Reports;

use Livewire\Component;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailySales extends Component
{
    public $date;

    public function mount(Request $request)
    {
        $this->date = $request->date ?: Carbon::now()->toDay()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.daily-sales', [
            'products' => Product::select('id', 'name')->get(),
        ]);
    }
}
