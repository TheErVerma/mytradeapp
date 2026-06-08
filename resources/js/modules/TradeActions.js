
export default class TradeActions {
    constructor() {
        this.actionBtns = null;

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
                            MainApp.Gallery.renderGallery(data[clm], trade_id);
                            // MainApp.Gallery.uploadScreenshots();
                        }
                        if(inp_arr && inp_arr.length >= 1){
                            inp_arr.forEach(inp_itm => {
                                inp_itm.removeAttribute('checked');
                            });
                        }
                        if(inp && inp.getAttribute('type') == 'radio'){
                            const radio_ = document.querySelector('#edit_trade_popup [name="'+clm+'"][value="'+data[clm]+'"]');
                            console.log(radio_);
                            if(radio_){
                                radio_.setAttribute('checked', 'true');
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
            // window.location.reload();
        }).catch((err) => {
            form.classList.remove('processing');
        })
    }
}