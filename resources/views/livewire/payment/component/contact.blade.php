<div>
    @if($contact)
        <div wire:loading.class="opacity-60">
            <div class="mb-1">
                <span class="text-gray-700 font-semibold">{{__('Receiver')}}: </span>
                <span class="text-gray-700">{{ $contact->name.' '.$contact->last_name }}</span>
            </div>
            <div class="mb-1">
                <span class="text-gray-700 font-semibold">{{__('Phone')}}: </span>
                <span class="text-gray-700">{{ !empty($contact->phone) ? $contact->phone : __('Please provide a valid phone number') }}</span>
            </div>
            <div class="mb-1">
                <span class="text-gray-700 font-semibold">{{__('Email')}}: </span>
                <span class="text-gray-700">{{ !empty($contact->email) ? $contact->email : __('Provide a valid email address') }}</span>
            </div>
            <div class="mb-1">
                <span class="text-gray-700 font-semibold">{{__('Address')}}: </span>
                <span class="text-gray-700">{{ !empty($contact->street) ? $contact->street.' Nro.'.$contact->number.' '.$contact->between_streets : __('Please provide a valid address') }}</span>
            </div>
            <div class="mb-1">
                <span class="text-gray-700 font-semibold">{{__('Province')}}: </span>
                <span class="text-gray-700">{{ !empty($contact->province->name) ? $contact->province->name : __('Please provide a valid province name') }}</span>
            </div>
            <div class="mb-1">
                <span class="text-gray-700 font-semibold">{{__('Municipality')}}: </span>
                <span class="text-gray-700">{{ !empty($contact->municipality->name) ? $contact->municipality->name : __('Please provide a valid municipality name') }}</span>
            </div>
        </div>
    @else
        <div class="text-gray-700">{{__('Add a shipping address')}}</div>
    @endif
</div>
