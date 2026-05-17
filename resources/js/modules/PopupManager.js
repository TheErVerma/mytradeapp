export default class PopupManager {
    constructor() {
        this.init();
    }

    init() {
        document.addEventListener('click', this.handleClick.bind(this));
    }

    handleClick(event) {

        // Open popup
        const openBtn = event.target.closest('[data-popup-target]');

        if (openBtn) {
            const popupId = openBtn.dataset.popupTarget;
            this.open(popupId);
        }

        // Close popup
        if (event.target.closest('.close')) {
            this.closeAll();
        }
    }

    open(id) {
        const popup = document.querySelector(
            `.main_popup[data_identity="${id}"]`
        );

        if (popup) {
            popup.classList.add('active');
        }
    }

    closeAll() {
        document.querySelectorAll('.main_popup').forEach((popup) => {
            popup.classList.remove('active');
        });
    }
}