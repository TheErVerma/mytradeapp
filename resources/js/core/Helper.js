import ConfirmPop from "../modules/ConfirmPop";
import PopupManager from "../modules/PopupManager";


export default class HelpManager {

    token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    constructor() {
        this.init();
    }

    init() {
        document.addEventListener(
            'click',
            this.handleClick.bind(this)
        );

        document.addEventListener(
            'click',
            this.removeAllTradeData.bind(this)
        );

        const savedDark = document.querySelector('html').classList.contains('dark-mode') ? 'dark' : 'dark';
        const themeQuery = window.matchMedia("(prefers-color-scheme: " + savedDark + ")");
        const isDarkMode = themeQuery.matches;
        // if (document.querySelector('html').classList.contains('dark-mode') == false) {
        //     this.toggleTheme(isDarkMode);
        // }
        // themeQuery.addEventListener("change", (event) => {
        //     this.toggleTheme(event.matches, true);
        // });


        document.querySelectorAll('.qtynumamnt').forEach(input => {

            // Allow only positive numbers
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
                this.value = this.value.replace(/^0+(?=\d)/, '');
            });

            // Increase / decrease with arrow keys
            input.addEventListener('keydown', function (e) {
                if (e.key !== 'ArrowUp' && e.key !== 'ArrowDown') {
                    return;
                }

                e.preventDefault();

                let value = parseInt(this.value || 0, 10);

                if (e.key === 'ArrowUp') {
                    value++;
                } else if (e.key === 'ArrowDown') {
                    value = Math.max(1, value - 1);
                }

                this.value = value;

                // Trigger input/change events if needed
                this.dispatchEvent(new Event('input', { bubbles: true }));
            });
        });
    }

    handleClick(e) {
        const target = e.target;
        this.themeToggler(target);
    }

    themeToggler(target) {
        if (!target.classList.contains('theme_toggler')) {
            return;
        }
        const theme = !(document.querySelector('html').classList).contains('dark-mode');
        this.toggleTheme(theme, true);
    }

    toggleTheme(theme, force = false) {
        const ThisApp = this;
        const user_id = document.querySelector('html[data_user_id]').getAttribute('data_user_id');
        if (user_id) {
            if (force) {
                document.documentElement.classList.remove('dark-mode');
                theme ? document.querySelector('html').classList.add('dark-mode') : false;
            }

            fetch(`/user/${user_id}/save-theme`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': ThisApp.token
                },
                body: JSON.stringify({ theme })
            }).then((response) => response.json())
                .then((data) => {
                    // console.log(data);
                }).catch((err) => {
                    console.log(err);
                })
        }

    }

    removeAllTradeData(e) {
        const target = e.target;
        if (!target.classList.contains('remove_all_trade_data')) {
            return;
        }

        const c = new ConfirmPop();

        c.confirm('Are you sure? This will not be revert back.', () => {

            target.classList.add('processing');

            fetch('/reset-all-data', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    target.classList.remove('processing');
                }).catch((err) => {
                    console.log(err);
                    target.classList.remove('processing');
                })
        });
    }

}