import PopupManager from '../modules/PopupManager';
import TradeForm from '../modules/TradeForm';
import AuthForm from '../modules/AuthForm';
import RegisterForm from '../modules/RegisterForm';

export default class App {
    constructor() {
        this.initModules();
    }

    initModules() {
        this.AuthForm = new AuthForm();
        this.RegisterForm = new RegisterForm();
        this.popupManager = new PopupManager();
        this.tradeForm = new TradeForm();
    }
}