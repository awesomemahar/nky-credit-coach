<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.business.head')
    @yield('head')
</head>
<body>

@include('includes.business.sidebar')
<div class="main-content" id="panel">
    @include('includes.business.header')
    @yield('content')
</div>
@include('includes.business.footer')
@include('includes.business.script')
@yield('script')
</body>
</html>
