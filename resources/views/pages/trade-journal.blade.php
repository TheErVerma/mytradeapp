@php
    use Illuminate\Support\Number;
@endphp
@extends('../layout/base')

@section('content')

    @php
        $current_page = $all_trades->currentPage();
        $total_pages = ceil($all_trades->total() / 10);
        $has_more = $all_trades->hasMorePages();

        $all_trades = $all_trades->items();
        // $all_trades
        // $all_trades = array_reverse($all_trades);
        // echo "<pre>";
        // print_r($all_trades);
        // echo "</pre>";
        $trad_actions = array_column($all_trades, 'trd_action');
        $trdActnCnt = array_count_values($trad_actions);
        $trdLong = isset($trdActnCnt['Long']) ? $trdActnCnt['Long'] : 0;
        $trdShort = isset($trdActnCnt['Short']) ? $trdActnCnt['Short'] : 0;
        $trdAllCnt = $trdLong + $trdShort;
    @endphp
    

    @php 
    //ob_start();
    @endphp
    <div class="flex flex-col gap-8">
            <div class="flex flex-col gap-6">

                <div
                    class="overflow-hidden shadow-xs ring-1 ring-secondary -mx-4 rounded-none bg-secondary lg:mx-0 lg:rounded-xl">

                    <div
                        class="relative flex flex-col items-center gap-4 border-b border-secondary bg-primary px-4 md:flex-row py-5 md:px-6">
                        <div class="flex flex-1 flex-col gap-0.5">
                            <div class="flex items-center gap-2">
                                <h2 class="text-xl font-semibold text-primary">Trades</h2>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button class="btn btn-sm btn-primary">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21 15V16.2C21 17.8802 21 18.7202 20.673 19.362C20.3854 19.9265 19.9265 20.3854 19.362 20.673C18.7202 21 17.8802 21 16.2 21H7.8C6.11984 21 5.27976 21 4.63803 20.673C4.07354 20.3854 3.6146 19.9265 3.32698 19.362C3 18.7202 3 17.8802 3 16.2V15M17 8L12 3M12 3L7 8M12 3V15"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                                <span data-text="true" class="transition-inherit-all px-0.5">
                                    <span class="flex items-center gap-1.5">Import Trades</span>
                                </span>
                            </button>

                            <button class="btn btn-sm btn-icon-only btn-secondary">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 21H3M18 11L12 17M12 17L6 11M12 17V3" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                            </button>

                            <button class="btn btn-sm btn-icon-only btn-secondary">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.59 13.51L15.42 17.49M15.41 6.51L8.59 10.49M21 5C21 6.65685 19.6569 8 18 8C16.3431 8 15 6.65685 15 5C15 3.34315 16.3431 2 18 2C19.6569 2 21 3.34315 21 5ZM9 12C9 13.6569 7.65685 15 6 15C4.34315 15 3 13.6569 3 12C3 10.3431 4.34315 9 6 9C7.65685 9 9 10.3431 9 12ZM21 19C21 20.6569 19.6569 22 18 22C16.3431 22 15 20.6569 15 19C15 17.3431 16.3431 16 18 16C19.6569 16 21 17.3431 21 19Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                            </button>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 border-b border-secondary px-4 py-3 max-md:flex-col lg:px-6">

                        <div class="hidden min-w-0 grow flex-wrap gap-3 md:flex">
                            <div class="flex flex-col w-auto">

                                <div
                                    class="group flex gap-0.5 rounded-lg bg-secondary_alt ring-1 ring-inset ring-secondary trades_table_filter_btm">
                                    <div data_type="all" class="filter-tab active">
                                        <span class="flex items-center gap-1.5 px-0.5">All Trades</span>
                                    </div>

                                    <div data_type="Long" class="filter-tab">
                                        <span class="flex items-center gap-1.5 px-0.5">Long</span>
                                    </div>

                                    <div data_type="Short" class="filter-tab">
                                        <span class="flex items-center gap-1.5 px-0.5">Short</span>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 max-md:w-full">

                            <div
                                class="group flex h-max w-full flex-col items-start justify-start gap-1.5 min-w-0  md:w-40 max-md:w-[35%] max-md:grow">

                                <div class="search-wrap">

                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        class="pointer-events-none absolute text-fg-quaternary left-3 size-4 stroke-[2.25px]"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21 10H3M16 2V6M8 2V6M10.5 14L12 13V18M10.75 18H13.25M7.8 22H16.2C17.8802 22 18.7202 22 19.362 21.673C19.9265 21.3854 20.3854 20.9265 20.673 20.362C21 19.7202 21 18.8802 21 17.2V8.8C21 7.11984 21 6.27976 20.673 5.63803C20.3854 5.07354 19.9265 4.6146 19.362 4.32698C18.7202 4 17.8802 4 16.2 4H7.8C6.11984 4 5.27976 4 4.63803 4.32698C4.07354 4.6146 3.6146 5.07354 3.32698 5.63803C3 6.27976 3 7.11984 3 8.8V17.2C3 18.8802 3 19.7202 3.32698 20.362C3.6146 20.9265 4.07354 21.3854 4.63803 21.673C5.27976 22 6.11984 22 7.8 22Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>


                                    <input aria-label="Search" type="text" placeholder="From" tabindex="0"
                                        id="trade_date_from" class="m-0 w-full datepicker bg-transparent text-primary ring-0 outline-hidden placeholder:text-placeholder autofill:rounded-lg autofill:text-primary disabled:cursor-not-allowed px-3 py-2 text-sm pl-9"
                                        value="" title="">

                                </div>

                            </div>
                            <div
                                class="group flex h-max w-full flex-col items-start justify-start gap-1.5 min-w-0 max-md:w-[35%] max-md:grow md:w-40">

                                <div class="search-wrap">

                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        class="pointer-events-none absolute text-fg-quaternary left-3 size-4 stroke-[2.25px]"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21 10H3M16 2V6M8 2V6M10.5 14L12 13V18M10.75 18H13.25M7.8 22H16.2C17.8802 22 18.7202 22 19.362 21.673C19.9265 21.3854 20.3854 20.9265 20.673 20.362C21 19.7202 21 18.8802 21 17.2V8.8C21 7.11984 21 6.27976 20.673 5.63803C20.3854 5.07354 19.9265 4.6146 19.362 4.32698C18.7202 4 17.8802 4 16.2 4H7.8C6.11984 4 5.27976 4 4.63803 4.32698C4.07354 4.6146 3.6146 5.07354 3.32698 5.63803C3 6.27976 3 7.11984 3 8.8V17.2C3 18.8802 3 19.7202 3.32698 20.362C3.6146 20.9265 4.07354 21.3854 4.63803 21.673C5.27976 22 6.11984 22 7.8 22Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>


                                    <input aria-label="Search" type="text" placeholder="To" tabindex="0"
                                        id="trade_date_to" class="m-0 w-full datepicker bg-transparent text-primary ring-0 outline-hidden placeholder:text-placeholder autofill:rounded-lg autofill:text-primary disabled:cursor-not-allowed px-3 py-2 text-sm pl-9"
                                        value="" title="">

                                </div>

                            </div>
                            <div
                                class="group flex h-max w-full flex-col items-start justify-start gap-1.5 min-w-0  md:w-70">

                                <div class="search-wrap">

                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                        stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true"
                                        class="pointer-events-none absolute text-fg-quaternary left-3 size-4 stroke-[2.25px]">
                                        <path d="m21 21-3.5-3.5m2.5-6a8.5 8.5 0 1 1-17 0 8.5 8.5 0 0 1 17 0Z">
                                        </path>
                                    </svg>

                                    <input aria-label="Search" id="trade_search" type="text" placeholder="Search" tabindex="0"
                                        class="m-0 w-full bg-transparent text-primary ring-0 outline-hidden placeholder:text-placeholder autofill:rounded-lg autofill:text-primary disabled:cursor-not-allowed px-3 py-2 text-sm pl-9"
                                        value="" title="">

                                </div>

                            </div>

                            <button class="btn btn-sm btn-secondary max-md:grow">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2 8.37722C2 8.0269 2 7.85174 2.01462 7.70421C2.1556 6.28127 3.28127 5.1556 4.70421 5.01462C4.85174 5 5.03636 5 5.40558 5C5.54785 5 5.61899 5 5.67939 4.99634C6.45061 4.94963 7.12595 4.46288 7.41414 3.746C7.43671 3.68986 7.45781 3.62657 7.5 3.5C7.54219 3.37343 7.56329 3.31014 7.58586 3.254C7.87405 2.53712 8.54939 2.05037 9.32061 2.00366C9.38101 2 9.44772 2 9.58114 2H14.4189C14.5523 2 14.619 2 14.6794 2.00366C15.4506 2.05037 16.126 2.53712 16.4141 3.254C16.4367 3.31014 16.4578 3.37343 16.5 3.5C16.5422 3.62657 16.5633 3.68986 16.5859 3.746C16.874 4.46288 17.5494 4.94963 18.3206 4.99634C18.381 5 18.4521 5 18.5944 5C18.9636 5 19.1483 5 19.2958 5.01462C20.7187 5.1556 21.8444 6.28127 21.9854 7.70421C22 7.85174 22 8.0269 22 8.37722V16.2C22 17.8802 22 18.7202 21.673 19.362C21.3854 19.9265 20.9265 20.3854 20.362 20.673C19.7202 21 18.8802 21 17.2 21H6.8C5.11984 21 4.27976 21 3.63803 20.673C3.07354 20.3854 2.6146 19.9265 2.32698 19.362C2 18.7202 2 17.8802 2 16.2V8.37722Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M12 16.5C14.2091 16.5 16 14.7091 16 12.5C16 10.2909 14.2091 8.5 12 8.5C9.79086 8.5 8 10.2909 8 12.5C8 14.7091 9.79086 16.5 12 16.5Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                                <span data-text="true" class="transition-inherit-all px-0.5" id="share_trade_screenshot">
                                    <span class="flex items-center gap-1.5">Share Screenshot</span>
                                </span>
                            </button>

                        </div>

                    </div>                        

                    <div class="no_trades_wrapper flex items-center justify-center overflow-hidden px-8 py-20" @if(is_array($all_trades) && count($all_trades) >= 1)) style="display:none;"
                @endif>
                        <div class="mx-auto flex w-full max-w-lg flex-col items-center justify-center">

                            <header class="relative mb-4">
                                <div
                                    class="relative flex shrink-0 items-center justify-center *:data-icon:size-6 bg-primary_alt ring-1 ring-inset before:absolute before:inset-1 before:shadow-[0px_1px_2px_0px_rgba(0,0,0,0.1),0px_3px_3px_0px_rgba(0,0,0,0.09),1px_8px_5px_0px_rgba(0,0,0,0.05),2px_21px_6px_0px_rgba(0,0,0,0),0px_0px_0px_1px_rgba(0,0,0,0.08),1px_13px_5px_0px_rgba(0,0,0,0.01),0px_-2px_2px_0px_rgba(0,0,0,0.13)_inset] before:ring-1 before:ring-secondary_alt size-12 rounded-xl before:rounded-lg text-fg-secondary ring-primary">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.5 12H5.88197C6.56717 12 7.19357 12.3871 7.5 13C7.80643 13.6129 8.43283 14 9.11803 14H14.882C15.5672 14 16.1936 13.6129 16.5 13C16.8064 12.3871 17.4328 12 18.118 12H21.5M8.96656 4H15.0334C16.1103 4 16.6487 4 17.1241 4.16396C17.5445 4.30896 17.9274 4.5456 18.2451 4.85675C18.6043 5.2086 18.8451 5.6902 19.3267 6.65337L21.4932 10.9865C21.6822 11.3645 21.7767 11.5535 21.8434 11.7515C21.9026 11.9275 21.9453 12.1085 21.971 12.2923C22 12.4992 22 12.7105 22 13.1331V15.2C22 16.8802 22 17.7202 21.673 18.362C21.3854 18.9265 20.9265 19.3854 20.362 19.673C19.7202 20 18.8802 20 17.2 20H6.8C5.11984 20 4.27976 20 3.63803 19.673C3.07354 19.3854 2.6146 18.9265 2.32698 18.362C2 17.7202 2 16.8802 2 15.2V13.1331C2 12.7105 2 12.4992 2.02897 12.2923C2.05471 12.1085 2.09744 11.9275 2.15662 11.7515C2.22326 11.5535 2.31776 11.3645 2.50675 10.9865L4.67331 6.65337C5.1549 5.69019 5.3957 5.2086 5.75495 4.85675C6.07263 4.5456 6.45551 4.30896 6.87589 4.16396C7.35125 4 7.88969 4 8.96656 4Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>

                                </div>
                            </header>

                            <main class="z-10 mb-6 flex w-full max-w-88 flex-col items-center justify-center gap-1">
                                <h1 class="text-xl font-semibold text-primary">No vendors found</h1>
                                <p class="text-center text-sm text-tertiary">Your search “Stripe” did not match any
                                    vendors. Please try again or create add a new vendor.</p>
                            </main>

                            <footer class="z-10 flex gap-3">
                                <button class="btn btn-secondary btn-sm">
                                    <span class="transition-inherit-all px-0.5">Clear search</span>
                                </button>
                                <button class="btn btn-primary btn-sm">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                        stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true" data-icon="leading"
                                        class="pointer-events-none size-5 shrink-0 transition-inherit-all">
                                        <path d="M12 5v14m-7-7h14">

                                        </path>
                                    </svg>
                                    <span data-text="true" class="transition-inherit-all px-0.5">New
                                        project</span>
                                </button>
                            </footer>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="global-table trades_journal_table">
                            <thead>
                                <tr>
                                    <th class="w-min pr-0!">
                                        <label class="hb-checkbox size-lg" for="rememberMe">
                                            <span>
                                                <input type="checkbox" id="rememberMe">
                                            </span>

                                        </label>
                                    </th>

                                    <th>
                                        <div class="title" role="group">
                                            ID
                                        </div>
                                    </th>

                                    <th>
                                        <div class="title" role="group">
                                            Symbol
                                        </div>
                                    </th>

                                    <th>
                                        <div class="title" role="group">
                                            Action
                                        </div>
                                    </th>

                                    <th>
                                        <div class="title" role="group">
                                            Date
                                        </div>
                                    </th>

                                    <th>
                                        <div class="title" role="group">
                                            Shares
                                        </div>
                                    </th>

                                    <th>
                                        <div class="title" role="group">
                                            Lot
                                        </div>
                                    </th>
                                    <th>
                                        <div class="title" role="group">
                                            Type
                                        </div>
                                    </th>

                                    <th>
                                        <div class="title" role="group">
                                            Price
                                        </div>
                                    </th>

                                    <th>
                                        <div class="title" role="group">
                                            Exit Price
                                        </div>
                                    </th>

                                    <th>
                                        <div class="title" role="group">
                                            P&L
                                        </div>
                                    </th>

                                    <th>

                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    echo view('components.journalRows', ['all_trades' => $all_trades, 'currency' => $currency]);
                                @endphp
                            </tbody>

                        </table>
                    </div>
                    
                    <div class="border-t border-secondary px-4 py-3 md:px-6 md:pt-3 md:pb-4 bg-secondary">

                        <nav aria-label="Pagination" class="flex items-center justify-between md:hidden">
                            <button class="btn btn-sm btn-secondary btn-icon-only">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true" data-icon="leading"
                                    class="pointer-events-none size-5 shrink-0 transition-inherit-all">
                                    <path d="M19 12H5m0 0 7 7m-7-7 7-7">

                                    </path>
                                </svg>
                            </button>
                            <span class="text-sm text-fg-secondary">Page <span class="font-medium">1</span> of <span
                                    class="font-medium">10</span>
                            </span>
                            <button class="btn btn-sm btn-secondary btn-icon-only">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true" data-icon="leading"
                                    class="pointer-events-none size-5 shrink-0 transition-inherit-all">
                                    <path d="M5 12h14m0 0-7-7m7 7-7 7">

                                    </path>
                                </svg>
                            </button>
                        </nav>

                        <nav aria-label="Pagination" class="hidden items-center gap-3 md:flex">

                            <div class="">
                                <button disabled class="btn btn-sm btn-secondary prev_journal_page" data_total_pages="{{ $total_pages }}">
                                    <span data-text="true" class="transition-inherit-all px-0.5">Previous</span>
                                </button>
                            </div>

                            <div class="flex items-center gap-3 order-first mr-auto">
                                <span class="text-sm font-medium text-fg-secondary pageination_status_wrap">Page 1 of {{ $total_pages }}</span>

                                <div class="flex flex-col gap-1.5">
                                    <select tabindex="-1" title="" id="trades_per_page" class="form-select form-select__lg">
                                        <option value="10" selected="">10</option>
                                        <option value="25" >25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>

                            <div class="">
                                <button {{ $total_pages <= 1 ? 'disabled' : '' }} class="btn btn-sm btn-secondary next_journal_page" data_total_pages="{{ $total_pages }}">
                                    <span data-text="true" class="transition-inherit-all px-0.5">Next</span>
                                </button>
                            </div>
                        </nav>

                    </div>

                </div>
            </div>
    </div>
    @php
    
    // ob_get_contents();
    // ob_end_clean();
    @endphp

    
    @php
    ob_start();
    @endphp
        <div class="trades_table_wrapper">
            <div class="trades_table_inner">
                <div class="trades_table_filter_top">
                    <div class="trades_search_wrap">
                        <div class="trades_date_filter">
                            <div class="trades_search_inp">
                                <span class="trades_search_inp_icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="Interface / Search_Magnifying_Glass">
                                            <path id="Vector"
                                                d="M15 15L21 21M10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10C17 13.866 13.866 17 10 17Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                </span>
                                <input type="search" name="trade_search" id="trade_search" placeholder="Search trades...">
                            </div>
                            <input type="text" class="datepicker" name="trade_date_from" id="trade_date_from" date_type="from"
                                placeholder="From" />
                            <input type="text" class="datepicker" name="trade_date_to" id="trade_date_to" date_type="to"
                                placeholder="To" />
                        </div>
                        <div class="trades_additional_actions">
                            <button type="button" class="export_all_trades" title="Export All Trades">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M12 5L11.2929 4.29289L12 3.58579L12.7071 4.29289L12 5ZM13 14C13 14.5523 12.5523 15 12 15C11.4477 15 11 14.5523 11 14L13 14ZM6.29289 9.29289L11.2929 4.29289L12.7071 5.70711L7.70711 10.7071L6.29289 9.29289ZM12.7071 4.29289L17.7071 9.29289L16.2929 10.7071L11.2929 5.70711L12.7071 4.29289ZM13 5L13 14L11 14L11 5L13 5Z"
                                        fill="currentColor" />
                                    <path d="M5 16L5 17C5 18.1046 5.89543 19 7 19L17 19C18.1046 19 19 18.1046 19 17V16"
                                        stroke="currentColor" stroke-width="2" />
                                </svg>
                            </button>
                            <button type="button" class="btn btn-md btn-primary import_new_trades"
                                data-popup-target="coming-soon-pop" title="Import All Trades">Import Trades</button>
                        </div>
                    </div>
                </div>
                <div class="trades_table_filter_btm">
                    <ul>
                        <li data_type="all" class="active">All Trades (<span class="count">{{ $trdAllCnt }}</span>)</li>
                        <li data_type="Long">Long (<span class="count">{{ $trdLong }}</span>)</li>
                        <li data_type="Short">Short (<span class="count">{{ $trdShort }}</span>)</li>
                    </ul>
                    <div class="trades_table_actions">
                        <button type="button" class="btn btn-sm btn-secondary" id="share_trade_screenshot">
                            <span class="icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M5 10.2V14.533C5.00423 15.4569 5.3754 16.3413 6.0318 16.9915C6.68821 17.6418 7.57608 18.0045 8.5 18H15.5C16.4239 18.0045 17.3118 17.6418 17.9682 16.9915C18.6246 16.3413 18.9958 15.4569 19 14.533V10.2C18.9958 9.27608 18.6246 8.39169 17.9682 7.74148C17.3118 7.09126 16.4239 6.72849 15.5 6.73301C15.0147 6.66864 14.6001 6.3515 14.411 5.90001C14.1009 5.34285 13.5126 4.99815 12.875 5.00001H11.125C10.4874 4.99815 9.89908 5.34285 9.589 5.90001C9.39986 6.3515 8.98526 6.66864 8.5 6.73301C7.57608 6.72849 6.68821 7.09126 6.0318 7.74148C5.3754 8.39169 5.00423 9.27608 5 10.2Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M12 14.533C10.8059 14.5214 9.84617 13.546 9.85405 12.3518C9.86193 11.1576 10.8344 10.1949 12.0286 10.1991C13.2228 10.2033 14.1885 11.1728 14.188 12.367C14.1851 12.9444 13.9529 13.4969 13.5426 13.9032C13.1323 14.3094 12.5774 14.5359 12 14.533Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            Share Screenshot
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary" id="live_share_trade_journal"
                            data-popup-target="share-trade-pop">
                            <span class="icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7 11C6.07003 11 5.60504 11 5.22354 11.1022C4.18827 11.3796 3.37962 12.1883 3.10222 13.2235C3 13.605 3 14.07 3 15V16.2C3 17.8802 3 18.7202 3.32698 19.362C3.6146 19.9265 4.07354 20.3854 4.63803 20.673C5.27976 21 6.11984 21 7.8 21H16.2C17.8802 21 18.7202 21 19.362 20.673C19.9265 20.3854 20.3854 19.9265 20.673 19.362C21 18.7202 21 17.8802 21 16.2V15C21 14.07 21 13.605 20.8978 13.2235C20.6204 12.1883 19.8117 11.3796 18.7765 11.1022C18.395 11 17.93 11 17 11M16 7L12 3M12 3L8 7M12 3V15"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>

                <div class="no_trades_wrapper" @if(is_array($all_trades) && count($all_trades) >= 1)) style="display:none;"
                @endif>
                    <div class="no_trades_wrapper_inner">
                        <h4>No trades match your criteria</h4>
                        <p>Try adjusting your search or filters to see more results</p>
                        <button type="button" class="btn btn-md btn-primary" data-popup-target="add-trade-pop">+ Add New
                            Trade</button>
                    </div>
                </div>

                <div class="main_trades_table_outer">
                    <table class="main_trades_table" @if(!is_array($all_trades) || (is_array($all_trades) && count($all_trades) <= 0)) style="display:none;" @endif>
                        <thead>
                            <tr>
                                <th class="trade_h_select">
                                    <input type="checkbox" name="select_all_trades" id="select_all_trades" />
                                </th>
                                <th class="trade_h_id">ID</th>
                                <!-- <th>Market Name</th> -->
                                <th class="trade_h_symbol">Symbol</th>
                                <th class="trade_h_action">Action</th>
                                <th class="trade_h_date">Date</th>
                                <th class="trade_h_shares">Shares</th>
                                <th class="trade_h_lot">Lot</th>
                                <th class="trade_h_type">Type</th>
                                <th class="trade_h_price">Price</th>
                                <th class="trade_h_exit_price">Exit Price</th>
                                <th class="trade_h_pnl">P&L</th>
                                <!-- <th>Commissions</th>
                                        <th>Fees</th> -->
                                <th class="trade_h_actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(is_array($all_trades) && count($all_trades) >= 1)
                                @php
                                    $td_cnt = 1;
                                @endphp
                                @foreach ($all_trades as $trade_item)
                                    @php
                                        $tred_classes = [];
                                        if (isset($trade_item['trd_action'])) {
                                            $tred_classes[] = strtolower($trade_item['trd_action']);
                                        }

                                        $trd_type = isset($trade_item['trd_type']) ? $trade_item['trd_type'] : 'Cash';
                                        $instrument = $trade_item['instrument'];
                                        $inst_type = $instrument && isset($instrument['underlying_type']) ? $instrument['underlying_type'] : $instrument['instrument_type'];
                                        $shares = $trade_item['trd_shares'];
                                        $lot_size = $trade_item['trd_lot'];

                                        $entry_prc = $trade_item['trd_price'];
                                        $exit_prc = $trade_item['trd_exit_price'];
                                        $charges_prc = $trade_item['trd_charges_amount'];
                                        $qty_multiplier = $instrument['qty_multiplier'];


                                        $lot_size_val = isset($trade_item['trd_shares']) ? $trade_item['trd_shares'] : 1;
                                        if($trd_type != 'Cash'){
                                            $lot_size_val = ((isset($instrument['lot_size']) ? $instrument['lot_size'] : 1) * $lot_size);
                                        }

                                        $lot_size_val *= $qty_multiplier;

                                        $pnl_val = (($exit_prc - $entry_prc) * $lot_size_val) - $charges_prc;
                                        if ($trade_item['trd_action'] == 'Short') {
                                            $pnl_val = (($entry_prc - $exit_prc) * $lot_size_val) - $charges_prc;
                                        }


                                        $pnl_status = $pnl_val < 0 ? 'loss' : 'profit';
                                    @endphp
                                    <tr class="@php echo implode(' ', $tred_classes); @endphp ">
                                        <td class="trade_b_select">
                                            <input type="checkbox" name="selected_trades" id="selected_trades" />
                                        </td>
                                        <td class="trade_b_id">{{ $td_cnt }}</td>
                                        <td class="trade_b_symbol"><span data-href="/journal/{{ $trade_item['id'] }}">{{ $trade_item['trd_symbol'] }}</span></td>
                                        <td class="trade_b_action"><span>{{ $trade_item['trd_action'] }}</span></td>
                                        <td class="trade_b_date">{{ date('F d, Y', strtotime($trade_item['trd_date'])) }}</td>
                                        <td class="trade_b_shares">{{ $trade_item['trd_type'] == 'Cash' ? $shares : '--' }}</td>
                                        <td class="trade_b_lot">{{ $trade_item['trd_type'] == 'F&O' ? $lot_size : '--' }}</td>
                                        <td class="trade_b_type">{{ $inst_type }}</td>
                                        <td class="trade_b_price">
                                            {{ Number::currency(floatval($trade_item['trd_price']), in: $currency) }}</td>
                                        <td class="trade_b_exit_price">
                                            {{ Number::currency(floatval($trade_item['trd_exit_price']), in: $currency) }}</td>
                                        <td class="trade_b_pnl {{ $pnl_status }}">
                                            {{ Number::currency(floatval($pnl_val), in: $currency) }}
                                            <span class="pnl_info">
                                                <svg width="14px" height="14px" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12 7C12.5523 7 13 7.44772 13 8V13C13 13.5523 12.5523 14 12 14C11.4477 14 11 13.5523 11 13V8C11 7.44772 11.4477 7 12 7Z" />
                                                    <path
                                                        d="M12 17C12.5523 17 13 16.5523 13 16C13 15.4477 12.5523 15 12 15C11.4477 15 11 15.4477 11 16C11 16.5523 11.4477 17 12 17Z" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12Z" />
                                                </svg>
                                                <div class="pnl_sub_info">Charges:
                                                    -{{ Number::currency(floatval($charges_prc), in: $currency) }}</div>
                                            </span>
                                        </td>
                                        <td class="trade_b_actions">
                                            <div class="trade_action_wrap">
                                                <button type="button" class="icon_btn edit" data_id="{{ $trade_item['id'] }}">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M14.2322 5.76777C15.2085 4.79146 16.7915 4.79146 17.7678 5.76777L18.4749 6.47487C19.4512 7.45118 19.4512 9.0341 18.4749 10.0104L10.3431 18.1421L7.10051 18.1421C6.54822 18.1421 6.1005 17.6944 6.10051 17.1421L6.10051 13.8995L14.2322 5.76777ZM16.3536 7.18198L17.0607 7.88909C17.2559 8.08435 17.2559 8.40093 17.0607 8.59619L16 9.65685L14.5858 8.24264L15.6464 7.18198C15.8417 6.98672 16.1583 6.98672 16.3536 7.18198ZM14.5858 11.0711L9.51472 16.1421L8.10051 16.1421L8.10051 14.7279L13.1716 9.65685L14.5858 11.0711Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </button>
                                                <button type="button" class="icon_btn trash" data_id="{{ $trade_item['id'] }}">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M5.16565 10.1534C5.07629 8.99181 5.99473 8 7.15975 8H16.8402C18.0053 8 18.9237 8.9918 18.8344 10.1534L18.142 19.1534C18.0619 20.1954 17.193 21 16.1479 21H7.85206C6.80699 21 5.93811 20.1954 5.85795 19.1534L5.16565 10.1534Z"
                                                            stroke="currentColor" stroke-width="2" />
                                                        <path d="M19.5 5H4.5" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" />
                                                        <path d="M10 3C10 2.44772 10.4477 2 11 2H13C13.5523 2 14 2.44772 14 3V5H10V3Z"
                                                            stroke="currentColor" stroke-width="2" />
                                                        <path d="M14 12V17" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" />
                                                        <path d="M10 12V17" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" />
                                                    </svg>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $td_cnt++;
                                    @endphp
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @php
    ob_get_contents();
    ob_end_clean();
    @endphp


@endsection