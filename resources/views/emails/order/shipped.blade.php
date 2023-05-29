<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-90551dfd.css') }}">
    <style>
        h2, h4, table, tr, td, div {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
        td {
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>
</head>
<body>
    <div>
        <h2 class="text-lg">{{ config('app.name') }}</h2>

        <h4>{{ __('Thank you for comparing in our store, these are the details of your purchase') }}:</h4>

        <x-table>
            <x-thead>
                <x-tr>
                    <x-th style="text-align: left; width:20%; padding:10px;">{{__('Order Number')}}</x-th>
                    <x-td style="text-align: left; width:60%; padding:10px;">{{ $order->number }}</x-td>
                </x-tr>
                <x-tr>
                    <x-th style="text-align: left; padding:10px;">{{__('Status')}}</x-th>
                    <x-td style="text-align: left; padding:10px;">{{ $order->orderStatus->name }}</x-td>
                </x-tr>
                <x-tr>
                    <x-th style="text-align: left; padding:10px;">{{__('Products')}} ({{ $order->userPurchasedProduct()->count() }})</x-th>
                    <x-td style="text-align: left; padding:10px;">
                        <x-table>
                            <x-thead>
                                <x-tr style="background-color: rgb(189, 189, 189);">
                                    <x-td>Nro</x-td>
                                    <x-td style="padding:5px;">{{__('Name')}}</x-td>
                                    <x-td style="padding:5px;">{{__('Units')}}</x-td>
                                    <x-td style="padding:5px;">{{__('Price')}}</x-td>
                                </x-tr>
                            </x-thead>
                            <tbody>
                                @foreach ($order->userPurchasedProduct as $key => $product)
                                    <x-tr>
                                        <x-td style="padding:5px;">{{ ++$key }}</x-td>
                                        <x-td style="padding:5px;">{{ $product->product->name }}</x-td>
                                        <x-td style="padding:5px;">{{ $product->units }}</x-td>
                                        <x-td style="padding:5px;">${{ number_format($product->price, 2) }}</x-td>
                                    </x-tr>
                                @endforeach
                            </tbody>
                        </x-table>
                    </x-td>
                </x-tr>
                <x-tr>
                    <x-th style="text-align: left; padding:10px;">{{__('Delivery Method')}}</x-th>
                    <x-td style="text-align: left; padding:10px;">{{ $order->deliveryMethod->name }}</x-td>
                </x-tr>
                <x-tr>
                    <x-th style="text-align: left; padding:10px;">{{__('Date')}}</x-th>
                    <x-td style="text-align: left; padding:10px;">{{ $order->created_at }}</x-td>
                </x-tr>
            </x-thead>
        </x-table>
    </div>
</body>
</html>
