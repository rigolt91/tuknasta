<div class="mt-8">
    <div class="sm:grid sm:grid-cols-2">
        <div class="mr-2">
            <div class="flex my-2">
                <div class="flex items-center justify-center w-40 mr-4 text-sm text-gray-500 border border-green-400 rounded-md" style="height: 112px; width:140px;">
                    @if($image)
                        @isset($product)
                            <img wire:loading.class='opacity-25' wire:target='image' src="{{ ($image !== $product->image) ? $image->temporaryUrl() : Storage::url($product->image) }}" class="rounded-md" style="height: 100 px;  width:118px;">
                        @else
                            <img wire:loading.class='opacity-25' wire:target='image' src="{{ $image->temporaryUrl() }}" class="rounded-md" style="height: 100 px;  width:118px;">
                        @endisset

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
                            <x-label for="name" :value="__('Name')" />
                            <x-input wire:model.lazy='name' type="text" class="block w-full mt-1" :value="old('name', $name)" placeholder="{{__('Product name')}}" autocomplete="name" />
                        </div>
                        <x-input-error for="name" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="mb-4 -mt-2">
                <div class="relative">
                    <x-label for="sku" :value="__('Inventory')" />
                    <x-input wire:model.lazy='sku' type="text" class="block w-full mt-1" :value="old('sku', $sku)" placeholder="{{__('Warehouse inventory')}}" autocomplete="sku" />
                </div>
                <x-input-error for="sku" class="mt-2" />
            </div>
            <div class="my-2 mb-4">
                <div class="relative">
                    <x-label for="slug" :value="__('Slug')" />
                    <x-input wire:model.lazy='slug' type="text" class="block w-full mt-1" :value="old('slug', $slug)" placeholder="{{__('Product slug')}}" autocomplete="slug" />
                </div>
                <x-input-error for="slug" class="mt-2" />
            </div>
            <div class="my-2 mb-4">
                <div class="relative">
                    <x-label for="short_description" :value="__('Short Description')" class="block mt-1" />
                    <x-textarea wire:model.lazy='short_description' class="mt-1" placeholder="{{__('Short product description')}}" autocomplete="short_description" />
                </div>
                <x-input-error for="short_description" class="mt-2" />
            </div>
            <div class="my-2 mb-4">
                <div class="relative">
                    <x-label for="branch_id" :value="__('Branch')" />
                    <x-select wire:model='branch_id' class="mt-1.5">
                        <option value="" selected disabled>{{__('Branches')}}</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </x-select>
                </div>
                <x-input-error for="branch_id" class="mt-2" />
            </div>
        </div>
        <div class="sm:ml-2">
            <div class="my-2 mb-4">
                <div class="relative">
                    <x-label for="price" :value="__('Price')" />
                    <x-input wire:model.lazy='price' type="number" step="any" min="0" class="block w-full mt-1" :value="old('price', $price)" placeholder="{{__('Price of the product')}}" autocomplete="price" />
                </div>
                <x-input-error for="price" class="mt-2" />
            </div>
            <div class="my-2 mb-4">
                <div class="relative">
                    <x-label for="stock" :value="__('Stock')" />
                    <x-input wire:model.lazy='stock' type="number" class="block w-full mt-1" :value="old('stock', $stock)" placeholder="{{__('Number of units in stock')}}" autocomplete="stock" />
                </div>
                <x-input-error for="stock" class="mt-2" />
            </div>
            <div class="mt-2 mb-4">
                <div class="relative">
                    <x-label for="category_id" :value="__('Category')" />
                    <x-select wire:model='category_id' class="mt-1">
                        <option value="" selected disabled>{{__('Product categories')}}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                        @endforeach
                    </x-select>
                </div>
                <x-input-error for="category_id" class="mt-2" />
            </div>
            <div class="my-2 mb-4">
                <div class="relative">
                    <x-label for="subcategory_id" :value="__('Subcategory')" />
                    <x-select wire:model='subcategory_id' class="mt-1.5">
                        <option value="" selected disabled>{{__('Product subcategories')}}</option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ __($subcategory->name) }}</option>
                        @endforeach
                    </x-select>
                </div>
                <x-input-error for="subcategory_id" class="mt-2" />
            </div>
            <div class="my-2 mb-4">
                <div class="relative">
                    <x-label for="description" :value="__('Description')" class="block mt-1" />
                    <x-textarea wire:model.lazy='description' class="h-32 mt-1" placeholder="{{__('Product description')}}" autocomplete="description" />
                </div>
                <x-input-error for="description" class="mt-2" />
            </div>
        </div>
    </div>
</div>
