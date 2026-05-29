import ConfirmPop from "../modules/ConfirmPop";


export default class HelpManager {

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

        // themeQuery.addEventListener("change", (event) => {
        //     const newTheme = event.matches ? "dark" : "light";
        //     this.toggleTheme(newTheme);
        // });
        const theme = localStorage.getItem('theme');
        this.toggleTheme(theme);
    }

    handleClick(e) {
        const target = e.target;
        this.themeToggler(target);
    }

    themeToggler(target) {
        if (!target.classList.contains('theme_toggler')) {
            return;
        }

        const theme = document.querySelector('html').getAttribute('theme');
        const new_theme = theme == 'light' ? 'dark' : 'light';

        localStorage.setItem('theme', new_theme);
        this.toggleTheme(new_theme);
    }

    toggleTheme(theme) {
        document.querySelector('html').setAttribute('theme', theme);

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