@php
    use Illuminate\Support\Number;
@endphp
@extends('base')


@section('content')

    <div class="min-h-full">
        <div class="mx-auto max-w-full flex flex-col gap-[20px] mt-[80px]">
            <div class="">
                <a href="/"
                    class="inline-flex items-center  text-white bg-blue-700 hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-xl text-xs px-3 py-1.5 focus:outline-none">Back</a>
            </div>
            @if(!is_array($stockdata) && property_exists($stockdata, 'name'))
                <div class="">
                    <div class="busines text-[20px]">{{ $stockdata->name }}</div>
                    <div class="flex gap-6 items-center">
                        <div class="price text-[60px] font-black text-gray-800">
                            {{ Number::currency($stockdata->price, in: 'USD') }}</div>
                        <div
                            class="ticker text-[12px] font-black bg-green-200 text-green-600 px-3 py-1 rounded-[100px] border-1 border-green-600">
                            {{ $stockdata->ticker }}</div>
                    </div>
                </div>
            @endif
            @php
                //                 stdClass Object
                // (
                //     [ticker] => AAPL
                //     [name] => Apple Inc.
                //     [price] => 293.257
                //     [exchange] => NASDAQ
                //     [updated] => 1778494221
                //     [currency] => USD
                //     [volume] => 52692761
                // )
            @endphp
            <div class="border-1 p-[20px] border-default border-dashed rounded-2xl">
                <div id="area-chart" class="relative h-100 overflow-hidden rounded-xl opacity-75"></div>
            </div>
        </div>
    </div>

    <script>
        const this_stock_data = JSON.parse(`@php echo json_encode($stockdata); @endphp `);
    </script>

@endsection