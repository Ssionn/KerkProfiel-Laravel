<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="author" content="{{ config('meta-tags.author') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ config('meta-tags.description') }}">

    <meta property="og:title" content="{{ config('meta-tags.title') }}">
    <meta property="og:description" content="{{ config('meta-tags.description') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('dashboard') }}">
    <meta property="og:site_name" content="{{ config('meta-tags.author') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <title>{{ config('meta-tags.title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>

<body class="flex bg-gray-100 font-poppins">
    <div x-data="{ open: false }" class="w-full">
        <x-navigation />

        <main class="p-6 transition-all duration-300" x-data :class="open ? 'ml-60' : 'ml-16'">
            {{ $slot }}
        </main>

        <x-notification-toast />
    </div>

    @push('scripts')
        <script src="{{ asset('js/filepond.js') }}" defer></script>
        <script src="{{ asset('js/modal.js') }}" defer></script>
        <script src="{{ asset('js/toast.js') }}" defer></script>
    @endpush
</body>

</html>
