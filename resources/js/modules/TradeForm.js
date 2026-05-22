export default class TradeForm {
    constructor() {
        this.init();
    }

    init() {
        document.addEventListener(
            'submit',
            this.handleSubmit.bind(this)
        );

        this.conditionalFields();
    }

    conditionalFields(){
        const all_cn_fields = document.querySelectorAll('[data_conditional]');

        if(all_cn_fields && all_cn_fields.length >= 1){
            all_cn_fields.forEach((field, indx) => {
                
                const this_condition = field.getAttribute('data_conditional');
                const this_condition_parts = this_condition.split('|');
                const target = this_condition_parts[0];
                const opt = this_condition_parts[1];
                const val = this_condition_parts[2];

                
                const target_obj = document.querySelectorAll('[name='+target+']');
                if(target_obj && target_obj.length >= 1){
                    const target_obj_1 = target_obj[0];
                    const target_obj_type = target_obj_1.getAttribute('type');
                    target_obj_1.addEventListener('change', this.conditionalFields);
                    
                    let target_obj_val = target_obj_1.value;
                    
                    if(target_obj_type == 'checkbox' || target_obj_type == 'radio'){
                        target_obj_val = '';
                        const chkd_targets = document.querySelectorAll('[name='+target+']:checked');
                        const chkd_values = Array.from(chkd_targets).map(cb => cb.value);
                        if(chkd_values && chkd_values.length >= 1){
                            target_obj_val = chkd_values[0];
                        }else{
                            target_obj_val = target_obj_1.getAttribute('not_checked');
                        }
                    }
                    
                    if(target_obj_1){
                        if(opt == 'is' && val == target_obj_val){
                            field.closest('.form_field').style.display = 'flex';
                        }else if(opt == 'not' && val != target_obj_val){
                            field.closest('.form_field').style.display = 'flex';
                        }else{
                            field.closest('.form_field').style.display = 'none';
                        }
                    }
                }
            });
        }
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