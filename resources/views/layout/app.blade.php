<!DOCTYPE html>
<html>
    @include ('layout.header')
    <body>
        <div id="wrapper">
            @include('layout.navbar')

            <div id="page-wrapper" class="gray-bg">
                @include('layout.infobar')
                @yield('content')
            </div>
        </div>
    </body>
    @include('layout.footer')
</html>