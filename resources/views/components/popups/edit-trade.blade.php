@php
    $formatter = new NumberFormatter('en_US@currency=' . $currency, NumberFormatter::CURRENCY);
    $money_symbol = $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
@endphp



<div class="global-popup" id="edit-trade-popup" data_identity="edit-trade-pop">
    <div class="global-popup__overlay"></div>
    <div class="global-popup__inner">
        <div class="global-popup__main">
            <div class="global-popup__body max-w-170">

                <button class="global-popup__close">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M17 7 7 17M7 7l10 10">
                        </path>
                    </svg>
                </button>

                <form action="" id="edit_trade_popup" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id" id="edit_trd_id" value="" />
                    <input type="hidden" name="trd_qty_size" value="1">
                    <input type="hidden" name="trd_qty_multiplier" value="1">
                    <input type="hidden" name="trd_type" value="">
                    <input type="hidden" name="trd_symbol_key" id="trd_symbol_key" value="">

                    <div class="flex flex-col gap-4 px-4 pt-5 sm:px-6 sm:pt-6">
                        <div
                            class="relative flex shrink-0 items-center justify-center *:data-icon:size-5 bg-primary shadow-xs-skeuomorphic ring-1 ring-primary ring-inset size-10 rounded-lg text-fg-secondary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" data-icon="true" class="z-1">
                                <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </div>

                        <div class="z-10 flex flex-col gap-1">
                            <p class="text-display-xs font-semibold text-primary">Edit Trade</p>
                            <p class="text-sm text-tertiary">Update the details of an existing trade and save your changes to keep your trade log accurate.</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-5 px-4 pt-5 sm:px-6 sm:pt-6">

                        <div class="w-full flex gap-5 max-md:flex-col">
                            <div class="w-full z-2 relative symbol_search_list_wrap">
                                <div class="group flex h-max flex-col items-start justify-start gap-1.5">
                                    <label class="form-label" for="trd_symbol" data-label="true">Symbol</label>
                                    <div class="symbol-input">
                                        <span class="symbol px-2.5!">
                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                                stroke-width="2" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round" aria-hidden="true"
                                                class="pointer-events-none text-fg-quaternary size-5">
                                                <path
                                                    d="m21 21-3.5-3.5m2.5-6a8.5 8.5 0 1 1-17 0 8.5 8.5 0 0 1 17 0Z">
                                                </path>
                                            </svg>
                                        </span>
                                        <input type="text" required="" name="trd_symbol" id="trd_symbol" placeholder="e.g. RELIANCE, TATA, JIO" tabindex="0"
                                            class="form-input">
                                    </div>
                                </div>

                                <div
                                    class="symbol_search_list absolute hidden rounded-lg bg-primary shadow-lg ring-1 ring-secondary_alt outline-hidden  w-full top-[calc(100%+8px)] overflow-hidden z-1">


                                    <div class="loader_wrapper flex items-center justify-center min-h-[120px] hidden">
                                        <svg class="size-6 animate-spin text-brand-tertiary"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>

                                    <div class="dropdown-list hidden">
                                        <div class="dropdown-list__item">

                                            <span class="symbol">
                                                NATURALGAS FUT 27 OCT 26
                                                <div class="symbol_meta">
                                                    <span class="exchange">MCX</span>
                                                    <span class="segment">Future</span>
                                                </div>
                                            </span>

                                            <span class="name">NATURALGAS</span>

                                        </div>
                                        <div class="dropdown-list__item">

                                            <span class="symbol">
                                                NATURALGAS FUT 27 OCT 26
                                                <div class="symbol_meta">
                                                    <span class="exchange MCX">MCX</span>
                                                    <span class="segment">Future</span>
                                                </div>
                                            </span>

                                            <span class="name">NATURALGAS</span>

                                        </div>
                                        <div class="dropdown-list__item">

                                            <span class="symbol">
                                                NATURALGAS FUT 27 OCT 26
                                                <div class="symbol_meta">
                                                    <span class="exchange MCX">MCX</span>
                                                    <span class="segment">Future</span>
                                                </div>
                                            </span>

                                            <span class="name">NATURALGAS</span>

                                        </div>
                                        <div class="dropdown-list__item">

                                            <span class="symbol">
                                                NATURALGAS FUT 27 OCT 26
                                                <div class="symbol_meta">
                                                    <span class="exchange MCX">MCX</span>
                                                    <span class="segment">Future</span>
                                                </div>
                                            </span>

                                            <span class="name">NATURALGAS</span>

                                        </div>
                                        <div class="dropdown-list__item">
                                            <span class="symbol">
                                                NATURALGAS FUT 27 OCT 26
                                                <div class="symbol_meta">
                                                    <span class="exchange MCX">MCX</span>
                                                    <span class="segment">Future</span>
                                                </div>
                                            </span>

                                            <span class="name">NATURALGAS</span>

                                        </div>
                                    </div>


                                    <div class="px-1.5 border-t border-primary py-2">
                                        <div
                                            class="flex gap-3 items-center px-2 py-2 cursor-pointer transition hover:bg-secondary rounded-lg">
                                            <div
                                                class="flex shrink-0 items-center justify-center rounded-full bg-brand-primary text-featured-icon-light-fg-brand size-8">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg" class="size-5">
                                                    <path d="M12 5V19M5 12H19" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                            <span class="font-medium whitespace-nowrap text-primary text-sm">Add
                                                Custom Symbol</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="z-1 group flex h-max flex-col items-start justify-start gap-1.5 w-fit">
                                <div class="form-label" data-label="true">Action</div>
                                <div class="form-radio__tab">

                                    <label for="long">
                                        <input type="radio" name="trd_action" value="Long" id="long" checked>
                                        Long
                                    </label>

                                    <label for="short">
                                        <input type="radio" name="trd_action" value="Short" id="short">
                                        Short
                                    </label>

                                </div>
                            </div>
                        </div>
                        

                        <div class="fld_Wrapper shares_amount_val group flex h-max flex-col items-start justify-start gap-1.5 w-[35%] grow">
                            <label class="form-label" data-label="true">Shares</label>
                            <input type="text" required="" placeholder="Enter your name" tabindex="0"
                                class="form-input" name="trd_shares" value="1" title="">
                        </div>
                        <div class="fld_Wrapper lot_amount_val group hidden flex h-max flex-col items-start justify-start gap-1.5 w-[35%] grow">
                            <label class="form-label" data-label="true">Lot</label>
                            <input type="text" required="" placeholder="Enter your name" tabindex="0"
                                class="form-input" name="trd_lot" value="1" title="">
                        </div>

                        <div class="group flex h-max flex-col items-start justify-start gap-1.5 w-[35%] grow">
                            <label class="form-label" data-label="true">Date</label>
                            <input type="text" required="" placeholder="Enter your name" tabindex="0"
                                class="form-input datepicker" name="trd_date" value="August 21, 2026" title="">
                        </div>

                        <div class="group flex h-max flex-col items-start justify-start gap-1.5 w-[35%] grow">
                            <label class="form-label" data-label="true">Entry Price</label>
                            <div class="symbol-input">
                                <span class="symbol">{{ $money_symbol }}</span>
                                <input type="text" required="" placeholder="0.00" tabindex="0" name="trd_price" class="form-input price">
                            </div>
                        </div>

                        <div class="group flex h-max flex-col items-start justify-start gap-1.5 w-[35%] grow">
                            <label class="form-label" data-label="true">Exit Price</label>
                            <div class="symbol-input">
                                <span class="symbol">{{ $money_symbol }}</span>
                                <input type="text" placeholder="0.00" tabindex="0" name="trd_exit_price" class="form-input price">
                            </div>
                        </div>

                        <div class="group flex h-max flex-col items-start justify-start gap-1.5 w-full grow">
                            <label class="form-label" data-label="true">Charges</label>
                            <div class="symbol-input">
                                <span class="symbol">{{ $money_symbol }}</span>
                                <input type="text" placeholder="0.00" tabindex="0" 
                                name="trd_charges_amount" class="form-input price">
                            </div>
                        </div>
                        <div class="form_text_field p_n_l" data_currency_symbol="{{ $money_symbol }}" style="display:none;"></div>

                        <div class="group flex h-max flex-col items-start justify-start gap-1.5 w-full grow">
                            <label class="form-label" for="trd_notes" data-label="true">Notes</label>
                            <textarea name="trd_notes" id="trd_notes" class="form-input" placeholder="Add your trade notes, observations and what you've learned..."></textarea>
                        </div>

                        <div class="group flex h-max flex-col items-start justify-start gap-1.5 w-full grow">
                            <div class="form-label" data-label="true">Chart Screenshots</div>

                            <div class="flex gap-4 mt-1 mb-3 screenshot-gallery">
                                @php
                                /*
                                <div class="w-[24%] rounded-sm overflow-hidden relative">
                                    <button class="author-open__popup" type="button" tabindex="0"
                                        data-pressed="true">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="size-4 shrink-0 stroke-[2.25px]">
                                            <path
                                                d="M16 6V5.2C16 4.0799 16 3.51984 15.782 3.09202C15.5903 2.71569 15.2843 2.40973 14.908 2.21799C14.4802 2 13.9201 2 12.8 2H11.2C10.0799 2 9.51984 2 9.09202 2.21799C8.71569 2.40973 8.40973 2.71569 8.21799 3.09202C8 3.51984 8 4.0799 8 5.2V6M10 11.5V16.5M14 11.5V16.5M3 6H21M19 6V17.2C19 18.8802 19 19.7202 18.673 20.362C18.3854 20.9265 17.9265 21.3854 17.362 21.673C16.7202 22 15.8802 22 14.2 22H9.8C8.11984 22 7.27976 22 6.63803 21.673C6.07354 21.3854 5.6146 20.9265 5.32698 20.362C5 19.7202 5 18.8802 5 17.2V6"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>

                                    </button>
                                    <img src="https://images.pexels.com/photos/26926327/pexels-photo-26926327.jpeg"
                                        alt="" class="h-auto w-full">
                                </div>
                                */
                                @endphp
                            </div>

                            <label for="trd_ss_file"
                                class="relative flex flex-col items-center gap-3 rounded-xl bg-primary px-6 py-4 text-tertiary ring-1 ring-secondary transition duration-100 ease-linear ring-inset w-full cursor-pointer">
                                <input multiple="true" id="trade_screenshots" name="trade_screenshots[]" type="file" id="trd_ss_file" class="absolute opacity-0 inset-0 cursor-pointer" accept="images/*" />
                                <div class="relative flex shrink-0 items-center justify-center *:data-icon:size-5 bg-primary shadow-xs-skeuomorphic ring-1 ring-primary ring-inset size-10 rounded-lg text-fg-secondary"
                                    data-featured-icon="true">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                        stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true" data-icon="true" class="z-1">
                                        <path
                                            d="m8 16 4-4m0 0 4 4m-4-4v9m8-4.257A5.5 5.5 0 0 0 16.5 7a.62.62 0 0 1-.534-.302 7.5 7.5 0 1 0-11.78 9.096">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex flex-col gap-1 text-center">
                                    <div class="flex justify-center gap-1 text-center">
                                        <span class="text-sm max-md:hidden">
                                            <span class="text-brand-secondary font-semibold">Click to
                                                upload</span> or drag and drop</span>
                                    </div>
                                    <p class="text-xs transition duration-100 ease-linear">SVG, PNG, JPG or GIF
                                        (max. 800x400px)</p>
                                </div>
                            </label>
                        </div>

                    </div>

                    <div
                        class="z-10 flex flex-1 flex-col-reverse gap-3 p-4 pt-6 *:grow sm:grid sm:grid-cols-2 sm:px-6 sm:pt-8 sm:pb-6">
                        <button type="button" class="btn btn-md btn-secondary">
                            <span class="transition px-0.5">Cancel</span>
                        </button>
                        <button class="btn btn-md btn-primary" type="submit">
                            <span class="transition px-0.5">Save Trade</span>
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
<div class="main_popup" data_identity="edit-trade-pop">
    <div class="main_popup_inner">
        <span class="close">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 8L8 16M8 8L16 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </span>
        <div class="main_pop_content">
            <h2>Edit Trade</h2>
            <p>Update the details of an existing trade and save your changes to keep your trade log accurate.</p>

            <form action="" id="edit_trade_popup" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="edit_trd_id" value="" />
                <div class="form_fields">
                    <div class="form_field_group">
                        <div class="form_field icon">
                            <label for="edit-symbol">Symbol</label>
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
                                <input type="text" name="trd_symbol" id="edit-symbol" placeholder="e.g. RELIANCE, TATA, APPL"
                                    required />
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
                        <div class="form_field toggle">
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
                            <input type="text" name="trd_shares" id="shares_amount" placeholder="0.00" />
                        </div>
                        <div class="form_field" style="display:none;">
                            <label for="trd_lot">Lot</label>
                            <input type="text" name="trd_lot" id="trd_lot" placeholder="0" />
                        </div>
                    </div>

                    <div class="form_field">
                        <label for="trade_date">Date</label>
                        <input type="text" class="datepicker" name="trd_date" id="trade_date" required />
                    </div>

                    <div class="form_field_group">
                        <div class="form_field">
                            <label for="entry_price_amount">Entry Price</label>
                            <div class="price_field">
                                <span class="currency">{{ $money_symbol }}</span>
                                <input type="text" class="price" name="trd_price" id="entry_price_amount" placeholder="0.00"
                                    required />
                            </div>
                        </div>
                        <div class="form_field">
                            <label for="exit_price_amount">Exit Price</label>
                            <div class="price_field">
                                <span class="currency">{{ $money_symbol }}</span>
                                <input type="text" class="price" name="trd_exit_price" id="exit_price_amount" placeholder="0.00"
                                    required />
                            </div>
                        </div>
                    </div>
                    <div class="form_field">
                        <label for="trd_charges_amount">Charges</label>
                        <div class="price_field">
                            <span class="currency">{{ $money_symbol }}</span>
                            <input type="text" class="price" name="trd_charges_amount" id="trd_charges_amount" placeholder="0.00"
                                required />
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
                        <div class="screenshot-gallery">
                            <div class="image_gallery"></div>
                        </div>
                        <label class="dropzone" for="trade_screenshots">
                            <input type="file" name="trade_screenshots[]" id="trade_screenshots" accept="image/*"
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
                    <button type="button" class="btn btn-md btn-secondary" disabled>Add Execution</button>
                    <button type="submit" class="btn btn-md btn-primary">
                        <span class="text">Save</span>
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