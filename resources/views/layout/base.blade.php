@php
    use Illuminate\Support\Facades\Route;
    $user = Auth::user();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" theme="{{ isset($user) && $user->theme_enabled != "" ? $user->theme_enabled : 'light' }}" data_user_id="{{isset($user) ? $user->id : false}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@php echo ucwords(Route::currentRouteName()); @endphp </title>

    <link rel="shortcut icon" href="{{ asset('imgs/favicon.ico') }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/modern-screenshot@4.5.0/dist/index.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    @fonts

    @php
    /*
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/output.css', 'resources/css/app.css', 'resources/js/app.js'])
    @endif
    */
    @endphp

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app-new.css', 'resources/css/output.css', 'resources/js/app.js'])
    @endif
</head>

<body class="{{ isset($user) ? 'logged-in' : 'not-logged-in' }} {{ Route::current() && Route::current()->uri() }}">


    <audio id="main_audio_player" style="display:none;"></audio>
    @if(isset($user))
        <div class="flex flex-col bg-primary lg:flex-row">
            @include('../components/header')
            
            <!-- <div class="dash_content"> -->
            <main class="min-w-0 min-h-svh flex-1 bg-secondary pt-8 px-4 lg:px-8 pb-12">
                @yield('content')
            </main>
            <!-- </div> -->
        </div>

        @include('../components/popups/add-trade')
        @include('../components/popups/coming-soon')
        @include('../components/popups/edit-trade')
        @include('../components/popups/confirm')
        @include('../components/popups/share-live')
        @include('../components/popups/custom-symbol')
        
    @else
        @yield('content')
    @endif
</body>

</html>