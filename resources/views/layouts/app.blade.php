<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="bunny.net">
    <link href="bunny.net" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-black min-h-screen">
    <div>
        @include('layouts.navigation')

        @isset($header)
        <header>
            <div>
                {{ $header }}
            </div>
        </header>
        @endisset

        <main style="padding-top: 1.5rem;">
            <div class="w-full px-6">
                @include('flash::message')
            </div>

            {{ $slot }}
        </main>
    </div>
</body>

</html>