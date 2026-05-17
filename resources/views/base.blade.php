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

    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    @if(isset($user))
        @include('header')
        
        <div class="dash_content">
            @yield('content')
        </div>
        
        @include('popups/add-trade')
    @else
        <div class="main_section">
            <div class="container center">
                @yield('content')
            </div>
        </div>
    @endif
</body>

</html>