import HelpManager from './Helper';
import EventsManager from './Events';
import PopupManager from '../modules/PopupManager';
import TradeForm from '../modules/TradeForm';
import ProfileSettingsForm from '../modules/ProfileSettings';
import AuthForm from '../modules/AuthForm';
import RegisterForm from '../modules/RegisterForm';
import ConfirmPop from '../modules/ConfirmPop';
import TradeActions from '../modules/TradeActions';
import Tabs from '../modules/Tabs';
import Gallery from '../modules/Gallery';
import AudioPlayer from '../modules/AudioControl';
import Toast from '../modules/Toast';
import UpstoxActions from '../modules/UpstoxActions';


export default class App {
    constructor() {
        this.initModules();
    }

    initModules() {
        this.HelpManager = new HelpManager();
        this.EventsManager = new EventsManager();
        this.ConfirmPop = new ConfirmPop();
        this.AuthForm = new AuthForm();
        this.RegisterForm = new RegisterForm();
        this.ProfileSettingsForm = new ProfileSettingsForm();
        this.popupManager = new PopupManager();
        this.tradeForm = new TradeForm();
        this.tradeActions = new TradeActions();
        this.tabs = new Tabs();
        this.Gallery = new Gallery();
        this.Audio = new AudioPlayer();
        this.Toast = new Toast();
        this.UpstoxActions = new UpstoxActions();
    }
}