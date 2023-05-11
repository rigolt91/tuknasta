<div>
    <x-card>
        <x-card-header  class="-m-6 bg-green-700">
            <div class="flex py-2 mx-4 text-lg font-bold text-white">
                <span class="mt-2 ml-2">{{ __('My Contacts') }}</span>

                <button wire:click="$emit('closeModal')" type="button" class="float-right sm:ml-auto ml-auto mt-2 sm:-mx-1.5 text-gray-800 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-100 hover:text-green-900 inline-flex h-8 w-8"  aria-label="Close">
                    <span class="sr-only">{{__('Close')}}</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </x-card-header>

        <x-card-body class="mt-6 sm:mx-2">
            @if($contacts->count() ==  0)
                <div class="text-gray-700 text-md">Add contacts to your list.</div>
            @else
                <x-table class="text-md">
                    <x-thead>
                        <x-tr>
                            <x-th>#</x-th>
                            <x-th>{{__('Nombre y Apellidos')}}</x-th>
                            <x-th>{{__('Preferido')}}</x-th>
                            <x-th>{{__('Opciones')}}</x-th>
                        </x-tr>
                    </x-thead>
                    <body>
                        @foreach ($contacts as $key => $contact)
                            <x-tr>
                                <x-td>{{ ++$key }}</x-td>
                                <x-td>{{ $contact->name.' '.$contact->last_name }}</x-td>
                                <x-td>
                                    <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                        <input wire:click='setFavorite({{ $contact->id }})' wire:loading.attr='disabled' type="checkbox" class="sr-only peer" @if($contact->prefer) checked @endif />
                                        <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600"></div>
                                    </label>
                                </x-td>
                                <x-td>
                                    <div class="flex items-center">
                                        <x-icon-edit wire:click="$emit('openModal', 'profile.my-contact.edit', [{{$contact->id}}])" class="mr-1 text-green-700 rounded hover:text-green-400 hover:cursor-pointer" width="24" height="24"/>
                                        <x-icon-trash wire:click="$emit('openModal', 'profile.my-contact.destroy', [{{$contact->id}}])" class="ml-1 text-red-700 rounded hover:text-red-500 hover:cursor-pointer" width="24" height="24" />
                                    </div>
                                </x-td>
                            </x-tr>
                        @endforeach
                    </body>
                </x-table>
            @endif

            <div class="flex justify-end">
                <x-button wire:click="$emit('openModal', 'profile.my-contact.create')" type="button" class="flex mt-4 -mb-4">
                    <svg fill="currentColor" class="h-4 mr-1 bi bi-pencil-fill" viewBox="0 0 16 16">
                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                    </svg>
                    {{ __('New Contact') }}
                </x-button>
            </div>
        </x-card-body>
    </x-card>
</div>
