<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'App') }}</title>

    {{-- Adjust to match your actual Vite entrypoints --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-[#f9fafb]">
    {{ $slot }}

    @livewireScripts
</body>

</html>
