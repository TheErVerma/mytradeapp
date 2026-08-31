@extends('../../layout/base')


@section('content')
    <div class="relative flex flex-col gap-6">

        <div class="flex items-center">
            <div class="flex flex-1 flex-col gap-1">
                <p class="text-display-xs font-semibold text-primary">Integrate</p>
                <p class="text-sm text-balance text-tertiary">Connect your broker account and autoload all the trades into your journal.</p>
            </div>
        </div>
        <div class="flex w-full flex-col flex-wrap gap-4 md:flex-row lg:gap-5 ">


            <div class="rounded-xl bg-primary shadow-xs ring-1 ring-secondary ring-inset lg:w-[25%] md:w-[35%] w-full grow">
                <div class="relative flex flex-col gap-4 px-4 py-5 md:gap-5 md:px-5">
                    
                    <a href="/connect-upstox" class="btn btn-md btn-primary w-fit">Connect to Upstox</a>

                    @php
                    echo "<pre>";
                    print_r($portfolio);
                    echo "</pre>";
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection