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
            if (pnl === 0) return TRADE_STATUS.BREAKEVEN;

            if (pnl < 0) {
                if (pnl >= LOSS_LEVELS.LOW) return TRADE_STATUS.LOW_LOSS;
                if (pnl >= LOSS_LEVELS.MEDIUM) return TRADE_STATUS.MEDIUM_LOSS;
                return TRADE_STATUS.HEAVY_LOSS;
            }

            if (pnl > 0) {
                if (pnl <= PROFIT_LEVELS.LOW) return TRADE_STATUS.LOW_PROFIT;
                if (pnl <= PROFIT_LEVELS.MEDIUM) return TRADE_STATUS.MEDIUM_PROFIT;
                return TRADE_STATUS.HEAVY_PROFIT;
            }
        }

        document.addEventListener('heat_map_load', function () {
            $heat.reset('trading-heatmap');
            const demoTrades_ = typeof pnl_js_data != 'undefined' ? pnl_js_data : [];
            // console.log(demoTrades_);
            demoTrades_.forEach(trade => {

                const status = getTradeStatus(trade.pnl);
                const count = STATUS_COUNT[status];

                for (let i = 0; i < count; i++) {
                    $heat.addDate(
                        "trading-heatmap",
                        new Date(trade.date),
                        "Trade",
                        false
                    );
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
        });

        document.dispatchEvent(new Event('heat_map_load'));

    }
}