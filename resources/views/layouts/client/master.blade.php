<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.client.head')
    @yield('head')
</head>
<body>

@include('includes.client.sidebar')
<div class="main-content" id="panel">
    @include('includes.client.header')
    @yield('content')
</div>
@include('includes.client.footer')
@include('includes.client.script')
@yield('script')
</body>
</html>
