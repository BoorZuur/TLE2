<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NMklikker') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="text-black antialiased">

@include('layouts.menu')
@isset($header)
    <header class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $header }}</h1>
    </header>
@endisset

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{ $slot }}
</main>
</body>
</html>
