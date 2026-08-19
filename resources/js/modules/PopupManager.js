export default class PopupManager {
    constructor() {
        this.init();
    }

    init() {
        const App = this;
        document.addEventListener('click', this.handleClick.bind(this));

        document.addEventListener('keyup', function(e){
            if(e.key == 'Escape'){
                App.closeAll();
            }
        })
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
            const cls_btn = event.target.closest('.close');
            const popWrap = cls_btn.closest('.main_popup');
            const popupId = popWrap.getAttribute('data_identity');
            this.close(popupId)
        }

        if(event.target.closest('.main_popup_overlay') || (event.target.closest('.main_popup_inner') == null && event.target.closest('.btn') == null)) {
            event.target.closest('.main_popup') ? event.target.closest('.main_popup').classList.remove('active') : false;
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

    close(id) {
        const popup = document.querySelector(
            `.main_popup[data_identity="${id}"]`
        );

        if (popup) {
            popup.classList.remove('active');
        }
    }

    closeAll() {
        document.querySelectorAll('.main_popup').forEach((popup) => {
            popup.classList.remove('active');
        });
    }
}