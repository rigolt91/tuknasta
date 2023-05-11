<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }
            table tr {
                text-align: left;
            }
            table th, td {
                text-align: left;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                padding: 5px 5px 5px 5px;
            }
            .w-full {
                width: 100%;
            }
            .py-1 {
                padding-top: 5px;
                padding-bottom: 5px;
            }
            .mr-1 {
                margin-right: 5px;
            }
            h2 {
                font-family: Arial, Helvetica, sans-serif;
            }
            h3 {
                font-family: Arial, Helvetica, sans-serif;
            }
            h5 {
                font-family: Arial, Helvetica, sans-serif;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div>
            <h2>{{ env('APP_NAME') }}</h2>
            <h3>{{__('Order Details')}}</h3>
            <hr>
            <h5>{{__('Order Number')}}: {{ $number }}</h5>
            <h5>{{__('Date')}}: {{ $created_at->format('d/m/Y') }}</h5>

            <table style="border:solid 1px rgb(195, 188, 188);">
                <thead style="border-bottom: 2px solid gray">
                    <tr>
                        <th colspan="4" style="background-color: rgb(185, 181, 181);">
                            {{__('Products')}} ({{ $total_products }})
                        </th>
                    </tr>
                    <tr>
                        <th>{{__('Nro')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Units')}}</th>
                        <th>{{__('Price')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                    <tr style="border-bottom: 1px solid rgb(195, 188, 188)">
                        <td>{{ ++$key }}</td>
                        <td>{{ $product->product->name }}</td>
                        <td>{{ $product->units }}</td>
                        <td>${{ number_format($product->units * $product->price, 2) }}</td>
                    </tr>
                    @endforeach

                    <tr style="border:solid 1px rgb(195, 188, 188);">
                        <th colspan="3">{{__('Total Cost:')}}</th>
                        <th>${{ number_format($total_cost, 2) }}</th>
                    </tr>
                </tbody>
            </table>

            <table style="padding-top: 10px;">
                <tr>
                    <th style="width: 50%;">{{ __('Deliver') }}</th>
                    <th style="width: 50%;">{{ __('Receive') }}</th>
                </tr>
                <tr>
                    <td>{{ __('Name') }}:</td>
                    <td>{{ __('Name') }}: {{ $contact->name.' '.$contact->last_name }}</td>
                </tr>
                <tr>
                    <td>{{ __('Firma') }}:</td>
                    <td>{{ __('Firma') }}:</td>
                </tr>
            </table>
        </div>
    </body>
</html>
