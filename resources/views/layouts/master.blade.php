<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="GobyArt">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="assets/admin/_con/images/icon.png">

    <title></title>

    @include('partials.head')

</head>

<body >

    @yield('header')

    @yield('content')

    @yield('footer')

    @include('partials.foot')

    @yield('scripts')

</body>
</html>
