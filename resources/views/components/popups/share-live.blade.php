@php
    $formatter = new NumberFormatter('en_US@currency=' . $currency, NumberFormatter::CURRENCY);
    $money_symbol = $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
    $live_key = json_decode($user->live_sharing, true);
    $live_timeperiod = isset($live_key['timeperiod']) ? $live_key['timeperiod'] : 0;
    $selected_period = isset($live_key['period']) && $live_timeperiod > time() ? $live_key['period'] : '';
    $live_share_link = $live_key && $live_timeperiod > time() ? $live_key['hash'] : '';
@endphp


 <div class="global-popup" data_identity="share-trade-pop">
        <div class="global-popup__overlay">

        </div>
        <div class="global-popup__inner">
            <div class="global-popup__main">
                <div class="global-popup__body max-w-110">

                    <button class="global-popup__close">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17 7 7 17M7 7l10 10">
                            </path>
                        </svg>
                    </button>

                    <form action="" id="share_live_trade_popup" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="flex flex-col gap-4 px-4 pt-5 sm:px-6 sm:pt-6">

                            <div
                                class="relative flex shrink-0 items-center justify-center *:data-icon:size-5 bg-primary shadow-xs-skeuomorphic ring-1 ring-primary ring-inset size-10 rounded-lg text-fg-secondary">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" data-icon="true" class="z-1">
                                    <path
                                        d="M12.7076 18.3639L11.2933 19.7781C9.34072 21.7308 6.1749 21.7308 4.22228 19.7781C2.26966 17.8255 2.26966 14.6597 4.22228 12.7071L5.63649 11.2929M18.3644 12.7071L19.7786 11.2929C21.7312 9.34024 21.7312 6.17441 19.7786 4.22179C17.826 2.26917 14.6602 2.26917 12.7076 4.22179L11.2933 5.636M8.50045 15.4999L15.5005 8.49994"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

                            <div class="z-10 flex flex-col gap-0.5">
                                <p class="text-xl font-semibold text-primary">Share Live Data</p>
                                <p class="text-sm text-tertiary">Share your live data securely with others and keep</p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-5 px-4 pt-5 sm:px-6 sm:pt-6">
                            <div class="group flex h-max w-full flex-col items-start justify-start gap-1.5">

                                <label class="form-label" data-label="true">Link expires after</label>

                                <select name="share_time_period" id="share_time_period" class="form-select text-sm!">
                                    @php
                                    $periods = [
                                        'Minutes' => [
                                            '1 minute',
                                            '5 minutes',
                                            '10 minutes',
                                            '30 minutes',
                                        ],
                                        'Hours' => [
                                            '1 hour',
                                            '2 hours',
                                            '12 hours',
                                        ],
                                        'Days' => [
                                            '1 day',
                                            '2 days',
                                        ],
                                        'Weeks' => [
                                            '1 week',
                                            '2 weeks',
                                        ],
                                        'Months' => [
                                            '1 month',
                                            '6 months',
                                        ],
                                        'Year' => [
                                            '1 year',
                                        ],
                                    ];

                                    foreach ($periods as $group => $options) {
                                        echo '<optgroup label="' . ($group) . '">';

                                        foreach ($options as $option) {
                                            $selected = ($selected_period === $option) ? ' selected' : '';

                                            echo '<option value="' . ($option) . '"' . $selected . '>'
                                                . ($option)
                                                . '</option>';
                                        }

                                        echo '</optgroup>';
                                    }
                                    @endphp
                                </select>

                                <div class="text-xs text-secondary">This shared link will stop working after the
                                    selected time.</div>

                            </div>

                            <div class="flex gap-2.5 {{ $live_share_link != "" ? '' : 'hide' }} copy_live_link_wrap">
                                <input type="text" name="live_share_link" id="live_share_link"
                                    placeholder="e.g https://example.com/?trd_plk=xxxxxxxxxxxxxxxxxxxxxxxxxxx" value="{{ $live_share_link }}"
                                    class="form-input md">
                                <button type="button" class="copy_link_btn btn btn-md btn-primary shrink-0 min-w-20">
                                    <span class="transition px-0.5">Copy</span>
                                </button>
                            </div>

                            <div class="flex flex-col gap-4 justify-center items-center {{ $live_share_link != "" ? '' : 'hide' }} qrcode_live_link_wrap">
                                <div class="w-full shrink-0 flex items-center gap-x-2">
                                    <div class="h-px flex-1 bg-border-secondary">

                                    </div>
                                    <span class="text-sm font-medium text-tertiary">QR scan to open</span>
                                    <div class="h-px flex-1 bg-border-secondary">

                                    </div>
                                </div>
                                <div class="relative flex items-center justify-center live_share_qr_code">
                                    
                                </div>
                            </div>

                        </div>

                        <div
                            class="z-10 flex flex-1 flex-col-reverse gap-3 p-4 pt-6 *:grow sm:grid sm:grid-cols-2 sm:px-6 sm:pt-8 sm:pb-6">
                            <button type="button" class="btn btn-md btn-secondary cancel_action" data-popup-target="share-trade-pop">
                                <span class="transition px-0.5">Cancel</span>
                            </button>
                            <button class="btn btn-md btn-primary" type="submit">
                                <span class="transition px-0.5">Generate Link</span>
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


@php
ob_start();
@endphp
<div class="main_popup" data_identity="share-trade-pop">
    <div class="main_popup_inner">
        <span class="close">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                <path d="M16 8L8 16M8 8L16 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </span>
        <div class="main_pop_content">

            <span class="icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M10.0464 14C8.54044 12.4882 8.67609 9.90087 10.3494 8.22108L15.197 3.35462C16.8703 1.67483 19.4476 1.53865 20.9536 3.05046C22.4596 4.56228 22.3239 7.14956 20.6506 8.82935L18.2268 11.2626"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path
                        d="M13.9536 10C15.4596 11.5118 15.3239 14.0991 13.6506 15.7789L11.2268 18.2121L8.80299 20.6454C7.12969 22.3252 4.55237 22.4613 3.0464 20.9495C1.54043 19.4377 1.67609 16.8504 3.34939 15.1706L5.77323 12.7373"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </span>
            <h2>Share Live Data</h2>

            <p>Share your live data securely with others and keep them updated in real time.</p>
            <form action="" id="share_live_trade_popup" enctype="multipart/form-data" autocomplete="off">
                @csrf

                @php
                $user = Auth::user();
                $sharing_data = $user->live_sharing;
                $sharing_arr = json_decode($sharing_data, true);
                $timestamp = isset($sharing_arr['timeperiod']) ? $sharing_arr['timeperiod'] : 0;
                $is_enabled = $timestamp > time();

                $selected_period = ($is_enabled && isset($sharing_arr['period'])) ? $sharing_arr['period'] : '';
                $shared_link = isset($sharing_arr['hash']) ? $sharing_arr['hash'] : '';
                @endphp
                <input type="hidden" name="live_share_link_" value="https://example.com" />

                <div class="form_fields">
                    <div class="form_field time_period_selector">
                        <label for="share_time_period">Link expires after</label>

                        <select name="share_time_period" id="share_time_period">
                        @php
                        $periods = [
                            'Minutes' => [
                                '1 minute',
                                '5 minutes',
                                '10 minutes',
                                '30 minutes',
                            ],
                            'Hours' => [
                                '1 hour',
                                '2 hours',
                                '12 hours',
                            ],
                            'Days' => [
                                '1 day',
                                '2 days',
                            ],
                            'Weeks' => [
                                '1 week',
                                '2 weeks',
                            ],
                            'Months' => [
                                '1 month',
                                '6 months',
                            ],
                            'Year' => [
                                '1 year',
                            ],
                        ];

                        foreach ($periods as $group => $options) {
                            echo '<optgroup label="' . ($group) . '">';

                            foreach ($options as $option) {
                                $selected = ($selected_period === $option) ? ' selected' : '';

                                echo '<option value="' . ($option) . '"' . $selected . '>'
                                    . ($option)
                                    . '</option>';
                            }

                            echo '</optgroup>';
                        }
                        @endphp
                        </select>

                        <small>This shared link will stop working after the selected time.</small>
                    </div>
                    <div class="form_field inline_btn_field {{ $is_enabled ? '' : 'disabled' }}">
                        <input type="text" name="live_share_link" id="live_share_link"
                            placeholder="e.g https://example.com/?trd_plk=xxxxxxxxxxxxxxxxxxxxxxxxxxx" value="{{ $is_enabled ? $shared_link :'' }}">
                        <button type="button" class="copy_link_btn btn btn-md btn-primary">Copy</button>
                    </div>
                </div>
                <div class="live_link_qr_zone_wrap" style="display: none;">
                    <span class="saparator" data-content="QR scan to open"></span>
                    <div id="live_link_qr_zone"></div>
                </div>
                <div class="form_action_btns">
                    <button type="button" class="btn btn-md btn-secondary close">
                        <span class="text">Cancel</span>
                    </button>
                    <button type="submit" class="btn btn-md  btn-primary">
                        <span class="text">Generate Link</span>
                        <span class="loader">Please wait...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@php
ob_end_clean();
@endphp