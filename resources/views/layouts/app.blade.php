<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'Admin') }}</title>

    {{-- Adjust to match your actual Vite entrypoints --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-[#f9fafb]" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">

        {{-- Mobile off-canvas backdrop --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/40 lg:hidden">
        </div>

        {{-- Sidebar: fixed off-canvas on mobile, static in the flex row on lg+ --}}
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 transform transition-transform duration-200 ease-in-out lg:static lg:translate-x-0">
            <x-layouts.sidebar />
        </div>

        <div class="flex min-w-0 flex-1 flex-col">

            {{-- Topbar: only really needed for the mobile hamburger --}}
            <header class="flex items-center gap-3 border-b border-[#e5e7eb] bg-white px-4 py-3 lg:hidden">
                <button type="button" @click="sidebarOpen = true"
                    class="rounded-md p-2 text-[#374151] hover:bg-[#f9fafb]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                    </svg>
                </button>
                <span class="text-sm font-bold text-[#101828]">{{ $title ?? config('app.name', 'Admin') }}</span>
            </header>

            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>
