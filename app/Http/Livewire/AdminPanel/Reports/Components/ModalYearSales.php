<?php

namespace App\Http\Livewire\AdminPanel\Reports\Components;

use App\Models\UserPurchasedProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class ModalYearSales extends ModalComponent
{
    public $years;
    public $date;

    public function mount()
    {
        $this->years = UserPurchasedProduct::groupByYear()->get();
        $this->date = Carbon::now()->format('Y');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.components.modal-year-sales');
    }
}
