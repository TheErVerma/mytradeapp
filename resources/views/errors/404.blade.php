@extends('../layout/base')

@section('content')
    <section class="grid min-h-screen bg-primary py-16 md:pb-24 lg:px-20">
        <div
            class="mx-auto flex h-full w-full flex-col items-center justify-center gap-16 px-4 md:px-8 lg:flex-row lg:gap-8">

            <div class="flex w-full max-w-140 flex-col items-start gap-8 md:gap-12">

                <div class="flex flex-col gap-4 md:gap-6">
                    <div class="flex flex-col gap-3 md:gap-4">
                        <span class="w-max">
                            <span
                                class="size-max flex items-center whitespace-nowrap ring-1 ring-inset bg-primary text-secondary ring-primary shadow-xs gap-1.5 py-1 px-2.5 text-sm font-medium rounded-lg">
                                <svg width="8" height="8" viewBox="0 0 8 8" fill="none" class="text-utility-brand-500">
                                    <circle cx="4" cy="4" r="2.5" fill="currentColor" stroke="currentColor">
                                    </circle>
                                </svg>404 error</span>
                        </span>
                        <h1 class="text-display-md font-semibold text-primary md:text-display-lg lg:text-display-xl">
                            Page not found</h1>
                    </div>
                    <p class="max-w-lg text-lg text-tertiary md:text-xl">Sorry, the page you are looking for doesn't
                        exist. <br class="max-md:hidden"> Here are some helpful links:</p>
                </div>

                <div class="flex flex-col-reverse gap-3 self-stretch md:flex-row md:self-auto">

                    <button onclick="history.back()" type="button" class="btn btn-xl btn-secondary">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-icon="leading"
                            class="pointer-events-none size-5 shrink-0 transition-inherit-all">
                            <path d="M19 12H5m0 0 7 7m-7-7 7-7">

                            </path>
                        </svg>
                        <span data-text="true" class="transition-inherit-all px-0.5">Go
                            back</span>
</button>

                    <a href="/" class="btn btn-xl btn-primary">
                        <span data-text="true" class="transition-inherit-all px-0.5">Go
                            home</span>
                    </a>
                </div>

            </div>

            <div class="relative h-70 w-full md:h-110 lg:h-full lg:max-h-none">
                <img class="absolute inset-0 size-full object-cover"
                    src="https://images.pexels.com/photos/39068374/pexels-photo-39068374.jpeg" alt="Image for Split Mockup">
            </div>

        </div>

    </section>


@endsection