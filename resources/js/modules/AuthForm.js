
export default class AuthForm {

    notices = [];
    loginForm = null;
    forgetForm = null;
    OtpForm = null;
    resetForm = null;

    constructor() {
        this.init();
    }

    init() {
        document.addEventListener('submit', this.handleSubmit.bind(this));
        document.addEventListener('submit', this.forgetPassword.bind(this));
        document.addEventListener('submit', this.verifyOTP.bind(this));
        document.addEventListener('submit', this.resetPassword.bind(this));
        document.addEventListener('click', this.togglePassword.bind(this));
        this.logout();
    }

    togglePassword(event) {
        this.toggleBtn = event.target;


        if (!this.toggleBtn.matches('.show_hide_pass')) {
            return;
        }

        if (this.toggleBtn.classList.contains('active')) {
            this.toggleBtn.classList.remove('active');
            document.getElementById('password').setAttribute('type', 'password');
        } else {
            document.getElementById('password').setAttribute('type', 'text');
            this.toggleBtn.classList.add('active');
        }

    }

    addNotice(message, type = '') {
        this.removeAllNotices();
        const notice = document.createElement('div');
        notice.classList.add('form_notice');
        notice.innerHTML = message;

        if (type) {
            notice.classList.add(type);
        }

        if (this.loginForm) {
            this.notices.push(notice);
            this.loginForm.querySelector('.form_notices').append(notice);
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
        this.loginForm = event.target;
        document.querySelectorAll('[name="password"], [name="email_address"]').forEach(function(inp, indx){
            inp.classList.remove('invalid');
        })

        if (!this.loginForm.matches('#login_form')) {
            return;
        }

        event.preventDefault();

        const formData = new FormData(this.loginForm);
        this.removeAllNotices();

        this.loginForm.querySelector('[type="submit"]').classList.add('loading');
        // AJAX request here
        fetch('/login', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                this.loginForm.querySelector('[type="submit"]').classList.remove('loading');
                
                if (data.redirect) {
                    window.location.href = data.redirect;
                }else{
                    if (data.status == 200) {
                        this.addNotice(data.message, 'success');
                    } else {
                        this.addNotice(data.message, 'warning');
                        document.querySelectorAll('[name="password"], [name="email_address"]').forEach(function(inp, indx){
                            inp.classList.add('invalid');
                        })
                    }
                }
            }).catch((err) => {
                this.loginForm.querySelector('[type="submit"]').classList.remove('loading');
                // console.log(err);
            })
    }

    forgetPassword(event) {
        const ThisApp = this;
        this.forgetForm = event.target;

        if (!this.forgetForm.matches('#forget_password_form')) {
            return;
        }

        event.preventDefault();

        this.forgetForm.querySelector('[type="submit"]').classList.add('loading');
        const formData = new FormData(this.forgetForm);

        // AJAX request here
        fetch('/forget-password', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                if (data.success) {
                    ThisApp.addNotice(data.message, 'success');

                    // document.querySelector('#verify_otp_form [name="email_address"]').value = document.querySelector('#forget_password_form [name="email_address"]').value
                    // document.querySelector('#reset_password_form [name="email_address"]').value = document.querySelector('#forget_password_form [name="email_address"]').value
                    // document.querySelector('.main_log_reg_form.forget_password_form').style.display = 'none';
                    // document.querySelector('.main_log_reg_form.verify_otp_form').style.display = 'block';

                } else {
                    ThisApp.addNotice(data.message, 'warning');
                }

                this.forgetForm.querySelector('[type="submit"]').classList.remove('loading');

                // document.querySelector('.main_log_reg_form.reset_password_form').style.display = 'block';
                if (data.redirect) {
                    window.location.href = data.redirect;
                }

            }).catch((err) => {
                console.log(err);
                this.forgetForm.querySelector('[type="submit"]').classList.remove('loading');
            })

    }

    verifyOTP(event) {
        this.OtpForm = event.target;

        if (!this.OtpForm.matches('#verify_otp_form')) {
            return;
        }

        event.preventDefault();

        this.OtpForm.querySelector('[type="submit"]').classList.add('loading');
        const formData = new FormData(this.OtpForm);

        // AJAX request here
        fetch('/verify-otp', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                if (data.success) {
                    if (document.querySelector('[name="verify_type"]').value == 'register') {
                        window.location.href = '/login?verified=1';
                    } else {
                        this.addNotice(data.message, 'success');
                        window.location.href = data.redirect;
                        // document.querySelector('#verify_otp_form [name="email_address"]').value = document.querySelector('#forget_password_form [name="email_address"]').value
                        // document.querySelector('#reset_password_form [name="email_address"]').value = document.querySelector('#forget_password_form [name="email_address"]').value
                        // document.querySelector('.main_log_reg_form.forget_password_form').style.display = 'none';
                        // document.querySelector('.main_log_reg_form.verify_otp_form').style.display = 'none';
                        // document.querySelector('.main_log_reg_form.reset_password_form').style.display = 'block';
                    }
                } else {
                    this.addNotice(data.message, 'warning');
                }

                this.OtpForm.querySelector('[type="submit"]').classList.remove('loading');
            }).catch((err) => {
                console.log(err);
                this.OtpForm.querySelector('[type="submit"]').classList.remove('loading');
            })
    }


    resetPassword(event) {
        this.resetForm = event.target;

        if (!this.resetForm.matches('#reset_password_form')) {
            return;
        }

        event.preventDefault();

        this.resetForm.querySelector('[type="submit"]').classList.add('loading');
        const formData = new FormData(this.resetForm);

        // AJAX request here
        fetch('/reset-password', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                if (data.success) {
                    this.addNotice(data.message, 'success');
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                } else {
                    this.addNotice(data.message, 'warning');
                }

                this.resetForm.querySelector('[type="submit"]').classList.remove('loading');


            }).catch((err) => {
                console.log(err);
                this.resetForm.querySelector('[type="submit"]').classList.remove('loading');
            })
    }

    logout() {
        const all_a = document.querySelectorAll('a');
        if (all_a.length >= 1) {
            all_a.forEach((itm, indx) => {
                if (itm.href.includes('logout')) {
                    itm.addEventListener('click', function (e) {
                        e.preventDefault();
                        MainApp.ConfirmPop.confirm('Are you sure? do you want to logout?', () => {
                            window.location.href = itm.href;
                        });
                    })
                }
                if (itm.href.includes('disconnect')) {
                    itm.addEventListener('click', function (e) {
                        e.preventDefault();
                        MainApp.ConfirmPop.confirm('Are you sure? do you want to disconnect the integration?', () => {
                            window.location.href = itm.href;
                        });
                    })
                }
            })
        }
    }
}