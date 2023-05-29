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
        $year = Carbon::now()->format('Y');
        $this->date = Carbon::now()->format('Y-m');

        $this->months = [
            ['mm' => "$year-01", 'name'=>'January'],
            ['mm' => "$year-02", 'name'=>'February'],
            ['mm' => "$year-03", 'name'=>'March'],
            ['mm' => "$year-04", 'name'=>'April'],
            ['mm' => "$year-05", 'name'=>'May'],
            ['mm' => "$year-06", 'name'=>'June'],
            ['mm' => "$year-07", 'name'=>'July'],
            ['mm' => "$year-08", 'name'=>'August'],
            ['mm' => "$year-09", 'name'=>'September'],
            ['mm' => "$year-10", 'name'=>'October'],
            ['mm' => "$year-11", 'name'=>'November'],
            ['mm' => "$year-12", 'name'=>'December'],
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
