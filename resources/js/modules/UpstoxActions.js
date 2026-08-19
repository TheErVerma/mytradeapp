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


        const searchInp = document.querySelector('[name="trd_symbol"]');
        if (searchInp) {
            searchInp.addEventListener('input', function () {
                clearTimeout(UpstxCntr.debounceSearch);

                searchInp.closest('.icon_field_inner').classList.add('processing');
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
                                'EQ':'Cash',
                                'COM': 'Commodity',
                                'INDEX': 'Index'
                            }
                            // console.log(data.data);
                            searchInp.closest('.icon_field_inner').classList.remove('processing');
                            document.querySelector('.form_fields .form_field ul.field_drop_down').innerHTML = '';

                            if ((data.data) !== null) {
                                UpstxCntr.loading = false;
                                (data.data).forEach(itemApd => {
                                    const new_opt = document.createElement('li');
                                    new_opt.setAttribute('data_value', itemApd.instrument_key);
                                    new_opt.setAttribute('data_name', itemApd.trading_symbol);
                                    new_opt.setAttribute('data_json', btoa(JSON.stringify(itemApd)));
                                    if(itemApd.underlying_type){
                                        new_opt.classList.add((itemApd.underlying_type).toLowerCase());
                                    }
                                    new_opt.innerHTML = `
                                    <span class="symbol">
                                        ${itemApd.trading_symbol} ${itemApd.short_name ? `(${itemApd.short_name})` : ''}
                                        <div class="symbol_meta">
                                            <span class="exchange ${(itemApd.exchange)}">${itemApd.exchange}</span>
                                            <span class="segment">${(segment_type[(itemApd.segment).split('_')[1]])}</span>
                                        </div>
                                    </span>
                                    <span class="name">${itemApd.name}</span>
                                    `;
                                    document.querySelector('.form_fields .form_field ul.field_drop_down').appendChild(new_opt);
                                    new_opt.addEventListener('click', function (e) {
                                        // console.log(e.target);
                                        window.MainApp.tradeForm.selectSuggestion(e);
                                    });
                                });
                            }
                        }).catch((err) => {
                            console.log(err);
                        })
                }, 800);
            });
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