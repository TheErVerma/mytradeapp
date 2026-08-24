@php /*
<div class="main_popup" data_identity="confirm-pop">
    <div class="main_popup_inner">
        <div class="main_pop_content">
            <h2>Confirmation</h2>
            <div class="confirmation_message"></div>
            <div class="confirm_actions">
                <button type="button" class="btn btn-md btn-primary">Confirm</button>
                <button type="button" class="btn btn-md btn-secondary">Cancel</button>
            </div>
        </div>
    </div>
</div> */ @endphp

 <div class="global-popup" data_identity="confirm-pop">
        <div class="global-popup__overlay"></div>
        <div class="global-popup__inner">
            <div class="global-popup__main">
                <div class="global-popup__body max-w-100 ">

                    <button class="global-popup__close">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17 7 7 17M7 7l10 10">
                            </path>
                        </svg>
                    </button>

                    <div class="flex flex-col gap-4 px-4 pt-5 sm:px-6 sm:pt-6">
                        <div class="relative flex shrink-0 items-center justify-center *:data-icon:size-5 bg-primary shadow-xs-skeuomorphic ring-1 ring-primary ring-inset size-10 rounded-lg text-fg-secondary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="z-1"
                                xmlns="http://www.w3.org/2000/svg" data-icon="true">
                                <path
                                    d="M6 17C6 17.93 6 18.395 6.10222 18.7765C6.37962 19.8117 7.18827 20.6204 8.22354 20.8978C8.60504 21 9.07003 21 10 21H16.2C17.8802 21 18.7202 21 19.362 20.673C19.9265 20.3854 20.3854 19.9265 20.673 19.362C21 18.7202 21 17.8802 21 16.2V7.8C21 6.11984 21 5.27976 20.673 4.63803C20.3854 4.07354 19.9265 3.6146 19.362 3.32698C18.7202 3 17.8802 3 16.2 3H10C9.07003 3 8.60504 3 8.22354 3.10222C7.18827 3.37962 6.37962 4.18827 6.10222 5.22354C6 5.60504 6 6.07003 6 7M12 8L16 12M16 12L12 16M16 12H3"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="z-10 flex flex-col gap-0.5">
                            <p class="text-xl font-semibold text-primary">Confirmation</p>
                            <p class="text-sm text-tertiary confirmation_message">Are you sure? do you want to logout?</p>
                        </div>
                    </div>

                    <div
                        class="confirm_actions z-10 flex flex-1 flex-col-reverse gap-3 p-4 pt-6 *:grow sm:grid sm:grid-cols-2 sm:px-6 sm:pt-8 sm:pb-6">
                        <button class="btn btn-md btn-secondary">
                            <span class="transition px-0.5">Cancel</span>
                        </button>
                        <button class="btn btn-md btn-primary">
                            <span class="transition px-0.5">Confirm</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>