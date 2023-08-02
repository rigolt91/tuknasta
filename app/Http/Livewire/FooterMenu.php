<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UpagosDirect;

class FooterMenu extends Component
{
    public $email = '';
    public $phone = '';
    public $address = '';
    public $facebook = '';
    public $instagram = '';
    public $twitter = '';
    public $google = '';
    public $linkedin = '';

    public function mount()
    {
        $upagosDirect = UpagosDirect::first();

        $this->email = $upagosDirect->email;
        $this->phone = $upagosDirect->phone;
        $this->address = $upagosDirect->address;
        $this->facebook = $upagosDirect->facebook;
        $this->instagram = $upagosDirect->instagram;
        $this->twitter = $upagosDirect->twitter;
        $this->google = $upagosDirect->google;
        $this->linkedin = $upagosDirect->linkedin;
    }

    public function render()
    {
        return view('footer-menu');
    }
}
