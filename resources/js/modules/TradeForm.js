
export default class TradeForm {
    constructor() {
        this.init();
    }

    init() {
        document.addEventListener(
            'submit',
            this.handleSubmit.bind(this)
        );

        this.conditionalLogic();
    }

    conditionalLogic() {
        document.querySelector('[name="trd_type"]').addEventListener('change', function () {
            const this_itm = this;
            const this_checked = document.querySelector('[name="trd_type"]:checked').value;
            const this_wrapper = this_itm.closest('.form_fields');
            if (this_checked == 'Cash') {
                this_wrapper.querySelector('[name="trd_shares"]').closest('.form_field').style.display = 'block';
            } else if (this_checked == 'F&O') {
                this_wrapper.querySelector('[name="trd_lot"]').closest('.form_field').style.display = 'block';
            }
        });
    }



    handleSubmit(event) {
        const form = event.target;

        if (!form.matches('#add_trade_popup')) {
            return;
        }

        event.preventDefault();

        const formData = new FormData(form);

        form.classList.add('processing');
        fetch('/trade', {
            method: "POST",
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then((response) => response.json())
            .then((data) => {
                console.log(data);
                window.location.reload();
            }).catch((err) => {
                console.log(err);
                form.classList.remove('processing');
            })
    }
}