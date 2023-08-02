<?php

namespace App\Http\Livewire\AdminPanel\Reports\Components;

use Livewire\Component;
use App\Models\UserPurchasedProduct;

class Products extends Component
{
    public $date, $start_date, $end_date, $purchased_products;

    public function mount()
    {
        $this->purchased_products = UserPurchasedProduct::whereDate($this->date)
                        ->when($this->start_date, function($query) {
                            $query->whereDateBetween($this->start_date, $this->end_date);
                        })->sum('units');
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.components.products');
    }
}
