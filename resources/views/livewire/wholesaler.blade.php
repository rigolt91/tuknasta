<div class="py-6">
    <x-slot name="header">
        <h2 class="font-semibold text-md text-gray-800 leading-tight">
            {{ __('Wholesaler') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
        <div class="mx-2">
            <x-card>
                <x-card-body class="flex sm:-m-8">
                    <div class="bg-no-repeat bg-right sm:bg-auto sm:h-64 -mx-4 -my-6 sm:m-0 bg-cover sm:rounded-r-md " style="background-image: url({{ asset('tukanasta.jpg') }})">
                        <div class="sm:m-8 m-4 sm:w-8/12 w-full pr-8 text-white sm:text-gray-700 bg">
                            <div class="text-xl text-white sm:text-gray-800 font-bold border-b mb-2">
                                {{__('Wholesaler')}}
                            </div>
                            {{ __('Do you need to make wholesale purchases for your business in Cuba? Tukanasta has a variety of wholesale options to always offer you the best and at the best price. Learn about all the offers available on the online platform and contact our sales team by email') }}:
                            <b><a href="mailto:{{ $email }}">{{ $email }}</a></b>
                        </div>
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
