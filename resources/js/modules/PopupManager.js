export default class PopupManager {

    activePops = [];
    constructor() {
        this.init();
    }

    init() {
        const App = this;
        document.addEventListener('click', this.handleClick.bind(this));

        document.addEventListener('keyup', function(e){
            if(e.key == 'Escape'){
                // App.closeAll();
                App.close((App.activePops).at(-1))
            }
        })
    }

    handleClick(event) {
        const thisApp = this;

        // Open popup
        const openBtn = event.target.closest('[data-popup-target]');

        if (openBtn) {
            const popupId = openBtn.dataset.popupTarget;
            this.open(popupId);
        }
        
        // Close popup
        if (event.target.closest('.global-popup__close')) {
            const cls_btn = event.target.closest('.global-popup__close');
            const popWrap = cls_btn.closest('.global-popup');
            const popupId = popWrap.getAttribute('data_identity');
            this.close(popupId)
        }

        if(event.target.closest('.global-popup__overlay') || (event.target.closest('.global-popup__inner') == null && event.target.closest('.btn') == null || event.target.closest('.cancel_action') != null)) {
            event.target.closest('.global-popup') ? event.target.closest('.global-popup').classList.remove('active') : false;
        }
    }

    open(id) {
        const thisApp = this;
        if(thisApp.activePops.includes(id) === false){
            thisApp.activePops.push(id);
        }
        const popup = document.querySelector(
            `.global-popup[data_identity="${id}"]`
        );

        if (popup) {
            popup.classList.add('active');
            document.querySelector('body').classList.add('popup-active');
        }
    }

    close(id) {
        const thisApp = this;
        const popup = document.querySelector(
            `.global-popup[data_identity="${id}"]`
        );

        if (popup) {
            popup.classList.remove('active');
            thisApp.activePops = (thisApp.activePops).filter(item => item !== id); 
            document.querySelector('body').classList.remove('popup-active');
        }
    }

    closeAll() {
        const thisApp = this;
        thisApp.activePops = [];
        document.querySelectorAll('.global-popup').forEach((popup) => {
            popup.classList.remove('active');
            document.querySelector('body').classList.remove('popup-active');
        });
    }
}