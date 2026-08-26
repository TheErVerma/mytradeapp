@php
    use Illuminate\Support\Number;
    $user = Auth::user();
@endphp

<!-- ********** Mobile Header ********** -->
<header class="flex h-auto items-center justify-between border-b border-secondary bg-primary p-3 pl-4 lg:hidden">

    <div class="flex w-max items-center justify-start overflow-visible h-7">

        <!-- **** Site Logo **** -->
        <div class="aspect-[0.3] font-semibold h-full text-xl uppercase">TradeApp</div>
        <!-- **** Site Logo **** -->

    </div>

    <button
        class="group flex items-center justify-center rounded-lg bg-primary p-2 text-fg-secondary outline-focus-ring hover:bg-primary_hover hover:text-fg-secondary_hover focus-visible:outline-2 focus-visible:outline-offset-2 toggle_mobile_sidebar"
        type="button">

        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
            class="size-6 transition duration-200 ease-in-out group-aria-expanded:opacity-0">
            <path d="M3 12h12M3 6h18M3 18h18">

            </path>
        </svg>
    </button>
</header>
<!-- ********** Mobile Header ********** -->

<!-- ********** Desktop Sidebar ********** -->
<div class="mobile-sibebar fixed inset-y-0 left-0 flex z-10">
    <aside
        class="flex h-full w-full max-w-full flex-col justify-between overflow-auto bg-primary pt-4 lg:w-(--width) lg:pt-5 border-secondary md:border-r scrollbar-thin"
        style="--width: 280px;">

        <div class="flex flex-col gap-5 px-4 lg:px-5 justify-center items-center border-b border-secondary pb-5">

            <div class="flex w-max items-center justify-start overflow-visible h-6">
                <!-- ********** Logo ********** -->
                <div class="aspect-[0.3] font-semibold h-full text-xl uppercase text-secondary">TradeApp</div>
                <!-- ********** Logo ********** -->
            </div>

            <button type="button" class="btn btn-md btn-primary w-full" data-popup-target="add-trade-pop">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Add Trade
            </button>

        </div>

        <ul>

            <li class="mt-4">
                <div class="px-5 pb-2">
                    <p class="text-xs font-semibold text-quaternary uppercase">Primary</p>
                </div>

                <ul class="px-4 pb-5 border-b border-secondary">

                    <li class="py-px">
                        <a class="sidebar-menu @if(request()->is('/')) active @endif" href="/" target="_self" rel="noopener noreferrer"
                            tabindex="0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20.5 7.27783L12 12.0001M12 12.0001L3.49997 7.27783M12 12.0001L12 21.5001M21 16.0586V7.94153C21 7.59889 21 7.42757 20.9495 7.27477C20.9049 7.13959 20.8318 7.01551 20.7354 6.91082C20.6263 6.79248 20.4766 6.70928 20.177 6.54288L12.777 2.43177C12.4934 2.27421 12.3516 2.19543 12.2015 2.16454C12.0685 2.13721 11.9315 2.13721 11.7986 2.16454C11.6484 2.19543 11.5066 2.27421 11.223 2.43177L3.82297 6.54288C3.52345 6.70928 3.37369 6.79248 3.26463 6.91082C3.16816 7.01551 3.09515 7.13959 3.05048 7.27477C3 7.42757 3 7.59889 3 7.94153V16.0586C3 16.4013 3 16.5726 3.05048 16.7254C3.09515 16.8606 3.16816 16.9847 3.26463 17.0893C3.37369 17.2077 3.52345 17.2909 3.82297 17.4573L11.223 21.5684C11.5066 21.726 11.6484 21.8047 11.7986 21.8356C11.9315 21.863 12.0685 21.863 12.2015 21.8356C12.3516 21.8047 12.4934 21.726 12.777 21.5684L20.177 17.4573C20.4766 17.2909 20.6263 17.2077 20.7354 17.0893C20.8318 16.9847 20.9049 16.8606 20.9495 16.7254C21 16.5726 21 16.4013 21 16.0586Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="py-px">
                        <a class="sidebar-menu @if(request()->is('journal')) active @endif" href="/journal" target="_self" rel="noopener noreferrer"
                            tabindex="0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14 2.26953V6.40007C14 6.96012 14 7.24015 14.109 7.45406C14.2049 7.64222 14.3578 7.7952 14.546 7.89108C14.7599 8.00007 15.0399 8.00007 15.6 8.00007H19.7305M16 13H8M16 17H8M10 9H8M14 2H8.8C7.11984 2 6.27976 2 5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803C4 4.27976 4 5.11984 4 6.8V17.2C4 18.8802 4 19.7202 4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673C6.27976 22 7.11984 22 8.8 22H15.2C16.8802 22 17.7202 22 18.362 21.673C18.9265 21.3854 19.3854 20.9265 19.673 20.362C20 19.7202 20 18.8802 20 17.2V8L14 2Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>


                            <span>Journal</span>
                        </a>
                    </li>

                    <li class="py-px">
                        <a class="sidebar-menu @if(request()->is('analytics')) active @endif" disabled href="/analytics" target="_self" rel="noopener noreferrer"
                            tabindex="0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 2C13.3132 2 14.6136 2.25866 15.8268 2.76121C17.0401 3.26375 18.1425 4.00035 19.0711 4.92893C19.9997 5.85752 20.7363 6.95991 21.2388 8.17317C21.7413 9.38643 22 10.6868 22 12M12 2V12M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5229 22 12M12 2C17.5228 2 22 6.47716 22 12M22 12L12 12M22 12C22 13.5781 21.6265 15.1338 20.9101 16.5399C20.1936 17.946 19.1546 19.1626 17.8779 20.0902L12 12"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>


                            <span>Analytics</span>
                        </a>
                    </li>

                    <li class="py-px">
                        <a class="sidebar-menu @if(request()->is('stocks')) active @endif" disabled href="/stocks" target="_self" rel="noopener noreferrer"
                            tabindex="0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 21H4.6C4.03995 21 3.75992 21 3.54601 20.891C3.35785 20.7951 3.20487 20.6422 3.10899 20.454C3 20.2401 3 19.9601 3 19.4V3M21 7L15.5657 12.4343C15.3677 12.6323 15.2687 12.7313 15.1545 12.7684C15.0541 12.8011 14.9459 12.8011 14.8455 12.7684C14.7313 12.7313 14.6323 12.6323 14.4343 12.4343L12.5657 10.5657C12.3677 10.3677 12.2687 10.2687 12.1545 10.2316C12.0541 10.1989 11.9459 10.1989 11.8455 10.2316C11.7313 10.2687 11.6323 10.3677 11.4343 10.5657L7 15M21 7H17M21 7V11"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>Stocks</span>
                        </a>
                    </li>

                </ul>

            </li>

            <li class="mt-4">
                <div class="px-5 pb-2">
                    <p class="text-xs font-semibold text-quaternary uppercase">Secondary</p>
                </div>

                <ul class="px-4 pb-5 border-b border-secondary">

                    <li class="py-px">
                        <a class="sidebar-menu @if(request()->is('profile')) active @endif" href="/profile" target="_self" rel="noopener noreferrer"
                            tabindex="0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.3163 19.4384C5.92462 18.0052 7.34492 17 9 17H15C16.6551 17 18.0754 18.0052 18.6837 19.4384M16 9.5C16 11.7091 14.2091 13.5 12 13.5C9.79086 13.5 8 11.7091 8 9.5C8 7.29086 9.79086 5.5 12 5.5C14.2091 5.5 16 7.29086 16 9.5ZM22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>Profile</span>
                        </a>
                    </li>

                    <li class="py-px">
                        <a class="sidebar-menu @if(request()->is('settings')) active @endif" href="/settings" target="_self" rel="noopener noreferrer"
                            tabindex="0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M18.7273 14.7273C18.6063 15.0015 18.5702 15.3056 18.6236 15.6005C18.6771 15.8954 18.8177 16.1676 19.0273 16.3818L19.0818 16.4364C19.2509 16.6052 19.385 16.8057 19.4765 17.0265C19.568 17.2472 19.6151 17.4838 19.6151 17.7227C19.6151 17.9617 19.568 18.1983 19.4765 18.419C19.385 18.6397 19.2509 18.8402 19.0818 19.0091C18.913 19.1781 18.7124 19.3122 18.4917 19.4037C18.271 19.4952 18.0344 19.5423 17.7955 19.5423C17.5565 19.5423 17.3199 19.4952 17.0992 19.4037C16.8785 19.3122 16.678 19.1781 16.5091 19.0091L16.4545 18.9545C16.2403 18.745 15.9682 18.6044 15.6733 18.5509C15.3784 18.4974 15.0742 18.5335 14.8 18.6545C14.5311 18.7698 14.3018 18.9611 14.1403 19.205C13.9788 19.4489 13.8921 19.7347 13.8909 20.0273V20.1818C13.8909 20.664 13.6994 21.1265 13.3584 21.4675C13.0174 21.8084 12.5549 22 12.0727 22C11.5905 22 11.1281 21.8084 10.7871 21.4675C10.4461 21.1265 10.2545 20.664 10.2545 20.1818V20.1C10.2475 19.7991 10.1501 19.5073 9.97501 19.2625C9.79991 19.0176 9.55521 18.8312 9.27273 18.7273C8.99853 18.6063 8.69437 18.5702 8.39947 18.6236C8.10456 18.6771 7.83244 18.8177 7.61818 19.0273L7.56364 19.0818C7.39478 19.2509 7.19425 19.385 6.97353 19.4765C6.7528 19.568 6.51621 19.6151 6.27727 19.6151C6.03834 19.6151 5.80174 19.568 5.58102 19.4765C5.36029 19.385 5.15977 19.2509 4.99091 19.0818C4.82186 18.913 4.68775 18.7124 4.59626 18.4917C4.50476 18.271 4.45766 18.0344 4.45766 17.7955C4.45766 17.5565 4.50476 17.3199 4.59626 17.0992C4.68775 16.8785 4.82186 16.678 4.99091 16.5091L5.04545 16.4545C5.25503 16.2403 5.39562 15.9682 5.4491 15.6733C5.50257 15.3784 5.46647 15.0742 5.34545 14.8C5.23022 14.5311 5.03887 14.3018 4.79497 14.1403C4.55107 13.9788 4.26526 13.8921 3.97273 13.8909H3.81818C3.33597 13.8909 2.87351 13.6994 2.53253 13.3584C2.19156 13.0174 2 12.5549 2 12.0727C2 11.5905 2.19156 11.1281 2.53253 10.7871C2.87351 10.4461 3.33597 10.2545 3.81818 10.2545H3.9C4.2009 10.2475 4.49273 10.1501 4.73754 9.97501C4.98236 9.79991 5.16883 9.55521 5.27273 9.27273C5.39374 8.99853 5.42984 8.69437 5.37637 8.39947C5.3229 8.10456 5.18231 7.83244 4.97273 7.61818L4.91818 7.56364C4.74913 7.39478 4.61503 7.19425 4.52353 6.97353C4.43203 6.7528 4.38493 6.51621 4.38493 6.27727C4.38493 6.03834 4.43203 5.80174 4.52353 5.58102C4.61503 5.36029 4.74913 5.15977 4.91818 4.99091C5.08704 4.82186 5.28757 4.68775 5.50829 4.59626C5.72901 4.50476 5.96561 4.45766 6.20455 4.45766C6.44348 4.45766 6.68008 4.50476 6.9008 4.59626C7.12152 4.68775 7.32205 4.82186 7.49091 4.99091L7.54545 5.04545C7.75971 5.25503 8.03183 5.39562 8.32674 5.4491C8.62164 5.50257 8.9258 5.46647 9.2 5.34545H9.27273C9.54161 5.23022 9.77093 5.03887 9.93245 4.79497C10.094 4.55107 10.1807 4.26526 10.1818 3.97273V3.81818C10.1818 3.33597 10.3734 2.87351 10.7144 2.53253C11.0553 2.19156 11.5178 2 12 2C12.4822 2 12.9447 2.19156 13.2856 2.53253C13.6266 2.87351 13.8182 3.33597 13.8182 3.81818V3.9C13.8193 4.19253 13.906 4.47834 14.0676 4.72224C14.2291 4.96614 14.4584 5.15749 14.7273 5.27273C15.0015 5.39374 15.3056 5.42984 15.6005 5.37637C15.8954 5.3229 16.1676 5.18231 16.3818 4.97273L16.4364 4.91818C16.6052 4.74913 16.8057 4.61503 17.0265 4.52353C17.2472 4.43203 17.4838 4.38493 17.7227 4.38493C17.9617 4.38493 18.1983 4.43203 18.419 4.52353C18.6397 4.61503 18.8402 4.74913 19.0091 4.91818C19.1781 5.08704 19.3122 5.28757 19.4037 5.50829C19.4952 5.72901 19.5423 5.96561 19.5423 6.20455C19.5423 6.44348 19.4952 6.68008 19.4037 6.9008C19.3122 7.12152 19.1781 7.32205 19.0091 7.49091L18.9545 7.54545C18.745 7.75971 18.6044 8.03183 18.5509 8.32674C18.4974 8.62164 18.5335 8.9258 18.6545 9.2V9.27273C18.7698 9.54161 18.9611 9.77093 19.205 9.93245C19.4489 10.094 19.7347 10.1807 20.0273 10.1818H20.1818C20.664 10.1818 21.1265 10.3734 21.4675 10.7144C21.8084 11.0553 22 11.5178 22 12C22 12.4822 21.8084 12.9447 21.4675 13.2856C21.1265 13.6266 20.664 13.8182 20.1818 13.8182H20.1C19.8075 13.8193 19.5217 13.906 19.2778 14.0676C19.0339 14.2291 18.8425 14.4584 18.7273 14.7273Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                            <span>Settings</span>
                        </a>
                    </li>

                </ul>

            </li>

            <li class="mt-4">
                <div class="px-5 pb-2">
                    <p class="text-xs font-semibold text-quaternary uppercase">Summary</p>
                </div>

                <div class="px-5">
                    <select class="form-select text-sm! summary-card-filter" id="summary-card-filter">
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

            </li>

            <div class="px-5 mt-4">
                <div
                    class="text-primary font-medium relative flex flex-col rounded-lg bg-secondary p-4 gap-2 border-secondary border">
                    <div class="text-xs flex justify-between items-center gap-4">
                        <span class="label">Total Trades</span>
                        <span class="value summary_total_entries">0</span>
                    </div>

                    <div class="text-xs flex justify-between items-center gap-4">
                        <span class="label">Net P&amp;L</span>
                        <span class="value summary_total_npl {{ $portfolioSummry['net_pnl'] >= 0 ? 'text-success-primary' : 'text-error-primary' }} ">{{ Number::currency(floatval($portfolioSummry['net_pnl']), in: $currency) }}</span>
                    </div>
                </div>
            </div>
        </ul>

        <div class="mt-auto flex flex-col gap-3 px-4 py-4 lg:py-5">
            <ul class="flex flex-col">
                <li class="py-px">
                    <a class="sidebar-menu" href="/help" target="_self" rel="noopener noreferrer"
                        tabindex="0">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path
                                d="M9.136 9.136 4.93 4.93m0 14.142 4.239-4.239m5.693.032 4.207 4.207m0-14.142-4.24 4.24M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10Zm-6 0a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z">
                            </path>
                        </svg>
                        <span>Help</span>
                    </a>
                </li>

                @php 
                /*
                <li class="py-0.25">
                    <a class="sidebar-menu" href="/logout" target="_self" rel="noopener noreferrer"
                        tabindex="0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16 17L21 12M21 12L16 7M21 12H9M9 3H7.8C6.11984 3 5.27976 3 4.63803 3.32698C4.07354 3.6146 3.6146 4.07354 3.32698 4.63803C3 5.27976 3 6.11984 3 7.8V16.2C3 17.8802 3 18.7202 3.32698 19.362C3.6146 19.9265 4.07354 20.3854 4.63803 20.673C5.27976 21 6.11984 21 7.8 21H9"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span>Logout</span>
                    </a>
                </li> */ @endphp

            </ul>

            <div class="relative flex items-center gap-3 rounded-xl p-3 ring-1 ring-secondary ring-inset">

                @php
                $user = Auth::user();
                $full_name = $user->name;
                $email_adds = $user->email;
                $profile_pic = $user->profile_pic ?? '/storage/images/user.png';
                @endphp
                <figure class="group flex min-w-0 flex-1 items-center gap-2">
                    <div data-avatar="true"
                        class="relative inline-flex shrink-0 rounded-full ring-1 ring-secondary_alt p-px size-10">
                        <div class="author-image">
                            <img data-avatar-img="true" class="size-full object-cover"
                                src="{{ $profile_pic }}">
                        </div>
                    </div>
                    <figcaption class="min-w-0 flex-1">
                        <p class="font-semibold text-primary text-sm">{{ $full_name }}</p>
                        <p class="truncate text-tertiary text-sm">{{ $email_adds }}</p>
                    </figcaption>
                </figure>

                <button class="author-open__popup" type="button" tabindex="0" data-pressed="true">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                        class="size-4 shrink-0 stroke-[2.25px]">
                        <path
                            d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm0-7a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm0 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z">
                        </path>
                    </svg>
                </button>

            </div>
        </div>

    </aside>

    <button
        class="lg:hidden fixed top-2.5 right-3 flex cursor-pointer items-center justify-center rounded-lg p-2 text-fg-white/70 outline-focus-ring hover:bg-white/10 hover:text-fg-white focus-visible:outline-2 focus-visible:outline-offset-2 toggle_sidebar_close">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="size-7">
            <path d="M17 7 7 17M7 7l10 10"></path>
        </svg>
    </button>

    <!-- ******** Author Popup ******** -->

    <div class="author-popup" style="--width: 280px;">
        <div class="w-66 rounded-xl bg-secondary_alt shadow-lg ring ring-secondary_alt outline-hidden">

            <div class="rounded-xl bg-primary ring-1 ring-secondary">
                <div class="flex flex-col gap-0.5 py-1.5">

                    <button class="author-popup__menu theme_toggler">
                        <div class="inner">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22 15.8442C20.6866 16.4382 19.2286 16.7688 17.6935 16.7688C11.9153 16.7688 7.23116 12.0847 7.23116 6.30654C7.23116 4.77135 7.5618 3.3134 8.15577 2C4.52576 3.64163 2 7.2947 2 11.5377C2 17.3159 6.68414 22 12.4623 22C16.7053 22 20.3584 19.4742 22 15.8442Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Dark Mode
                        </div>

                    </button>

                    <a href="/profile" class="author-popup__menu">
                        <div class="inner">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path
                                    d="M20 21c0-1.396 0-2.093-.172-2.661a4 4 0 0 0-2.667-2.667c-.568-.172-1.265-.172-2.661-.172h-5c-1.396 0-2.093 0-2.661.172a4 4 0 0 0-2.667 2.667C4 18.907 4 19.604 4 21M16.5 7.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z">
                                </path>
                            </svg>
                            View profile
                        </div>

                    </a>

                    <a href="/settings" class="author-popup__menu">
                        <div class="inner">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z">

                                </path>
                                <path
                                    d="M18.727 14.727a1.5 1.5 0 0 0 .3 1.655l.055.054a1.816 1.816 0 0 1 0 2.573 1.818 1.818 0 0 1-2.573 0l-.055-.055a1.5 1.5 0 0 0-1.654-.3 1.5 1.5 0 0 0-.91 1.373v.155a1.818 1.818 0 1 1-3.636 0V20.1a1.5 1.5 0 0 0-.981-1.373 1.5 1.5 0 0 0-1.655.3l-.054.055a1.818 1.818 0 0 1-3.106-1.287 1.818 1.818 0 0 1 .533-1.286l.054-.055a1.5 1.5 0 0 0 .3-1.654 1.5 1.5 0 0 0-1.372-.91h-.155a1.818 1.818 0 1 1 0-3.636H3.9a1.5 1.5 0 0 0 1.373-.981 1.5 1.5 0 0 0-.3-1.655l-.055-.054A1.818 1.818 0 1 1 7.491 4.99l.054.054a1.5 1.5 0 0 0 1.655.3h.073a1.5 1.5 0 0 0 .909-1.372v-.155a1.818 1.818 0 0 1 3.636 0V3.9a1.499 1.499 0 0 0 .91 1.373 1.5 1.5 0 0 0 1.654-.3l.054-.055a1.817 1.817 0 0 1 2.573 0 1.819 1.819 0 0 1 0 2.573l-.055.054a1.5 1.5 0 0 0-.3 1.655v.073a1.5 1.5 0 0 0 1.373.909h.155a1.818 1.818 0 0 1 0 3.636H20.1a1.499 1.499 0 0 0-1.373.91Z">
                                </path>
                            </svg>
                            Account settings
                        </div>

                    </a>

                </div>
            </div>

            <div class="pt-1 pb-1.5">
                <a href="/logout" class="author-popup__menu-v2" style="display: block;">
                    <div class="inner">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path
                                d="m16 17 5-5m0 0-5-5m5 5H9m0-9H7.8c-1.68 0-2.52 0-3.162.327a3 3 0 0 0-1.311 1.311C3 5.28 3 6.12 3 7.8v8.4c0 1.68 0 2.52.327 3.162a3 3 0 0 0 1.311 1.311C5.28 21 6.12 21 7.8 21H9">
                            </path>
                        </svg> Sign out
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- ******** Author Popup ******** -->
</div>
<!-- ********** Desktop Sidebar ********** -->
<div class="invisible hidden lg:sticky lg:top-0 lg:bottom-0 lg:left-0 lg:block" style="padding-left: 280px;"></div>
@php
    /*
    <header class="main_header">
        <div class="header_inner">
            <div class="left_head">
                <!-- <img src="/storage/images/trade-logo-dark.png" width="120px"/> -->
                <h4>TradeApp</h4>
            </div>
            <div class="center_head"></div>
            <div class="right_head">
                <div class="head_btn_wrap">
                    <!-- <a href="/login" class="btn btn-md btn-primary">Login</a>
                    <a href="/login" class="btn btn-md btn-secondary">Sign Up</a> -->
                    <button type="button" class="icon_btn theme_toggler">
                        <div class="light_icon">
                            <svg fill="currentColor" width="20" height="20" viewBox="-5.5 0 32 32" version="1.1"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.875 6v2.469c0 0.844-0.375 1.25-1.156 1.25s-1.156-0.406-1.156-1.25v-2.469c0-0.813 0.375-1.219 1.156-1.219s1.156 0.406 1.156 1.219zM14.219 9.25l1.438-2.031c0.469-0.625 1.063-0.75 1.656-0.313s0.656 1 0.188 1.688l-1.438 2c-0.469 0.688-1.031 0.75-1.656 0.313-0.594-0.438-0.656-0.969-0.188-1.656zM5.781 7.25l1.469 2c0.469 0.688 0.406 1.219-0.219 1.656-0.594 0.469-1.156 0.375-1.625-0.313l-1.469-2c-0.469-0.688-0.406-1.219 0.219-1.656 0.594-0.469 1.156-0.375 1.625 0.313zM10.719 11.125c2.688 0 4.875 2.188 4.875 4.875 0 2.656-2.188 4.813-4.875 4.813s-4.875-2.156-4.875-4.813c0-2.688 2.188-4.875 4.875-4.875zM1.594 11.813l2.375 0.75c0.781 0.25 1.063 0.719 0.813 1.469-0.219 0.75-0.75 0.969-1.563 0.719l-2.313-0.75c-0.781-0.25-1.063-0.75-0.844-1.5 0.25-0.719 0.75-0.938 1.531-0.688zM17.5 12.563l2.344-0.75c0.813-0.25 1.313-0.031 1.531 0.688 0.25 0.75-0.031 1.25-0.844 1.469l-2.313 0.781c-0.781 0.25-1.281 0.031-1.531-0.719-0.219-0.75 0.031-1.219 0.813-1.469zM10.719 18.688c1.5 0 2.719-1.219 2.719-2.688 0-1.5-1.219-2.719-2.719-2.719s-2.688 1.219-2.688 2.719c0 1.469 1.188 2.688 2.688 2.688zM0.906 17.969l2.344-0.75c0.781-0.25 1.313-0.063 1.531 0.688 0.25 0.75-0.031 1.219-0.813 1.469l-2.375 0.781c-0.781 0.25-1.281 0.031-1.531-0.719-0.219-0.75 0.063-1.219 0.844-1.469zM18.219 17.219l2.344 0.75c0.781 0.25 1.063 0.719 0.813 1.469-0.219 0.75-0.719 0.969-1.531 0.719l-2.344-0.781c-0.813-0.25-1.031-0.719-0.813-1.469 0.25-0.75 0.75-0.938 1.531-0.688zM3.938 23.344l1.469-1.969c0.469-0.688 1.031-0.781 1.625-0.313 0.625 0.438 0.688 0.969 0.219 1.656l-1.469 1.969c-0.469 0.688-1.031 0.813-1.656 0.375-0.594-0.438-0.656-1.031-0.188-1.719zM16.063 21.375l1.438 1.969c0.469 0.688 0.406 1.281-0.188 1.719s-1.188 0.281-1.656-0.344l-1.438-2c-0.469-0.688-0.406-1.219 0.188-1.656 0.625-0.438 1.188-0.375 1.656 0.313zM11.875 23.469v2.469c0 0.844-0.375 1.25-1.156 1.25s-1.156-0.406-1.156-1.25v-2.469c0-0.844 0.375-1.25 1.156-1.25s1.156 0.406 1.156 1.25z">
                                </path>
                            </svg>
                        </div>
                        <div class="dark_icon">
                            <svg fill="currentColor" height="12" width="12" version="1.1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 512 512" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M504.929,323.637c-6.955-6.953-17.436-8.995-26.489-5.16c-26.922,11.403-55.471,17.185-84.859,17.185
                c-58.032,0-112.586-22.597-153.618-63.63c-62.92-62.918-81.149-156.525-46.442-238.474c3.835-9.057,1.793-19.534-5.162-26.487
                c-6.953-6.955-17.434-8.992-26.487-5.157c-31.495,13.343-59.788,32.433-84.093,56.74C27.616,108.815-0.006,175.506,0,246.443
                c0.006,70.927,27.63,137.61,77.785,187.767C127.948,484.374,194.643,512,265.58,512c70.926,0,137.61-27.622,187.767-77.779
                c24.308-24.308,43.397-52.6,56.74-84.093C513.923,341.071,511.883,330.593,504.929,323.637z" />
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </button>
                    <button type="button" class="btn btn-md btn-primary" data-popup-target="add-trade-pop">+ Add Trade</button>
                    <div class="user-profile-menu">
                        @if(isset($user->profile_pic) && !empty($user->profile_pic) && filter_var($user->profile_pic, FILTER_VALIDATE_URL))
                            <div class="user-profile-thumb">
                                <img src="{{ $user->profile_pic }}" alt="{{ $user->name }}" class="profile-pic" />
                            </div>
                        @else
                            <div class="user-profile-thumb">
                                <button>{{ $user->name[0] }}</button>
                            </div>
                        @endif
                        <ul>
                            <li>
                                <a href="{{ route('Edit Profile') }}" class=" @if(request()->is('profile')) active @endif ">
                                    <span class="icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15 7C15 8.65685 13.6569 10 12 10C10.3431 10 9 8.65685 9 7C9 5.34315 10.3431 4 12 4C13.6569 4 15 5.34315 15 7Z"
                                                stroke="currentColor" stroke-width="2" />
                                            <path
                                                d="M5 19.5C5 15.9101 7.91015 13 11.5 13H12.5C16.0899 13 19 15.9101 19 19.5V20C19 20.5523 18.5523 21 18 21H6C5.44772 21 5 20.5523 5 20V19.5Z"
                                                stroke="currentColor" stroke-width="2" />
                                        </svg>
                                    </span>
                                    <span class="title">
                                        Profile
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('settings') }}" class=" @if(request()->is('settings')) active @endif ">
                                    <span class="icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.5213 3.62368C11.3147 2.75255 12.6853 2.75255 13.4787 3.62368L14.2142 4.43128C14.6151 4.87154 15.1914 5.11025 15.7862 5.08245L16.8774 5.03146C18.0543 4.97645 19.0236 5.94568 18.9685 7.12264L18.9176 8.21377C18.8898 8.80859 19.1285 9.38487 19.5687 9.78582L20.3763 10.5213C21.2475 11.3147 21.2475 12.6853 20.3763 13.4787L19.5687 14.2142C19.1285 14.6151 18.8898 15.1914 18.9176 15.7862L18.9685 16.8774C19.0236 18.0543 18.0543 19.0236 16.8774 18.9685L15.7862 18.9176C15.1914 18.8898 14.6151 19.1285 14.2142 19.5687L13.4787 20.3763C12.6853 21.2475 11.3147 21.2475 10.5213 20.3763L9.78582 19.5687C9.38487 19.1285 8.80859 18.8898 8.21376 18.9176L7.12264 18.9685C5.94568 19.0236 4.97645 18.0543 5.03146 16.8774L5.08245 15.7862C5.11025 15.1914 4.87154 14.6151 4.43128 14.2142L3.62368 13.4787C2.75255 12.6853 2.75255 11.3147 3.62368 10.5213L4.43128 9.78582C4.87154 9.38487 5.11025 8.80859 5.08245 8.21376L5.03146 7.12264C4.97645 5.94568 5.94568 4.97645 7.12264 5.03146L8.21376 5.08245C8.80859 5.11025 9.38487 4.87154 9.78583 4.43128L10.5213 3.62368Z"
                                                stroke="currentColor" stroke-width="2" />
                                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                                        </svg>
                                    </span>
                                    <span class="title">Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="/logout">
                                    <span class="icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.9999 2C10.2385 2 7.99991 4.23858 7.99991 7C7.99991 7.55228 8.44762 8 8.99991 8C9.55219 8 9.99991 7.55228 9.99991 7C9.99991 5.34315 11.3431 4 12.9999 4H16.9999C18.6568 4 19.9999 5.34315 19.9999 7V17C19.9999 18.6569 18.6568 20 16.9999 20H12.9999C11.3431 20 9.99991 18.6569 9.99991 17C9.99991 16.4477 9.55219 16 8.99991 16C8.44762 16 7.99991 16.4477 7.99991 17C7.99991 19.7614 10.2385 22 12.9999 22H16.9999C19.7613 22 21.9999 19.7614 21.9999 17V7C21.9999 4.23858 19.7613 2 16.9999 2H12.9999Z"
                                                fill="currentColor" />
                                            <path
                                                d="M13.9999 11C14.5522 11 14.9999 11.4477 14.9999 12C14.9999 12.5523 14.5522 13 13.9999 13V11Z"
                                                fill="currentColor" />
                                            <path
                                                d="M5.71783 11C5.80685 10.8902 5.89214 10.7837 5.97282 10.682C6.21831 10.3723 6.42615 10.1004 6.57291 9.90549C6.64636 9.80795 6.70468 9.72946 6.74495 9.67492L6.79152 9.61162L6.804 9.59454L6.80842 9.58848C6.80846 9.58842 6.80892 9.58778 5.99991 9L6.80842 9.58848C7.13304 9.14167 7.0345 8.51561 6.58769 8.19098C6.14091 7.86637 5.51558 7.9654 5.19094 8.41215L5.18812 8.41602L5.17788 8.43002L5.13612 8.48679C5.09918 8.53682 5.04456 8.61033 4.97516 8.7025C4.83623 8.88702 4.63874 9.14542 4.40567 9.43937C3.93443 10.0337 3.33759 10.7481 2.7928 11.2929L2.08569 12L2.7928 12.7071C3.33759 13.2519 3.93443 13.9663 4.40567 14.5606C4.63874 14.8546 4.83623 15.113 4.97516 15.2975C5.04456 15.3897 5.09918 15.4632 5.13612 15.5132L5.17788 15.57L5.18812 15.584L5.19045 15.5872C5.51509 16.0339 6.14091 16.1336 6.58769 15.809C7.0345 15.4844 7.13355 14.859 6.80892 14.4122L5.99991 15C6.80892 14.4122 6.80897 14.4123 6.80892 14.4122L6.804 14.4055L6.79152 14.3884L6.74495 14.3251C6.70468 14.2705 6.64636 14.1921 6.57291 14.0945C6.42615 13.8996 6.21831 13.6277 5.97282 13.318C5.89214 13.2163 5.80685 13.1098 5.71783 13H13.9999V11H5.71783Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <span class="title">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="sidebar_toggler">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M10 7L15 12L10 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </div>

    <aside class="main_sidebar">
        <div class="aside_inner">
            <div class="aside_menu_items primary">
                <h5>Primary</h5>
                <ul>
                    <li>
                        <a href="/" class=" @if(request()->is('/')) active @endif ">
                            <span class="icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                </svg>
                            </span>
                            <span class="title">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="/journal" class=" @if(request()->is('journal')) active @endif ">
                            <span class="icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
                                    <polyline points="14,2 14,8 20,8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                </svg>
                            </span>
                            <span class="title">Journal</span>
                        </a>
                    </li>
                    <li>
                        <a href="/analytics" disabled class=" @if(request()->is('analytics')) active @endif ">
                            <span class="icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="18" y1="20" x2="18" y2="10"></line>
                                    <line x1="12" y1="20" x2="12" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="14"></line>
                                </svg>
                            </span>
                            <span class="title">Analytics</span>
                        </a>
                    </li>
                    <li>
                        <a href="/stocks" disabled class=" @if(request()->is('stocks')) active @endif ">
                            <span class="icon">
                                <svg fill="currentColor" width="16" height="16" viewBox="0 0 32 32" version="1.1">
                                    <path
                                        d="M29.5 7c-1.381 0-2.5 1.12-2.5 2.5 0 0.284 0.058 0.551 0.144 0.805l-6.094 5.247c-0.427-0.341-0.961-0.553-1.55-0.553-0.68 0-1.294 0.273-1.744 0.713l-4.774-2.39c-0.093-1.296-1.162-2.323-2.482-2.323-1.38 0-2.5 1.12-2.5 2.5 0 0.378 0.090 0.732 0.24 1.053l-4.867 5.612c-0.273-0.102-0.564-0.166-0.873-0.166-1.381 0-2.5 1.119-2.5 2.5s1.119 2.5 2.5 2.5c1.381 0 2.5-1.119 2.5-2.5 0-0.332-0.068-0.649-0.186-0.939l4.946-5.685c0.236 0.073 0.48 0.124 0.74 0.124 0.727 0 1.377-0.316 1.834-0.813l4.669 2.341c0.017 1.367 1.127 2.471 2.497 2.471 1.381 0 2.5-1.119 2.5-2.5 0-0.044-0.011-0.086-0.013-0.13l6.503-5.587c0.309 0.137 0.649 0.216 1.010 0.216 1.381 0 2.5-1.119 2.5-2.5s-1.119-2.5-2.5-2.5z">
                                    </path>
                                </svg>
                            </span>
                            <span class="title">Stocks</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="aside_menu_items secondary">
                <h5>Secondary</h5>
                <ul>
                    <li>
                        <a href="/profile" class=" @if(request()->is('profile')) active @endif ">
                            <span class="icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15 7C15 8.65685 13.6569 10 12 10C10.3431 10 9 8.65685 9 7C9 5.34315 10.3431 4 12 4C13.6569 4 15 5.34315 15 7Z"
                                        stroke="currentColor" stroke-width="2" />
                                    <path
                                        d="M5 19.5C5 15.9101 7.91015 13 11.5 13H12.5C16.0899 13 19 15.9101 19 19.5V20C19 20.5523 18.5523 21 18 21H6C5.44772 21 5 20.5523 5 20V19.5Z"
                                        stroke="currentColor" stroke-width="2" />
                                </svg>
                            </span>
                            <span class="title">
                                Profile
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="/settings" class=" @if(request()->is('settings')) active @endif ">
                            <span class="icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.5213 3.62368C11.3147 2.75255 12.6853 2.75255 13.4787 3.62368L14.2142 4.43128C14.6151 4.87154 15.1914 5.11025 15.7862 5.08245L16.8774 5.03146C18.0543 4.97645 19.0236 5.94568 18.9685 7.12264L18.9176 8.21377C18.8898 8.80859 19.1285 9.38487 19.5687 9.78582L20.3763 10.5213C21.2475 11.3147 21.2475 12.6853 20.3763 13.4787L19.5687 14.2142C19.1285 14.6151 18.8898 15.1914 18.9176 15.7862L18.9685 16.8774C19.0236 18.0543 18.0543 19.0236 16.8774 18.9685L15.7862 18.9176C15.1914 18.8898 14.6151 19.1285 14.2142 19.5687L13.4787 20.3763C12.6853 21.2475 11.3147 21.2475 10.5213 20.3763L9.78582 19.5687C9.38487 19.1285 8.80859 18.8898 8.21376 18.9176L7.12264 18.9685C5.94568 19.0236 4.97645 18.0543 5.03146 16.8774L5.08245 15.7862C5.11025 15.1914 4.87154 14.6151 4.43128 14.2142L3.62368 13.4787C2.75255 12.6853 2.75255 11.3147 3.62368 10.5213L4.43128 9.78582C4.87154 9.38487 5.11025 8.80859 5.08245 8.21376L5.03146 7.12264C4.97645 5.94568 5.94568 4.97645 7.12264 5.03146L8.21376 5.08245C8.80859 5.11025 9.38487 4.87154 9.78583 4.43128L10.5213 3.62368Z"
                                        stroke="currentColor" stroke-width="2" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                                </svg>
                            </span>
                            <span class="title">Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="/help" class=" @if(request()->is('help')) active @endif ">
                            <span class="icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="Warning / Circle_Help">
                                        <path id="Vector"
                                            d="M9.14648 9.07361C9.31728 8.54732 9.63015 8.07896 10.0508 7.71948C10.4714 7.36001 10.9838 7.12378 11.5303 7.03708C12.0768 6.95038 12.6362 7.0164 13.1475 7.22803C13.6587 7.43966 14.1014 7.78875 14.4268 8.23633C14.7521 8.68391 14.9469 9.21256 14.9904 9.76416C15.0339 10.3158 14.9238 10.8688 14.6727 11.3618C14.4215 11.8548 14.0394 12.2685 13.5676 12.5576C13.0958 12.8467 12.5533 12.9998 12 12.9998V14.0002M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21ZM12.0498 17V17.1L11.9502 17.1002V17H12.0498Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </g>
                                </svg>
                            </span>
                            <span class="title">Help</span>
                        </a>
                    </li>
                    <li>
                        <a href="/logout">
                            <span class="icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.9999 2C10.2385 2 7.99991 4.23858 7.99991 7C7.99991 7.55228 8.44762 8 8.99991 8C9.55219 8 9.99991 7.55228 9.99991 7C9.99991 5.34315 11.3431 4 12.9999 4H16.9999C18.6568 4 19.9999 5.34315 19.9999 7V17C19.9999 18.6569 18.6568 20 16.9999 20H12.9999C11.3431 20 9.99991 18.6569 9.99991 17C9.99991 16.4477 9.55219 16 8.99991 16C8.44762 16 7.99991 16.4477 7.99991 17C7.99991 19.7614 10.2385 22 12.9999 22H16.9999C19.7613 22 21.9999 19.7614 21.9999 17V7C21.9999 4.23858 19.7613 2 16.9999 2H12.9999Z"
                                        fill="currentColor" />
                                    <path
                                        d="M13.9999 11C14.5522 11 14.9999 11.4477 14.9999 12C14.9999 12.5523 14.5522 13 13.9999 13V11Z"
                                        fill="currentColor" />
                                    <path
                                        d="M5.71783 11C5.80685 10.8902 5.89214 10.7837 5.97282 10.682C6.21831 10.3723 6.42615 10.1004 6.57291 9.90549C6.64636 9.80795 6.70468 9.72946 6.74495 9.67492L6.79152 9.61162L6.804 9.59454L6.80842 9.58848C6.80846 9.58842 6.80892 9.58778 5.99991 9L6.80842 9.58848C7.13304 9.14167 7.0345 8.51561 6.58769 8.19098C6.14091 7.86637 5.51558 7.9654 5.19094 8.41215L5.18812 8.41602L5.17788 8.43002L5.13612 8.48679C5.09918 8.53682 5.04456 8.61033 4.97516 8.7025C4.83623 8.88702 4.63874 9.14542 4.40567 9.43937C3.93443 10.0337 3.33759 10.7481 2.7928 11.2929L2.08569 12L2.7928 12.7071C3.33759 13.2519 3.93443 13.9663 4.40567 14.5606C4.63874 14.8546 4.83623 15.113 4.97516 15.2975C5.04456 15.3897 5.09918 15.4632 5.13612 15.5132L5.17788 15.57L5.18812 15.584L5.19045 15.5872C5.51509 16.0339 6.14091 16.1336 6.58769 15.809C7.0345 15.4844 7.13355 14.859 6.80892 14.4122L5.99991 15C6.80892 14.4122 6.80897 14.4123 6.80892 14.4122L6.804 14.4055L6.79152 14.3884L6.74495 14.3251C6.70468 14.2705 6.64636 14.1921 6.57291 14.0945C6.42615 13.8996 6.21831 13.6277 5.97282 13.318C5.89214 13.2163 5.80685 13.1098 5.71783 13H13.9999V11H5.71783Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <span class="title">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="summry_wrapper">
                <h5>Summary</h5>
                <select class="mini-selector summary-card-filter" id="summary-card-filter">
                    <option value="today">Today</option>
                    <option value="last_week">Last Week</option>
                    <option value="last_month">Last Month</option>
                    <option value="last_3_month">Last 3 Month</option>
                    <option value="last_6_month">Last 6 Month</option>
                    <option value="last_year">Last Year</option>
                    <option value="last_3_year">Last 3 Year</option>
                    <option value="last_5_year">Last 5 Year</option>
                    <option value="last_10_year">Last 10 Year</option>
                </select>
                <ul>
                    <li>
                        <span class="label">Total Trades</span>
                        <span class="value summary_total_entries">{{ $total_trades }}</span>
                    </li>
                    <!-- <li>
                        <span class="label">Win Rate</span>
                        <span class="value">100.0%</span>
                    </li> -->
                    <li>
                        <span class="label">Net P&L</span>
                        <span class="value summary_total_npl">--</span>
                    </li>
                    <!-- <li>
                        <span class="label">Avg WinL</span>
                        <span class="value profit">$168,333.33</span>
                    </li>
                    <li>
                        <span class="label">Avg Loss</span>
                        <span class="value loss">—</span>
                    </li> -->
                </ul>
            </div>

            <span class="sidebar_bottom_credits">TradeApp &copy; {{ date('Y') }}</span>
        </div>
    </aside>
    */
@endphp