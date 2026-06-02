export default class Tabs {
    constructor() {
        this.tabs = document.querySelectorAll('.single_trade_tab');
        this.contents = document.querySelectorAll('.single_trtb_cnt');

        this.init();
    }

    init() {
        this.tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                this.toggleTab(tab.getAttribute('tab_id'));
            });
        });
    }

    toggleTab(tab_id) {
        this.tabs.forEach(tab => {
            tab.classList.toggle(
                'active',
                tab.getAttribute('tab_id') === tab_id
            );
        });

        this.contents.forEach(content => {
            content.classList.toggle(
                'active',
                content.getAttribute('cnt_id') === tab_id
            );
        });
    }
}