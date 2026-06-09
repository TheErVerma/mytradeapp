import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";


export default class EventManager {

    constructor() {
        this.init();
    }

    init() {
        const rep = flatpickr(".datepicker", {
            dateFormat: "Y-m-d", // Matches Laravel's database date format
            altInput: true,
            altFormat: "F j, Y", // Human-readable format for the user interface
            allowInput: true
        });
    }
}