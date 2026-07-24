<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return $this->redirect('/login', navigate: true);
    }
};
?>

<nav x-data="{ mobileMenuOpen: false, userDropdownOpen: false }" class="sticky top-0 z-30 bg-white/80 backdrop-blur border-b border-gray-200 w-full">
    <div
        class="@auth w-full px-4 sm:px-6 @else max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 @endauth h-16 flex items-center justify-between">

        @auth
            <!-- Left: Sidebar Toggler & Dynamic Page Title (Logged In) -->
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen" type="button"
                    class="lg:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-600 focus:outline-none transition-colors"
                    aria-label="Toggle Sidebar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <h1 class="text-lg font-extrabold text-gray-900 tracking-tight">
                    @php
                        $segment = request()->segment(1);
                        $pageTitle = $segment ? ucwords(str_replace('-', ' ', $segment)) : 'Dashboard';
                    @endphp
                    {{ $pageTitle }}
                </h1>
            </div>
        @else
            <!-- Left: TindaHub Brand Logo (Logged Out) -->
            <a href="{{ url('/') }}" wire:navigate
                class="flex items-center gap-2 font-extrabold text-lg tracking-tight text-gray-900 shrink-0">
                <span
                    class="inline-flex items-center justify-center w-10 h-10 bg-linear-to-br from-indigo-600 to-indigo-800 text-white rounded-xl shadow-sm">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7" />
                        <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8" />
                        <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4" />
                        <path d="M2 7h20" />
                        <path
                            d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7" />
                    </svg>
                </span>
                <span>Tinda<span class="text-indigo-600">Hub</span></span>
            </a>

            <!-- Center: Landing Page Nav Links (Desktop lg+ only) -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="#features"
                    class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition-colors">Features</a>
                <a href="#how-it-works"
                    class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition-colors">How It Works</a>
                <a href="#pricing"
                    class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition-colors">Pricing</a>
                <a href="#testimonials"
                    class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition-colors">Success Stories</a>
            </div>
        @endauth

        <div class="flex items-center gap-3">
            @auth
                <!-- Desktop & Tablet User Dropdown (Logged In) -->
                <div class="hidden md:flex items-center gap-3">
                    <div class="relative" @click.away="userDropdownOpen = false">
                        <button @click="userDropdownOpen = !userDropdownOpen" type="button"
                            class="flex items-center gap-2 py-1.5 px-3 rounded-xl hover:bg-gray-100 text-gray-800 text-sm font-bold transition-colors focus:outline-none cursor-pointer">
                            <span>{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-500 transition-transform duration-200"
                                :class="{ 'rotate-180': userDropdownOpen }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="userDropdownOpen" x-cloak x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-xl shadow-lg py-1.5 z-50">

                            <div class="px-4 py-2 border-b border-gray-100 mb-1">
                                <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-wider">Signed in as
                                </p>
                                <p class="text-xs font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                            </div>

                            <a href="{{ url('/dashboard') }}" wire:navigate @click="userDropdownOpen = false"
                                class="block px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                                Dashboard
                            </a>
                            <a href="{{ url('/settings') }}" wire:navigate @click="userDropdownOpen = false"
                                class="block px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                                Settings
                            </a>

                            <div class="pt-1 mt-1 border-t border-gray-100">
                                <button wire:click="logout" @click="userDropdownOpen = false"
                                    class="w-full text-left px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                    Sign Out
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Desktop Auth Actions (Logged Out - lg+ only) -->
                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ url('/login') }}" wire:navigate
                        class="px-4 py-2 text-sm font-bold rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                        Sign In
                    </a>
                    <a href="{{ url('/register') }}" wire:navigate
                        class="px-4 py-2 text-sm font-bold rounded-lg bg-indigo-600 text-white shadow-btn-indigo hover:shadow-hover-indigo hover:-translate-y-0.5 transition-all duration-200">
                        Get Started
                    </a>
                </div>
            @endauth

            <!-- Mobile & Tablet Hamburger Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                class="@auth md:hidden @else lg:hidden @endauth p-2 rounded-lg hover:bg-gray-100 text-gray-600 focus:outline-none transition-colors"
                aria-label="Toggle menu">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile & Tablet Dropdown Menu -->
    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="@auth md:hidden @else lg:hidden @endauth absolute w-full left-0 top-full border-b border-gray-200 bg-white px-4 pt-3 pb-5 space-y-2 shadow-lg">

        @auth
            <div class="px-3 py-2.5 bg-gray-50 rounded-xl border border-gray-100 mb-2">
                <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-wider">Signed in as</p>
                <p class="text-sm font-extrabold text-gray-900 truncate">{{ auth()->user()->name }}</p>
            </div>

            <a href="{{ url('/dashboard') }}" wire:navigate @click="mobileMenuOpen = false"
                class="block px-3 py-2 text-sm font-bold rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                Dashboard
            </a>
            <a href="{{ url('/settings') }}" wire:navigate @click="mobileMenuOpen = false"
                class="block px-3 py-2 text-sm font-bold rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                Settings
            </a>

            <div class="pt-2 border-t border-gray-100">
                <button wire:click="logout" @click="mobileMenuOpen = false"
                    class="w-full text-left px-3 py-2 text-sm font-bold rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                    Sign Out
                </button>
            </div>
        @else
            <!-- Landing Page Links (Mobile & Tablet) -->
            <div class="space-y-1 pb-2 border-b border-gray-100">
                <a href="#features" @click="mobileMenuOpen = false"
                    class="block px-3 py-2 text-sm font-bold rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">Features</a>
                <a href="#how-it-works" @click="mobileMenuOpen = false"
                    class="block px-3 py-2 text-sm font-bold rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">How
                    It Works</a>
                <a href="#pricing" @click="mobileMenuOpen = false"
                    class="block px-3 py-2 text-sm font-bold rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">Pricing</a>
                <a href="#testimonials" @click="mobileMenuOpen = false"
                    class="block px-3 py-2 text-sm font-bold rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">Success
                    Stories</a>
            </div>

            <div class="pt-2 space-y-2">
                <a href="{{ url('/login') }}" wire:navigate @click="mobileMenuOpen = false"
                    class="block w-full text-center px-4 py-2.5 text-sm font-bold rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    Sign In
                </a>
                <a href="{{ url('/register') }}" wire:navigate @click="mobileMenuOpen = false"
                    class="block w-full text-center px-4 py-2.5 text-sm font-bold rounded-lg bg-indigo-600 text-white shadow-btn-indigo">
                    Get Started
                </a>
            </div>
        @endauth
    </div>
</nav>
