@php
    use Illuminate\Support\Facades\Route;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@php echo ucwords(Route::currentRouteName()); @endphp </title>

    <link rel="shortcut icon" href="{{ asset('imgs/favicon.ico') }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @fonts


    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-[#f7f7f7] dark:bg-[#0a0a0a] text-[#1b1b18] h-dvh items-center lg:justify-center min-h-screen flex-col">

    @if(isset($user))
        <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
            type="button"
            class="text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base ms-3 mt-3 text-sm p-2 focus:outline-none inline-flex sm:hidden">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10" />
            </svg>
        </button>

        @include('header')

        <aside id="default-sidebar"
            class="fixed top-0  mt-16 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0"
            aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-gray-200">
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="/"
                            class="flex {{ request()->is('/') ? 'bg-gray-200' : '' }} rounded-lg items-center px-4 py-2 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                            <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z" />
                            </svg>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="/about"
                            class="flex {{ request()->is('about') ? 'bg-gray-200' : '' }} rounded-lg items-center px-4 py-2 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                            <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z" />
                            </svg>
                            <span class="ms-3">About</span>
                        </a>
                    </li>
                    <li>
                        <a href="/logout"
                            class="flex items-center px-4 py-2 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Sign Out</span>
                        </a>
                    </li>
                </ul>
                <div id="alert-additional-content-1"
                    class="rounded-2xl bg-blue-50 p-4 mb-4 text-sm text-blue-900 rounded-base bg-brand-softer border border-blue-200 mt-4"
                    role="alert">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 shrink-0 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                            </svg>
                            <span class="sr-only">Info</span>
                            <h3 class="font-medium">Beta version</h3>
                        </div>
                        <button type="button" data-dismiss-target="#alert-additional-content-1" aria-label="Close"
                            class="ms-auto -mx-1.5 -my-1.5 rounded focus:ring-2 focus:ring-brand-medium hover:bg-brand-soft inline-flex items-center justify-center h-8 w-8">
                            <span class="sr-only">Close</span>
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18 17.94 6M18 18 6.06 6"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-2 mb-4">
                        Preview the new Flowbite navigation! You can turn the new navigation off for a limited time in your
                        profile.
                    </div>
                    <button type="button"
                        class="inline-flex items-center  text-white bg-blue-700 hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-xl text-xs px-3 py-1.5 focus:outline-none">
                        Turn off now
                    </button>
                </div>
            </div>
        </aside>

        <div class="p-4 sm:ml-64">
            @yield('content')
        </div>
    @else
        <div class="h-full">
            <div class="mx-auto h-full max-w-full">
                @yield('content')
            </div>
        </div>
    @endif
</body>

</html>