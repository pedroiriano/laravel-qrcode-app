<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('inc.meta')
    @yield('css')
</head>
<body>
    <div id="layoutDefault">
        <div id="layoutDefault_content">
            <main>
                @include('inc.frontend-nav')
                @yield('content')
            </main>
        </div>
        @include('inc.frontend-footer')
    </div>
</body>
@include('inc.bootstrap-bundle-js')
@include('inc.frontend-js')
</html>
