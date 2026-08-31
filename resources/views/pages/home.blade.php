@php
    use Illuminate\Support\Number;
    use App\Services\OptionService;
@endphp
@extends('../layout/base')

@section('content')



@php
$cstmAltcCrds = OptionService::getOption('customized_analytic_cards');
if(!is_array($cstmAltcCrds)){
    $cstmAltcCrds = [];
}

$all_trades_arr = collect($trades->items())->toArray();
@endphp

    <div class="relative flex flex-col gap-6">


        @if(is_array($all_trades_arr) && count($all_trades_arr) == 0)
            <div class="flex flex-1 flex-col gap-4 rounded-xl shadow-xs ring-1 ring-secondary ring-inset p-6">
                <div class="flex flex-col gap-5">

                    <div class="flex flex-1 flex-col gap-1">
                        <p class="text-display-xs font-semibold text-primary">Welcome to your trading dashboard! 👋
                        </p>
                        <p class="text-sm text-balance text-tertiary">Your performance summary will appear here once
                            you
                            start logging trades.</p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button type="button" class="btn btn-md btn-primary" data-popup-target="add-trade-pop">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                            Add Trade
                        </button>

                        <button type="button" class="btn btn-md btn-secondary" disabled>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 15V16.2C21 17.8802 21 18.7202 20.673 19.362C20.3854 19.9265 19.9265 20.3854 19.362 20.673C18.7202 21 17.8802 21 16.2 21H7.8C6.11984 21 5.27976 21 4.63803 20.673C4.07354 20.3854 3.6146 19.9265 3.32698 19.362C3 18.7202 3 17.8802 3 16.2V15M17 8L12 3M12 3L7 8M12 3V15"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </svg>

                            Import Trades
                        </button>
                    </div>
                </div>
                <!-- <img src="/storage/images/chart-demo.svg" alt="img" class="h-auto object-fill hidden lg:block"> -->
            </div>
        @else
            <div class="flex items-center">
                <div class="flex flex-1 flex-col gap-1">
                    <p class="text-display-xs font-semibold text-primary">Account Summary</p>
                    <p class="text-sm text-balance text-tertiary">Returns are shown once deposits are made.</p>
                </div>
                <div class="w-max flex items-center gap-4">
                    <button type="button" class="btn btn-icon-only btn-secondary btn-sm" data-popup-target="customize-analytics-pop" >
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12.0005 15C13.6573 15 15.0005 13.6569 15.0005 12C15.0005 10.3431 13.6573 9 12.0005 9C10.3436 9 9.00049 10.3431 9.00049 12C9.00049 13.6569 10.3436 15 12.0005 15Z"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M9.28957 19.3711L9.87402 20.6856C10.0478 21.0768 10.3313 21.4093 10.6902 21.6426C11.0492 21.8759 11.4681 22.0001 11.8962 22C12.3244 22.0001 12.7433 21.8759 13.1022 21.6426C13.4612 21.4093 13.7447 21.0768 13.9185 20.6856L14.5029 19.3711C14.711 18.9047 15.0609 18.5159 15.5029 18.26C15.9477 18.0034 16.4622 17.8941 16.9729 17.9478L18.4029 18.1C18.8286 18.145 19.2582 18.0656 19.6396 17.8713C20.021 17.6771 20.3379 17.3763 20.5518 17.0056C20.766 16.635 20.868 16.2103 20.8455 15.7829C20.823 15.3555 20.677 14.9438 20.4251 14.5978L19.5785 13.4344C19.277 13.0171 19.1159 12.5148 19.1185 12C19.1184 11.4866 19.281 10.9864 19.5829 10.5711L20.4296 9.40778C20.6814 9.06175 20.8275 8.65007 20.85 8.22267C20.8725 7.79528 20.7704 7.37054 20.5562 7C20.3423 6.62923 20.0255 6.32849 19.644 6.13423C19.2626 5.93997 18.833 5.86053 18.4074 5.90556L16.9774 6.05778C16.4667 6.11141 15.9521 6.00212 15.5074 5.74556C15.0645 5.48825 14.7144 5.09736 14.5074 4.62889L13.9185 3.31444C13.7447 2.92317 13.4612 2.59072 13.1022 2.3574C12.7433 2.12408 12.3244 1.99993 11.8962 2C11.4681 1.99993 11.0492 2.12408 10.6902 2.3574C10.3313 2.59072 10.0478 2.92317 9.87402 3.31444L9.28957 4.62889C9.0825 5.09736 8.73245 5.48825 8.28957 5.74556C7.84479 6.00212 7.33024 6.11141 6.81957 6.05778L5.38513 5.90556C4.95946 5.86053 4.52987 5.93997 4.14844 6.13423C3.76702 6.32849 3.45014 6.62923 3.23624 7C3.02206 7.37054 2.92002 7.79528 2.94251 8.22267C2.96499 8.65007 3.11103 9.06175 3.36291 9.40778L4.20957 10.5711C4.51151 10.9864 4.67411 11.4866 4.67402 12C4.67411 12.5134 4.51151 13.0137 4.20957 13.4289L3.36291 14.5922C3.11103 14.9382 2.96499 15.3499 2.94251 15.7773C2.92002 16.2047 3.02206 16.6295 3.23624 17C3.45036 17.3706 3.76727 17.6712 4.14864 17.8654C4.53001 18.0596 4.95949 18.1392 5.38513 18.0944L6.81513 17.9422C7.3258 17.8886 7.84034 17.9979 8.28513 18.2544C8.72966 18.511 9.08134 18.902 9.28957 19.3711Z"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </button>
                    <select class="form-select text-sm! main-summary--filter" id="main-summary--filter">
                        <option value="all">All</option>
                        <option value="today">Today</option>
                        <option value="last_week">Last 7 Days</option>
                        <option value="current_month">Current Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="last_3_month">Last 3 Month</option>
                        <option value="last_6_month">Last 6 Month</option>
                        <option value="last_year">Last Year</option>
                        <option value="last_3_year">Last 3 Year</option>
                        <option value="last_5_year">Last 5 Year</option>
                        <option value="last_10_year">Last 10 Year</option>
                    </select>
                </div>
            </div>
        @endif


        <div class="flex w-full flex-col flex-wrap gap-4 md:flex-row lg:gap-5 {{ !in_array('account-summary', $cstmAltcCrds) ? 'hide' : '' }}">

            <div class="rounded-xl bg-primary shadow-xs ring-1 ring-secondary ring-inset lg:w-[25%] md:w-[35%] w-full grow">
                <div class="relative flex flex-col gap-4 px-4 py-5 md:gap-5 md:px-5">

                    <div class="flex items-center gap-3">
                        <div data-featured-icon="true"
                            class="relative flex shrink-0 items-center justify-center *:data-icon:size-6 rounded-full size-12 bg-success-primary text-success-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="z-1">
                                <path
                                    d="M21 21H4.6C4.03995 21 3.75992 21 3.54601 20.891C3.35785 20.7951 3.20487 20.6422 3.10899 20.454C3 20.2401 3 19.9601 3 19.4V3M21 7L15.5657 12.4343C15.3677 12.6323 15.2687 12.7313 15.1545 12.7684C15.0541 12.8011 14.9459 12.8011 14.8455 12.7684C14.7313 12.7313 14.6323 12.6323 14.4343 12.4343L12.5657 10.5657C12.3677 10.3677 12.2687 10.2687 12.1545 10.2316C12.0541 10.1989 11.9459 10.1989 11.8455 10.2316C11.7313 10.2687 11.6323 10.3677 11.4343 10.5657L7 15M21 7H17M21 7V11"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </div>
                        <h3 class="text-md font-semibold text-primary">Profit & Loss</h3>
                    </div>

                    <div class="flex flex-col gap-3">
                        <p class="flex-1 text-display-sm font-semibold text-primary net_pnl_wrap">
                            {{ Number::currency(floatval($portfolioSummry['net_pnl']), in: $currency) }}</p>
                        @if(!isset($portfolioSummry['net_pnl']) || isset($portfolioSummry['net_pnl']) && $portfolioSummry['net_pnl'] == 0)
                            <span class="text-sm font-medium text-tertiary">No trades recorded</span>
                        @else
                            <span class="text-sm font-medium text-tertiary net_pnl_status_wrap">Net {{ isset($portfolioSummry['net_pnl']) && $portfolioSummry['net_pnl'] > 0 ? 'profit' : 'loss' }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-primary shadow-xs ring-1 ring-secondary ring-inset lg:w-[25%] md:w-[35%] w-full grow">
                <div class="relative flex flex-col gap-4 px-4 py-5 md:gap-5 md:px-5">

                    <div class="flex items-center gap-3">
                        <div data-featured-icon="true"
                            class="relative flex shrink-0 items-center justify-center *:data-icon:size-6 rounded-full size-12 bg-success-primary text-success-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="z-1"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 15C8.68629 15 6 12.3137 6 9V3.44444C6 3.0306 6 2.82367 6.06031 2.65798C6.16141 2.38021 6.38021 2.16141 6.65798 2.06031C6.82367 2 7.0306 2 7.44444 2H16.5556C16.9694 2 17.1763 2 17.342 2.06031C17.6198 2.16141 17.8386 2.38021 17.9397 2.65798C18 2.82367 18 3.0306 18 3.44444V9C18 12.3137 15.3137 15 12 15ZM12 15V18M18 4H20.5C20.9659 4 21.1989 4 21.3827 4.07612C21.6277 4.17761 21.8224 4.37229 21.9239 4.61732C22 4.80109 22 5.03406 22 5.5V6C22 6.92997 22 7.39496 21.8978 7.77646C21.6204 8.81173 20.8117 9.62038 19.7765 9.89778C19.395 10 18.93 10 18 10M6 4H3.5C3.03406 4 2.80109 4 2.61732 4.07612C2.37229 4.17761 2.17761 4.37229 2.07612 4.61732C2 4.80109 2 5.03406 2 5.5V6C2 6.92997 2 7.39496 2.10222 7.77646C2.37962 8.81173 3.18827 9.62038 4.22354 9.89778C4.60504 10 5.07003 10 6 10M7.44444 22H16.5556C16.801 22 17 21.801 17 21.5556C17 19.5919 15.4081 18 13.4444 18H10.5556C8.59188 18 7 19.5919 7 21.5556C7 21.801 7.19898 22 7.44444 22Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </div>
                        <h3 class="text-md font-semibold text-primary">Winnings</h3>
                    </div>

                    <div class="flex flex-col gap-3">
                        <p class="flex-1 text-display-sm font-semibold text-primary main_pnl_winnings">{{ isset($portfolioSummry['winning_trades']) ? $portfolioSummry['winning_trades'] : '--' }}</p>
                        @if (!isset($portfolioSummry['winning_trades']) || isset($portfolioSummry['winning_trades']) && $portfolioSummry['winning_trades'] == 0)
                            <span class="text-sm font-medium text-tertiary">No data yet</span>
                        @else
                            <span class="text-sm font-medium text-tertiary">of <span class="main_pnl_totalTrades">{{ $all_trades_count }}</span> trades</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-primary shadow-xs ring-1 ring-secondary ring-inset lg:w-[25%] md:w-[35%] w-full grow">
                <div class="relative flex flex-col gap-4 px-4 py-5 md:gap-5 md:px-5">

                    <div class="flex items-center gap-3">
                        <div data-featured-icon="true"
                            class="relative flex shrink-0 items-center justify-center *:data-icon:size-6 rounded-full size-12 bg-error-primary text-error-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="z-1"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 21H4.6C4.03995 21 3.75992 21 3.54601 20.891C3.35785 20.7951 3.20487 20.6422 3.10899 20.454C3 20.2401 3 19.9601 3 19.4V3M21 15L15.5657 9.56569C15.3677 9.36768 15.2687 9.26867 15.1545 9.23158C15.0541 9.19895 14.9459 9.19895 14.8455 9.23158C14.7313 9.26867 14.6323 9.36768 14.4343 9.56569L12.5657 11.4343C12.3677 11.6323 12.2687 11.7313 12.1545 11.7684C12.0541 11.8011 11.9459 11.8011 11.8455 11.7684C11.7313 11.7313 11.6323 11.6323 11.4343 11.4343L7 7M21 15H17M21 15V11"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </div>
                        <h3 class="text-md font-semibold text-primary">Losing Trades</h3>
                    </div>

                    <div class="flex flex-col gap-3">
                        <p class="flex-1 text-display-sm font-semibold text-primary main_pnl_loosing">{{ isset($portfolioSummry['losing_trades']) ? $portfolioSummry['losing_trades'] : '--' }}</p>
                        @if (!isset($portfolioSummry['losing_trades']) || isset($portfolioSummry['losing_trades']) && $portfolioSummry['losing_trades'] == 0)
                            <span class="text-sm font-medium text-tertiary">No data yet</span>
                        @else
                            <span class="text-sm font-medium text-tertiary">of <span class="main_pnl_totalTrades">{{ $all_trades_count }}</span> trades</span>
                        @endif
                    </div>
                </div>
            </div>

            
            <div class="rounded-xl bg-primary shadow-xs ring-1 ring-secondary ring-inset lg:w-[25%] md:w-[35%] w-full grow">
                <div class="relative flex flex-col gap-4 px-4 py-5 md:gap-5 md:px-5">

                    <div class="flex items-center gap-3">
                        <div data-featured-icon="true"
                            class="relative flex shrink-0 items-center justify-center *:data-icon:size-6 rounded-full size-12 bg-yellow-50 text-yellow-500">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="z-1">
                                <path
                                    d="M2.50047 13H8.50047M15.5005 13H21.5005M12.0005 7V21M12.0005 7C13.3812 7 14.5005 5.88071 14.5005 4.5M12.0005 7C10.6198 7 9.50047 5.88071 9.50047 4.5M4.00047 21L20.0005 21M4.00047 4.50001L9.50047 4.5M9.50047 4.5C9.50047 3.11929 10.6198 2 12.0005 2C13.3812 2 14.5005 3.11929 14.5005 4.5M14.5005 4.5L20.0005 4.5M8.88091 14.3364C8.48022 15.8706 7.11858 17 5.50047 17C3.88237 17 2.52073 15.8706 2.12004 14.3364C2.0873 14.211 2.07093 14.1483 2.06935 13.8979C2.06838 13.7443 2.12544 13.3904 2.17459 13.2449C2.25478 13.0076 2.34158 12.8737 2.51519 12.6059L5.50047 8L8.48576 12.6059C8.65937 12.8737 8.74617 13.0076 8.82636 13.2449C8.87551 13.3904 8.93257 13.7443 8.9316 13.8979C8.93002 14.1483 8.91365 14.211 8.88091 14.3364ZM21.8809 14.3364C21.4802 15.8706 20.1186 17 18.5005 17C16.8824 17 15.5207 15.8706 15.12 14.3364C15.0873 14.211 15.0709 14.1483 15.0693 13.8979C15.0684 13.7443 15.1254 13.3904 15.1746 13.2449C15.2548 13.0076 15.3416 12.8737 15.5152 12.6059L18.5005 8L21.4858 12.6059C21.6594 12.8737 21.7462 13.0076 21.8264 13.2449C21.8755 13.3904 21.9326 13.7443 21.9316 13.8979C21.93 14.1483 21.9137 14.211 21.8809 14.3364Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </div>
                        <h3 class="text-md font-semibold text-primary">Break-even Trades</h3>
                    </div>

                    <div class="flex flex-col gap-3">
                        <p class="flex-1 text-display-sm font-semibold text-primary main_pnl_breakeven">{{ isset($portfolioSummry['breakeven_trades']) ? $portfolioSummry['breakeven_trades'] : '--' }}</p>
                        @if (!isset($portfolioSummry['breakeven_trades']) || isset($portfolioSummry['breakeven_trades']) && $portfolioSummry['breakeven_trades'] == 0)
                            <span class="text-sm font-medium text-tertiary">No data yet</span>
                        @else
                            <span class="text-sm font-medium text-tertiary">of <span class="main_pnl_totalTrades">{{ $all_trades_count }}</span> trades</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-primary shadow-xs ring-1 ring-secondary ring-inset lg:w-[25%] md:w-[35%] w-full grow">
                <div class="relative flex flex-col gap-4 px-4 py-5 md:gap-5 md:px-5">

                    <div class="flex items-center gap-3">
                        <div data-featured-icon="true"
                            class="relative flex shrink-0 items-center justify-center *:data-icon:size-6 rounded-full size-12 bg-sky-100 text-sky-500">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="z-1">
                                <path
                                    d="M14 2.26953V6.40007C14 6.96012 14 7.24015 14.109 7.45406C14.2049 7.64222 14.3578 7.7952 14.546 7.89108C14.7599 8.00007 15.0399 8.00007 15.6 8.00007H19.7305M16 13H8M16 17H8M10 9H8M14 2H8.8C7.11984 2 6.27976 2 5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803C4 4.27976 4 5.11984 4 6.8V17.2C4 18.8802 4 19.7202 4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673C6.27976 22 7.11984 22 8.8 22H15.2C16.8802 22 17.7202 22 18.362 21.673C18.9265 21.3854 19.3854 20.9265 19.673 20.362C20 19.7202 20 18.8802 20 17.2V8L14 2Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </div>
                        <h3 class="text-md font-semibold text-primary">Total Trades</h3>
                    </div>

                    <div class="flex flex-col gap-3">
                        <p class="flex-1 text-display-sm font-semibold text-primary main_pnl_totalTrades">{{ $all_trades_count }}</p>
                        @if ($all_trades_count == 0)
                            <span class="text-sm font-medium text-tertiary">No data yet</span>
                        @else
                            <span class="text-sm font-medium text-tertiary">Total Trades</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        
        <div class="{{ !in_array('performance-metrics', $cstmAltcCrds) ? 'hide' : '' }}  flex flex-col gap-6 border rounded-lg p-4 border-secondary shadow-xs">
            <div class="flex flex-1 flex-col gap-1">
                <h2 class="text-xl font-semibold text-primary">Performance Metrics</h2>
                <p class="text-sm text-balance text-tertiary">Key stats</p>
            </div>
            <div class="flex flex-row gap-8">
                @php
                $all_mtrc_chunks = array_chunk($all_matrics, ceil(count($all_matrics) / 2));
                $all_mtrc_first  = $all_mtrc_chunks[0] ?? [];
                $all_mtrc_second = $all_mtrc_chunks[1] ?? [];
                @endphp
                <div class="w-full flex flex-col gap-2">
                    @foreach ($all_mtrc_first as $matric_item)
                        <div class="flex flex-row justify-between matric_item {{ ($matric_item['id']) }}">
                            <div class="flex gap-1 items-center matric_title text-quaternary text-sm">
                                {{ $matric_item['title'] }}
                                <div class="tooltip-wrap ">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="size-3.5">
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3m.08 4h.01M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10Z">
                                        </path>
                                    </svg>
                                    <div class="tooltip-popup">
                                        <div class="z-50 flex max-w-xs flex-col items-start gap-1 rounded-lg bg-primary-solid px-3 shadow-xs will-change-transform py-2">
                                            <span class="text-xs font-semibold text-white">{{ $matric_item['desc'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="value text-md {{ (strpos($matric_item['value'], '-') == "" ? 'text-success-primary' : 'text-error-primary') }} matric_value">{{ $matric_item['value'] }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="w-full flex flex-col gap-2">
                    @foreach ($all_mtrc_second as $matric_item)
                        <div class="flex flex-row justify-between matric_item {{ ($matric_item['id']) }}">
                            <div class="flex gap-1 items-center matric_title text-quaternary text-sm">
                                {{ $matric_item['title'] }}
                                <div class="tooltip-wrap ">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="size-3.5">
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3m.08 4h.01M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10Z">
                                        </path>
                                    </svg>
                                    <div class="tooltip-popup">
                                        <div class="z-50 flex max-w-xs flex-col items-start gap-1 rounded-lg bg-primary-solid px-3 shadow-xs will-change-transform py-2">
                                            <span class="text-xs font-semibold text-white">{{ $matric_item['desc'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="value text-md text-success-primary matric_value">{{ $matric_item['value'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="{{ !in_array('monthly-performance', $cstmAltcCrds) ? 'hide' : '' }} flex flex-col gap-6 border rounded-lg p-4 border-secondary shadow-xs">
            <div class="flex flex-1 flex-col gap-1">
                <h2 class="text-xl font-semibold text-primary">Monthly Performance</h2>
                <p class="text-sm text-balance text-tertiary">Your P&L broken down by month</p>
            </div>
            <canvas id="main_analytics_chart" data_ch_hash="{{ base64_encode(json_encode($monthlyPerformance)) }}" style="max-height:264px;"></canvas>
        </div>    

        <script>
            let pnl_js_data = JSON.parse(atob(`{{ base64_encode(json_encode($headMapData)) }}`));
        </script>
        <div
            class="{{ !in_array('trading-activity', $cstmAltcCrds) ? 'hide' : '' }} custom-heatmap__wrap flex flex-1 flex-col gap-4 rounded-xl shadow-xs ring-1 ring-secondary ring-inset p-6">
            <div class="flex flex-1 flex-col gap-1">
                <h2 class="text-xl font-semibold text-primary">Trading Activity</h2>
            </div>
            <div id="trading-heatmap" data-heat-js='{
                "year": {{ date('Y') }},
                "views": {
                    "map": {
                        "showDayNames": false,
                        "showMonthNames": true,
                        "showToolTips": false
                    }
                },
                "colorRanges": [
                    { "minimum": 1, "cssClassName": "heavy-loss" },
                    { "minimum": 2, "cssClassName": "medium-loss" },
                    { "minimum": 3, "cssClassName": "low-loss" },
                    { "minimum": 4, "cssClassName": "breakeven" },
                    { "minimum": 5, "cssClassName": "low-profit" },
                    { "minimum": 6, "cssClassName": "medium-profit" },
                    { "minimum": 7, "cssClassName": "heavy-profit" }
                ]
            }'>
            </div>

            <div class="flex flex-col items-center mt-6 gap-5 text-sm text-tertiary">

                <div class="flex items-center gap-4">

                    <span>Less</span>

                    <div class="flex gap-2">

                        <span class="legend-square no-trades"></span>

                        <span class="legend-square low-loss"></span>
                        <span class="legend-square medium-loss"></span>
                        <span class="legend-square heavy-loss"></span>

                        <span class="legend-square low-profit"></span>
                        <span class="legend-square medium-profit"></span>
                        <span class="legend-square heavy-profit"></span>

                    </div>

                    <span>More</span>

                </div>


                <div class="flex text-xs items-center gap-y-4 gap-x-8 ``flex-wrap">

                    <div class="flex items-center gap-1.5 max-sm:w-[35%] grow">
                        <span class="legend-square no-trades"></span>
                        No trades
                    </div>

                    <div class="flex items-center gap-1.5 max-sm:w-[35%] grow">
                        <span class="legend-square medium-profit"></span>
                        Profit
                    </div>

                    <div class="flex items-center gap-1.5 max-sm:w-[35%] grow">
                        <span class="legend-square medium-loss"></span>
                        Loss
                    </div>

                </div>

            </div>
        </div>

        <div class="{{ !in_array('weekly-summary', $cstmAltcCrds) ? 'hide' : '' }} flex flex-col gap-6 border rounded-lg p-4 border-secondary shadow-xs">
            <div class="flex flex-1 flex-col gap-1">
                <h2 class="text-xl font-semibold text-primary">Weekly Summary</h2>
            </div>
            <div class="flex flex-row gap-8">
                <table class="global-table week_summery_table">
                    <thead>
                        <tr class="text-fg-quaternary">
                            <th style="font-weight: 400;" class="trade_h_day">Day</th>
                            <th style="font-weight: 400;" class="trade_h_net_profits">Net Profits</th>
                            <th style="font-weight: 400;" class="trade_h_winning">Winning %</th>
                            <th style="font-weight: 400;" class="trade_h_total_profits">Total Profits</th>
                            <th style="font-weight: 400;" class="trade_h_total_loss">Total Loss</th>
                            <th style="font-weight: 400;" class="trade_h_trades">Trades</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        function chkpnlClass($str){
                            $str_len = strlen($str);
                            if(strpos($str, '-', 0) == ""){
                                return 'text-success-primary';
                            }
                            return 'text-error-primary';
                        }
                        @endphp
                        @if(isset($weekday_summary))
                            @foreach($weekday_summary as $wkdy_smry_itm)                           
                                <tr style="height: auto;">
                                    <td class="trade_b_day">{{ $wkdy_smry_itm['day'] }}</td>
                                    <td class="{{ chkpnlClass($wkdy_smry_itm['net_profit']) }} trade_b_net_profits">{{ Number::currency(floatval($wkdy_smry_itm['net_profit']), in: $currency) }}</td>
                                    <td class="trade_b_winning">
                                        <span class="flex overflow-hidden rounded-lg">
                                            <span style="width:{{ $wkdy_smry_itm['winning_percent'] }}%; background:var(--text-color-success-primary);" class="rounded-lg flex py-1"></span>
                                            <span style="width:{{ 100 - $wkdy_smry_itm['winning_percent'] }}%; background: var(--color-bg-error-solid);" class="rounded-lg flex py-1"></span>
                                        </span>
                                    </td>
                                    <td class="text-success-primary trade_b_total_profits">{{ Number::currency(floatval($wkdy_smry_itm['total_profit']), in: $currency) }}</td>
                                    <td class="text-error-primary trade_b_total_loss">{{ Number::currency(floatval($wkdy_smry_itm['total_loss']), in: $currency) }}</td>
                                    <td class="trade_b_trades">{{ $wkdy_smry_itm['trades'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>


        
        
    </div>
    


@endsection