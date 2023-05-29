<div class="relative">
    <x-label for="name" value="{{ __('Name') }}" />
    <x-input wire:model.lazy='name' id="name" class="block mt-1 w-full" type="text" name="name" autofocus autocomplete="name" />
    <x-input-error for="name" class="mt-2" />
</div>

<div class="mt-4 relative">
    <x-label for="last_name" value="{{ __('Last Name') }}" />
    <x-input wire:model.lazy='last_name' id="last_name" class="block mt-1 w-full" type="text" name="last_name" autocomplete="last:name" />
    <x-input-error for="last_name" class="mt-2" />
</div>

<div class="mt-4 relative">
    <x-label for="email" value="{{ __('Email') }}" />
    <x-input wire:model.lazy='email' id="email" class="block mt-1 w-full" type="email" name="email" autocomplete="username" />
    <x-input-error for="email" class="mt-2" />
</div>

<div class="mt-4 relative">
    <x-label for="password" value="{{ __('Password') }}" />
    <x-input wire:model.lazy='password' id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
    <x-input-error for="password" class="mt-2" />
</div>

<div class="mt-4 relative">
    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
    <x-input wire:model.lazy='password_confirmation' id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
    <x-input-error for="password_confirmation" class="mt-2" />
</div>

<div class="mt-4">
    <div class="relative">
        <x-label for="role" :value="__('Role')" />
        <x-select wire:model='role'>
            @foreach($roles as $rol)
                <option value="{{ $rol->id }}">{{ ucfirst($rol->name) }}</option>
            @endforeach
        </x-select>
    </div>
    <x-input-error for="category_id" class="mt-2" />
</div>
