<?php

namespace App\Http\Livewire\AdminPanel\Reports\Components;

use Illuminate\Http\Request;
use LivewireUI\Modal\ModalComponent;
use Carbon\Carbon;

class ModalWeeklySales extends ModalComponent
{
    public $start_date;
    public $end_date;
    public $start;
    public $end;

    public function mount()
    {
        $this->start = Carbon::now()->subWeek()->startOfWeek();
        $this->end = Carbon::now()->startOfWeek();
        $this->dateFormat();
    }

    public function dateFormat()
    {
        $this->start_date = $this->start->format('Y-m-d');
        $this->end_date = $this->end->format('Y-m-d');
    }

    public function previousWeek()
    {
        $this->start = $this->start->subWeek()->startOfWeek();
        $this->end = $this->end->subWeek()->startOfWeek();
        $this->dateFormat();
    }

    public function nextWeek()
    {
        $this->start = $this->start->addWeek()->startOfWeek();
        $this->end = $this->end->addWeek()->startOfWeek();
        $this->dateFormat();
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.reports.components.modal-weekly-sales');
    }
}
