<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.admin.head')
    @yield('head')
</head>
<body>

@include('includes.admin.sidebar')
<div class="main-content" id="panel">
    @include('includes.admin.header')
    @yield('content')
</div>
@include('includes.admin.footer')
@include('includes.admin.script')
@yield('script')
</body>
</html>
