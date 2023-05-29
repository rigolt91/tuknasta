<?php

namespace App\Http\Livewire\AdminPanel\Reports\Components;

use Livewire\Component;
use App\Models\UserPurchasedProduct;

class Products extends Component
{
    public $date;
    public $start_date;
    public $end_date;

    public function render()
    {
        return view('livewire.admin-panel.reports.components.products', [
            'purchased_products' => UserPurchasedProduct::when($this->date, function($query) {
                                        $query->where('created_at', 'like' ,'%'.$this->date.'%');
                                    })
                                    ->when($this->start_date, function($query) {
                                        $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
                                    })
                                    ->sum('units'),
        ]);
    }
}
