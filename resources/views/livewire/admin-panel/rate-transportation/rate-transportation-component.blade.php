<div class="py-6">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel-component')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-4 sm:mx-2">
            <x-card>
                <x-card-body>
                    <div class="pb-2 mb-2 -mt-2 font-bold border-b border-green-300">
                        {{ __('Transportation') }}

                        @hasrole(['administrator'])
                            <x-button-inline wire:click="create" class="flex float-right -mt-2">
                                <x-icon-file-plus />
                                <span class="ml-1">{{ __('Add') }}</span>
                            </x-button-inline>
                            <div class="flex items-center hidden float-right w-48 mr-2 -mt-2 sm:block">
                                <select wire:model='province_id' class="peer font-normal h-9 w-full rounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                    <option value="" selected>{{__('All provinces')}}</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ __($province->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endhasrole
                    </div>
                    <div class="relative overflow-x-auto">
                        <x-table class="w-full">
                            <x-thead>
                                <x-tr>
                                    <x-th>#</x-th>
                                    <x-th>{{ __('Province') }}</x-th>
                                    <x-th>{{ __('Municipality') }}</x-th>
                                    <x-th>{{ __('Price') }}</x-th>
                                    @hasrole(['administrator'])
                                        <x-th class="float-right">{{ __('Options') }}</x-th>
                                    @endhasrole
                                </x-tr>
                            </x-thead>
                            <tbody>
                                @foreach ($rateTransportations as $key => $rateTransportation)
                                    <x-tr wire:loading.class="opacity-60">
                                        <x-td>{{ ++$key }}</x-td>
                                        <x-td>{{ $rateTransportation->province->name }}</x-td>
                                        <x-td>{{ $rateTransportation->municipality->name }}</x-td>
                                        <x-td>{{ $rateTransportation->amount }}</x-td>
                                        @hasrole(['administrator'])
                                            <x-td class="flex float-right">
                                                <x-button wire:click="edit({{ $rateTransportation }})"
                                                    wire:loading.attr="disabled"
                                                    class="flex items-center mx-1 disabled:opacity-60">
                                                    <x-icon-edit />
                                                    <span class="hidden sm:ml-2 sm:block">{{ __('Edit') }}</span>
                                                </x-button>

                                                <x-button-danger wire:click="delete({{ $rateTransportation }})"
                                                    wire:loading.attr="disabled"
                                                    class="flex items-center disabled:opacity-60">
                                                    <x-icon-trash />
                                                    <span class="hidden sm:ml-2 sm:block">{{ __('Delete') }}</span>
                                                </x-button-danger>
                                            </x-td>
                                        @endhasrole
                                    </x-tr>
                                @endforeach
                            </tbody>
                        </x-table>
                    </div>

                    <div class="mt-4">
                        {{ $rateTransportations->links() }}
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
