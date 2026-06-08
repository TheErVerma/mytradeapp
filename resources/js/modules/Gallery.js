import {Fancybox} from '@fancyapps/ui';
import "@fancyapps/ui/dist/fancybox/fancybox.css";

export default class Gallery {
    
    journalNotesForm = null;

    constructor() {
        this.deleteScreenshots();
        this.gallerySelector = '.image_gallery';
        this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        this.init();
    }

    init() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('#uploadBtn, #trade_screenshots')) {
                this.uploadScreenshots(e);
            }
        });
        Fancybox.bind("[data-fancybox]", {});
    }

    renderGallery(images, id) {
        let gallery = document.querySelector(this.gallerySelector);

        if (!gallery) {
            gallery = document.createElement('div');
            gallery.classList = 'image_gallery';
            document.querySelector('.screenshot-gallery').appendChild(gallery);
        }

        gallery.innerHTML = '';

        images.forEach((imgUrl) => {

            let item = document.createElement('div');
            item.classList.add('screenshot-thumb');

            item.innerHTML = `
                <img src="${imgUrl}" data-tid="${id}" />

                <div class="screenshot-actions">
                    <button class="screenshot-view" data-fancybox="gallery" data-src="${imgUrl}">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 83.78" style="enable-background:new 0 0 122.88 83.78" xml:space="preserve"><g><path d="M95.73,10.81c10.53,7.09,19.6,17.37,26.48,29.86l0.67,1.22l-0.67,1.21c-6.88,12.49-15.96,22.77-26.48,29.86 C85.46,79.88,73.8,83.78,61.44,83.78c-12.36,0-24.02-3.9-34.28-10.81C16.62,65.87,7.55,55.59,0.67,43.1L0,41.89l0.67-1.22 c6.88-12.49,15.95-22.77,26.48-29.86C37.42,3.9,49.08,0,61.44,0C73.8,0,85.45,3.9,95.73,10.81L95.73,10.81z M60.79,22.17l4.08,0.39 c-1.45,2.18-2.31,4.82-2.31,7.67c0,7.48,5.86,13.54,13.1,13.54c2.32,0,4.5-0.62,6.39-1.72c0.03,0.47,0.05,0.94,0.05,1.42 c0,11.77-9.54,21.31-21.31,21.31c-11.77,0-21.31-9.54-21.31-21.31C39.48,31.71,49.02,22.17,60.79,22.17L60.79,22.17L60.79,22.17z M109,41.89c-5.5-9.66-12.61-17.6-20.79-23.11c-8.05-5.42-17.15-8.48-26.77-8.48c-9.61,0-18.71,3.06-26.76,8.48 c-8.18,5.51-15.29,13.45-20.8,23.11c5.5,9.66,12.62,17.6,20.8,23.1c8.05,5.42,17.15,8.48,26.76,8.48c9.62,0,18.71-3.06,26.77-8.48 C96.39,59.49,103.5,51.55,109,41.89L109,41.89z"/></g></svg>
                    </button>
                    <button class="screenshot-delete">
                        <?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="109.484px" height="122.88px" viewBox="0 0 109.484 122.88" enable-background="new 0 0 109.484 122.88" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M2.347,9.633h38.297V3.76c0-2.068,1.689-3.76,3.76-3.76h21.144 c2.07,0,3.76,1.691,3.76,3.76v5.874h37.83c1.293,0,2.347,1.057,2.347,2.349v11.514H0V11.982C0,10.69,1.055,9.633,2.347,9.633 L2.347,9.633z M8.69,29.605h92.921c1.937,0,3.696,1.599,3.521,3.524l-7.864,86.229c-0.174,1.926-1.59,3.521-3.523,3.521h-77.3 c-1.934,0-3.352-1.592-3.524-3.521L5.166,33.129C4.994,31.197,6.751,29.605,8.69,29.605L8.69,29.605z M69.077,42.998h9.866v65.314 h-9.866V42.998L69.077,42.998z M30.072,42.998h9.867v65.314h-9.867V42.998L30.072,42.998z M49.572,42.998h9.869v65.314h-9.869 V42.998L49.572,42.998z"/></g></svg>
                    </button>
                </div>
            `;

            gallery.appendChild(item);
        });

        if (window.Fancybox) {
            Fancybox.bind("[data-fancybox='gallery']", {});
        }
    }

    uploadScreenshots(e) {
        let uploadInput = e.target;
        let form = document.getElementById('uploadForm');
        
        if( uploadInput === null ) {
            return;
        }
        // uploadInput.addEventListener('click', () => {
            console.log(uploadInput);
        // });
        if( e.target.matches('#uploadBtn') ) {
            const parent = e.target.parentElement;
            uploadInput = parent.querySelector('#imageInput');
            uploadInput.click();
            console.log(uploadInput);
        }
        // uploadBtn.addEventListener('click', () => {
        //     if (!form.matches('#uploadForm')) {
        //         return;
        //     }
        //     uploadInput.click();
        // }); 

        uploadInput.addEventListener('change', (e) => {

            let formData = new FormData(form);

            let files = e.target.files;

            let imageGallery = document.querySelectorAll('.image_gallery img');

            for (let file of files) {
                formData.append('images[]', file);
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
                    'X-CSRF-TOKEN': this.token,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success ==  true) {
                    this.renderGallery(data.images, data.trade_id);
                }
            });
        });
    }

    deleteScreenshots() {

        document.addEventListener('click', (e) => {

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
                    'X-CSRF-TOKEN': this.token
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
        const notesForm = document.querySelector('#notesForm');
        let deleteBtns = document.querySelector('.screenshot-delete');
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
                    'X-CSRF-TOKEN': this.token
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