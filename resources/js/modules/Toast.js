export default class Toast {
    constructor() {
    }

    dive(message, type = 'success') {
        const toast = document.createElement('div');
        toast.classList.add('global_toast',type);
        toast.innerHTML = message;
        
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('active');
            setTimeout(() => {
                toast.classList.remove('active');
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }, 3000);
        }, 10);
    }
}