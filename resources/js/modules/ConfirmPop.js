export default class ConfirmPop {
    constructor() {
        this.popup = null;
        this.messageEl = null;
        this.confirmBtn = null;
        this.cancelBtn = null;

        this.callback = null;

        this.init();
    }

    init() {
        this.popup = document.querySelector(
            '.main_popup[data_identity="confirm-pop"]'
        );

        if (!this.popup) {
            // console.error('Confirm popup not found');
            return;
        }

        this.messageEl = this.popup.querySelector(
            '.confirmation_message'
        );

        this.confirmBtn = this.popup.querySelector(
            '.btn-primary'
        );

        this.cancelBtn = this.popup.querySelector(
            '.btn-secondary'
        );

        this.confirmBtn.addEventListener('click', () => {

            if (typeof this.callback === 'function') {
                this.callback();
            }

            this.cancel();

        });

        this.cancelBtn.addEventListener('click', () => {
            this.cancel();
        });
    }

    confirm(message, callback) {

        this.callback = callback;

        this.messageEl.innerHTML = message;

        this.popup.classList.add('active');
    }

    cancel() {

        this.popup.classList.remove('active');

        this.callback = null;

    }
}