@php
    $formatter = new NumberFormatter('en_US@currency=' . $currency, NumberFormatter::CURRENCY);
    $money_symbol = $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
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
                        <button type="button" class="copy_link_btn btn btn-primary">Copy</button>
                    </div>
                </div>
                <div class="live_link_qr_zone_wrap" style="display: none;">
                    <span class="saparator" data-content="QR scan to open"></span>
                    <div id="live_link_qr_zone"></div>
                </div>
                <div class="form_action_btns">
                    <button type="button" class="btn btn-secondary close">
                        <span class="text">Cancel</span>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <span class="text">Generate Link</span>
                        <span class="loader">Please wait...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>