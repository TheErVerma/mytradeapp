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
        const thisApp = this;
        if(thisApp.activePops.includes(id) === false){
            thisApp.activePops.push(id);
        }
        const popup = document.querySelector(
            `.main_popup[data_identity="${id}"]`
        );

        if (popup) {
            popup.classList.add('active');
        }
    }

    close(id) {
        const thisApp = this;
        const popup = document.querySelector(
            `.main_popup[data_identity="${id}"]`
        );

        if (popup) {
            popup.classList.remove('active');
            thisApp.activePops = (thisApp.activePops).filter(item => item !== id); 
        }
    }

    closeAll() {
        const thisApp = this;
        thisApp.activePops = [];
        document.querySelectorAll('.main_popup').forEach((popup) => {
            popup.classList.remove('active');
        });
    }
}