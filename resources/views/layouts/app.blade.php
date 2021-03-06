<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(auth()->check())
        <meta name="user-token" content="{{ auth()->user()->token}}">
    @endif

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body id="@yield('bodyId')">

<div id="app">

    <div class="container">

        @yield('content')

    </div> {{-- div.container --}}

</div> {{-- div#app --}}

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

@stack('scripts')
</body>
</html>
