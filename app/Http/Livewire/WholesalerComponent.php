<?php

namespace App\Http\Livewire;

use App\Mail\Wholesaler;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class WholesalerComponent extends Component
{
    public $subject;
    public $email;
    public $message;
    public $form;

    public function store()
    {
        $this->validate([
            'subject' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        try {
            Mail::to(config('mail.from.address'))
                ->send(new Wholesaler($this->subject, $this->email, $this->message));

            session()->flash('message', 'Message sent, someone will contact you shortly.');
        } catch (\Throwable $th) {
            session()->flash('message', 'Error, message not sent');
        }

        $this->subject = '';
        $this->email = '';
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.wholesaler-component');
    }
}
