<?php

namespace App\Http\Livewire\AdminPanel\RateTransportation;

use App\Models\Municipality;
use App\Models\Province;
use App\Models\RateTransportation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

class EditComponent extends ModalComponent
{
    use AuthorizesRequests;

    public $rateTransportation, $province_id, $municipality_id, $amount;

    public $rules = [
        'province_id' => 'required',
        'municipality_id' => 'required',
        'amount' => 'nullable|numeric',
    ];

    public function mount(RateTransportation $rateTransportation)
    {
        $this->rateTransportation = $rateTransportation;
        $this->province_id = $rateTransportation->province_id;
        $this->municipality_id = $rateTransportation->municipality_id;
        $this->amount = $rateTransportation->amount;
    }

    public function update(RateTransportation $rateTransportation)
    {
        $this->authorize('update', $rateTransportation);
        $validated = $this->validate();

        $this->rateTransportation->update($validated);

        $this->closeModalWithEvents([RateTransportationComponent::getName() => 'refreshRateTransportation']);
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.admin-panel.rate-transportation.edit-component', [
            'provinces' => Province::all(),
            'municipalities' => Municipality::whereProvinceId($this->province_id)->get(),
        ]);
    }
}
