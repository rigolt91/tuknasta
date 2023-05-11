<?php

namespace App\Http\Livewire\AdminPanel\Reports\Components;

use App\Models\UserPurchasedProduct;
use LivewireUI\Modal\ModalComponent;
use Carbon\Carbon;

class ModalDailySales extends ModalComponent
{
    public $date;

    public function mount()
    {
        $this->date = Carbon::now()->format('Y-m-d');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.components.modal-daily-sales', [
            'dates' => UserPurchasedProduct::select('created_at')->where('created_at', 'like', '%'.date('Y-m').'%')->groupBy('created_at')->get(),
        ]);
    }
}
