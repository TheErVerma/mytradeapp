
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
        // this.toggleTheme(isDarkMode ? 'dark' : 'light');

        // themeQuery.addEventListener("change", (event) => {
        //     const newTheme = event.matches ? "dark" : "light";
        //     this.toggleTheme(newTheme);
        // });
        const theme = localStorage.getItem('theme');
        console.log(theme);
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
}