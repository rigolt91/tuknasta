<?php

namespace App\Http\Livewire\AdminPanel\Reports\Components;

use Livewire\Component;
use App\Models\UserPurchasedProduct;

class Profits extends Component
{
    public $date, $start_date, $end_date, $profits;

    public function mount()
    {
        $this->profits = UserPurchasedProduct::selectRaw('units * price as amount')
                        ->whereDate($this->date)
                        ->when($this->start_date, function ($query) {
                            $query->whereDateBetween($this->start_date, $this->end_date);
                        })->get()->sum('amount');
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.components.profits');
    }
}
