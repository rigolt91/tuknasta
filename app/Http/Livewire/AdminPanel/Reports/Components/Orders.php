<?php

namespace App\Http\Livewire\AdminPanel\Reports\Components;

use Livewire\Component;
use App\Models\UserOrder;

class Orders extends Component
{
    public $date;
    public $start_date;
    public $end_date;

    public function render()
    {
        return view('livewire.admin-panel.reports.components.orders', [
            'orders' => UserOrder::when($this->date, function($query) {
                            $query->where('created_at', 'like' ,'%'.$this->date.'%');
                        })
                        ->when($this->start_date, function($query) {
                            $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
                        })
                        ->count(),
        ]);
    }
}
