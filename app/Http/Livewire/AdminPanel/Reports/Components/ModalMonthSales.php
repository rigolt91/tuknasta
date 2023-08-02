<?php

namespace App\Http\Livewire\AdminPanel\Reports\Components;

use LivewireUI\Modal\ModalComponent;
use Carbon\Carbon;

class ModalMonthSales extends ModalComponent
{
    public $date;
    public $months;

    public function mount()
    {
        $yy = Carbon::now()->format('Y');

        $this->date = Carbon::now()->format('Y-m');

        $this->months = [
            ['mm' => "$yy-01", 'name'=>'January'],
            ['mm' => "$yy-02", 'name'=>'February'],
            ['mm' => "$yy-03", 'name'=>'March'],
            ['mm' => "$yy-04", 'name'=>'April'],
            ['mm' => "$yy-05", 'name'=>'May'],
            ['mm' => "$yy-06", 'name'=>'June'],
            ['mm' => "$yy-07", 'name'=>'July'],
            ['mm' => "$yy-08", 'name'=>'August'],
            ['mm' => "$yy-09", 'name'=>'September'],
            ['mm' => "$yy-10", 'name'=>'October'],
            ['mm' => "$yy-11", 'name'=>'November'],
            ['mm' => "$yy-12", 'name'=>'December'],
        ];
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.components.modal-month-sales');
    }
}
