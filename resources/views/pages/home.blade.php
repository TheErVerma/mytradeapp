@php
    use Illuminate\Support\Number;
@endphp
@extends('../layout/base')

@section('content')



    <div class="relative flex flex-col gap-6">
        <div class="flex flex-1 flex-col gap-1">
            <p class="text-display-xs font-semibold text-primary">Account Summary</p>
            <p class="text-sm text-balance text-tertiary">Returns are shown once deposits are made.</p>
        </div>

        <div class="flex w-full flex-col flex-wrap gap-4 md:flex-row lg:gap-5">
            <div class="rounded-xl bg-primary shadow-xs ring-1 ring-secondary ring-inset lg:w-[25%] md:w-[35%] w-full grow">
                <div class="relative flex flex-col gap-2 px-4 py-5 md:px-5">
                    <h3 class="text-sm font-medium text-tertiary">Profit & Loss</h3>
                    <div class="flex items-end gap-4">
                        <p class="flex-1 text-display-sm font-semibold text-primary">{{ Number::currency(floatval($portfolioSummry['net_pnl']), in: $currency) }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl bg-primary shadow-xs ring-1 ring-secondary ring-inset lg:w-[25%] md:w-[35%] w-full grow">
                <div class="relative flex flex-col gap-2 px-4 py-5 md:px-5">
                    <h3 class="text-sm font-medium text-tertiary">Winnings</h3>
                    <div class="flex items-end gap-4">
                        <p class="flex-1 text-display-sm font-semibold text-primary">0</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl bg-primary shadow-xs ring-1 ring-secondary ring-inset lg:w-[25%] md:w-[35%] w-full grow">
                <div class="relative flex flex-col gap-2 px-4 py-5 md:px-5">
                    <h3 class="text-sm font-medium text-tertiary">Lossing</h3>
                    <div class="flex items-end gap-4">
                        <p class="flex-1 text-display-sm font-semibold text-primary">0</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl bg-primary shadow-xs ring-1 ring-secondary ring-inset lg:w-[25%] md:w-[35%] w-full grow">
                <div class="relative flex flex-col gap-2 px-4 py-5 md:px-5">
                    <h3 class="text-sm font-medium text-tertiary">Break</h3>
                    <div class="flex items-end gap-4">
                        <p class="flex-1 text-display-sm font-semibold text-primary">0</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl bg-primary shadow-xs ring-1 ring-secondary ring-inset lg:w-[25%] md:w-[35%] w-full grow">
                <div class="relative flex flex-col gap-2 px-4 py-5 md:px-5">
                    <h3 class="text-sm font-medium text-tertiary">Total</h3>
                    <div class="flex items-end gap-4">
                        <p class="flex-1 text-display-sm font-semibold text-primary">0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection