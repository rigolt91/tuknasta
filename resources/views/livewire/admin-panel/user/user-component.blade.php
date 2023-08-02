<div class="py-6">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel-component')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-2">
            <x-card>
                <x-card-body>
                    <div class="pb-2 mb-2 -mt-2 font-bold border-b border-green-300">
                        {{ __('Users') }} <span>({{ $users->count() }})</span>

                        <x-button-inline wire:click="create" class="flex float-right -mt-2">
                            <x-icon-file-plus />
                            <span class="ml-1">{{ __('Add') }}</span>
                        </x-button-inline>
                    </div>
                    <div class="relative overflow-x-auto">
                        <x-table class="w-full">
                            <x-thead >
                                <x-tr>
                                    <x-th>#</x-th>
                                    <x-th>{{ __('Name') }}</x-th>
                                    <x-th>{{ __('Last Name') }}</x-th>
                                    <x-th>{{ __('Email') }}</x-th>
                                    <x-th>{{ __('Role') }}</x-th>
                                    <x-th>{{ __('Disabled') }}</x-th>
                                    <x-th class="float-right">{{ __('Options') }}</x-th>
                                </x-tr>
                            </x-thead>
                            <tbody>
                                @foreach ($users->except($userId) as $key => $user)
                                    <x-tr wire:loading.class="opacity-60">
                                        <x-td>{{ ++$key }}</x-td>
                                        <x-td>{{ $user->name }}</x-td>
                                        <x-td>{{ $user->last_name }}</x-td>
                                        <x-td>{{ $user->email }}</x-td>
                                        <x-td>{{ ucfirst($user->modelHasRole->role->name) }}</x-td>
                                        <x-td>
                                            <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                                <input type="checkbox" wire:click="disabled({{ $user}})" wire:loading.attr="disabled" class="sr-only peer disabled:opacity-60" @if($user->disabled) checked @endif >
                                                <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600"></div>
                                            </label>
                                        </x-td>
                                        <x-td class="flex float-right">
                                            <x-button type="button" wire:click="edit({{ $user }})" wire:loading.attr="disabled" class="mr-1 disabled:opacity-60">
                                                <x-icon-edit />
                                                <span class="hidden ml-1 sm:block">{{ __('Edit') }}</span>
                                            </x-button>

                                            <x-button-danger type="button" wire:click="delete({{ $user }})" wire:loading.attr="disabled" class="disabled:opacity-60">
                                                <x-icon-trash />
                                                <span class="hidden ml-1 sm:block">{{ __('Delete') }}</span>
                                            </x-button-danger>
                                        </x-td>
                                    </x-tr>
                                @endforeach
                            </tbody>
                        </x-table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
