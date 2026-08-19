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

        const themeQuery = window.matchMedia("(prefers-color-scheme: dark)");
        const isDarkMode = themeQuery.matches;
        // this.toggleTheme(isDarkMode ? 'dark' : 'light');

        const theme = localStorage.getItem('theme');
        if (theme == null) {
            themeQuery.addEventListener("change", (event) => {
                const newTheme = event.matches ? "dark" : "light";
                this.toggleTheme(newTheme);
            });
            // this.toggleTheme(isDarkMode ? 'dark' : 'light');
        } else {
            // this.toggleTheme(theme);
        }
    }

    handleClick(e) {
        const target = e.target;
        this.themeToggler(target);
    }

    themeToggler(target) {
        if (!target.classList.contains('theme_toggler')) {
            return;
        }

        const theme = (document.querySelector('html').classList).contains('dark-mode');
        const new_theme = !theme ? 'dark-mode' : '';

        localStorage.setItem('theme', new_theme);
        this.toggleTheme(new_theme);
    }

    toggleTheme(theme) {
        const ThisApp = this;
        const user_id = document.querySelector('html[data_user_id]').getAttribute('data_user_id');
        document.documentElement.classList.remove('dark-mode');

        theme != "" ? document.querySelector('html').classList.add(theme) : false;
        fetch(`/user/${user_id}/save-theme`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': ThisApp.token
            },
            body: JSON.stringify({theme})
        }).then((response) => response.json())
            .then((data) => {
                console.log(data);
            }).catch((err) => {
                console.log(err);
            })

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