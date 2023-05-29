<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\App;

class LangApp extends Component
{
    public $lang;

    public function mount()
    {
        $this->lang = App::currentLocale();
    }

    public function render()
    {
        return view('livewire.lang-app');
    }
}
