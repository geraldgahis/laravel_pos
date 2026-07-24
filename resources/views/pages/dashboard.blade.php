<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts.app')] #[Title('Dashboard — TindaHub')] class extends Component {
    // You can declare public properties or fetch live database metrics here later
};
?>

<div class="space-y-6 pb-12">

    <!-- Welcome Banner / Quick Actions Header -->
    <div
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white border border-gray-200 rounded-2xl p-6 shadow-xs">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Store Overview</h1>
            <p class="text-sm text-gray-500 mt-0.5">Here is what’s happening in your store today,
                {{ auth()->user()->name ?? 'Merchant' }}.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="/pos" wire:navigate
                class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-btn-indigo hover:shadow-hover-indigo transition-all duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                New Sale (POS)
            </a>
        </div>
    </div>

    <!-- KPI Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <!-- Card 1: Today's Sales -->
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Today's Sales</p>
                <h3 class="text-2xl font-black text-gray-900 mt-1">₱ 4,850.00</h3>
                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 mt-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    +12.5% vs yesterday
                </span>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Card 2: Estimated Profit -->
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Est. Profit</p>
                <h3 class="text-2xl font-black text-gray-900 mt-1">₱ 1,120.50</h3>
                <span class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 mt-2">
                    Estimated margins
                </span>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
        </div>

        <!-- Card 3: Total Transactions -->
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Transactions</p>
                <h3 class="text-2xl font-black text-gray-900 mt-1">38</h3>
                <span class="inline-flex items-center gap-1 text-xs font-semibold text-gray-500 mt-2">
                    Completed checkouts
                </span>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
        </div>

        <!-- Card 4: Low Stock Warnings -->
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Low Stock Items</p>
                <h3 class="text-2xl font-black text-amber-600 mt-1">4 Items</h3>
                <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 mt-2">
                    Requires restock
                </span>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Lower Section Grid: Transactions & Stock Alerts -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- Recent Transactions Table (Spans 2 columns on XL screens) -->
        <div
            class="xl:col-span-2 bg-white border border-gray-200 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-base text-gray-900">Recent Transactions</h3>
                    <p class="text-xs text-gray-500">Latest sales processed through your register</p>
                </div>
                <a href="/transactions" wire:navigate
                    class="text-xs font-bold text-indigo-600 hover:text-indigo-700 hover:underline">View All →</a>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr
                            class="border-b border-gray-100 text-gray-400 uppercase text-[10px] font-extrabold tracking-wider">
                            <th class="pb-3 pr-4">Reference ID</th>
                            <th class="pb-3 pr-4">Time</th>
                            <th class="pb-3 pr-4">Payment Method</th>
                            <th class="pb-3 text-right">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-600 font-medium">
                        <tr>
                            <td class="py-3.5 pr-4 font-mono text-xs font-bold text-gray-900">#TXN-8492</td>
                            <td class="py-3.5 pr-4 text-xs text-gray-500">10:42 AM</td>
                            <td class="py-3.5 pr-4">
                                <span
                                    class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold tracking-wide">CASH</span>
                            </td>
                            <td class="py-3.5 text-right font-bold text-gray-900">₱ 145.00</td>
                        </tr>
                        <tr>
                            <td class="py-3.5 pr-4 font-mono text-xs font-bold text-gray-900">#TXN-8491</td>
                            <td class="py-3.5 pr-4 text-xs text-gray-500">10:28 AM</td>
                            <td class="py-3.5 pr-4">
                                <span
                                    class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold tracking-wide">GCASH</span>
                            </td>
                            <td class="py-3.5 text-right font-bold text-gray-900">₱ 320.00</td>
                        </tr>
                        <tr>
                            <td class="py-3.5 pr-4 font-mono text-xs font-bold text-gray-900">#TXN-8490</td>
                            <td class="py-3.5 pr-4 text-xs text-gray-500">09:55 AM</td>
                            <td class="py-3.5 pr-4">
                                <span
                                    class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold tracking-wide">CASH</span>
                            </td>
                            <td class="py-3.5 text-right font-bold text-gray-900">₱ 65.50</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Stock Attention Widget -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
            <div class="mb-4">
                <h3 class="font-bold text-base text-gray-900">Inventory Alert</h3>
                <p class="text-xs text-gray-500">Items running low on stock</p>
            </div>

            <div class="space-y-3 flex-1">
                <div class="flex items-center justify-between p-3 rounded-xl bg-amber-50/50 border border-amber-100">
                    <div class="min-w-0 flex-1 pr-3">
                        <p class="text-xs font-bold text-gray-900 truncate">Lucky Me Pancit Canton</p>
                        <p class="text-[10px] font-medium text-gray-500 truncate">Barcode: 480001664112</p>
                    </div>
                    <span class="text-xs font-extrabold text-amber-600 bg-amber-100 px-2.5 py-1 rounded-lg shrink-0">3
                        pcs left</span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="min-w-0 flex-1 pr-3">
                        <p class="text-xs font-bold text-gray-900 truncate">Silver Swan Soy Sauce (350ml)</p>
                        <p class="text-[10px] font-medium text-gray-500 truncate">Barcode: 480001123456</p>
                    </div>
                    <span class="text-xs font-extrabold text-amber-600 bg-amber-100 px-2.5 py-1 rounded-lg shrink-0">2
                        pcs left</span>
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-gray-100">
                <a href="/inventory" wire:navigate
                    class="w-full py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 font-bold text-xs rounded-xl border border-gray-200 transition-colors flex items-center justify-center gap-2">
                    Manage Inventory
                </a>
            </div>
        </div>

    </div>
</div>
