import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";
import QRCode from 'qrcode';


export default class EventManager {

    token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    constructor() {
        this.init();
    }
    
    init() {
        const ThisApp = this;

        const sidebar_toggler = document.querySelector('.sidebar_toggler');
        if (sidebar_toggler) {
            sidebar_toggler.addEventListener('click', function () {
                const sidebar = document.querySelector('aside.main_sidebar');
                if (sidebar) {
                    if (sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                    } else {
                        sidebar.classList.add('active');
                    }
                }
            });
        }
        const rep = flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            allowInput: true
        });

        const passwordVisibility = document.querySelector('.toggle-password-visibility');
        if(passwordVisibility){
            passwordVisibility.addEventListener('click', function(){
                const parent = this.parentElement;
                const thisInp = parent.querySelector('input');
                
                if(this.classList.contains('active')){
                    this.classList.remove('active')
                    thisInp.setAttribute('type', 'text');
                }else{
                    this.classList.add('active')
                    thisInp.setAttribute('type', 'password');
                }
            })
        }

        const sideauthpop = document.querySelector('.author-open__popup');
        if(sideauthpop){
            sideauthpop.addEventListener('click', function(){
                const sidepop = document.querySelector('.author-popup');
                if(sidepop){
                    if(sidepop.classList.contains('active')){
                        sidepop.classList.remove('active');
                    }else{
                        sidepop.classList.add('active');
                    }
                }
            })
        }

        const cs_trd_type_elm = document.querySelector('#cs_trd_type');
        if(cs_trd_type_elm){
            cs_trd_type_elm.addEventListener('change', function(){
                if(this.checked){
                    console.log('Checked');
                    document.querySelector('#add_trade_popup #trd_type').checked = true;
                }else{
                    console.log('Not Checked');
                    document.querySelector('#add_trade_popup #trd_type').checked = false;
                }
                const chngEvnt = new Event('change');
                document.querySelector('#add_trade_popup #trd_type').dispatchEvent(chngEvnt);
            });
        }


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
                backgroundColor: 'white'//rgbToHex(window.getComputedStyle(document.body).backgroundColor)
            });

            const link = document.createElement('a');
            link.download = filename;
            link.href = dataUrl;
            link.click();
        }


        const screenshot_btn = document.querySelector('#share_trade_screenshot');
        if (screenshot_btn) {
            screenshot_btn.addEventListener('click', function () {

                if (document.querySelector('.trades_journal_table').checkVisibility()) {
                    document.querySelector('.trades_journal_table').classList.add('capturing');


                    downloadDivAsImage('.trades_journal_table', 'trade-insights.png');


                    document.querySelector('.trades_journal_table').classList.add('snap_takken');
                    if (MainApp) {
                        MainApp.Audio.play('/storage/audio/click.mp3');
                    }
                    setTimeout(() => {
                        document.querySelector('.trades_journal_table').classList.remove('capturing');
                        document.querySelector('.trades_journal_table').classList.remove('snap_takken');
                    }, 350);
                } else {
                    if (MainApp) {
                        MainApp.Toast.dive('Nothing to capture', 'warning');
                    }
                }
            });
        }


        const toggle_mobile_sidebar = document.querySelector('.toggle_mobile_sidebar');
        if(toggle_mobile_sidebar){
            toggle_mobile_sidebar.addEventListener('click', function(){
                document.querySelector('.mobile-sibebar').classList.add('active');
            });
        }

        const toggle_sidebar_close = document.querySelector('.toggle_sidebar_close');
        if(toggle_sidebar_close){
            toggle_sidebar_close.addEventListener('click', function(){
                document.querySelector('.mobile-sibebar').classList.remove('active');
            });
        }



        const summary_filter = document.querySelector('#summary-card-filter');
        if (summary_filter) {
            summary_filter.addEventListener('change', function () {
                const this_opt = this.value;
                // console.log(this_opt);

                fetch(`/pnl/${this_opt}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': ThisApp.token
                    },
                }).then((response) => response.json())
                    .then((data) => {
                        // console.log(data);
                        if (data.trades) {
                            const is_p_l = data.trade_num < 0 ? 'loss' : 'profit';
                            document.querySelector('.summary_total_npl').classList.remove('profit');
                            document.querySelector('.summary_total_npl').classList.remove('loss');
                            document.querySelector('.summary_total_npl').innerHTML = data.trades;
                            document.querySelector('.summary_total_npl').classList.add(is_p_l);
                            document.querySelector('.summary_total_entries').innerHTML = data.total_entries;
                        }
                    }).catch((err) => {
                        console.log(err);
                    })
            });
            const summary_filter_evnt = new Event('change');
            summary_filter.dispatchEvent(summary_filter_evnt);
        };


        async function copyText(text) {
            try {
                await navigator.clipboard.writeText(text);
                // console.log('Text copied to clipboard successfully!');
            } catch (err) {
                console.error('Failed to copy text: ', err);
            }
        }


        const copyLiveLinkBtn = document.querySelector('#share_live_trade_popup .copy_link_btn');
        if (copyLiveLinkBtn) {
            copyLiveLinkBtn.addEventListener('click', function () {
                const this_btn = this;
                const target_text = document.querySelector('#share_live_trade_popup #live_share_link');
                console.log(target_text.value);
                if (target_text && target_text.value) {
                    MainApp.Toast.dive('Copied', 'success');
                    copyText(target_text.value);
                }else{
                    MainApp.Toast.dive('Generate Link First', 'error');
                }
            });
        }

        const generateQrInZone = () => {
            const live_link_inp = document.getElementById('live_share_link');
            if (live_link_inp) {
                const sharedLink = document.getElementById('live_share_link').value;
                sharedLink != "" ? document.querySelector('.live_link_qr_zone_wrap').style.display = '' : '';
                document.getElementById('live_share_link').closest('.form_field').classList.remove('disabled');

                const qrCodeLandingZone = document.getElementById('live_link_qr_zone');
                if (qrCodeLandingZone && sharedLink != "") {
                    QRCode.toString(sharedLink, {
                        type: 'svg',
                        width: 300,
                        margin: 2,
                        errorCorrectionLevel: 'H'
                    }, function (error, svg) {
                        if (error) {
                            console.error(error);
                            return;
                        }

                        qrCodeLandingZone.innerHTML = svg;
                    });
                }
            }
        }

        generateQrInZone();

        const liveShareLinkForm = document.getElementById('share_live_trade_popup');
        if (liveShareLinkForm) {
            liveShareLinkForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const this_form = this;
                const this_data = new FormData(this_form);
                console.log(this_data);
                fetch('/generate-livesharelink', {
                    method: 'POST',
                    body: this_data,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then((response) => response.json())
                    .then((data) => {
                        console.log(data);
                        if (data.live_link) {
                            document.getElementById('live_share_link').value = data.live_link;
                            generateQrInZone();
                        }
                    }).catch((err) => {
                        console.log(err);
                    });
            })
        }


        const liveShareCountdown = document.getElementById('liveShareCountdown');
        if (liveShareCountdown) {
            const timestamp = Number(liveShareCountdown.getAttribute('data_countto'));

            const targetDate = timestamp * 1000;

            function updateCountdown() {
                const remaining = targetDate - Date.now();

                if (remaining <= 0) {
                    liveShareCountdown.textContent = 'Expired';
                    clearInterval(countdownInterval);
                    return;
                }

                const totalSeconds = Math.floor(remaining / 1000);

                const days = Math.floor(totalSeconds / 86400);
                const hours = Math.floor((totalSeconds % 86400) / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;

                liveShareCountdown.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            }

            updateCountdown();
            const countdownInterval = setInterval(updateCountdown, 1000);
        }


        const OtpDigInp = document.querySelectorAll('#otp_dg1,#otp_dg2,#otp_dg3,#otp_dg4');
        if(OtpDigInp){

            OtpDigInp.forEach(function(dgInp, indx){
                dgInp.addEventListener('keyup', function(e){
                    dgInp.blur();
                    const key = e.key;
                    if(key == 'Backspace'){
                        const prevInp = OtpDigInp[indx-1];
                        if(prevInp){
                            prevInp.focus();
                        }
                    }else{
                        const nextInp = OtpDigInp[indx+1];
                        if(nextInp){
                            nextInp.focus();
                        }
                    }
                    let finalOtp = [];
                    OtpDigInp.forEach(function(dgInpV, indxS){
                        finalOtp.push(dgInpV.value);
                    });
                    
                    document.querySelector('#otp').value = finalOtp.join('');
                });
            })
        }
    }
}