<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    @yield('title')
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{asset('css/dashlite.css?ver=2.9.0')}}">
    <link rel="stylesheet" href="{{asset('css/theme.css')}}">
    <script src="{{asset('js/jquery.js')}}"></script>
    <!-- DevExtreme themes -->
    <link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/17.2.18/css/dx.common.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/17.2.18/css/dx.light.css" />

    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/17.2.18/js/dx.all.js"></script>
</head>

@if(strpos(URL::current(), 'login') || strpos(URL::current(), 'register') || strpos(URL::current(), 'login') || strpos(URL::current(), 'reset'))

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <div class="nk-main">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @else

    <body class="nk-body bg-lighter npc-general has-sidebar ">
        <div class="nk-app-root">
            <div class="nk-main">
                @include('pages.sidebar')
                <div class="nk-wrap ">
                    @include('pages.header') <div class="nk-content ">
                        @yield('content')
                    </div>
                    @include('pages.footer')
                </div>
            </div>
        </div>
        @endif
        <script src="{{asset('js/bundle.js?ver=2.9.0')}}"></script>
        <script src="{{asset('js/scripts.js?ver=2.9.0')}}"></script>
        <script src="{{asset('js/charts/gd-default.js?ver=2.9.0')}}"></script>
        @yield('scripts')
    </body>

</html>