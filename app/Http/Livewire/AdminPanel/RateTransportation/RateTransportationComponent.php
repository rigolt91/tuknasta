<?php

namespace App\Http\Livewire\AdminPanel\RateTransportation;

use App\Models\Province;
use App\Models\RateTransportation;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RateTransportationComponent extends Component
{
    use WithPagination, AuthorizesRequests;

    public $province_id;

    protected $listeners = ['refreshRateTransportation' => '$refresh'];

    public function create() {
        $this->emit('openModal', 'admin-panel.rate-transportation.create-component');
    }

    public function edit($rateTransportation) {
        $this->emit('openModal', 'admin-panel.rate-transportation.edit-component', ['rateTransportation' => $rateTransportation]);
    }

    public function delete(RateTransportation $rateTransportation) {
        $this->authorize('delete', $rateTransportation);
        $rateTransportation->delete();
        $this->emit('refreshRateTransportation');
    }

    public function render()
    {
        return view('livewire.admin-panel.rate-transportation.rate-transportation-component', [
            'provinces' => Province::all(),
            'rateTransportations' => RateTransportation::whereProvince($this->province_id)->paginate(10)
        ]);
    }
}
