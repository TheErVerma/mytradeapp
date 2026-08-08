import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";


export default class EventManager {

    constructor() {
        this.init();
    }

    init() {
        const rep = flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            allowInput: true
        });

        const priceInputs = document.querySelectorAll('input.price');
        if (priceInputs.length >= 1) {
            priceInputs.forEach((priceInput) => {
                priceInput.addEventListener('input', function (e) {
                    let value = e.target.value.replace(/[^\d.]/g, '');
                    const parts = value.split('.');
                    if (parts.length > 2) {
                        value = parts[0] + '.' + parts.slice(1).join('');
                    }
                    let [integerPart, decimalPart] = value.split('.');
                    if (integerPart) {
                        integerPart = Number(integerPart).toLocaleString('en-IN');
                    }
                    if (decimalPart !== undefined) {
                        decimalPart = decimalPart.substring(0, 2);
                        value = `${integerPart}.${decimalPart}`;
                    } else {
                        value = integerPart;
                    }
                    e.target.value = value;
                });

            });
        }

        function rgbToHex(rgb) {
            const values = rgb.match(/\d+/g).map(Number);

            return '#' + values
                .slice(0, 3)
                .map(value => value.toString(16).padStart(2, '0'))
                .join('');
        }

        async function downloadDivAsImage(selector, filename = 'screenshot.png') {
            const element = document.querySelector(selector);

            const dataUrl = await modernScreenshot.domToPng(element, {
                scale: 2,
                backgroundColor: rgbToHex(window.getComputedStyle(document.body).backgroundColor)
            });

            const link = document.createElement('a');
            link.download = filename;
            link.href = dataUrl;
            link.click();
        }


        const screenshot_btn = document.querySelector('#share_trade_screenshot');
        if (screenshot_btn) {
            screenshot_btn.addEventListener('click', function () {

                if (document.querySelector('.main_trades_table').checkVisibility()) {
                    document.querySelector('.main_trades_table').classList.add('capturing');


                    downloadDivAsImage('.main_trades_table', 'trade-insights.png');


                    document.querySelector('.main_trades_table').classList.add('snap_takken');
                    if (MainApp) {
                        MainApp.Audio.play('/storage/audio/click.mp3');
                    }
                    setTimeout(() => {
                        document.querySelector('.main_trades_table').classList.remove('capturing');
                        document.querySelector('.main_trades_table').classList.remove('snap_takken');
                    }, 350);
                } else {
                    if(MainApp){
                        MainApp.Toast.dive('Nothing to capture', 'warning');
                    }
                }
            });
        }




        const summary_filter = document.querySelector('#summary-card-filter');
        if(summary_filter){
            summary_filter.addEventListener('change', function(){
                const this_opt = this.value;
                console.log(this_opt);

                fetch(`/pnl/${this_opt}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.token
                    },
                }).then((response) => response.json())
                    .then((data) => {
                        console.log(data);
                        if(data.trades){
                            document.querySelector('.summary_total_npl').innerHTML = data.trades;
                        }
                    }).catch((err) => {
                        console.log(err);
                    })
            });
        }
    }
}