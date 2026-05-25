// profile_settings_form


export default class ProfileSettingsForm {

    notices = [];
    profileForm = null;

    constructor() {
        this.init();
    }

    init() {
        document.addEventListener(
            'submit',
            this.handleSubmit.bind(this)
        );
    }

    addNotice(message, type = '') {
        this.removeAllNotices();
        const notice = document.createElement('div');
        notice.classList.add('form_notice');
        notice.innerHTML = message;

        if (type) {
            notice.classList.add(type);
        }

        if (this.profileForm) {
            this.notices.push(notice);
            this.profileForm.querySelector('.form_notices').append(notice);
        }
    }

    removeAllNotices(){
        if(this.notices.length >= 1){
            (this.notices).forEach((notice_item, indx) => {
                console.log(notice_item);
                notice_item.remove();
            });
        }
    }

    handleSubmit(event) {
        this.profileForm = event.target;

        if (!this.profileForm.matches('#profile_settings_form')) {
            return;
        }

        event.preventDefault();

        const formData = new FormData(this.profileForm);

        const user_id = document.querySelector('input[name=user_id]').value;
        // AJAX request here
        fetch(`/user/${user_id}/saveprofile`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                if (data.status == 200) {
                    this.addNotice(data.message, 'success');
                }else{
                    this.addNotice(data.message, 'warning');
                }

                if(data.redirect){
                    window.location.href = data.redirect;
                }

            }).catch((err) => {
                console.log(err);
            })
    }
}