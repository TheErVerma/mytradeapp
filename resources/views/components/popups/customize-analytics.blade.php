@php
    use App\Services\OptionService;
    $analytic_cards = [
        [
            'title' => 'Account Summary',
            'desc' => 'Choose which summary cards you want to display on your dashboard.'
        ],
        [
            'title' => 'Trading Calendar',
            'desc' => 'Show your daily trading activity and P&L on the calendar.'
        ],
        [
            'title' => 'Performance Metrics',
            'desc' => 'Show key statistics that summarize your trading performance.'
        ],
        [
            'title' => 'Weekly Summary',
            'desc' => 'Show your trading performance and P&L breakdown by day of the week.'
        ],
    ];
@endphp

<div class="global-popup" data_identity="customize-analytics-pop">
    <div class="global-popup__overlay"></div>
    <div class="global-popup__inner">
        <div class="global-popup__main">
            <div class="global-popup__body max-w-170">

                <button class="global-popup__close">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M17 7 7 17M7 7l10 10">
                        </path>
                    </svg>
                </button>

                <form action="" id="customize-analytics_form" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="flex flex-col gap-4 px-4 pt-5 sm:px-6 sm:pt-6">
                        <div
                            class="relative flex shrink-0 items-center justify-center *:data-icon:size-5 bg-primary shadow-xs-skeuomorphic ring-1 ring-primary ring-inset size-10 rounded-lg text-fg-secondary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3 8L15 8M15 8C15 9.65686 16.3431 11 18 11C19.6569 11 21 9.65685 21 8C21 6.34315 19.6569 5 18 5C16.3431 5 15 6.34315 15 8ZM9 16L21 16M9 16C9 17.6569 7.65685 19 6 19C4.34315 19 3 17.6569 3 16C3 14.3431 4.34315 13 6 13C7.65685 13 9 14.3431 9 16Z"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>


                        </div>

                        <div class="z-10 flex flex-col gap-1">
                            <p class="text-display-xs font-semibold text-primary">Customize Analytics</p>
                            <p class="text-sm text-tertiary">Customize your analytics dahsboard, show/hide your desired
                                data.</p>
                        </div>
                    </div>


                    <div class="flex flex-wrap gap-5 px-4 py-4 sm:pt-6 sm:px-6 my-6">
                        @php
                        $customized_analytic_cards = OptionService::getOption('customized_analytic_cards');
                        @endphp
                        @foreach ($analytic_cards as $analytic_card)
                            @php
                            $slctd_cstman = '';
                            if($customized_analytic_cards && is_array($customized_analytic_cards) && in_array(slugifyStr($analytic_card['title']), $customized_analytic_cards)){
                                $slctd_cstman = 'checked';
                            }
                            @endphp
                            <div class="border border-secondary rounded-lg w-full cursor-pointer">
                                <label class="cursor-pointer flex gap-2 hover:bg-primary_hover p-6 relative w-full" data-rac=""
                                    for="{{ slugifyStr($analytic_card['title']) }}">
                                    <span
                                        style="border: 0px; clip: rect(0px, 0px, 0px, 0px); clip-path: inset(50%); height: 1px; margin: -1px; overflow: hidden; padding: 0px; position: absolute; width: 1px; white-space: nowrap;">
                                        <input id="{{ slugifyStr($analytic_card['title']) }}" name="analytic_cards[]" tabindex="0" value="{{ slugifyStr($analytic_card['title']) }}" {{ $slctd_cstman }} type="checkbox">
                                    </span>
                                    <div class="toggle_btn_wrap">
                                        <div class="toggle_btn_slider"
                                            style="transition: transform 0.15s ease-in-out, translate 0.15s ease-in-out, border-color 0.1s linear, background-color 0.1s linear;">
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="text-md" style="line-height: 1;margin-bottom: 4px;">
                                            {{ $analytic_card['title'] }}</h4>
                                        <p class="text-fg-quaternary select-none text-sm font-medium">
                                            {{ $analytic_card['desc'] }}</p>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div
                        class="z-10 flex flex-1 flex-col-reverse gap-3 p-4 pt-6 *:grow sm:grid sm:grid-cols-2 sm:px-6 sm:pt-8 sm:pb-6">
                        <button type="button" class="btn btn-md btn-secondary cancel_action">
                            <span class="transition px-0.5">Cancel</span>
                        </button>
                        <button class="btn btn-md btn-primary" type="submit">
                            <span class="transition px-0.5">Save Changes</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>