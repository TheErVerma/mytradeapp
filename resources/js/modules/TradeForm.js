
export default class TradeForm {

    crnt_page = 1;
    token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    constructor() {
        this.trdTypeFilters = document.querySelectorAll('.trades_table_filter_btm .filter-tab');
        this.init();
    }

    init() {
        const thisApp = this;
        document.addEventListener('submit', this.handleSubmit.bind(this));
        if (document.querySelectorAll('[name="trd_symbol"]').length >= 1) {
            document.querySelectorAll('[name="trd_symbol"]').forEach(inp_bar => {
                inp_bar.addEventListener('focus', this.openSuggestions.bind(this));
                inp_bar.addEventListener('input', this.searchSuggestions.bind(this));
                inp_bar.addEventListener('blur', this.closeSuggestions.bind(this));
            });
        }
        if (document.querySelectorAll('#trd_symbol').length >= 1) {
            document.querySelector('#trd_symbol').addEventListener('input', this.searchSuggestions.bind(this));
        }
        if (document.querySelectorAll('#trd_symbol').length >= 1) {
            document.querySelector('#trd_symbol').addEventListener('blur', this.closeSuggestions.bind(this));
        }
        if (document.querySelectorAll('#trades_per_page').length >= 1) {
            document.querySelector('#trades_per_page').addEventListener('change', function(){
                thisApp.crnt_page = 1;
                thisApp.FilterJournal();
            });
        }
        if (document.querySelectorAll('#trade_search').length >= 1) {
            let debounceSearch = false;
            document.querySelector('#trade_search').addEventListener('input', function(){
                clearTimeout(debounceSearch);
                debounceSearch = setTimeout(() => {
                    thisApp.crnt_page = 1;
                    thisApp.FilterJournal();
                }, 400);
            });
        }
        if (document.querySelectorAll('.export_all_trades').length >= 1) {
            document.querySelector('.export_all_trades').addEventListener('click', this.downloadTradeCsv.bind(this));
        }
        if (document.querySelectorAll('#trade_date_range, #trade_date_from, #trade_date_to').length >= 1) {
            document.querySelectorAll('#trade_date_range, #trade_date_from, #trade_date_to').forEach((dt_inp, dt_indx) => {
                dt_inp.addEventListener('change', function(){
                    thisApp.crnt_page = 1;
                    thisApp.FilterJournal();
                });
            });
        }
        document.querySelectorAll('.symbol_search_list .dropdown-list__item').forEach((drop_itm) => {
            drop_itm.addEventListener('click', this.selectSuggestion.bind(this));
        })

        this.trdTypeFilters.forEach((trdType) => {
            trdType.addEventListener('click', () => {
                
                thisApp.trdTypeFilters.forEach((trdType) => {
                    trdType.classList.remove('active');
                });
                
                trdType.classList.add('active');
                thisApp.crnt_page = 1;
                this.FilterJournal();
                // this.FilterTradeTable(trdType.getAttribute('data_type'), trdType);
            });
        });

        this.conditionalLogic();

        document.getElementById('custom_symbol_popup').addEventListener('submit', this.createCustomSymbol);


        const next_journal_page = document.querySelector('.next_journal_page');
        if(next_journal_page){
            next_journal_page.addEventListener('click', function(){
                const this_btn = this;
                const total_pages = Number(this_btn.getAttribute('data_total_pages'));
                if(thisApp.crnt_page < total_pages){
                    thisApp.crnt_page++;
                    document.querySelector('.prev_journal_page').removeAttribute('disabled');
                }
                
                if(thisApp.crnt_page >= total_pages){
                    this_btn.setAttribute('disabled', true);
                }
                thisApp.FilterJournal();
            });
        }

        const prev_journal_page = document.querySelector('.prev_journal_page');
        if(prev_journal_page){
            prev_journal_page.addEventListener('click', function(){
                const this_btn = this;
                const total_pages = Number(this_btn.getAttribute('data_total_pages'));
                if(thisApp.crnt_page >= 2){
                    thisApp.crnt_page--;
                    document.querySelector('.next_journal_page').removeAttribute('disabled');
                }
                
                if(thisApp.crnt_page <= 1){
                    this_btn.setAttribute('disabled', true);
                }
                thisApp.FilterJournal();
            });
        }
    }

    createCustomSymbol = (e) => {
        e.preventDefault();
        const thisApp = this;
        const this_form = e.target;
        const this_data = new FormData(this_form);

        const form_values = Object.fromEntries(this_data.entries());
        console.log(form_values);

        document.querySelector('#add_trade_popup #symbol').value = form_values.symbol_name;
        document.querySelector('#add_trade_popup #symbol_key').value = 'custom-symbol';

        MainApp.popupManager.close('custom-symbol-pop');
        // this_form.classList.add('processing');
        // fetch('/custom_symbol', {
        //     method: "POST",
        //     body: this_data,
        //     headers: {
        //         'X-Requested-With': 'XMLHttpRequest',
        //         'X-CSRF-TOKEN': thisApp.token
        //     }
        // }).then((response) => response.json())
        //     .then((data) => {
        //         console.log(data);
        //         this_form.classList.remove('processing');
        //     }).catch((err) => {
        //         console.log(err);
        //     });
    }

    downloadTradeCsv = async () => {
        try {
            const response = await fetch(
                '/exporttrades',
                {
                    method: 'GET',
                    headers: {
                        'Accept': 'text/csv',
                    },
                }
            );

            if (!response.ok) {
                throw new Error('Failed to download CSV');
            }

            const blob = await response.blob();

            const url = window.URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.href = url;


            const date = new Date();
            const formatOptions = {
                year: 'numeric', month: '2-digit', day: '2-digit',
                hour: '2-digit', minute: '2-digit', second: '2-digit',
                hour12: false
            };

            const formatter = new Intl.DateTimeFormat('en-US', formatOptions);
            const [{ value: month }, , { value: day }, , { value: year }, , { value: hour }, , { value: minute }, , { value: second }] = formatter.formatToParts(date);

            const formattedDate = `${year}${month}${day}_${hour}${minute}${second}`;

            a.download = 'Trades_' + formattedDate + '.csv';
            document.body.appendChild(a);

            a.click();

            a.remove();
            window.URL.revokeObjectURL(url);

        } catch (error) {
            console.error(error);
        }
    };

    conditionalLogic() {
        document.querySelectorAll('[name="trd_type"]').forEach((trd_type, trdtp_indx) => {
            trd_type.addEventListener('change', function () {
                const this_itm = this;
                const this_wrapper = this_itm.closest('.form_fields');
                const this_checked_obj = document.querySelector('[name="trd_type"]');
                const this_checked = this_checked_obj ? this_checked_obj.value : false;
                const shr_inp = document.querySelector('.shares_amount_val input');
                const lot_inp = document.querySelector('.lot_amount_val input');
                if(shr_inp && lot_inp){
                    
                    if (this_checked == 'Cash') {
                        shr_inp.value = 1;
                        shr_inp.setAttribute('required', true)
                        shr_inp.closest('.fld_Wrapper').classList.remove('hidden');

                        lot_inp.value = null;
                        lot_inp.removeAttribute('required');
                        lot_inp.closest('.fld_Wrapper').classList.add('hidden');
                    } else {
                        shr_inp.value = null;
                        shr_inp.removeAttribute('required', true)
                        shr_inp.closest('.fld_Wrapper').classList.add('hidden');

                        lot_inp.value = 1;
                        lot_inp.setAttribute('required', true);
                        lot_inp.closest('.fld_Wrapper').classList.remove('hidden');
                    }
                }
            });
        })
    }

    handleSubmit(event) {
        const form = event.target;

        if (!form.matches('#add_trade_popup')) {
            return;
        }

        event.preventDefault();

        const formData = new FormData(form);

        form.classList.add('processing');
        fetch('/trade', {
            method: "POST",
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then((response) => response.json())
            .then((data) => {
                console.log(data);
                if(data.exception){
                    MainApp.Toast.dive('Something Wrong!', 'error');
                }else{
                    window.location.href = '/journal';//reload();
                }
            }).catch((err) => {
                console.log(err);
                form.classList.remove('processing');
            })
    }

    openSuggestions(event) {
        const inp = event.target;
        console.log(inp);
        inp.closest('.symbol_search_list_wrap').querySelector('.symbol_search_list').classList.remove('hidden');
    }

    closeSuggestions(event) {
        const inp = event.target;
        setTimeout(() => {
            inp.closest('.symbol_search_list_wrap').querySelector('.symbol_search_list').classList.add('hidden');
        }, 100);
    }

    searchSuggestions(event) {
        const inp = event.target;

        this.doSearch(inp.value);
    }

    doSearch(value) {
        const all_suggessions = document.querySelectorAll('.form_fields .form_field .field_drop_down li');
        if (all_suggessions && all_suggessions.length >= 1) {
            all_suggessions.forEach(itm => {
                const this_val = itm.getAttribute('data_value');
                if (value != "") {
                    if ((this_val.toLowerCase()).includes((value))) {
                        itm.style.display = 'block';
                    } else {
                        itm.style.display = 'none';
                    }
                } else {
                    itm.style.display = 'block';

                }
            })
        }
    }

    selectSuggestion(event) {
        const inp = event.target;
        // const srch_wrapp = inp.closest('.symbol_search_list_wrap');
        const this_form = inp.closest('form');
        const hash_raw = inp.getAttribute('data_json');

        const this_data = hash_raw ? JSON.parse(atob(inp.getAttribute('data_json'))) : [];
        // console.log(this_data);
        this_form.querySelector('#trd_symbol').value = `${this_data.trading_symbol} ${this_data.short_name ? `(${this_data.short_name})` : ''}`;
        this_form.querySelector('#trd_symbol_key').value = this_data.instrument_key;

        // console.log(this_data);

        const changeEvnt = new Event('change');
        const this_segment = this_data?.segment;
        if (this_segment && this_segment.includes('_FO')) {
            this_form.querySelector('[name="trd_type"]').value = 'F&O';
        } else {
            this_form.querySelector('[name="trd_type"]').value = 'Cash';
        }
        this_form.querySelector('[name="trd_type"]').dispatchEvent(changeEvnt);

        this_form.querySelector('[name="trd_qty_size"]').value = this_data.qty_multiplier <= 1 ? this_data.lot_size : 1;
        this_form.querySelector('[name="trd_qty_size"]').dispatchEvent(new Event('input'));

        this_form.querySelector('[name="trd_qty_multiplier"]').value = this_data.qty_multiplier;
        this_form.querySelector('[name="trd_qty_multiplier"]').dispatchEvent(new Event('input'));
        
    }

    countTrades() {
        document.querySelector('.main_trades_table').style.display = '';
        document.querySelector('.no_trades_wrapper').style.display = 'none';
        let has_trade = false;
        let total_trades = 0;
        let total_long_trades = 0;
        let total_short_trades = 0;
        document.querySelectorAll('table.trades_journal_table tbody tr').forEach((itm) => {
            if (itm.checkVisibility()) {
                total_trades++;
                has_trade = true;
                if (itm.classList.contains('long')) {
                    total_long_trades++;
                }
                if (itm.classList.contains('short')) {
                    total_short_trades++;
                }
            }
        });


        if (!has_trade) {
            document.querySelector('.main_trades_table').style.display = 'none';
            document.querySelector('.no_trades_wrapper').style.display = '';
        } else {
            document.querySelector('.main_trades_table').style.display = '';
            document.querySelector('.no_trades_wrapper').style.display = 'none';
        }

        document.querySelector('.trades_table_filter_btm .filter-tab[data_type="all"] .count').innerHTML = total_trades;
        document.querySelector('.trades_table_filter_btm .filter-tab[data_type="long"] .count').innerHTML = total_long_trades;
        document.querySelector('.trades_table_filter_btm .filter-tab[data_type="short"] .count').innerHTML = total_short_trades;
    }


    FilterJournal(){
        const thisApp = this;
        const tradeAction = document.querySelector('.trades_table_filter_btm .filter-tab.active').getAttribute('data_type');
        const trade_search = document.getElementById('trade_search').value;
        const trade_date_range = document.getElementById('trade_date_range').value;
        const trade_date_range_arr = trade_date_range.split('to');
        const trade_date_from = trade_date_range_arr[0];//document.getElementById('trade_date_from').value;
        const trade_date_to = trade_date_range_arr[1];//document.getElementById('trade_date_to').value;
        const trades_per_page = document.getElementById('trades_per_page').value;
        const page = thisApp.crnt_page;
        

        document.querySelector('.trades_journal_table').classList.add('processing');
        fetch('/filter-journal-items', {
            method: "POST",
            body: JSON.stringify({
                trd_action: tradeAction != 'all' ? tradeAction : '',
                trd_search: trade_search,
                trd_dateFrom: trade_date_from,
                trd_dateTo: trade_date_to,
                trd_perPage: trades_per_page,
                trd_page: page
            }),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-type': 'application/json',
                'X-CSRF-TOKEN': thisApp.token
            }
        }).then((response) => response.json())
            .then((data) => {                
                if(data.html == ''){
                    document.querySelector('.trades_journal_table').parentElement.style.display = 'none';
                    document.querySelector('.no_trades_wrapper').style.display = '';
                }else{
                    document.querySelector('.trades_journal_table').parentElement.style.display = '';
                    document.querySelector('.no_trades_wrapper').style.display = 'none';
                }

                document.querySelector('table.trades_journal_table tbody').innerHTML = data.html;
                document.querySelector('.pageination_status_wrap').innerHTML = `Page ${data.current_page} of ${data.total_pages}`;
                if(data.total_pages <= 1){
                    document.querySelector('.prev_journal_page').setAttribute('disabled', true);
                    document.querySelector('.next_journal_page').setAttribute('disabled', true);
                }else{
                    document.querySelector('.next_journal_page').removeAttribute('disabled', true);
                }
                if(data.current_page >= data.total_pages){
                    document.querySelector('.next_journal_page').setAttribute('disabled', true);
                }
                document.querySelector('.trades_journal_table').classList.remove('processing');
                document.dispatchEvent(new Event('journal-loaded'));
            }).catch((err) => {
                console.log(err);
            });        
    }


    FilterTradeTable(filterType, target) {
        this.trdTypeFilters.forEach((trdType) => {
            trdType.classList.remove('active');
        });

        target.classList.add('active');
        // console.log(filterType);
        switch (filterType) {
            case 'long':
                document.querySelectorAll('table.trades_journal_table tbody tr.long').forEach((itm) => {
                    itm.style.display = '';
                });
                document.querySelectorAll('table.trades_journal_table tbody tr.short').forEach((itm) => {
                    itm.style.display = 'none';
                });
                break;
            case 'short':
                document.querySelectorAll('table.trades_journal_table tbody tr.short').forEach((itm) => {
                    itm.style.display = '';
                });
                document.querySelectorAll('table.trades_journal_table tbody tr.long').forEach((itm) => {
                    itm.style.display = 'none';
                });
                break;

            default:
                document.querySelectorAll('table.trades_journal_table tbody tr').forEach((itm) => {
                    itm.style.display = '';
                });
                break;
        }

        const inputEvent = new Event('input');
        document.querySelector('#trade_search').dispatchEvent(inputEvent);
    }


    SearchTrades(event) {
        if (event) {
            const tabFilter = document.querySelector('.trades_table_filter_btm .filter-tab.active').getAttribute('data_type');
            const searchText = (event.target.value).toLowerCase();
            let has_trade = false;
            let total_trades = 0;
            let total_long_trades = 0;
            let total_short_trades = 0;
            document.querySelectorAll('table.trades_journal_table tbody tr').forEach((itm) => {
                const this_text = itm.querySelector('.trade_b_symbol').textContent;
                if ((this_text.toLowerCase()).includes(searchText)) {
                    itm.style.display = '';
                    total_trades++;
                    if (itm.classList.contains('long')) {
                        total_long_trades++;
                        if (tabFilter == 'long' || tabFilter == 'all') {
                            has_trade = true;
                            itm.style.display = '';
                        } else {
                            itm.style.display = 'none';
                        }
                    }
                    if (itm.classList.contains('short')) {
                        total_short_trades++;
                        if (tabFilter == 'short' || tabFilter == 'all') {
                            has_trade = true;
                            itm.style.display = '';
                        } else {
                            itm.style.display = 'none';
                        }
                    }
                } else {
                    itm.style.display = 'none';
                }
            });

            console.log(has_trade);

            if (!has_trade) {
                document.querySelector('.trades_journal_table').style.display = 'none';
                document.querySelector('.no_trades_wrapper').style.display = '';
            } else {
                document.querySelector('.trades_journal_table').style.display = '';
                document.querySelector('.no_trades_wrapper').style.display = 'none';
            }

            document.querySelector('.trades_table_filter_btm .filter-tab[data_type="all"] .count').innerHTML = total_trades;
            document.querySelector('.trades_table_filter_btm .filter-tab[data_type="long"] .count').innerHTML = total_long_trades;
            document.querySelector('.trades_table_filter_btm .filter-tab[data_type="short"] .count').innerHTML = total_short_trades;
        }
    }


    FilterByDate() {
        const fromDate = document.getElementById('trade_date_from').value;
        const toDate = document.getElementById('trade_date_to').value;


        if (fromDate != "" && toDate != "") {
            const all_trades = document.querySelectorAll('table.trades_journal_table tbody tr');
            // console.log(all_trades);
            if (all_trades && all_trades.length >= 1) {
                all_trades.forEach((itm, elm) => {
                    const this_date_elm = itm.querySelector('.trade_b_date');
                    if (this_date_elm) {
                        const this_date = new Date(this_date_elm.textContent);
                        const this_fdate = this_date.toISOString().split('T')[0];

                        console.log(this_fdate);
                        if (this_fdate >= fromDate && this_fdate <= toDate) {
                            itm.style.display = '';
                        } else {
                            itm.style.display = 'none';
                        }
                    }
                })
            }

            this.countTrades();
        }
    }

}