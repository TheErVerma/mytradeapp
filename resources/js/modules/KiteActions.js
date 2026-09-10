import App from "../core/App";

export default class KiteActions {

    loading = false;
    debounceSearch = null;
    page = 1;
    token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    constructor() {
        this.init();
    }

    init() {
        const ThisApp = this;

        const syncWithKite = document.querySelector('.syncWithKite');
        if (syncWithKite) {
            syncWithKite.addEventListener('click', function (e) {
                const this_btn = this;
                const selectTradeFut = this_btn.getAttribute('data_select_trades');
                const broker = document.querySelector('#sync_broker_trades_form [name="broker"]');
                broker.value = 'kite';
                console.log(selectTradeFut);
                this.classList.add('loading');

                fetch('/fetch-kite-portfolio', {
                    method: 'POST',
                    body: JSON.stringify({
                        selectTrades: selectTradeFut,
                    }),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': ThisApp.token
                    },
                }).then((response) => response.json())
                    .then((data) => {
                        console.log(data);
                        this.classList.remove('loading');
                        if(data.html && selectTradeFut == 'yes'){
                            document.querySelector('.select-entries-rows_wrap').innerHTML = data.html;
                            MainApp.popupManager.open('select-entries');
                        }
                    });
            });
        }
    }
}