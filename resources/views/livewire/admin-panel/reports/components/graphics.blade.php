<div class="w-full">
    <div class="sm:flex">
        <div class="mx-2 mb-4 sm:w-6/12">
            <x-card>
                <x-card-header>
                    {{ __($chart_units_products->options['name']) }}
                </x-card-header>
                <x-card-body>
                    <div style="height: 175px;">{!! $chart_units_products->renderHtml() !!}</div>
                </x-card-body>
            </x-cards>
        </div>

        <div class="mx-2 mb-4 sm:w-6/12">
            <x-card>
                <x-card-header>
                    {{ __($chart_price_products->options['name']) }}
                </x-card-header>
                <x-card-body class="flex">
                    <div style="height: 175px;">{!! $chart_price_products->renderHtml() !!}</div>
                </x-card-body>
            </x-card>
        </div>
    </div>

    @section('scripts')
        {!! $chart_units_products->renderChartJsLibrary() !!}
        {!! $chart_units_products->renderJs() !!}
        {!! $chart_price_products->renderChartJsLibrary() !!}
        {!! $chart_price_products->renderJs() !!}
    @endsection
</div>
