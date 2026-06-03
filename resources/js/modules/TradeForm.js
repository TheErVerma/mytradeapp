
export default class TradeForm {

    constructor() {
        this.init();
    }

    init() {
        document.addEventListener(
            'submit',
            this.handleSubmit.bind(this)
        );
        document.querySelector('#symbol').addEventListener(
            'focus',
            this.openSuggestions.bind(this)
        );
        document.querySelector('#symbol').addEventListener(
            'input',
            this.searchSuggestions.bind(this)
        );
        document.querySelector('#symbol').addEventListener(
            'blur',
            this.closeSuggestions.bind(this)
        );
        document.querySelectorAll('.form_fields .form_field ul.field_drop_down li').forEach((drop_itm) => {
            drop_itm.addEventListener(
                'click',
                this.selectSuggestion.bind(this)
            );
        })

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


    openSuggestions(event) {
        const inp = this;
        document.querySelector('.form_fields .form_field ul.field_drop_down').classList.add('active');
    }

    closeSuggestions(event) {
        const inp = this;
        setTimeout(() => {
            document.querySelector('.form_fields .form_field ul.field_drop_down').classList.remove('active');
        }, 100);
    }

    searchSuggestions(event) {
        const inp = event.target;

        this.doSearch(inp.value);
    }

    doSearch(value) {
        const all_suggessions = document.querySelectorAll('.form_fields .form_field ul.field_drop_down li');
        if (all_suggessions && all_suggessions.length >= 1) {
            all_suggessions.forEach(itm => {
                const this_val = itm.getAttribute('data_value');
                if (value != "") {
                    if ((this_val.toLowerCase()).includes((value))) {
                        itm.style.display = 'block';
                    } else {
                        itm.style.display = 'none';
                    }
                } else {
                    itm.style.display = 'block';

                }
            })
        }
    }

    selectSuggestion(event) {
        const inp = event.target;
        document.getElementById('symbol').value = inp.getAttribute('data_value');
    }

}