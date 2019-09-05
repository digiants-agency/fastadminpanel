<!DOCTYPE html>
<html lang="en">
    <head>
        @include('fastadminpanel.inc.head')
        @yield('head')
    </head>
    <body>
        <div id="app">
            @yield('content')
        </div>
        @yield('javascript')
    </body>
</html>