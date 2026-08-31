
import ConfirmPop from "../modules/ConfirmPop";
import PopupManager from "../modules/PopupManager";
import Chart from 'chart.js/auto';
import { getRelativePosition } from 'chart.js/helpers';


export default class HelpManager {

    token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    constructor() {
        this.init();
    }

    init() {
        const thisApp = this;


        document.addEventListener('start_analytics_monthly_performace', function () {
            const ctx_cnv = document.querySelector('#main_analytics_chart');
            if (ctx_cnv) {
                const data_obj = JSON.parse(atob(ctx_cnv.getAttribute('data_ch_hash')));

                const ctx = ctx_cnv.getContext('2d');

                const chart = new Chart(ctx, {

                    type: 'bar',

                    data: {

                        labels: data_obj.monthlyPnlLabels,

                        datasets: [{
                            label: 'P&L',

                            data: data_obj.monthlyPnlData,

                            backgroundColor: function (context) {

                                const value = context.raw;

                                if (value > 0) {
                                    return '#22c55e';
                                }

                                if (value < 0) {
                                    return '#ef2929';
                                }

                                return 'transparent';
                            },

                            borderRadius: 7,

                            borderSkipped: false,

                            barPercentage: 0.55,

                            categoryPercentage: 0.8
                        }]
                    },

                    options: {

                        responsive: true,

                        // Important for controlling canvas height
                        maintainAspectRatio: false,

                        plugins: {

                            legend: {
                                display: false
                            },

                            tooltip: {

                                displayColors: false,

                                callbacks: {

                                    title: function (tooltipItems) {
                                        return tooltipItems[0].label;
                                    },

                                    label: function (tooltipItem) {

                                        const value = tooltipItem.raw;

                                        return 'P&L : ' + new Intl.NumberFormat('en-IN', {
                                            style: 'currency',
                                            currency: document.querySelector('html').getAttribute('data_cur'),
                                            maximumFractionDigits: 2
                                        }).format(value);
                                    }
                                }
                            }
                        },

                        scales: {

                            x: {

                                grid: {
                                    display: false
                                },

                                ticks: {
                                    color: '#777',
                                    font: {
                                        size: 14
                                    }
                                }
                            },

                            y: {

                                // min: -210000,
                                // max: 210000,

                                // EXACTLY 5 tick positions
                                // afterBuildTicks: function (scale) {

                                //     scale.ticks = [
                                //         { value: -210000 },
                                //         { value: -110000 },
                                //         { value: 0 },
                                //         { value: 110000 },
                                //         { value: 210000 }
                                //     ];
                                // },

                                grid: {

                                    color: function (context) {

                                        if (context.tick.value === 0) {
                                            return '#d5d5d5';
                                        }

                                        return '#e5e7eb';
                                    },

                                    lineWidth: function (context) {

                                        if (context.tick.value === 0) {
                                            return 1.5;
                                        }

                                        return 1;
                                    },

                                    borderDash: [4, 4]
                                },

                                ticks: {

                                    color: '#777',

                                    callback: function (value) {
                                        return thisApp.formatShortNumber(value);
                                    }
                                }
                            }
                        }
                    }
                });

                document.addEventListener('update_analytics_monthly_performace', function(){
                    const latest_data_obj = JSON.parse(atob(ctx_cnv.getAttribute('data_ch_hash')));
                    chart.data.labels = latest_data_obj.monthlyPnlLabels;
                    chart.data.datasets[0].data = latest_data_obj.monthlyPnlData;
                    chart.update();
                });
            }
        });

        document.dispatchEvent(new Event('start_analytics_monthly_performace'));

        document.addEventListener(
            'click',
            this.handleClick.bind(this)
        );

        document.addEventListener(
            'click',
            this.removeAllTradeData.bind(this)
        );

        const savedDark = document.querySelector('html').classList.contains('dark-mode') ? 'dark' : 'dark';
        const themeQuery = window.matchMedia("(prefers-color-scheme: " + savedDark + ")");
        const isDarkMode = themeQuery.matches;
        // if (document.querySelector('html').classList.contains('dark-mode') == false) {
        //     this.toggleTheme(isDarkMode);
        // }
        // themeQuery.addEventListener("change", (event) => {
        //     this.toggleTheme(event.matches, true);
        // });


        document.querySelectorAll('.qtynumamnt').forEach(input => {

            // Allow only positive numbers
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
                this.value = this.value.replace(/^0+(?=\d)/, '');
            });

            // Increase / decrease with arrow keys
            input.addEventListener('keydown', function (e) {
                if (e.key !== 'ArrowUp' && e.key !== 'ArrowDown') {
                    return;
                }

                e.preventDefault();

                let value = parseInt(this.value || 0, 10);

                if (e.key === 'ArrowUp') {
                    value++;
                } else if (e.key === 'ArrowDown') {
                    value = Math.max(1, value - 1);
                }

                this.value = value;

                // Trigger input/change events if needed
                this.dispatchEvent(new Event('input', { bubbles: true }));
            });
        });
    }

    formatShortNumber(num) {
        const formatterUSD = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: document.querySelector('html').getAttribute('data_cur')
        });
        num = Number(num);

        const chknm = Math.abs(num);
        if (isNaN(num)) {
            return '0';
        }

        if (chknm >= 10000000) {
            return formatterUSD.format((num / 10000000).toFixed(1).replace('.0', '')) + 'Cr';
        }

        if (chknm >= 100000) {
            return formatterUSD.format((num / 100000).toFixed(1).replace('.0', '')) + 'L';
        }

        if (chknm >= 1000) {
            return formatterUSD.format((num / 1000).toFixed(1).replace('.0', '')) + 'K';
        }

        if (chknm <= 999 && chknm >= 0) {
            return formatterUSD.format(num);
        }

        return num.toString();
    }
    handleClick(e) {
        const target = e.target;
        this.themeToggler(target);
    }

    themeToggler(target) {
        if (!target.classList.contains('theme_toggler')) {
            return;
        }
        const theme = !(document.querySelector('html').classList).contains('dark-mode');
        this.toggleTheme(theme, true);
    }

    toggleTheme(theme, force = false) {
        const ThisApp = this;
        const user_id = document.querySelector('html[data_user_id]').getAttribute('data_user_id');
        if (user_id) {
            if (force) {
                document.documentElement.classList.remove('dark-mode');
                theme ? document.querySelector('html').classList.add('dark-mode') : false;
            }

            fetch(`/user/${user_id}/save-theme`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': ThisApp.token
                },
                body: JSON.stringify({ theme })
            }).then((response) => response.json())
                .then((data) => {
                    // console.log(data);
                }).catch((err) => {
                    console.log(err);
                })
        }

    }

    removeAllTradeData(e) {
        const target = e.target;
        if (!target.classList.contains('remove_all_trade_data')) {
            return;
        }

        const c = new ConfirmPop();

        c.confirm('Are you sure? This will not be revert back.', () => {

            target.classList.add('processing');

            fetch('/reset-all-data', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    target.classList.remove('processing');
                }).catch((err) => {
                    console.log(err);
                    target.classList.remove('processing');
                })
        });
    }

}