<?php

namespace App\Http\Livewire\AdminPanel\RateTransportation;

use App\Models\Municipality;
use App\Models\Province;
use App\Models\RateTransportation;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateComponent extends ModalComponent
{
    use AuthorizesRequests;

    public $province_id, $municipality_id, $amount;

    public $rules = [
        'province_id' => 'required',
        'municipality_id' => 'required',
        'amount' => 'nullable|numeric',
    ];

    public function store(RateTransportation $rateTransportation)
    {
        $this->authorize('create', $rateTransportation);
        $validated = $this->validate();

        $rateTransportation->create($validated);

        $this->closeModalWithEvents([RateTransportationComponent::getName() => 'refreshRateTransportation']);
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.admin-panel.rate-transportation.create-component',  [
            'provinces' => Province::all(),
            'municipalities' => Municipality::whereProvinceId($this->province_id)->get(),
        ]);
    }
}
