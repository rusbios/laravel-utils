<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="author" content="RusBIOS">
    <link rel="author" href="https://rusbios.ru">
    <meta name="robots" content="NOINDEX,FOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('head.title') }}</title>
    <meta name="description" content="{{ config('head.description') }}">

    <meta property="og:image" content="https://biosdv.ru/img/logo.png">
    <link rel="icon" sizes="16x16" href="https://biosdv.ru/img/icons/favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="https://biosdv.ru/img/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="https://biosdv.ru/img/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="https://biosdv.ru/img/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://biosdv.ru/img/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="https://biosdv.ru/img/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://biosdv.ru/img/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="https://biosdv.ru/img/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://biosdv.ru/img/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://biosdv.ru/img/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="https://biosdv.ru/img/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://biosdv.ru/img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="https://biosdv.ru/img/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://biosdv.ru/img/icons/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#cccccc">
    <meta name="msapplication-TileImage" content="https://biosdv.ru/img/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#cccccc">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    @yield('head')
</head>
<body>
<div id="admin" class="container-fluid">
    <div class="row">
        <div class="col-2">
            @include('rb_admin::menu')
        </div>
        <div class="col-10">
            @yield('body')
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/ebdfec647e.js" crossorigin="anonymous"></script>
@yield('footer')
</body>
</html>
