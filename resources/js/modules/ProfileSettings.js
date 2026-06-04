// profile_settings_form


export default class ProfileSettingsForm {

    notices = [];
    profileForm = null;
    mainSettingForm = null;

    constructor() {
        this.init();
    }

    init() {
        document.addEventListener(
            'submit',
            this.handleSubmit.bind(this)
        );
        document.addEventListener(
            'submit',
            this.saveMainSettings.bind(this)
        );
        this.imagePicker();
    }

    addNotice(message, type = '') {
        this.removeAllNotices();
        const notice = document.createElement('div');
        notice.classList.add('form_notice');
        notice.innerHTML = message;

        if (type) {
            notice.classList.add(type);
        }

        console.log(this.profileForm);
        if (this.profileForm != null) {
            if (this.profileForm.matches('#profile_settings_form')) {
                this.notices.push(notice);
                this.profileForm.querySelector('.form_notices').append(notice);
            }
        }
        if (this.mainSettingForm != null) {
            if (this.profileForm.matches('#main_set_preference_form')) {
                this.notices.push(notice);
                this.mainSettingForm.querySelector('.form_notices').append(notice);
            }
        }
    }

    removeAllNotices() {
        if (this.notices.length >= 1) {
            (this.notices).forEach((notice_item, indx) => {
                console.log(notice_item);
                notice_item.remove();
            });
        }
    }

    handleSubmit(event) {

        const profileInstance = this;

        this.profileForm = event.target;

        if (!this.profileForm.matches('#profile_settings_form')) {
            return;
        }

        event.preventDefault();

        const formData = new FormData(this.profileForm);

        const user_id = document.querySelector('input[name=user_id]').value;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // AJAX request here
        fetch(`/user/${user_id}/saveprofile`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token
            }
        })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            if (data.success) {
                this.addNotice(data.message, 'success');
                setTimeout(function () {
                    profileInstance.removeAllNotices();
                }, 4000);
            } else {
                this.addNotice(data.message, 'warning');
            }

            if (data.redirect) {
                window.location.href = data.redirect;
            }

        }).catch((err) => {
            console.log(err);
        })
    }

    imagePicker() {

        const imageSelector = document.getElementById('profile_pic');
        const previewImage = document.querySelector('.profile_image > img');

        if (imageSelector) {
            imageSelector.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    // Create a temporary URL for the selected file
                    const objectUrl = URL.createObjectURL(file);
                    previewImage.src = objectUrl;

                    // Optional: Clean up memory when image loads
                    previewImage.onload = () => URL.revokeObjectURL(objectUrl);
                }
            });
        }

    }


    saveMainSettings(event){

        const thisClass = this;
        this.mainSettingForm = event.target;

        if (!this.mainSettingForm.matches('#main_set_preference_form')) {
            return;
        }

        event.preventDefault();

        const formData = new FormData(this.mainSettingForm);

        const user_id = document.querySelector('input[name=user_id]').value;
        
        fetch(`/user/${user_id}/savesettings`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            thisClass.addNotice(data.message, 'success');
        }).catch((err) => {
            console.log(err);
            thisClass.addNotice(err.message, 'error');
        })
    }
}