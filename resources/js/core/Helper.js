
export default class HelpManager {

    constructor() {
        this.init();
    }

    init() {
        document.addEventListener(
            'click',
            this.handleClick.bind(this)
        );

        const themeQuery = window.matchMedia("(prefers-color-scheme: dark)");
        const isDarkMode = themeQuery.matches;
        this.toggleTheme(isDarkMode ? 'dark' : 'light');

        themeQuery.addEventListener("change", (event) => {
            const newTheme = event.matches ? "dark" : "light";
            this.toggleTheme(newTheme);
        });
    }

    handleClick(e) {
        const target = e.target;

        if (!target.classList.contains('theme_toggler')) {
            return;
        }

        const theme = document.querySelector('html').getAttribute('theme');
        const new_theme = theme == 'light' ? 'dark' : 'light';
        this.toggleTheme(new_theme);
        // document.querySelector('html').setAttribute('theme', new_theme);
    }

    toggleTheme(theme) {
        document.querySelector('html').setAttribute('theme', theme);
    }
}