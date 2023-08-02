<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Slider;

class SliderComponent extends Component
{
    public function action($link)
    {
        return redirect($link);
    }

    public function render()
    {
        return view('livewire.slider-component', [
            'sliders' => Slider::all()
        ]);
    }
}
