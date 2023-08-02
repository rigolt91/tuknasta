<?php

namespace App\Http\Livewire\AdminPanel\Order;

use LivewireUI\Modal\ModalComponent;

class SearchComponent extends ModalComponent
{
    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function render()
    {
        return view('livewire.admin-panel.order.search-component');
    }
}
