import App from "../core/App";

export default class UpstoxActions {

    loading = false;
    debounceSearch = null;
    page = 1;
    token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    constructor() {
        this.init();
    }

    init() {
        const ThisApp = this;
        const UpstxCntr = this;


        const searchInps = document.querySelectorAll('[name="trd_symbol"]');
        if (searchInps.length >= 1) {
            searchInps.forEach(searchInp => {
                const srchWrapper = searchInp.closest('.symbol_search_list_wrap');
                searchInp.addEventListener('input', function () {
                    clearTimeout(UpstxCntr.debounceSearch);

                    srchWrapper.querySelector('.symbol_search_list .loader_wrapper').classList.remove('hidden');
                    srchWrapper.querySelector('.symbol_search_list .dropdown-list').classList.add('hidden');
                    const srchVal = searchInp.value;
                    UpstxCntr.debounceSearch = setTimeout(() => {
                        clearTimeout(UpstxCntr.debounceSearch);
                        fetch(`/loadmorestocks/`, {
                            method: 'POST',
                            body: JSON.stringify({
                                // page: UpstxCntr.page++,
                                search: srchVal
                            }),
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': ThisApp.token
                            },
                        }).then((response) => response.json())
                            .then((data) => {
                                const segment_type = {
                                    'FO': 'Future',
                                    'EQ': 'Cash',
                                    'COM': 'Commodity',
                                    'INDEX': 'Index'
                                }
                                const instrument_type = {
                                    "B": "Other",
                                    "RR": "Other",
                                    "BS": "Other",
                                    "NV": "Other",
                                    "NY": "Other",
                                    "NS": "Other",
                                    "YU": "Other",
                                    "ZF": "Other",
                                    "N2": "Other",
                                    "BC": "Other",
                                    "YZ": "Other",
                                    "NW": "Other",
                                    "ZR": "Other",
                                    "Y1": "Other",
                                    "NF": "Other",
                                    "NI": "Other",
                                    "ZK": "Other",
                                    "BV": "Other",
                                    "BR": "Other",
                                    "NA": "Other",
                                    "W1": "Other",
                                    "YG": "Other",
                                    "YC": "Other",
                                    "YP": "Other",
                                    "BZ": "Other",
                                    "YT": "Other",
                                    "MT": "Other",
                                    "N6": "Other",
                                    "ZJ": "Other",
                                    "Y6": "Other",
                                    "Z6": "Other",
                                    "Z0": "Other",
                                    "P1": "Other",
                                    "YI": "Other",
                                    "YV": "Other",
                                    "N4": "Other",
                                    "SM": "Other",
                                    "NH": "Other",
                                    "ZT": "Other",
                                    "YM": "Other",
                                    "YQ": "Other",
                                    "Z5": "Other",
                                    "INDEX": "Index",
                                    "ZO": "Other",
                                    "CE": "Call Option",
                                    "SZ": "Other",
                                    "R": "Other",
                                    "NU": "Other",
                                    "Z3": "Other",
                                    "NR": "Other",
                                    "ST": "Other",
                                    "ZS": "Other",
                                    "E1": "Other",
                                    "ZQ": "Other",
                                    "D1": "Other",
                                    "X": "Other",
                                    "YS": "Other",
                                    "ZI": "Other",
                                    "NO": "Other",
                                    "BA": "Other",
                                    "T": "Other",
                                    "NK": "Other",
                                    "AL": "Other",
                                    "GS": "Other",
                                    "NN": "Other",
                                    "BE": "Other",
                                    "AN": "Other",
                                    "AZ": "Other",
                                    "Y7": "Other",
                                    "Z": "Other",
                                    "ZZ": "Other",
                                    "PE": "Put Option",
                                    "ND": "Other",
                                    "SG": "Other",
                                    "P": "Other",
                                    "N0": "Other",
                                    "NZ": "Other",
                                    "ZY": "Other",
                                    "IF": "Other",
                                    "YW": "Other",
                                    "YA": "Other",
                                    "NL": "Other",
                                    "EQ": "Cash",
                                    "YL": "Other",
                                    "NE": "Other",
                                    "BX": "Other",
                                    "ZM": "Other",
                                    "M": "Other",
                                    "N5": "Other",
                                    "Z9": "Other",
                                    "Y3": "Other",
                                    "Z4": "Other",
                                    "FUT": "Future",
                                    "Z8": "Other",
                                    "NP": "Other",
                                    "BW": "Other",
                                    "Y9": "Other",
                                    "N9": "Other",
                                    "NJ": "Other",
                                    "YB": "Other",
                                    "N7": "Other",
                                    "N1": "Other",
                                    "E": "Other",
                                    "ZP": "Other",
                                    "XT": "Other",
                                    "YJ": "Other",
                                    "Y8": "Other",
                                    "Z7": "Other",
                                    "ZH": "Other",
                                    "YH": "Other",
                                    "YX": "Other",
                                    "ZG": "Other",
                                    "NQ": "Other",
                                    "NB": "Other",
                                    "YD": "Other",
                                    "N3": "Other",
                                    "NM": "Other",
                                    "BU": "Other",
                                    "MS": "Other",
                                    "Z1": "Other",
                                    "ZN": "Other",
                                    "NC": "Other",
                                    "TB": "Other",
                                    "F": "Other",
                                    "YR": "Other",
                                    "YK": "Other",
                                    "N8": "Other",
                                    "AM": "Other",
                                    "ZL": "Other",
                                    "AK": "Other",
                                    "Y2": "Other",
                                    "NX": "Other",
                                    "NG": "Other",
                                    "GB": "Other",
                                    "IT": "Other",
                                    "G": "Other",
                                    "YY": "Other",
                                    "Y5": "Other",
                                    "TS": "Other",
                                    "Y0": "Other",
                                    "COM": "Commodity",
                                    "Z2": "Other",
                                    "IV": "Other",
                                    "A": "Other",
                                    "Y4": "Other",
                                    "NT": "Other"
                                }
                                // console.log(data.data);
                                srchWrapper.querySelector('.symbol_search_list .loader_wrapper').classList.add('hidden');
                                srchWrapper.querySelector('.symbol_search_list .dropdown-list').classList.remove('hidden');

                                srchWrapper.querySelector('.symbol_search_list .dropdown-list').innerHTML = '';

                                if ((data.data) !== null) {
                                    UpstxCntr.loading = false;
                                    (data.data).forEach(itemApd => {
                                        const new_opt = document.createElement('div');
                                        new_opt.setAttribute('data_value', itemApd.instrument_key);
                                        new_opt.setAttribute('data_name', itemApd.trading_symbol);
                                        new_opt.setAttribute('data_json', btoa(JSON.stringify(itemApd)));
                                        new_opt.classList.add('dropdown-list__item');
                                        if (itemApd.underlying_type) {
                                            new_opt.classList.add((itemApd.underlying_type).toLowerCase());
                                        }
                                        new_opt.innerHTML = `
                                        <span class="symbol" style="pointer-events:none;">
                                            ${itemApd.trading_symbol} ${itemApd.short_name ? `(${itemApd.short_name})` : ''}
                                            <div class="symbol_meta">
                                                <span class="exchange ${(itemApd.exchange)}">${itemApd.exchange}</span>
                                                <span class="segment">${(instrument_type[itemApd.instrument_type])}</span>
                                            </div>
                                        </span>
                                        <span class="name" style="pointer-events:none;">${itemApd.name}</span>
                                        `;
                                        srchWrapper.querySelector('.symbol_search_list .dropdown-list').appendChild(new_opt);
                                        new_opt.addEventListener('click', function (e) {
                                            // console.log(e.target);
                                            window.MainApp.tradeForm.selectSuggestion(e);
                                        });
                                    });
                                    srchWrapper.querySelector('.symbol_search_list .dropdown-list').scrollTop = 0
                                }
                            }).catch((err) => {
                                console.log(err);
                            })
                    }, 800);
                });
            })
        }



        // const stockWrapper = document.querySelector('.form_fields .form_field ul.field_drop_down');
        // stockWrapper.addEventListener('scroll', function () {
        //     const stockWrapper = document.querySelector('.form_fields .form_field ul.field_drop_down');
        //     const stkWarpSl = stockWrapper.scrollTop;
        //     const stkWarpCH = stockWrapper.clientHeight;
        //     const stkWarpSH = stockWrapper.scrollHeight - (stkWarpCH + 50);

        //     if (stkWarpSl >= stkWarpSH && UpstxCntr.loading == false) {
        //         UpstxCntr.loading = true;

        //         fetch(`/loadmorestocks/`, {
        //             method: 'POST',
        //             body: JSON.stringify({
        //                 page: UpstxCntr.page++
        //             }),
        //             headers: {
        //                 'X-Requested-With': 'XMLHttpRequest',
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': ThisApp.token
        //             },
        //         }).then((response) => response.json())
        //             .then((data) => {
        //                 // console.log(data);

        //                 if (data !== null) {
        //                     UpstxCntr.loading = false;
        //                     data.forEach(itemApd => {
        //                         // console.log(itemApd);
        //                         const new_opt = document.createElement('li');
        //                         new_opt.setAttribute('data_value', itemApd.instrument_key)
        //                         new_opt.setAttribute('data_name', itemApd.name)
        //                         new_opt.innerHTML = `
        //                         <span class="symbol">
        //                             ${itemApd.trading_symbol}
        //                             <span class="exchange ${(itemApd.exchange)}">${itemApd.exchange}</span>
        //                         </span>
        //                         <span class="name">${itemApd.name}</span>
        //                         `
        //                         new_opt.addEventListener('click', function (e) {
        //                             window.MainApp.tradeForm.selectSuggestion(e);
        //                         });
        //                         document.querySelector('.form_fields .form_field ul.field_drop_down').appendChild(new_opt);
        //                     });
        //                 }
        //             }).catch((err) => {
        //                 console.log(err);
        //             })
        //     }
        // });
    }
}