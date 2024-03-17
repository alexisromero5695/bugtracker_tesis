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
    <title>Sales Dashboard | DashLite Admin Template</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('css/dashlite.css?ver=2.9.0') }}">
    <link id="skin-default" rel="stylesheet" href="{{asset('css/theme-bluelite.css?ver=2.9.1')}}">

</head>

<body class="nk-body bg-white npc-general pg-auth ">
    <div class="nk-app-root">
        <div class="nk-main">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/bundle.js?ver=2.9.0')}}"></script>
    <script src="{{asset('js/scripts.js?ver=2.9.0')}}"></script>
    <script src="{{asset('js/charts/gd-default.js?ver=2.9.0')}}"></script>
    @yield('scripts')

</body>

</html>