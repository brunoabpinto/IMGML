<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:300,400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <div class="flex h-screen">
        <livewire:home />
    </div>

    <footer class="fixed bottom-0 left-0 right-0 flex items-center justify-center p-4 text-white/50">
        <p class="font-light">Made with ❤️ by <a href="https://github.com/brunoabpinto" target="_blank">Bruno Pinto</a>
        </p>
    </footer>
</body>

</html>
