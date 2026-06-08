export default class TradeForm {

    constructor() {
        this.trdTypeFilters = document.querySelectorAll('.trades_table_wrapper .trades_table_inner .trades_table_filter_btm ul li');
        this.init();
    }

    init() {
        document.addEventListener('submit', this.handleSubmit.bind(this));
        if (document.querySelectorAll('#symbol').length >= 1) {
            document.querySelector('#symbol').addEventListener('focus', this.openSuggestions.bind(this));
        }
        if (document.querySelectorAll('#symbol').length >= 1) {
            document.querySelector('#symbol').addEventListener('input', this.searchSuggestions.bind(this));
        }
        if (document.querySelectorAll('#symbol').length >= 1) {
            document.querySelector('#symbol').addEventListener('blur', this.closeSuggestions.bind(this));
        }
        if (document.querySelectorAll('#trade_search').length >= 1) {
            document.querySelector('#trade_search').addEventListener('input', this.SearchTrades.bind(this));
        }
        if (document.querySelectorAll('.export_all_trades').length >= 1) {
            document.querySelector('.export_all_trades').addEventListener('click', this.downloadTradeCsv.bind(this));
        }
        if (document.querySelectorAll('#trade_date_from, #trade_date_to').length >= 1) {
            document.querySelectorAll('#trade_date_from, #trade_date_to').forEach((dt_inp, dt_indx) => {
                dt_inp.addEventListener('change', this.FilterByDate.bind(this));
            });
        }
        document.querySelectorAll('.form_fields .form_field ul.field_drop_down li').forEach((drop_itm) => {
            drop_itm.addEventListener(
                'click',
                this.selectSuggestion.bind(this)
            );
        })

        this.trdTypeFilters.forEach((trdType) => {
            trdType.addEventListener('click', () => {
                this.FilterTradeTable(trdType.getAttribute('data_type'), trdType);
            });
        });

        this.conditionalLogic();
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
                const this_checked = this_wrapper.querySelector('[name="trd_type"]:checked').value;
                if (this_checked == 'Cash') {
                    this_wrapper.querySelector('[name="trd_shares"]').closest('.form_field').style.display = 'flex';
                    this_wrapper.querySelector('[name="trd_lot"]').closest('.form_field').style.display = 'none';
                } else if (this_checked == 'F&O') {
                    this_wrapper.querySelector('[name="trd_shares"]').closest('.form_field').style.display = 'none';
                    this_wrapper.querySelector('[name="trd_lot"]').closest('.form_field').style.display = 'flex';
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
                window.location.reload();
            }).catch((err) => {
                console.log(err);
                form.classList.remove('processing');
            })
    }


    openSuggestions(event) {
        const inp = this;
        document.querySelector('.form_fields .form_field ul.field_drop_down').classList.add('active');
    }

    closeSuggestions(event) {
        const inp = this;
        setTimeout(() => {
            document.querySelector('.form_fields .form_field ul.field_drop_down').classList.remove('active');
        }, 100);
    }

    searchSuggestions(event) {
        const inp = event.target;

        this.doSearch(inp.value);
    }

    doSearch(value) {
        const all_suggessions = document.querySelectorAll('.form_fields .form_field ul.field_drop_down li');
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
        document.getElementById('symbol').value = inp.getAttribute('data_value');
    }


    countTrades() {
        document.querySelector('.main_trades_table').style.display = '';
        document.querySelector('.no_trades_wrapper').style.display = 'none';
        let has_trade = false;
        let total_trades = 0;
        let total_long_trades = 0;
        let total_short_trades = 0;
        document.querySelectorAll('.trades_table_wrapper .trades_table_inner table tbody tr').forEach((itm) => {
            if (itm.checkVisibility()) {
                total_trades++;
                has_trade = true;
                if (itm.classList.contains('buy')) {
                    total_long_trades++;
                }
                if (itm.classList.contains('sell')) {
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

        document.querySelector('.trades_table_wrapper .trades_table_inner .trades_table_filter_btm ul li[data_type="all"] .count').innerHTML = total_trades;
        document.querySelector('.trades_table_wrapper .trades_table_inner .trades_table_filter_btm ul li[data_type="long"] .count').innerHTML = total_long_trades;
        document.querySelector('.trades_table_wrapper .trades_table_inner .trades_table_filter_btm ul li[data_type="short"] .count').innerHTML = total_short_trades;
    }


    FilterTradeTable(filterType, target) {
        this.trdTypeFilters.forEach((trdType) => {
            trdType.classList.remove('active');
        });

        target.classList.add('active');
        // console.log(filterType);
        switch (filterType) {
            case 'long':
                document.querySelectorAll('.trades_table_wrapper .trades_table_inner table tbody tr.buy').forEach((itm) => {
                    itm.style.display = '';
                });
                document.querySelectorAll('.trades_table_wrapper .trades_table_inner table tbody tr.sell').forEach((itm) => {
                    itm.style.display = 'none';
                });
                break;
            case 'short':
                document.querySelectorAll('.trades_table_wrapper .trades_table_inner table tbody tr.sell').forEach((itm) => {
                    itm.style.display = '';
                });
                document.querySelectorAll('.trades_table_wrapper .trades_table_inner table tbody tr.buy').forEach((itm) => {
                    itm.style.display = 'none';
                });
                break;

            default:
                document.querySelectorAll('.trades_table_wrapper .trades_table_inner table tbody tr').forEach((itm) => {
                    itm.style.display = '';
                });
                break;
        }

        const inputEvent = new Event('input');
        document.querySelector('#trade_search').dispatchEvent(inputEvent);
    }


    SearchTrades(event) {
        if (event) {
            const tabFilter = document.querySelector('.trades_table_wrapper .trades_table_inner .trades_table_filter_btm ul li.active').getAttribute('data_type');
            const searchText = (event.target.value).toLowerCase();
            let has_trade = false;
            let total_trades = 0;
            let total_long_trades = 0;
            let total_short_trades = 0;
            document.querySelectorAll('.trades_table_wrapper .trades_table_inner table tbody tr').forEach((itm) => {
                const this_text = itm.querySelector('.trade_b_symbol a').textContent;
                if ((this_text.toLowerCase()).includes(searchText)) {
                    itm.style.display = '';
                    total_trades++;
                    if (itm.classList.contains('buy')) {
                        total_long_trades++;
                        if (tabFilter == 'long' || tabFilter == 'all') {
                            has_trade = true;
                            itm.style.display = '';
                        } else {
                            itm.style.display = 'none';
                        }
                    }
                    if (itm.classList.contains('sell')) {
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
                document.querySelector('.main_trades_table').style.display = 'none';
                document.querySelector('.no_trades_wrapper').style.display = '';
            } else {
                document.querySelector('.main_trades_table').style.display = '';
                document.querySelector('.no_trades_wrapper').style.display = 'none';
            }

            document.querySelector('.trades_table_wrapper .trades_table_inner .trades_table_filter_btm ul li[data_type="all"] .count').innerHTML = total_trades;
            document.querySelector('.trades_table_wrapper .trades_table_inner .trades_table_filter_btm ul li[data_type="long"] .count').innerHTML = total_long_trades;
            document.querySelector('.trades_table_wrapper .trades_table_inner .trades_table_filter_btm ul li[data_type="short"] .count').innerHTML = total_short_trades;
        }
    }


    FilterByDate() {
        const fromDate = document.getElementById('trade_date_from').value;
        const toDate = document.getElementById('trade_date_to').value;

        if (fromDate != "" && toDate != "") {
            const all_trades = document.querySelectorAll('.trades_table_wrapper .trades_table_inner table tbody tr');
            // console.log(all_trades);
            if (all_trades && all_trades.length >= 1) {
                all_trades.forEach((itm, elm) => {
                    const this_date_elm = itm.querySelector('.trade_b_date');
                    if (this_date_elm) {
                        const this_date = this_date_elm.textContent;
                        // console.log(this_date);

                        if (this_date >= fromDate && this_date <= toDate) {
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