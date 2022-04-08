<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ChartMander</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/app.js')}} " defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

    @livewireStyles

</head>
<body>

@include('layouts.nav')

@yield('content')

@livewireScripts
</body>
</html>

