<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'TindaHub') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="h-full bg-gray-100 text-gray-900 font-sans antialiased overflow-hidden" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    <div class="flex h-full w-full relative overflow-hidden">

        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen && window.innerWidth < 1024" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 bg-gray-900/50 backdrop-blur-xs z-40 lg:hidden">
        </div>

        <!-- Vertical Sidebar Component -->
        <livewire:layouts.sidebar />

        <!-- Main Workspace (Right Side) -->
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">

            <!-- App Topbar Navbar -->
            <livewire:layouts.navbar />

            <!-- Scrollable Page Content Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-8 bg-gray-100 relative">
                <div class="max-w-7xl mx-auto w-full">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>
