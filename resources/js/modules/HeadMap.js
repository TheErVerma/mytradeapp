export default class HeadMap {
    constructor() {
        this.init();
    }

    init() {
        /* =========================================================
            TRADE TYPES
        ========================================================= */

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


        /* =========================================================
           P&L THRESHOLDS
        ========================================================= */

        const LOSS_LEVELS = {
            LOW: -100,
            MEDIUM: -500
        };

        const PROFIT_LEVELS = {
            LOW: 100,
            MEDIUM: 500
        };


        /* =========================================================
           GET TRADE STATUS
        ========================================================= */

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


        /* =========================================================
           DEMO DATA
        ========================================================= */

        const demoTrades = [
            // Randomly generated extra data points
            ...Array.from({ length: 100 }, () => {
                const month = Math.floor(Math.random() * 12) + 1;
                const day = Math.floor(Math.random() * 28) + 1;
                const pnl = Math.floor(Math.random() * 2000) - 1000;
                return {
                    date: `2026-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`,
                    pnl
                };
            }),
            /*
             * =========================
             * JANUARY
             * =========================
             */
            { date: "2026-01-02", pnl: 50 },
            { date: "2026-01-03", pnl: 300 },
            { date: "2026-01-04", pnl: 1000 },
            { date: "2026-01-05", pnl: -50 },
            { date: "2026-01-06", pnl: -300 },
            { date: "2026-01-07", pnl: -1000 },
            { date: "2026-01-08", pnl: 0 },

            /*
             * =========================
             * FEBRUARY
             * =========================
             */
            { date: "2026-02-02", pnl: 25 },
            { date: "2026-02-03", pnl: 450 },
            { date: "2026-02-04", pnl: 800 },
            { date: "2026-02-05", pnl: -75 },
            { date: "2026-02-06", pnl: -250 },
            { date: "2026-02-07", pnl: -700 },

            /*
             * =========================
             * MARCH
             * =========================
             */
            { date: "2026-03-02", pnl: 80 },
            { date: "2026-03-03", pnl: 250 },
            { date: "2026-03-04", pnl: 1500 },
            { date: "2026-03-05", pnl: -25 },
            { date: "2026-03-06", pnl: -400 },
            { date: "2026-03-07", pnl: -900 },

            /*
             * =========================
             * APRIL
             * =========================
             */
            { date: "2026-04-01", pnl: 200 },
            { date: "2026-04-02", pnl: 100 },
            { date: "2026-04-03", pnl: 500 },
            { date: "2026-04-04", pnl: -100 },
            { date: "2026-04-05", pnl: -500 },
            { date: "2026-04-06", pnl: -1200 },

            /*
             * =========================
             * MAY
             * =========================
             */
            { date: "2026-05-01", pnl: 40 },
            { date: "2026-05-02", pnl: 350 },
            { date: "2026-05-03", pnl: 900 },
            { date: "2026-05-04", pnl: -60 },

            /*
             * =========================
             * JUNE
             * =========================
             */
            { date: "2026-06-01", pnl: 70 },
            { date: "2026-06-02", pnl: 400 },
            { date: "2026-06-03", pnl: 1200 },
            { date: "2026-06-04", pnl: -80 },
            { date: "2026-06-05", pnl: -350 },

            /*
             * =========================
             * JULY
             * =========================
             */
            { date: "2026-07-01", pnl: 0 },
            { date: "2026-07-02", pnl: 30 },
            { date: "2026-07-03", pnl: 200 },
            { date: "2026-07-04", pnl: 700 },
            { date: "2026-07-05", pnl: -40 },
            { date: "2026-07-06", pnl: -300 },

            /*
             * =========================
             * AUGUST
             * =========================
             */
            { date: "2026-08-01", pnl: 90 },
            { date: "2026-08-02", pnl: 450 },
            { date: "2026-08-03", pnl: 900 },
            { date: "2026-08-04", pnl: -90 },
            { date: "2026-08-05", pnl: -450 },
            { date: "2026-08-06", pnl: -800 },

            /*
             * =========================
             * SEPTEMBER
             * =========================
             */
            { date: "2026-09-01", pnl: 0 },
            { date: "2026-09-02", pnl: 60 },
            { date: "2026-09-03", pnl: 300 },
            { date: "2026-09-04", pnl: 800 },

            /*
             * =========================
             * OCTOBER
             * =========================
             */
            { date: "2026-10-01", pnl: -30 },
            { date: "2026-10-02", pnl: -250 },
            { date: "2026-10-03", pnl: -1000 },
            { date: "2026-10-04", pnl: 100 },

            /*
             * =========================
             * NOVEMBER
             * =========================
             */
            { date: "2026-11-01", pnl: 20 },
            { date: "2026-11-02", pnl: 300 },
            { date: "2026-11-03", pnl: 1000 },
            { date: "2026-11-04", pnl: -200 },

            /*
             * =========================
             * DECEMBER
             * =========================
             */
            { date: "2026-12-01", pnl: 0 },
            { date: "2026-12-02", pnl: 75 },
            { date: "2026-12-03", pnl: 400 },
            { date: "2026-12-04", pnl: 1500 },
            { date: "2026-12-05", pnl: -100 },
            { date: "2026-12-06", pnl: -600 }
        ];


        /* =========================================================
           ADD DEMO DATA TO HEAT.JS
        ========================================================= */

        const demoTrades_ = typeof pnl_js_data != 'undefined' ? pnl_js_data : [];
        demoTrades_.forEach(trade => {

            const status = getTradeStatus(trade.pnl);
            const count = STATUS_COUNT[status];

            // console.log(
            //     trade.date,
            //     trade.pnl,
            //     status
            // );

            // Add the date multiple times so Heat.js maps it to the correct color range minimum
            for (let i = 0; i < count; i++) {
                $heat.addDate(
                    "trading-heatmap",
                    new Date(trade.date),
                    "Trade",
                    false
                );
            }

        });

        /*
         * Refresh after all demo entries are added.
         */
        $heat.refresh("trading-heatmap");
    }
}