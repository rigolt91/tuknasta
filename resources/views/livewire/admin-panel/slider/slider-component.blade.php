<div class="py-6">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel-component')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="sm:grid sm:grid-cols-2">
            <div class="mx-2">
                <x-card>
                    <x-card-body>
                        <form wire:submit.prevent='store' method="post">
                            @csrf

                            <div class="flex items-center justify-center w-full mr-4 mb-4 text-sm text-gray-500 border border-green-400 rounded-md" style="height: 80px;">
                                @if($image)
                                    <img wire:loading.class='opacity-25' wire:target='image' src="{{ Storage::exists($image) ? Storage::url($image) : $image->temporaryUrl() }}" class="rounded-md flex items-center justify-center text-xs w-full" style="height: 80px;" alt="{{__('Image')}}">
                                @else
                                    <span wire:loading.class='hidden'>"JPEG"</span>
                                @endif
                                <div wire:loading wire:target='image' class="absolute text-bold">{{__('Charging')}}...</div>
                            </div>

                            <div class="w-full">
                                <div class="mb-4">
                                    <div class="relative">
                                        <x-label for="image" :value="__('Image')" />
                                        <x-input wire:model='image' type="file" class="text-sm file:p-2 file:border-none file:bg-green-200 file:text-gray-500 file:cursor-pointer focus:outline-none focus:shadow-[0_0_0_1px] focus:shadow-green-500 hover:file:bg-green-700 hover:file:text-white block w-full" :value="old('image', $image)" autofocus autocomplete="image" />
                                    </div>
                                    <x-input-error for="image" class="mt-2" />
                                </div>

                                <div class="mt-2 mb-4">
                                    <div class="relative">
                                        <x-label for="name" :value="__('Title')" />
                                        <x-input wire:model.lazy='title' type="text" class="block w-full mt-1" :value="old('title', $title)" placeholder="{{__('Title of slider')}}" autocomplete="title" />
                                    </div>
                                    <x-input-error for="title" class="mt-2" />
                                </div>

                                <div class="mt-2 mb-4">
                                    <div class="relative">
                                        <x-label for="text" :value="__('Text')" />
                                        <x-input wire:model.lazy='text' type="text" class="block w-full mt-1" :value="old('text', $text)" placeholder="{{__('Text of slider')}}" autocomplete="text" />
                                    </div>
                                    <x-input-error for="text" class="mt-2" />
                                </div>

                                <div class="my-2 mb-4">
                                    <div class="relative">
                                        <x-label for="link" :value="__('Link')" />
                                        <x-select wire:model='link' class="mt-1.5">
                                            <option value="" selected>{{__('Productos')}}</option>
                                            @foreach ($products as $product)
                                                <option value="/product/details/{{ $product->slug }}">{{ $product->name }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <x-input-error for="link" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex justify-end -mb-4">
                                <x-button type="submit" wire:loading.attr="disabled" class="ml-2 disabled:opacity-60">
                                    {{ __('Save') }}
                                    <x-icon-spin wire:loading wire:target="store" class="ml-1" />
                                </x-button>
                            </div>
                        </form>
                    </x-card-body>
                </x-card>
            </div>

            <div class="mx-2">
                @foreach($images as $key => $img)
                    <div class="shadow-md rounded-md flex items-center p-3 my-2 justify-end bg-right bg-no-repeat bg-cover h-16" style="background-image: url('{{ Storage::url($img->image) }}')">
                        <x-button wire:click="edit({{ $img }})" wire.target="edit" wire:loading.attr="disabled" class="flex items-center mr-2 h-8 disabled:opacity-60">
                            <x-icon-edit />
                            <span class="hidden ml-2 sm:block">{{ __('Edit') }}</span>
                        </x-button>

                        <x-button-danger wire:click="delete({{ $img }})" wire.target="delete" wire:loading.attr="disabled" class="flex items-center h-8 disabled:opacity-60">
                            <x-icon-trash />
                            <span class="hidden ml-2 sm:block">{{ __('Delete') }}</span>
                        </x-button-danger>
                    </div>
                @endforeach
            </div>
    </div>
</div>
