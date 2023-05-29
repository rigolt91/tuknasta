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
        </style>
    </head>
    <body class="font-sans antialiased">
        <div>
            <h2>{{ env('APP_NAME') }}</h2>
            <h3>{{__('List Of Orders')}} ({{ $orders->count() }})</h3>

            <table>
                <thead style="border-bottom: 2px solid gray">
                    <tr>
                        <th>{{__('#')}}</th>
                        <th>{{__('Number')}}</th>
                        <th>{{__('Receive')}}</th>
                        <th>{{__('Products')}}</th>
                        <th>{{__('Date')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                    <tr style="border-bottom: 1px solid gray">
                        <td>{{ ++$key }}</td>
                        <td>{{ $order->number }}</td>
                        <td>
                            <div>{{ $order->userContact->name.' '.$order->userContact->last_name }}</div>
                            <div>{{ $order->userContact->dni }}</div>
                        </td>
                        <td>
                            @foreach ($order->userPurchasedProduct as $purchased_product)
                                <span>{{ __($purchased_product->product->name) }} ({{ $purchased_product->units }}), </span>
                            @endforeach
                        </td>
                        <td>{{ $order->created_at->format('Y/m/d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
