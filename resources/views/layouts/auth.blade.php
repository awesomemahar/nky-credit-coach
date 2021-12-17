<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.auth.head')
</head>

<body class="bg-default">
<!-- Main content -->
@include('includes.auth.header')
<div class="main-content">
    <!-- Page content -->
    @yield('content')
</div>
@include('includes.auth.script')
@yield('script')
</body>

</html>
