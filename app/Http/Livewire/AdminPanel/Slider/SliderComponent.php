<?php

namespace App\Http\Livewire\AdminPanel\Slider;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;
use App\Models\Product;

class SliderComponent extends Component
{
    use WithFileUploads;

    public $slider, $title, $text, $link, $image;

    public $rules = [
        'title' => 'nullable|string',
        'text'  => 'nullable|string',
        'link'  => 'nullable',
        'image' => 'required|mimes:jpeg,png,bmp,gif|max: 2000'
    ];

    public function store()
    {
        if ($this->slider) {
            $this->update($this->slider);
        } else {
            $validate = $this->validate();

            $image = $this->image->storeAs("public/slider/$this->title", substr(sha1(rand(1, 999)), 0, -30) . '.jpg');

            Slider::create([
                'title' => $this->title,
                'text'  => $this->text,
                'link'  => !empty($link) ? $this->link : '/products',
                'image' => $image,
            ]);
        }

        $this->clear();
    }

    public function edit(Slider $slider)
    {
        $this->title = $slider->title;
        $this->text  = $slider->text;
        $this->link  = $slider->link;
        $this->image = $slider->image;
        $this->slider = $slider;
    }

    public function update()
    {
        $validate = $this->validate([
            'title' => 'required|string',
            'text'  => 'required|string',
            'link'  => 'nullable',
            'image' => 'required'
        ]);

        if (Storage::exists($this->image)) {
            $image = $this->image;
        } else {
            $image = $this->image->storeAs("public/slider/$this->title", substr(sha1(rand(1, 999)), 0, -30) . '.jpg');
        }

        $this->slider->update([
            'title' => $this->title,
            'text'  => $this->text,
            'link'  => $this->link,
            'image' => $image,
        ]);
    }

    public function delete(Slider $slider)
    {
        $slider->delete();

        $this->slider = '';

        $this->clear();
    }

    public function clear()
    {
        $this->title = '';
        $this->text  = '';
        $this->link  = '';
        $this->image = '';
    }

    public function render()
    {
        return view('livewire.admin-panel.slider.slider-component', [
            'images' => Slider::all(),
            'products' => Product::select('id', 'name', 'slug')->get()
        ]);
    }
}
