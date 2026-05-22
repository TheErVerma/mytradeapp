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

    }

    delete(trade_id) {
        fetch('/trade', {
            method: 'delete',
            body: JSON.stringify({
                id: Number(trade_id)
            }),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
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
                        if(inp){
                            inp.value = data[clm];
                        }
                    });
                }
            }).catch((err) => {

                console.log(err);
            });
    }
}