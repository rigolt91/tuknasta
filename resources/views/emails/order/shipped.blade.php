<div>
    <h2 style="font-size: 40px;">Superbuy</h2>

    <h4>{{ __('Thank you for comparing in our store, these are the details of your purchase:') }}</h4>

    <table style="margin-bottom:4px; border-color:gray; border-collapse:collapse;">
        <thead>
            <tr>
                <th style="text-align: left; width:20%; padding:10px;">{{__('Order Number')}}</th>
                <td style="text-align: left; width:60%; padding:10px;">{{ $order->number }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding:10px;">{{__('Status')}}</th>
                <td style="text-align: left; padding:10px;">{{ $order->orderStatus->name }}</td>
            </tr>
            <tr >
                <th style="text-align: left; padding:10px;">{{__('Products')}} ({{ $order->userPurchasedProduct()->count() }})</th>
                <td style="text-align: left; padding:10px;">
                    <table>
                        <thead>
                            <tr>
                                <td>Nro</td>
                                <td style="padding:5px;">{{__('Name')}}</td>
                                <td style="padding:5px;">{{__('Units')}}</td>
                                <td style="padding:5px;">{{__('Price')}}</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->userPurchasedProduct as $key => $product)
                                <tr>
                                    <td style="padding:5px;">{{ ++$key }}</td>
                                    <td style="padding:5px;">{{ $product->product->name }}</td>
                                    <td style="padding:5px;">{{ $product->units }}</td>
                                    <td style="padding:5px;">${{ number_format($product->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th style="text-align: left; padding:10px;">{{__('Delivery Method')}}</th>
                <td style="text-align: left; padding:10px;">{{ $order->deliveryMethod->name }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding:10px;">{{__('Date')}}</th>
                <td style="text-align: left; padding:10px;">{{ $order->created_at }}</td>
            </tr>
        </thead>
    </table>
</div>
