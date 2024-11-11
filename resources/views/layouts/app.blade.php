<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <title>KerkProfiel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex bg-gray-100 font-poppins">
    <div x-data="{ open: false }" class="w-full">
        <x-navigation />

        <main class="flex-1 p-6" x-data :class="open ? 'ml-60' : 'ml-16'" class="transition-all duration-300">
            {{ $slot }}
        </main>
    </div>

    <x-notification-toast />

    @if (env('APP_ENV') === 'local')
        <div class="fixed bottom-0 right-0 p-2 bg-red-400 text-red-800 rounded-tl-md">
            <p class="text-sm font-bold">
                {{ __('This is a local environment') }}
            </p>
        </div>
    @endif
</body>

</html>
