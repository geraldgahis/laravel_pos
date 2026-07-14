@php
    // Small local helper so each link's classes don't have to be repeated
    // four times below. request()->routeIs() supports wildcards like
    // 'products.*' to keep a parent link highlighted across its sub-pages.
    $linkClasses = fn(bool $active) => $active
        ? 'flex items-center gap-3 rounded-md bg-[#101828] px-3 py-2 text-sm font-medium text-white'
        : 'flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-[#374151] hover:bg-[#f9fafb] hover:text-[#101828]';
@endphp

<aside class="flex h-full w-64 flex-col border-r border-[#e5e7eb] bg-white">

    <div class="flex items-center gap-2 border-b border-[#e5e7eb] px-6 py-5">
        <div class="flex h-8 w-8 items-center justify-center rounded-md bg-[#101828] text-sm font-bold text-white">
            S
        </div>
        <span class="text-sm font-bold text-[#101828]">{{ config('app.name', 'Admin') }}</span>
    </div>

    <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-4">

        <div>
            <p class="px-3 text-[10px] font-semibold uppercase tracking-wider text-[#99a1af]">Overview</p>
            <div class="mt-1 space-y-0.5">
                <a href="{{ route('dashboard') }}" wire:navigate
                    class="{{ $linkClasses(request()->routeIs('dashboard')) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>

        <div>
            <p class="px-3 text-[10px] font-semibold uppercase tracking-wider text-[#99a1af]">Inventory</p>
            <div class="mt-1 space-y-0.5">
                <a href="{{ route('products.index') }}" wire:navigate
                    class="{{ $linkClasses(request()->routeIs('products.index') || request()->routeIs('products.show') || request()->routeIs('products.edit')) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    Products
                </a>
                <a href="{{ route('products.create') }}" wire:navigate
                    class="{{ $linkClasses(request()->routeIs('products.create')) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Scan / Add Product
                </a>
            </div>
        </div>

        <div>
            <p class="px-3 text-[10px] font-semibold uppercase tracking-wider text-[#99a1af]">Sales</p>
            <div class="mt-1 space-y-0.5">
                {{--
                    Assumes a named route 'pos.index' for the POS Terminal
                    component built earlier in this project. Adjust the
                    route name here if yours differs.
                --}}
                <a href="#" wire:navigate class="{{ $linkClasses(request()->routeIs('pos.*')) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                    </svg>
                    POS / Transactions
                </a>
            </div>
        </div>

        <div>
            <p class="px-3 text-[10px] font-semibold uppercase tracking-wider text-[#99a1af]">Insights</p>
            <div class="mt-1 space-y-0.5">
                {{-- Not built yet in this project — shown but not linked --}}
                <span
                    class="flex cursor-not-allowed items-center justify-between rounded-md px-3 py-2 text-sm text-[#99a1af]">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        Reports
                    </span>
                    <span class="rounded bg-[#f3f4f6] px-1.5 py-0.5 text-[10px] font-semibold uppercase">Soon</span>
                </span>
            </div>
        </div>

    </nav>

    <div class="border-t border-[#e5e7eb] p-4">
        <p class="text-xs text-[#99a1af]">Signed in</p>
        @auth
            <p class="truncate text-sm font-medium text-[#101828]">{{ auth()->user()->name }}</p>
        @endauth
    </div>

</aside>
