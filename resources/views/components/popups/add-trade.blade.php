@php
    $formatter = new NumberFormatter('en_US@currency=' . $currency, NumberFormatter::CURRENCY);
    $money_symbol = $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
@endphp

<div class="main_popup" data_identity="add-trade-pop">
    <div class="main_popup_inner">
        <span class="close">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 8L8 16M8 8L16 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </span>
        <div class="main_pop_content">
            <h2>Add Trade</h2>
            <p>Add your latest trade to your journal. Fill in the trade details to maintain an accurate trading history
            </p>
            <form action="" id="add_trade_popup" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="form_fields">
                    <div class="form_field_group">
                        <div class="form_field icon">
                            <label for="symbol">Symbol</label>
                            <div class="icon_field_inner">
                                <span class="icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="Interface / Search_Magnifying_Glass">
                                            <path id="Vector"
                                                d="M15 15L21 21M10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10C17 13.866 13.866 17 10 17Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                </span>
                                <input type="text" name="trd_symbol" id="symbol" placeholder="e.g. RELIANCE, TATA, JIO"
                                    required />
                                <span class="loader">
                                    <img src="/storage/images/loader.gif" />
                                </span>
                                <input type="hidden" name="trd_symbol_key" id="symbol_key" required />
                            </div>
                            <div class="field_drop_down_wrap">
                                <ul class="field_drop_down">
                                    @php
                                        /*
                                        // echo "
                                                                            <pre>";
                                        // print_r($upstox);
                                        // echo "<pre>";
                                        $upstox_sub = array_map(function($upstox_itm) {
                                            return [
                                                'name'  => $upstox_itm['name'],
                                                'key'  => $upstox_itm['instrument_key'],
                                                'exch'  => $upstox_itm['exchange'],
                                                'symbol'  => $upstox_itm['trading_symbol'],
                                            ];
                                        }, $upstox);
                                        @if (!empty($upstox_sub))
                                            @foreach ($upstox_sub as $trade_symbol)
                                                <li data_value="{{ $trade_symbol['key'] }}">{{ $trade_symbol['name'] }} ({{ $trade_symbol['symbol'] }})</li>
                                            @endforeach
                                        @endif
                                        */
                                    @endphp
                                </ul>
                                <div class="add_custom_symbol" data-popup-target="custom-symbol-pop">
                                    <span class="icon">
                                        <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none">
                                            <path d="M13 3C13 2.44772 12.5523 2 12 2C11.4477 2 11 2.44772 11 3V11H3C2.44772 11 2 11.4477 2 12C2 12.5523 2.44772 13 3 13H11V21C11 21.5523 11.4477 22 12 22C12.5523 22 13 21.5523 13 21V13H21C21.5523 13 22 12.5523 22 12C22 11.4477 21.5523 11 21 11H13V3Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                    <span class="text">Add Custom Symbol</span>
                                </div>
                            </div>
                        </div>

                        <div class="form_field toggle">
                            <div class="form_field_label">Action</div>
                            <div class="form_field togglebtn">
                                <label for="trd_action" class="positive">
                                    <span class="option_1">Long</span>
                                    <span class="option_2">Short</span>
                                    <input type="checkbox" name="trd_action" id="trd_action" value="Short" />
                                </label>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="form_field_group">
                        <div class="form_field toggle hidden_field">
                            <div class="form_field_label">Type</div>
                            <div class="form_field togglebtn">
                                <label for="trd_type" class="positive">
                                    <span class="option_1">Cash</span>
                                    <span class="option_2">F&O</span>
                                    <input type="checkbox" name="trd_type" id="trd_type" value="F&O" />
                                </label>
                            </div>
                        </div>
                        <div class="form_field">
                            <label for="shares_amount">Shares</label>
                            <input type="text" class="qtynumamnt" name="trd_shares" id="shares_amount" value="1" required/>
                        </div>
                        <div class="form_field" style="display:none;">
                            <label for="trd_lot">Lot</label>
                            <input type="text" class="qtynumamnt" name="trd_lot" id="trd_lot" value="1" />
                        </div>
                    </div>
                    <div class="form_field">
                        <label for="trade_date">Date</label>
                        <input type="text" class="datepicker" name="trd_date" id="trade_date" required value="
                        @php 
                            echo date('Y-m-d');
                        @endphp
                        "/>
                    </div>
                    <div class="form_field_group">
                        <div class="form_field">
                            <label for="entry_price_amount">Entry Price</label>
                            <div class="price_field">
                                <span class="currency">{{ $money_symbol }}</span>
                                <input type="text" class="price" name="trd_price" id="entry_price_amount" placeholder="0.00" required />
                            </div>
                        </div>
                        <div class="form_field">
                            <label for="exit_price_amount">Exit Price</label>
                            <div class="price_field">
                                <span class="currency">{{ $money_symbol }}</span>
                                <input type="text" class="price" name="trd_exit_price" id="exit_price_amount" placeholder="0.00" required />
                            </div>
                        </div>
                    </div>
                    <div class="form_field">
                        <label for="trd_charges_amount">Charges</label>
                        <div class="price_field">
                            <span class="currency">{{ $money_symbol }}</span>
                            <input type="text" class="price" name="trd_charges_amount" id="trd_charges_amount" placeholder="0.00" required />
                        </div>
                    </div>
                    <div class="form_text_field p_n_l" data_currency_symbol="{{ $money_symbol }}" style="display:none;">
                        <p><strong>Loss: </strong><span>-$20</span></p>
                        <p><strong>Profit: </strong><span>+$20</span></p>
                    </div>

                    <div class="form_field">
                        <label for="trade_notes">Notes</label>
                        <textarea name="trd_notes" id="trade_notes" rows="6"
                            placeholder="Add your trade notes, observations and what you've learned..."
                            required></textarea>
                    </div>
                    <div class="form_field">
                        <label for="trade_screenshots">Chart Screenshots</label>
                        <div class="screenshot-gallery"></div>
                        <label class="dropzone" for="trade_screenshots">
                            <input type="file" name="trade_screenshots[]" id="trade_screenshots" accept="images/*"
                                multiple />
                            <span class="icon">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 16C13.6569 16 15 14.6569 15 13C15 11.3431 13.6569 10 12 10C10.3431 10 9 11.3431 9 13C9 14.6569 10.3431 16 12 16Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M3 16.8V9.2C3 8.0799 3 7.51984 3.21799 7.09202C3.40973 6.71569 3.71569 6.40973 4.09202 6.21799C4.51984 6 5.0799 6 6.2 6H7.25464C7.37758 6 7.43905 6 7.49576 5.9935C7.79166 5.95961 8.05705 5.79559 8.21969 5.54609C8.25086 5.49827 8.27836 5.44328 8.33333 5.33333C8.44329 5.11342 8.49827 5.00346 8.56062 4.90782C8.8859 4.40882 9.41668 4.08078 10.0085 4.01299C10.1219 4 10.2448 4 10.4907 4H13.5093C13.7552 4 13.8781 4 13.9915 4.01299C14.5833 4.08078 15.1141 4.40882 15.4394 4.90782C15.5017 5.00345 15.5567 5.11345 15.6667 5.33333C15.7216 5.44329 15.7491 5.49827 15.7803 5.54609C15.943 5.79559 16.2083 5.95961 16.5042 5.9935C16.561 6 16.6224 6 16.7454 6H17.8C18.9201 6 19.4802 6 19.908 6.21799C20.2843 6.40973 20.5903 6.71569 20.782 7.09202C21 7.51984 21 8.0799 21 9.2V16.8C21 17.9201 21 18.4802 20.782 18.908C20.5903 19.2843 20.2843 19.5903 19.908 19.782C19.4802 20 18.9201 20 17.8 20H6.2C5.0799 20 4.51984 20 4.09202 19.782C3.71569 19.5903 3.40973 19.2843 3.21799 18.908C3 18.4802 3 17.9201 3 16.8Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            <h4>Add screenshots</h4>
                            <p>Drag & drop multiple images or click to browse<br>PNG, JPEG, WebP, GIF up to 5MB each</p>
                        </label>
                    </div>

                </div>
                <div class="form_action_btns">
                    <!-- <button type="button" class="btn btn-md btn-secondary" disabled>Add Execution</button> -->
                    <button type="submit" class="btn btn-md btn-primary">
                        <span class="text">Save</span>
                        <span class="loader">Please wait...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>