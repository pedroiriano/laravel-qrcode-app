<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('inc.meta')
    @yield('css')
</head>
<body class="nav-fixed">
    @auth
        @include('inc.backend-nav')
        <div id="layoutSidenav">
            @include('inc.backend-sidenav')
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
                @include('inc.backend-footer')
            </div>
        </div>
    @endauth

    @guest
        <script>history.back()</script>
    @endguest
</body>
@include('inc.bootstrap-bundle-js')
@include('inc.backend-js')
@yield('js')
</html>
