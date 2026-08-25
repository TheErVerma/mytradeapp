
export default class TradeActions {
    constructor() {
        this.actionBtns = null;
        this.fileInput = document.getElementById('trade_screenshots');
        this.init();
    }

    init() {
        const thisApp = this;
        document.addEventListener('journal-loaded', function(){
            // console.log('Journal Loaded!');
            thisApp.actionBtns = document.querySelectorAll(
                'table.trades_journal_table tbody tr td.trade_b_actions button'
            );
            if (!thisApp.actionBtns) {
                console.error('Trash button not found');
                return;
            }
    
            thisApp.actionBtns.forEach(act_btn => {
    
                // Delete Action
                if (act_btn.classList.contains('trash')) {
                    act_btn.addEventListener('click', () => {
                        const this_id = act_btn.getAttribute('data_id');
    
                        MainApp.ConfirmPop.confirm('Are you sure? you want to remove the trade item.', () => {
                            console.log(`Deleted! ${this_id}`);
                            thisApp.delete(this_id);
                        });
                    });
                } else if (act_btn.classList.contains('edit')) {
                    act_btn.addEventListener('click', async () => {
                        const this_id = act_btn.getAttribute('data_id');
                        await thisApp.edit(this_id);
                    });
                }
    
    
            });
        });

        document.addEventListener('trd_loaded_ssthumbs', function(){
            console.log('Thumbs Loaded');
            document.querySelectorAll('.screenshot-delete').forEach(elm => elm.addEventListener('click', function(){
                const this_btn = this;
                const this_prnt =  this_btn.parentNode;
                const this_src =  this_prnt ? this_prnt.querySelector('img').src : false;
                let new_imgs = [];
                JSON.parse(atob(document.querySelector('#trd_old_screenshots').value)).forEach(lnk => (lnk != this_src ? new_imgs.push(lnk) : false));
                console.log(new_imgs);
                document.querySelector('#trd_old_screenshots').value = btoa(JSON.stringify(new_imgs));
                this_prnt.remove();
            }));
        });


        document.dispatchEvent(new Event('journal-loaded'));


        document.addEventListener(
            'submit',
            this.handleEditSubmit.bind(this)
        );

        document.querySelectorAll('#trade_screenshots').forEach(input => {
            input.addEventListener('change', (e) => {
                if (!e.target.matches('#trade_screenshots')) return;

                const form = e.target.closest('form');
                if (!form) return;

                let trade_id = form.querySelector("[name='id']")?.value || '';
                this.previewImages(e, trade_id);
            });
        });

        const formatePrice = (value) => {
            value = (parseFloat(value)).toFixed(2);
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
            return value;
        }

        const checkPNL = (elm) => {
        
            const form = elm.closest('form');
            const is_short = form.querySelector('[name="trd_action"]:checked').value;
            const lot_size = Number(form.querySelector('[name="trd_lot"]').value);
            const shr_size = Number(form.querySelector('[name="trd_shares"]').value);
            const qty_multiplier = Number(form.querySelector('[name="trd_qty_multiplier"]')?.value);
            const qty_size = (Number(form.querySelector('[name="trd_qty_size"]')?.value) * (lot_size || shr_size)) * qty_multiplier;
            const entry_price = (form.querySelector('[name="trd_price"]').value).replaceAll(',', '');
            const exit_price = (form.querySelector('[name="trd_exit_price"]').value).replaceAll(',', '');
            const charges_price = (form.querySelector('[name="trd_charges_amount"]').value).replaceAll(',', '');
            
            let sum = ((exit_price - entry_price) * qty_size) - charges_price;
            if(is_short == 'Short'){
                sum = ((entry_price - exit_price) * qty_size) - charges_price;
            }
            
            // console.log(is_short);
            // console.log(sum, {is_short,lot_size,shr_size,qty_multiplier,qty_size,entry_price,exit_price,charges_price,});
            const pnl_wrap = form.querySelector('.form_text_field.p_n_l');
            // console.log(pnl_wrap);
            if(pnl_wrap){
                const symbol = pnl_wrap.getAttribute('data_currency_symbol');
                const formatted = (sum < 0 ? '-' : '') + symbol + formatePrice(Math.abs(sum));

                if(sum < 0){
                    pnl_wrap.innerHTML = `<div class="pnl_text loss"><strong>Total P&L: </strong><span>${formatted}</span></div>`;
                }else{
                    pnl_wrap.innerHTML = `<div class="pnl_text profit"><strong>Total P&L: </strong><span>${formatted}</span></div>`;
                }
                if(entry_price != "" && exit_price != ""){
                    pnl_wrap.style.display = '';
                }else{
                    pnl_wrap.style.display = 'none';
                }
            }
            // console.log(entry_price, exit_price, sum);
        }
        document.querySelectorAll('[name="trd_shares"], [name="trd_lot"], [name="trd_qty_size"], [name="trd_action"], [name="trd_price"],[name="trd_exit_price"], [name="trd_charges_amount"] ').forEach(input => {
            input.addEventListener('input', function(){
                checkPNL(this);
            });
        });

    }

    delete(trade_id) {
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/trade', {
            method: 'delete',
            body: JSON.stringify({
                id: Number(trade_id)
            }),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            }
        }).then((response) => response.json())
        .then((data) => {
            console.log(data);
            window.location.reload();
        }).catch((err) => {
            console.log(err);
        });
    }

    async edit(trade_id) {
        MainApp.popupManager.open('edit-trade-pop');
        // console.log(trade_id);

        await fetch(`/trade/${trade_id}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        }).then((response) => response.json())
            .then((data) => {
                const changeEvent = new Event('change');
                const inputEvent = new Event('input');
                // console.log(data);
                if(typeof data == 'object' && Object.keys(data).length >= 1){
                    Object.keys(data).forEach((clm, ind) => {
                        const inp = document.querySelector('#edit_trade_popup [name="'+clm+'"]');
                        const inp_arr = document.querySelectorAll('#edit_trade_popup [name="'+clm+'"]');
                        const trd_notes = document.querySelector('#edit_trade_popup [name="trd_notes"]');
                        const trd_old_screenshots = document.querySelector('#edit_trade_popup [name="trd_old_screenshots"]');
                        if( trd_notes && clm == 'notes' ) {
                            trd_notes.value = data[clm];
                        }
                        if (clm == 'trd_screenshots') {
                            if(trd_old_screenshots){
                                trd_old_screenshots.value = btoa(JSON.stringify(data[clm]));
                            }
                            MainApp.Gallery.renderGallery('#edit_trade_popup .screenshot-gallery', data[clm], trade_id);
                            document.dispatchEvent(new Event('trd_loaded_ssthumbs'));
                        }
                        if(inp_arr && inp_arr.length >= 1){
                            inp_arr.forEach(inp_itm => {
                                inp_itm.removeAttribute('checked');
                            });
                        }
                        
                        if(inp && inp.getAttribute('type') == 'radio'){
                            const radio_ = document.querySelector('#edit_trade_popup [name="'+clm+'"][value="'+(data[clm])+'"]');
                            if(radio_){
                                radio_.setAttribute('checked', 'true');//.dispatchEvent(changeEvent);
                                radio_.dispatchEvent(changeEvent);
                            }
                            // console.log('#edit_trade_popup [name="'+clm+'"][value="'+(data[clm])+'"]');
                        }else{
                            if(inp){
                                inp.value = data[clm];

                                
                                if(clm == 'trd_type'){
                                    const type_val = data[clm];
                                    // console.log(type_val);
                                    if(type_val == 'F&O'){
                                        document.querySelector('#edit_trade_popup .shares_amount_val').classList.add('hidden');
                                        document.querySelector('#edit_trade_popup .lot_amount_val').classList.remove('hidden');
                                    }else{
                                        document.querySelector('#edit_trade_popup .shares_amount_val').classList.remove('hidden');
                                        document.querySelector('#edit_trade_popup .lot_amount_val').classList.add('hidden');
                                    }
                                    inp.dispatchEvent(inputEvent);
                                }
                                if(clm == 'trd_date'){
                                    const ddpinp = document.querySelector('#edit_trade_popup [name='+clm+']');
                                    ddpinp._flatpickr.setDate(data[clm]);
                                }
                                if(inp.classList.contains('price')){
                                    // console.log(inp);
                                    inp.dispatchEvent(inputEvent);
                                }
                            }else{
                                if(clm == 'instrument'){
                                    const lot_size_hinp = document.querySelector('#edit_trade_popup [name="trd_qty_size"]');
                                    const qty_mult_hinp = document.querySelector('#edit_trade_popup [name="trd_qty_multiplier"]');
                                    
                                    const this_instrument = data[clm];
                                    lot_size_hinp.value = this_instrument.lot_size;
                                    qty_mult_hinp.value = this_instrument.qty_multiplier;
                                    
                                    lot_size_hinp.dispatchEvent(inputEvent);
                                    qty_mult_hinp.dispatchEvent(inputEvent);
                                }
                            }
                        }
                    });
                }
            }).catch((err) => {

                console.log(err);
            });
    }

    handleEditSubmit(event) {
        const form = event.target;

        if (!form.matches('#edit_trade_popup')) {
            return;
        }

        event.preventDefault();

        const formData = new FormData(form);

        // for(let [name, value] of formData.entries()) {
        //     console.log(name, value);
        // }
        // console.log(formData);

        form.classList.add('processing');
        fetch('/trade', {
            method: "PUT",
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then((response) => response.json())
        .then((data) => {
            console.log(data);
            form.classList.remove('processing');
            if(data.exception){
                MainApp.Toast.dive('Something wrong', 'error');
            }else{
                window.location.reload();
            }
        }).catch((err) => {
            form.classList.remove('processing');
        })
    }

    previewImages(event, trade_id = null) {
        const files = event.target.files;
        if (!files.length) return;

        // Find container safely
        let form = event.target.closest('form');
        if (!form) return;

        let imageGallery = form.querySelector('.screenshot-gallery');
        if (!imageGallery) return;

        // let imageGallery = wrapper.querySelector('.image_gallery');

        // Create gallery if not exists
        // if (!imageGallery) {
        //     imageGallery = document.createElement('div');
        //     imageGallery.className = 'image_gallery';
        //     wrapper.appendChild(imageGallery);
        // }

        document.addEventListener('click', (e) => {
            if (e.target.closest('.screenshot-delete')) {
                e.target.closest('.screenshot-thumb').remove();
            }
        });

        Array.from(files).forEach(file => {
            // Only allow images
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();

            reader.onload = (e) => {
                const imgThumb = document.createElement('div');
                imgThumb.classList.add('w-[24%]', 'rounded-sm', 'overflow-hidden', 'relative', 'screenshot-thumb');
                imgThumb.innerHTML = `
                    <button class="author-open__popup screenshot-delete" type="button" tabindex="0"
                        data-pressed="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="size-4 shrink-0 stroke-[2.25px]">
                            <path
                                d="M16 6V5.2C16 4.0799 16 3.51984 15.782 3.09202C15.5903 2.71569 15.2843 2.40973 14.908 2.21799C14.4802 2 13.9201 2 12.8 2H11.2C10.0799 2 9.51984 2 9.09202 2.21799C8.71569 2.40973 8.40973 2.71569 8.21799 3.09202C8 3.51984 8 4.0799 8 5.2V6M10 11.5V16.5M14 11.5V16.5M3 6H21M19 6V17.2C19 18.8802 19 19.7202 18.673 20.362C18.3854 20.9265 17.9265 21.3854 17.362 21.673C16.7202 22 15.8802 22 14.2 22H9.8C8.11984 22 7.27976 22 6.63803 21.673C6.07354 21.3854 5.6146 20.9265 5.32698 20.362C5 19.7202 5 18.8802 5 17.2V6"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>

                    </button>
                    <img src="${e.target.result}" data-tid="" class="h-auto w-full"/>
                `;

                // Optional styling
                // img.style.width = '100px';
                // img.style.height = '100px';
                // img.style.objectFit = 'cover';
                // img.style.margin = '5px';

                imageGallery.appendChild(imgThumb);
            };

            reader.readAsDataURL(file);
        });
    }
    
}