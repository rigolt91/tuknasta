<div class="py-8">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-2">
            <x-card>
                <x-card-body class="flex sm:-m-8">
                    <div class="-mx-4 -my-6 bg-right bg-no-repeat bg-cover sm:bg-auto sm:h-64 sm:m-0 sm:rounded-r-md " style="background-image: url({{ asset('tukanasta.jpg') }})">
                        <div class="w-full pr-8 m-4 text-white sm:m-8 sm:w-8/12 sm:text-gray-700 bg">
                            <div class="mb-2 text-xl font-bold text-white border-b sm:text-gray-800">
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
