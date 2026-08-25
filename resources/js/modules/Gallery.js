import {Fancybox} from '@fancyapps/ui';
import "@fancyapps/ui/dist/fancybox/fancybox.css";

export default class Gallery {
    
    journalNotesForm = null;
    token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    constructor() {
        this.updateNotes();
        this.deleteScreenshots();
        
        this.init();
    }

    init() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('#uploadBtn')) {
                this.uploadScreenshots(e);
            }
        });
        Fancybox.bind("[data-fancybox]", {});
    }

    renderGallery(container, images, id) {
        let gallery = document.querySelector(container);

        if (!gallery) {
            gallery = document.createElement('div');
            gallery.classList = 'image_gallery';
            document.querySelector('.screenshot-gallery').appendChild(gallery);
        }

        gallery.innerHTML = '';

        images.forEach((imgUrl) => {

            let item = document.createElement('div');
            item.classList.add('w-[24%]', 'rounded-sm', 'overflow-hidden', 'relative');

            item.innerHTML = `
                <button class="author-open__popup screenshot-delete" type="button" tabindex="0"
                    data-pressed="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-4 shrink-0 stroke-[2.25px]">
                        <path
                            d="M16 6V5.2C16 4.0799 16 3.51984 15.782 3.09202C15.5903 2.71569 15.2843 2.40973 14.908 2.21799C14.4802 2 13.9201 2 12.8 2H11.2C10.0799 2 9.51984 2 9.09202 2.21799C8.71569 2.40973 8.40973 2.71569 8.21799 3.09202C8 3.51984 8 4.0799 8 5.2V6M10 11.5V16.5M14 11.5V16.5M3 6H21M19 6V17.2C19 18.8802 19 19.7202 18.673 20.362C18.3854 20.9265 17.9265 21.3854 17.362 21.673C16.7202 22 15.8802 22 14.2 22H9.8C8.11984 22 7.27976 22 6.63803 21.673C6.07354 21.3854 5.6146 20.9265 5.32698 20.362C5 19.7202 5 18.8802 5 17.2V6"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>

                </button>
                <img src="${imgUrl}" data-tid="${id}" class="h-auto w-full"/>
            `;

            gallery.appendChild(item);
        });

        if (window.Fancybox) {
            Fancybox.bind("[data-fancybox='gallery']", {});
        }
    }

    uploadScreenshots(e) {
        const ThisApp = this;
        let uploadInput = e.target;
        let form = document.getElementById('uploadForm') || document.getElementById('edit_trade_popup');
        
        if( uploadInput === null ) {
            return;
        }
        // uploadInput.addEventListener('click', () => {
        //     console.log(uploadInput);
        // });
        if( e.target.matches('#uploadBtn') ) {
            const parent = e.target.parentElement;
            uploadInput = parent.querySelector('#imageInput');
            uploadInput.click();
        }

        uploadInput.addEventListener('change', (inputEvent) => {
            console.log(e.target);
            let formData = new FormData(form);
            const tradeId = formData.get('id');
            formData.delete('id');
            if( tradeId !== null ) {
                formData.set('trade_id', tradeId);
            }

            let files = inputEvent.target.files;

            let imageGallery = document.querySelectorAll('.image_gallery img');

            for (let file of files) {
                formData.append('images[]', file);
            }

            for(let [value, index] of formData.entries()) {
                console.log(value, index);
            }

            imageGallery.forEach((img) => {
                if (img && img.src) {
                    formData.append('existing_images[]', img.src);
                }
            });

            fetch('/upload-image', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': ThisApp.token,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success ==  true) {
                    console.log(data);
                    this.renderGallery('.image_gallery',data.images, data.trade_id);
                }
            });
        });
    }

    deleteScreenshots() {
        const ThisApp = this;
        document.addEventListener('click_', (e) => {

            const deleteBtn = e.target.closest('.screenshot-delete');
            if (!deleteBtn) return;

            const ssThumbBlock = deleteBtn.closest('.screenshot-thumb');
            const img = ssThumbBlock.querySelector('img');
            
            const trade_id = img.dataset.tid;

            fetch('/delete-image', {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': ThisApp.token
                },
                body: JSON.stringify({
                    screenshotURL: img.src,
                    trade_id
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    ssThumbBlock.remove();
                }
            });

        });

    }

    updateNotes(e) {
        const ThisApp = this;
        const notesForm = document.querySelector('#notesForm');
        const notesTextarea = document.querySelector('#journal_notes');
        const saveButton = document.querySelector('#save-notes');
        
        if (notesForm === null) {
            return;
        }

        notesTextarea.addEventListener('input', function (event) {
            const typedText = event.target.value;
            if (typedText.length > 0) {
                saveButton.classList.add('show');
            } else {
                saveButton.classList.remove('show');
            }
        });

        notesForm.addEventListener('submit', (e) => {
            
            this.journalNotesForm = e.target;

            e.preventDefault();

            const formData = new FormData(this.journalNotesForm);

            fetch('/save-notes', {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': ThisApp.token
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success == true) {
                    saveButton.classList.remove('show');
                }
            });
        
        });
    }
}