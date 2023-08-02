<?php

namespace App\Http\Livewire\AdminPanel\Reports\Components;

use Livewire\Component;
use App\Models\UserOrder;

class Orders extends Component
{
    public $date, $start_date, $end_date, $orders;

    public function mount()
    {
        $this->orders = UserOrder::whereDate($this->date)
                        ->when($this->start_date, function ($query) {
                            $query->whereDateBetween($this->start_date, $this->end_date)->count();
                        })->count();
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.components.orders');
    }
}
