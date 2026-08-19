@php
    $formatter = new NumberFormatter('en_US@currency=' . $currency, NumberFormatter::CURRENCY);
    $money_symbol = $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
@endphp

<div class="main_popup" data_identity="custom-symbol-pop">
    <div class="main_popup_inner">
        <span class="close">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 8L8 16M8 8L16 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </span>
        <div class="main_pop_content">
            <h2>Create Custom Symbol</h2>
            <p>Enter a symbol manually for options, futures, or instruments not found in search.</p>
            <form action="" id="custom_symbol_popup" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="form_fields">
                    <div class="form_field">
                        <label for="cs_symbol_name">Symbol <span class="required">*</span></label>
                        <input type="text" name="symbol_name" id="cs_symbol_name" required
                            placeholder="e.g. RELIANCE, TATA, JIO">
                        <small>Up to 50 Characters</small>
                    </div>
                    <div class="form_field">
                        <label for="cs_company_name">Company Name (Optional)</label>
                        <input type="text" name="company_name" id="cs_company_name" placeholder="e.g. MYCOMPANY">
                    </div>
                    <div class="form_field_group">
                        <div class="form_field toggle">
                            <div class="form_field_label">Type</div>
                            <div class="form_field togglebtn">
                                <label for="cs_trd_type" class="positive">
                                    <span class="option_1">Cash</span>
                                    <span class="option_2">F&O</span>
                                    <input type="checkbox" name="cs_trd_type" id="cs_trd_type" value="F&O" />
                                </label>
                            </div>
                        </div>
                        <div class="form_field">
                            <label for="cs_exchange">Exchange <span class="required">*</span></label>
                            <select name="exchange" id="cs_exchange" required>
                                <option value="bse">BSE</option>
                                <option value="nse">NSE</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form_action_btns">
                    <button type="submit" class="btn btn-md btn-primary">
                        <span class="text">Add Symbol</span>
                        <span class="loader">Please wait...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>