<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NMklikker') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body {
            height: 100vh;
            max-height: 100vh;
            overflow-y: auto;
        }
    </style>
</head>
<body class="text-black antialiased h-screen max-h-screen overflow-y-auto">

@include('layouts.menu')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{ $slot }}
</main>
</body>
</html>
