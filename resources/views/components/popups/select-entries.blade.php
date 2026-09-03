<div class="global-popup" data_identity="select-entries">
    <div class="global-popup__overlay"></div>
    <div class="global-popup__inner">
        <div class="global-popup__main">
            <div class="global-popup__body max-w-140 ">

                <button class="global-popup__close">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M17 7 7 17M7 7l10 10">
                        </path>
                    </svg>
                </button>

                <form action="" id="sync_broker_trades_form" >
                    @csrf
                    <div class="flex flex-col gap-4 px-4 pt-5 sm:px-6 sm:pt-6">
                        <div
                            class="relative flex shrink-0 items-center justify-center *:data-icon:size-5 bg-primary shadow-xs-skeuomorphic ring-1 ring-primary ring-inset size-10 rounded-lg text-fg-secondary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 12L9 12M21 6L9 6M21 18L9 18M5 12C5 12.5523 4.55228 13 4 13C3.44772 13 3 12.5523 3 12C3 11.4477 3.44772 11 4 11C4.55228 11 5 11.4477 5 12ZM5 6C5 6.55228 4.55228 7 4 7C3.44772 7 3 6.55228 3 6C3 5.44772 3.44772 5 4 5C4.55228 5 5 5.44772 5 6ZM5 18C5 18.5523 4.55228 19 4 19C3.44772 19 3 18.5523 3 18C3 17.4477 3.44772 17 4 17C4.55228 17 5 17.4477 5 18Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                        </div>
                        <div class="z-10 flex flex-col gap-0.5">
                            <p class="text-xl font-semibold text-primary">Select Trades</p>
                            <p class="text-sm text-tertiary">Selected trades will be added to your journal.</p>
                        </div>

                        <div class="flex flex-col gap-2 select-entries-rows_wrap">
                            <label
                                class="border border-secondary cursor-pointer flex flex-col gap-0.5 hover:bg-primary_hover p-4 rounded-xl z-10 hb-checkbox"
                                for="slctTrdEntry_1">
                                <div class="flex flex-row items-center gap-2">
                                    <span style="margin-top: 0px;">
                                        <input type="checkbox" id="slctTrdEntry_1" name="slctTrdEntry[]" value="">
                                    </span>
                                    <div class="text-md text-primary">Symbol Name</div>
                                </div>
                                <div class="text-sm text-fg-quaternary">Lorem, ipsum dolor sit amet consectetur
                                    adipisicing
                                    elit. Quis reiciendis tempora et voluptas doloremque minima aliquid.</div>
                            </label>
                            <label
                                class="border border-secondary cursor-pointer flex flex-col gap-0.5 hover:bg-primary_hover p-4 rounded-xl z-10 hb-checkbox"
                                for="slctTrdEntry_2">
                                <div class="flex flex-row items-center gap-2">
                                    <span style="margin-top: 0px;">
                                        <input type="checkbox" id="slctTrdEntry_2" name="slctTrdEntry[]" value="">
                                    </span>
                                    <div class="text-md text-primary">Symbol Name</div>
                                </div>
                                <div class="text-sm text-fg-quaternary">Lorem, ipsum dolor sit amet consectetur
                                    adipisicing
                                    elit. Quis reiciendis tempora et voluptas doloremque minima aliquid.</div>
                            </label>
                        </div>

                        <label
                            class="flex flex-col gap-0.5 hb-checkbox hover:bg-primary_hover rounded-xl z-10 mt-4"
                            for="dontshowagain">
                            <div class="flex flex-row items-center gap-2">
                                <span style="margin-top: 0px;">
                                    <input type="checkbox" id="dontshowagain" name="dontshowagain" value="yes">
                                </span>
                                <div class="text-sm text-secondary">Don't show this again.</div>
                            </div>
                        </label>
                    </div>

                    <div
                        class="confirm_actions z-10 flex flex-1 flex-col-reverse gap-3 p-4 pt-6 *:grow sm:grid sm:grid-cols-2 sm:px-6 sm:pt-8 sm:pb-6">
                        <button class="btn btn-md btn-secondary">
                            <span class="transition px-0.5">Cancel</span>
                        </button>
                        <button class="btn btn-md btn-primary" type="submit">
                            <span class="transition px-0.5">Sync Trades</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>