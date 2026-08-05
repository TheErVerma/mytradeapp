import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";


export default class EventManager {

    constructor() {
        this.init();
    }

    init() {
        const rep = flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            allowInput: true
        });

        const priceInputs = document.querySelectorAll('input.price');
        if (priceInputs.length >= 1) {
            priceInputs.forEach((priceInput) => {
                priceInput.addEventListener('input', function (e) {
                    let value = e.target.value.replace(/[^\d.]/g, '');
                    const parts = value.split('.');
                    if (parts.length > 2) {
                        value = parts[0] + '.' + parts.slice(1).join('');
                    }
                    let [integerPart, decimalPart] = value.split('.');
                    if (integerPart) {
                        integerPart = Number(integerPart).toLocaleString('en-IN');
                    }
                    if (decimalPart !== undefined) {
                        decimalPart = decimalPart.substring(0, 2);
                        value = `${integerPart}.${decimalPart}`;
                    } else {
                        value = integerPart;
                    }
                    e.target.value = value;
                });

            });
        }
    }
}