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
            <form action="" id="edit_trade_popup">
                <div class="form_fields">
                    <!-- <div class="form_field_group">
                        <div class="form_field">
                            <label for="market_name">Market Name</label>
                            <input type="text" name="trd_market_name" id="market_name" placeholder="BSE or NSE" required />
                        </div>
                    </div> -->
                    <div class="form_field">
                        <label for="symbol">Symbol</label>
                        <input type="text" name="trd_symbol" id="symbol" placeholder="RELIANCE, TATA, APPL" required />
                    </div>

                    <div class="form_field">
                        <label for="action">Action</label>
                        <select name="trd_action" id="action">
                            <option value="buy">Buy</option>
                            <option value="sell">Sell</option>
                        </select>
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
                    <div class="form_field">
                        <label for="shares_amount">Shares</label>
                        <input type="text" name="trd_shares" id="shares_amount" placeholder="0.00" required />
                    </div>
                    <div class="form_field">
                        <label for="price_amount">Price</label>
                        <input type="text" name="trd_price" id="price_amount" placeholder="0.0000" required />
                    </div>
                    <!-- <div class="form_field_group">
                        <div class="form_field">
                            <label for="commissions_amount">Commisions</label>
                            <input type="text" name="trd_commissions" id="commissions_amount" placeholder="0.00" required />
                        </div>
                        <div class="form_field">
                            <label for="fee_amount">Fees</label>
                            <input type="text" name="trd_fees" id="fee_amount" placeholder="0.00" required />
                        </div>
                    </div> -->
                </div>
                <div class="form_action_btns">
                    <button type="button" class="btn btn-secondary" disabled>Add Execution</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>