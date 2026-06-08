
<div class="main_popup" data_identity="edit-trade-pop">
    <div class="main_popup_inner">
        <span class="close">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 8L8 16M8 8L16 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </span>
        <div class="main_pop_content">
            <h2>Edit Trade</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate similique ducimus impedit eligendi aut nobis mollitia maiores, assumenda perspiciatis pariatur quisquam!</p>

            <form action="" id="edit_trade_popup" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="edit_trd_id" value="" />
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
                                <input type="text" name="trd_symbol" id="symbol" placeholder="e.g. RELIANCE, TATA, APPL"
                                    required />
                            </div>
                        </div>

                        <div class="form_field toggle">
                            <div class="form_field_label">Action</div>
                            <div class="form_field toggle_inner">
                                <label for="edit_action_buy" class="positive">Long
                                    <input type="radio" name="trd_action" id="edit_action_buy" value="Buy" checked/>
                                </label>
                                <label for="edit_action_sell" class="negative">Short
                                    <input type="radio" name="trd_action" id="edit_action_sell" value="Sell"/>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form_field_group">
                        <div class="form_field">
                            <label for="trade_date">Date</label>
                            <input type="date" name="trd_date" id="trade_date" required />
                        </div>
                        <div class="form_field">
                            <label for="trade_time">Time</label>
                            <input type="time" name="trd_time" id="trade_time" required />
                        </div>
                    </div>
                    <div class="form_field_group">
                        <div class="form_field toggle">
                            <div class="form_field_label">Type</div>
                            <div class="form_field toggle_inner">
                                <label for="edit_type_cash" class="positive">Cash
                                    <input type="radio" name="trd_type" id="edit_type_cash" value="Cash" checked/>
                                </label>
                                <label for="edit_type_fno" class="negative">F&O
                                    <input type="radio" name="trd_type" id="edit_type_fno" value="F&O"/>
                                </label>
                            </div>
                        </div>
                        <div class="form_field" >
                            <label for="trd_lot">Lot</label>
                            <input type="text" name="trd_lot" id="trd_lot" placeholder="0" />
                        </div>
                        <div class="form_field" style="display:none;">
                            <label for="shares_amount">Shares</label>
                            <input type="text" name="trd_shares" id="shares_amount" placeholder="0.00" />
                        </div>

                    </div>
                    <div class="form_field">
                        <label for="price_amount">Price</label>
                        <input type="text" name="trd_price" id="price_amount" placeholder="0.0000" required />
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
                            <input type="file" name="trade_screenshots[]" id="trade_screenshots" accept="image/*" multiple/>
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
                    <button type="button" class="btn btn-secondary" disabled>Add Execution</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="text">Save</span>
                        <span class="loader">Please wait...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>