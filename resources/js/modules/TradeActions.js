
export default class TradeActions {
    constructor() {
        this.actionBtns = null;
        this.fileInput = document.getElementById('trade_screenshots');
        this.init();
    }

    init() {
        this.actionBtns = document.querySelectorAll(
            '.trades_table_inner table tbody tr td .trade_action_wrap button'
        );

        if (!this.actionBtns) {
            console.error('Trash button not found');
            return;
        }

        this.actionBtns.forEach(act_btn => {

            // Delete Action
            if (act_btn.classList.contains('trash')) {
                act_btn.addEventListener('click', () => {
                    const this_id = act_btn.getAttribute('data_id');

                    MainApp.ConfirmPop.confirm('Are you sure? you want to remove the trade item.', () => {
                        console.log(`Deleted! ${this_id}`);
                        this.delete(this_id);
                    });
                });
            } else if (act_btn.classList.contains('edit')) {
                act_btn.addEventListener('click', async () => {
                    const this_id = act_btn.getAttribute('data_id');
                    await this.edit(this_id);
                });
            }


        });

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

                console.log('Trade ID:', trade_id);

                this.previewImages(e, trade_id);
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

        await fetch(`/trade/${trade_id}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        }).then((response) => response.json())
            .then((data) => {
                if(typeof data == 'object' && Object.keys(data).length >= 1){
                    Object.keys(data).forEach((clm, ind) => {
                        const inp = document.querySelector('#edit_trade_popup [name="'+clm+'"]');
                        const inp_arr = document.querySelectorAll('#edit_trade_popup [name="'+clm+'"]');
                        const trd_notes = document.querySelector('#edit_trade_popup [name="trd_notes"]');
                        if( clm == 'notes' ) {
                            trd_notes.value = data[clm];
                        }
                        if (clm == 'trd_screenshots') {

                            MainApp.Gallery.renderGallery('#edit_trade_popup .screenshot-gallery .image_gallery', data[clm], trade_id);
                        }
                        if(inp_arr && inp_arr.length >= 1){
                            inp_arr.forEach(inp_itm => {
                                inp_itm.removeAttribute('checked');
                            });
                        }
                        if(inp && inp.getAttribute('type') == 'radio'){
                            const radio_ = document.querySelector('#edit_trade_popup [name="'+clm+'"][value="'+data[clm]+'"]');
                            if(radio_){
                                const changeEvent = new Event('change');
                                radio_.setAttribute('checked', 'true');//.dispatchEvent(changeEvent);
                                radio_.dispatchEvent(changeEvent);
                            }else{
                                console.log('#edit_trade_popup [name="'+clm+'"][value="'+data[clm]+'"]');
                            }
                        }else{
                            if(inp){
                                inp.value = data[clm];
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
            window.location.reload();
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

        let wrapper = form.querySelector('.screenshot-gallery');
        if (!wrapper) return;

        let imageGallery = wrapper.querySelector('.image_gallery');

        // Create gallery if not exists
        if (!imageGallery) {
            imageGallery = document.createElement('div');
            imageGallery.className = 'image_gallery';
            wrapper.appendChild(imageGallery);
        }

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
                imgThumb.classList.add('screenshot-thumb');
                imgThumb.innerHTML = `
                    <img src="${e.target.result}" data-tid="" />

                    <div class="screenshot-actions">
                        <button type="button" class="screenshot-view" data-fancybox="gallery" data-src="${e.target.result}">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 83.78" style="enable-background:new 0 0 122.88 83.78" xml:space="preserve"><g><path d="M95.73,10.81c10.53,7.09,19.6,17.37,26.48,29.86l0.67,1.22l-0.67,1.21c-6.88,12.49-15.96,22.77-26.48,29.86 C85.46,79.88,73.8,83.78,61.44,83.78c-12.36,0-24.02-3.9-34.28-10.81C16.62,65.87,7.55,55.59,0.67,43.1L0,41.89l0.67-1.22 c6.88-12.49,15.95-22.77,26.48-29.86C37.42,3.9,49.08,0,61.44,0C73.8,0,85.45,3.9,95.73,10.81L95.73,10.81z M60.79,22.17l4.08,0.39 c-1.45,2.18-2.31,4.82-2.31,7.67c0,7.48,5.86,13.54,13.1,13.54c2.32,0,4.5-0.62,6.39-1.72c0.03,0.47,0.05,0.94,0.05,1.42 c0,11.77-9.54,21.31-21.31,21.31c-11.77,0-21.31-9.54-21.31-21.31C39.48,31.71,49.02,22.17,60.79,22.17L60.79,22.17L60.79,22.17z M109,41.89c-5.5-9.66-12.61-17.6-20.79-23.11c-8.05-5.42-17.15-8.48-26.77-8.48c-9.61,0-18.71,3.06-26.76,8.48 c-8.18,5.51-15.29,13.45-20.8,23.11c5.5,9.66,12.62,17.6,20.8,23.1c8.05,5.42,17.15,8.48,26.76,8.48c9.62,0,18.71-3.06,26.77-8.48 C96.39,59.49,103.5,51.55,109,41.89L109,41.89z"/></g></svg>
                        </button>
                        <button type="button" class="screenshot-delete">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="109.484px" height="122.88px" viewBox="0 0 109.484 122.88" enable-background="new 0 0 109.484 122.88" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M2.347,9.633h38.297V3.76c0-2.068,1.689-3.76,3.76-3.76h21.144 c2.07,0,3.76,1.691,3.76,3.76v5.874h37.83c1.293,0,2.347,1.057,2.347,2.349v11.514H0V11.982C0,10.69,1.055,9.633,2.347,9.633 L2.347,9.633z M8.69,29.605h92.921c1.937,0,3.696,1.599,3.521,3.524l-7.864,86.229c-0.174,1.926-1.59,3.521-3.523,3.521h-77.3 c-1.934,0-3.352-1.592-3.524-3.521L5.166,33.129C4.994,31.197,6.751,29.605,8.69,29.605L8.69,29.605z M69.077,42.998h9.866v65.314 h-9.866V42.998L69.077,42.998z M30.072,42.998h9.867v65.314h-9.867V42.998L30.072,42.998z M49.572,42.998h9.869v65.314h-9.869 V42.998L49.572,42.998z"/></g></svg>
                        </button>
                    </div>
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