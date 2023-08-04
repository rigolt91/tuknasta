<div class="py-6">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel-component')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6" wire:loading.class='opacity-60 animation-pulse'>
        <div class="mx-2">
            <div class="pb-2 mb-4 font-bold border-b">
                {{__('Monthly Sales')}}

                <div class="flex float-right text-gray-600">
                    <span class="ml-2">{{ $date }}</span>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <div class="flex">
                <div class="w-full mx-2">
                    @livewire('admin-panel.reports.components.orders', ['date' => $date])
                </div>

                <div class="w-full mx-2">
                    @livewire('admin-panel.reports.components.products', ['date' => $date])
                </div>

                <div class="w-full mx-2">
                    @livewire('admin-panel.reports.components.profits', ['date' => $date])
                </div>
            </div>
        </div>

        <div class="w-full">
            <div class="sm:grid sm:grid-cols-3">
                <div class="mx-2 mb-4">
                    <x-card>
                        <x-card-header>
                            {{ __($chart_sales_per_day->options['name']) }}
                        </x-card-header>
                        <x-card-body>
                            <div style="height: 175px;">{!! $chart_sales_per_day->renderHtml() !!}</div>
                        </x-card-body>
                    </x-card>
                </div>

                <div class="mx-2 mb-4">
                    <x-card>
                        <x-card-header>
                            {{ __($chart_units_products->options['name']) }}
                        </x-card-header>
                        <x-card-body>
                            <div style="height: 175px;">{!! $chart_units_products->renderHtml() !!}</div>
                        </x-card-body>
                    </x-cards>
                </div>

                <div class="mx-2 mb-4">
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
        </div>

        <div class="mx-2">
            <x-card>
                <x-card-body>
                    <div class="relative overflow-x-auto">
                        <x-table>
                            <x-thead>
                                <x-tr>
                                    <x-th>{{ __('Day') }}</x-th>
                                    <x-th>{{ __('Products') }}</x-th>
                                    <x-th>{{ __('Sales') }}</x-th>
                                    <x-th>{{ __('Growth') }}</x-th>
                                    <x-th>% {{ __('VS. The Day Before') }}</x-th>
                                </x-tr>
                            </x-thead>

                            <tbody>
                                @foreach ($products as $key => $product)
                                    <x-tr>
                                        <x-td>{{ $carbon->parse($product->date)->format('d-D') }}</x-td>
                                        <x-td>{{ $product->total_products }}</x-td>
                                        <x-td>$ {{ number_format($product->amount, 2) }}</x-td>
                                        <x-td>$ {{ number_format((($key > 0) ? ($product->amount - $growth[$key-1]['amount']) : $growth[$key]['amount']), 2) }}</x-td>
                                        <x-td>% {{ number_format((($key > 0) ? (($percent = ((($product->amount - $this->growth[$key-1]['amount'])/$product->amount) * 100)) > 0 ? $percent : 0) : 100), 2) }}</x-td>
                                    </x-tr>
                                @endforeach
                                <x-tr class="font-bold ">
                                    <x-td><span class="uppercase">{{ __('Total') }}</span></x-td>
                                    <x-td>{{ $products->sum('total_products') }}</x-td>
                                    <x-td>$ {{ number_format($products->sum('amount'), 2) }}</x-td>
                                    <x-td>$ {{ number_format($overall_growth, 2) }}</x-td>
                                    <x-td>% {{ number_format($full_percent, 2) }}</x-td>
                                </x-tr>
                            </tbody>
                        </x-table>
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>

    @section('scripts')
        {!! $chart_units_products->renderChartJsLibrary() !!}
        {!! $chart_units_products->renderJs() !!}
        {!! $chart_price_products->renderChartJsLibrary() !!}
        {!! $chart_price_products->renderJs() !!}
        {!! $chart_sales_per_day->renderChartJsLibrary() !!}
        {!! $chart_sales_per_day->renderJs() !!}
    @endsection
</div>
