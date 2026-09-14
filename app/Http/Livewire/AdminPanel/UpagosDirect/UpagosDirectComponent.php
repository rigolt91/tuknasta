<?php

namespace App\Http\Livewire\AdminPanel\UpagosDirect;

use Livewire\Component;
use App\Models\UpagosDirect;

class UpagosDirectComponent extends Component
{
    public $setting;
    public $email;
    public $phone;
    public $address;
    public $facebook;
    public $instagram;
    public $twitter;
    public $google;
    public $linkedin;

    public $rules = [
        'email' => 'email|nullable',
        'phone' => 'string|nullable',
        'address' => 'string|nullable',
        'facebook' => 'string|nullable',
        'instagram' => 'string|nullable',
        'twitter' => 'string|nullable',
        'google' => 'string|nullable',
        'linkedin' => 'string|nullable',
    ];

    public function mount() {
        $setting = UpagosDirect::first();

        if($setting) {
            $this->email = $setting->email;
            $this->phone = $setting->phone;
            $this->address = $setting->address;
            $this->facebook = $setting->facebook;
            $this->instagram = $setting->instagram;
            $this->twitter = $setting->twitter;
            $this->google = $setting->google;
            $this->linkedin = $setting->linkedin;
        }
    }

    public function store()
    {
        $validate = $this->validate();

        !UpagosDirect::first() ? UpagosDirect::create($validate) : $this->update();
    }

    public function update()
    {
        $validate = $this->validate();
        $upagosDirect = $upagosDirect = UpagosDirect::first();
        $upagosDirect->update($validate);
    }

    public function render()
    {
        return view('livewire.admin-panel.upagos-direct.upagos-direct-component');
    }
}
