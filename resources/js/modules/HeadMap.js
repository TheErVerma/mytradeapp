export default class HeadMap {
    constructor() {
        this.init();
    }

    init() {
        const TRADE_STATUS = {
            NO_TRADES: "no-trades",
            HEAVY_LOSS: "heavy-loss",
            MEDIUM_LOSS: "medium-loss",
            LOW_LOSS: "low-loss",
            BREAKEVEN: "breakeven",
            LOW_PROFIT: "low-profit",
            MEDIUM_PROFIT: "medium-profit",
            HEAVY_PROFIT: "heavy-profit"
        };

        const STATUS_COUNT = {
            [TRADE_STATUS.NO_TRADES]: 0,
            [TRADE_STATUS.HEAVY_LOSS]: 1,
            [TRADE_STATUS.MEDIUM_LOSS]: 2,
            [TRADE_STATUS.LOW_LOSS]: 3,
            [TRADE_STATUS.BREAKEVEN]: 4,
            [TRADE_STATUS.LOW_PROFIT]: 5,
            [TRADE_STATUS.MEDIUM_PROFIT]: 6,
            [TRADE_STATUS.HEAVY_PROFIT]: 7
        };

        const LOSS_LEVELS = {
            LOW: -100,
            MEDIUM: -500
        };

        const PROFIT_LEVELS = {
            LOW: 100,
            MEDIUM: 500
        };

        function getTradeStatus(pnl) {
            if (pnl === 0) return { pnl, sts: TRADE_STATUS.BREAKEVEN };

            if (pnl < 0) {
                if (pnl >= LOSS_LEVELS.LOW) return { pnl, sts: TRADE_STATUS.LOW_LOSS };
                if (pnl >= LOSS_LEVELS.MEDIUM) return { pnl, sts: TRADE_STATUS.MEDIUM_LOSS };
                return { pnl, sts: TRADE_STATUS.HEAVY_LOSS };
            }

            if (pnl > 0) {
                if (pnl <= PROFIT_LEVELS.LOW) return { pnl, sts: TRADE_STATUS.LOW_PROFIT };
                if (pnl <= PROFIT_LEVELS.MEDIUM) return { pnl, sts: TRADE_STATUS.MEDIUM_PROFIT };
                return { pnl, sts: TRADE_STATUS.HEAVY_PROFIT };
            }
        }

        function parseDate(date) {
            // console.log(date);
            const [year, month, day] = date.split('-');

            return `${day}-${month}-${year}`;
        }

        document.addEventListener('heat_map_load', function () {
            $heat.reset('trading-heatmap');
            const demoTrades_ = typeof pnl_js_data != 'undefined' ? pnl_js_data : [];
            demoTrades_.forEach(trade => {

                const status = getTradeStatus(trade.pnl).sts;
                const pnl = getTradeStatus(trade.pnl).pnl;
                // console.log(status, pnl);
                const count = STATUS_COUNT[status];

                for (let i = 0; i < count; i++) {

                    $heat.addDate(
                        "trading-heatmap",
                        new Date(trade.date),
                        "Trade",
                        false
                    );


                    setTimeout(() => {
                        const day = document.querySelector(`#trading-heatmap [data-heat-js-map-date="${parseDate(trade.date)}"]`);

                        if (day) {
                            const this_day_pnl = new Intl.NumberFormat('en-IN', {
                                style: 'currency',
                                currency: document.querySelector('html').getAttribute('data_cur'),
                                maximumFractionDigits: 2
                            }).format(pnl);

                            day.classList.add('hastooltip');
                            day.innerHTML = `
                            <div class="tooltip-popup">
                                <div class="z-50 flex max-w-xs flex-col items-start gap-1 rounded-lg bg-primary-solid px-3 shadow-xs will-change-transform py-2">
                                    <span class="text-xs font-semibold text-white">PNL: ${this_day_pnl}</span>
                                </div>
                            </div>`;
                        }
                    }, 10);

                }

            });
            $heat.refresh("trading-heatmap");
            document.querySelectorAll('div#trading-heatmap .map .month .day').forEach(dy => dy.addEventListener('click', function (e) {
                const this_day = e.target;
                const this_classes = Array.from(this_day.classList);
                const req_classes = Object.values(TRADE_STATUS);
                const hasCommon = req_classes.some(element => (this_classes).includes(element));
                if (hasCommon) {
                    const this_date = this.getAttribute('data-heat-js-map-date');
                    const date_hash = btoa(this_date);
                    window.location.href = `/journal/${date_hash}`;
                }
            }));

            setTimeout(() => {
                document.querySelectorAll('div#trading-heatmap .map .month .day').forEach(function (dy) {
                    const this_elm = dy;
                    const classList = this_elm.classList;
                    if (classList.contains('hastooltip')) {
                        const mn_wrap = document.getElementById('trading-heatmap');
                        const mn_rct = mn_wrap.getBoundingClientRect();
                        const mn_wrap_t = mn_wrap.offsetTop;
                        const mn_wrap_l = mn_rct.left;
                        const mn_wrap_r = mn_rct.right;

                        const mn_wrap_h = mn_wrap.offsetHeight;
                        const mn_wrap_w = mn_wrap.offsetWidth;



                        const this_tooltip = this_elm.querySelector('.tooltip-popup');
                        const ttp_rct = this_tooltip.getBoundingClientRect();
                        const ttp_t = (ttp_rct.top + window.scrollY) - 36;
                        const ttp_l = (ttp_rct.left + window.scrollX) + 0;
                        const ttp_r = ttp_l + this_tooltip.clientWidth;

                        const has_y_cut = mn_wrap_t > ttp_t;
                        if (has_y_cut) {
                            this_tooltip.style.top = 'unset';
                            this_tooltip.style.bottom = -36 + 'px';
                        }

                        const has_x_cut = mn_wrap_l > ttp_l;
                        if (has_x_cut) {
                            this_tooltip.style.left = ttp_l - (mn_wrap_l) + 6 + 'px';
                        }
                        const has_xr_cut = mn_wrap_r < ttp_r;
                        if (has_xr_cut) {
                            this_tooltip.style.left = (ttp_l - mn_wrap_r) - 24 + 'px';
                        }
                    }
                });
            }, 10);
        });

        document.dispatchEvent(new Event('heat_map_load'));

    }
}