<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts.guest')] #[Title('TindaHub — Smart POS & Inventory for Sari-Sari Stores')] class extends Component {
    // Landing page controller logic
};
?>

<div>

    <!-- ============================================================ -->
    <!-- HERO                                                          -->
    <!-- ============================================================ -->
    <div class="relative overflow-hidden bg-white py-16 lg:py-24">

        <!-- Background Soft Ambient Glow -->
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
            aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-indigo-100 to-indigo-50 opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">

                <!-- Left Column: Copy & CTAs -->
                <div class="lg:col-span-6 text-left space-y-6">

                    <div
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold shadow-xs">
                        <span class="flex h-2 w-2 rounded-full bg-indigo-600 animate-pulse"></span>
                        Built for Philippine Retail & Sari-Sari Stores
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 tracking-tight leading-[1.1]">
                        Manage your store inventory & sales with <span class="text-indigo-600">TindaHub</span>
                    </h1>

                    <p class="text-base sm:text-lg text-gray-600 font-medium leading-relaxed max-w-xl">
                        Streamline your daily checkouts, track stock levels in real time, and monitor store
                        profitability
                        from any device—all in one simple platform.
                    </p>

                    <div class="pt-2 flex flex-col sm:flex-row items-center gap-4">
                        <a href="/register" wire:navigate
                            class="w-full sm:w-auto px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base rounded-xl shadow-btn-indigo hover:shadow-hover-indigo hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                            Get Started Free
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        <a href="#how-it-works"
                            class="w-full sm:w-auto px-8 py-3.5 bg-white hover:bg-gray-50 text-gray-700 font-bold text-base rounded-xl border border-gray-200 transition-all duration-200 flex items-center justify-center">
                            See How It Works
                        </a>
                    </div>

                    <div class="pt-6 border-t border-gray-100 grid grid-cols-3 gap-4 max-w-md">
                        <div>
                            <p class="text-xl font-black text-gray-900">500+</p>
                            <p class="text-xs font-semibold text-gray-500">Active Stores</p>
                        </div>
                        <div>
                            <p class="text-xl font-black text-gray-900">₱2M+</p>
                            <p class="text-xs font-semibold text-gray-500">Sales Tracked</p>
                        </div>
                        <div>
                            <p class="text-xl font-black text-gray-900">99.9%</p>
                            <p class="text-xs font-semibold text-gray-500">Uptime</p>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Fanned Card-Stack Receipt Carousel -->
                <div class="lg:col-span-6 relative flex items-center justify-center py-20 lg:py-28">

                    <div
                        class="absolute inset-0 bg-linear-to-tr from-indigo-200/50 to-violet-100/50 rounded-3xl blur-3xl">
                    </div>

                    <div class="relative w-full max-w-md h-125 flex flex-col items-center justify-center"
                        x-data="{
                            activeIndex: 0,
                            receipts: [{
                                    id: '#TXN-8493',
                                    time: '10:42 AM',
                                    type: 'CASH',
                                    items: [
                                        { name: '1x Lucky Me Pancit Canton', price: '₱14.00' },
                                        { name: '2x Great Taste White Coffee', price: '₱24.00' },
                                        { name: '1x Silver Swan Soy Sauce', price: '₱35.00' },
                                        { name: '1x Kopiko Brown Coffee Mix', price: '₱12.00' },
                                        { name: '2x Fiesta Spag Sauce 200g', price: '₱48.00' }
                                    ],
                                    total: '₱133.00',
                                    barcode: '||| | |||| || |||||| | ||'
                                },
                                {
                                    id: '#TXN-8494',
                                    time: '10:45 AM',
                                    type: 'GCASH',
                                    items: [
                                        { name: '1x CDO Carne Norte 260g', price: '₱48.00' },
                                        { name: '3x Mega Sardines Red', price: '₱75.00' },
                                        { name: '1x San Mig Coffee Mix', price: '₱12.00' },
                                        { name: '2x Century Tuna Flakes', price: '₱44.00' },
                                        { name: '1x Champion Detergent Bar', price: '₱28.00' }
                                    ],
                                    total: '₱207.00',
                                    barcode: '|||| ||| | ||| ||||||| |'
                                },
                                {
                                    id: '#TXN-8495',
                                    time: '10:49 AM',
                                    type: 'CASH',
                                    items: [
                                        { name: '2x Bear Brand Powder 33g', price: '₱26.00' },
                                        { name: '1x Surf Detergent Powder', price: '₱38.00' },
                                        { name: '1x Safeguard Soap White', price: '₱34.00' },
                                        { name: '2x Palmolive Shampoo Sachet', price: '₱16.00' },
                                        { name: '1x Datu Puti Vinegar 350ml', price: '₱25.00' }
                                    ],
                                    total: '₱139.00',
                                    barcode: '|| |||| | |||||| | |||| |'
                                }
                            ],
                            init() {
                                setInterval(() => {
                                    this.activeIndex = (this.activeIndex + 1) % this.receipts.length;
                                }, 4000);
                            },
                            stackDepth(index) {
                                return (index - this.activeIndex + this.receipts.length) % this.receipts.length;
                            },
                            cardStyle(index) {
                                const depth = this.stackDepth(index);
                                const layers = [
                                    { y: 0, x: 0, rot: 0, scale: 1, opacity: 1, z: 30 },
                                    { y: -22, x: 34, rot: 7, scale: 0.94, opacity: 0.85, z: 20 },
                                    { y: -40, x: 62, rot: 13, scale: 0.88, opacity: 0.6, z: 10 },
                                ];
                                const l = layers[depth] ?? { y: -55, x: 84, rot: 18, scale: 0.82, opacity: 0, z: 0 };
                                return `transform: translate(${l.x}px, ${l.y}px) rotate(${l.rot}deg) scale(${l.scale}); opacity: ${l.opacity}; z-index: ${l.z};`;
                            }
                        }">

                        <div class="relative w-full max-w-70 sm:max-w-75 mx-auto h-112.5">

                            <template x-for="(receipt, index) in receipts" :key="receipt.id">
                                <div class="absolute inset-x-0 top-0 bg-white text-gray-900 p-6 rounded-2xl shadow-2xl border border-gray-200/90 flex flex-col justify-between origin-bottom-left transition-all duration-700 ease-out"
                                    :style="cardStyle(index)"
                                    :class="stackDepth(index) > 0 ? 'pointer-events-none' : ''" style="height: 430px;">

                                    <div>
                                        <div
                                            class="flex items-center justify-between pb-3 border-b border-dashed border-gray-200">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-7 h-7 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                                    ✓</div>
                                                <span
                                                    class="text-xs font-black uppercase tracking-wider text-indigo-600">TindaHub
                                                    POS</span>
                                            </div>
                                            <span class="text-xs font-mono font-semibold text-gray-400"
                                                x-text="receipt.time"></span>
                                        </div>

                                        <div
                                            class="py-2.5 flex items-center justify-between text-xs border-b border-gray-100">
                                            <span class="font-mono font-bold text-gray-900 text-sm"
                                                x-text="receipt.id"></span>
                                            <span
                                                class="px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 font-bold text-[11px]"
                                                x-text="receipt.type"></span>
                                        </div>

                                        <div
                                            class="py-3 space-y-1.5 text-xs sm:text-sm font-medium border-b border-dashed border-gray-200">
                                            <template x-for="item in receipt.items">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600 truncate pr-2" x-text="item.name"></span>
                                                    <span class="font-bold text-gray-900 shrink-0"
                                                        x-text="item.price"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="pt-2 flex justify-between items-center">
                                            <span class="text-xs font-extrabold uppercase text-gray-400">Total
                                                Paid</span>
                                            <span class="text-lg font-black text-indigo-600"
                                                x-text="receipt.total"></span>
                                        </div>
                                        <div class="mt-2.5 pt-2 text-center border-t border-gray-100">
                                            <p class="font-mono text-[10px] tracking-[0.4em] text-gray-400"
                                                x-text="receipt.barcode"></p>
                                        </div>
                                    </div>

                                </div>
                            </template>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- LOGO STRIP                                                     -->
    <!-- ============================================================ -->
    <div class="border-y border-gray-100 bg-gray-50/60 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-bold uppercase tracking-widest text-gray-400 mb-6">
                Trusted by sari-sari stores across the Philippines
            </p>
            <div
                class="flex flex-wrap items-center justify-center gap-x-10 gap-y-4 text-gray-300 font-black text-lg sm:text-xl tracking-tight">
                <span>Aling Nena's Store</span>
                <span>Kuya Jun Tindahan</span>
                <span>Bahay Kubo Sari-Sari</span>
                <span>Mang Ador Grocery</span>
                <span>Barangay 24 Store</span>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- FEATURES                                                       -->
    <!-- ============================================================ -->
    <section id="features" class="py-20 lg:py-28 bg-white scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-2xl mx-auto text-center mb-16">
                <span class="text-xs font-black uppercase tracking-widest text-indigo-600">Features</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">
                    Everything a tindahan actually needs
                </h2>
                <p class="mt-4 text-base sm:text-lg text-gray-600 font-medium">
                    Not a generic retail system with features you'll never touch — built around how sari-sari stores
                    really sell.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <div
                    class="p-6 rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-lg transition-all duration-200">
                    <div
                        class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6h.01M4 12h.01M4 18h.01M9 6h11M9 12h11M9 18h11" />
                        </svg>
                    </div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Barcode & Batch Scanning</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">Register a barcode for a single piece, a pack
                        of 6, or a full box separately — stock counts stay correct either way.</p>
                </div>

                <div
                    class="p-6 rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-lg transition-all duration-200">
                    <div
                        class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4m8-8v16" />
                        </svg>
                    </div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Tingi-Ready Inventory</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">Buy in bulk, sell per piece. Break down a
                        pack into individual units for retail without losing track of quantity.</p>
                </div>

                <div
                    class="p-6 rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-lg transition-all duration-200">
                    <div
                        class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Private Catalog Items</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">Add products only you can see, including
                        loose items with no barcode at all — cooking oil, sugar, tingi-tingi.</p>
                </div>

                <div
                    class="p-6 rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-lg transition-all duration-200">
                    <div
                        class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Real-Time Stock Alerts</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">Get notified before you run out of
                        fast-moving items, so you never turn away a customer at the counter.</p>
                </div>

                <div
                    class="p-6 rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-lg transition-all duration-200">
                    <div
                        class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Daily Sales Reports</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">See today's total, your margin, and your best
                        sellers at a glance — no spreadsheets to update.</p>
                </div>

                <div
                    class="p-6 rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-lg transition-all duration-200">
                    <div
                        class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                        </svg>
                    </div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Works on Any Device</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">Run the register from a phone behind the
                        counter, a tablet, or a desktop browser — no dedicated hardware needed.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- HOW IT WORKS                                                   -->
    <!-- ============================================================ -->
    <section id="how-it-works" class="py-20 lg:py-28 bg-gray-50 scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-2xl mx-auto text-center mb-16">
                <span class="text-xs font-black uppercase tracking-widest text-indigo-600">How It Works</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">
                    From scan to sale in three steps
                </h2>
            </div>

            <div class="grid sm:grid-cols-3 gap-8 relative">

                <div class="hidden sm:block absolute top-7 left-[16.5%] right-[16.5%] h-0.5 bg-indigo-100"></div>

                <div class="relative text-center">
                    <div
                        class="relative z-10 mx-auto w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-xl shadow-btn-indigo">
                        1</div>
                    <h3 class="mt-5 font-extrabold text-lg text-gray-900">Scan the barcode</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed max-w-xs mx-auto">Or pick it from your catalog
                        if it doesn't have one — loose items work too.</p>
                </div>

                <div class="relative text-center">
                    <div
                        class="relative z-10 mx-auto w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-xl shadow-btn-indigo">
                        2</div>
                    <h3 class="mt-5 font-extrabold text-lg text-gray-900">Set your price</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed max-w-xs mx-auto">Enter what you paid and what
                        you're selling it for — your margin shows up automatically.</p>
                </div>

                <div class="relative text-center">
                    <div
                        class="relative z-10 mx-auto w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-xl shadow-btn-indigo">
                        3</div>
                    <h3 class="mt-5 font-extrabold text-lg text-gray-900">Sell with confidence</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed max-w-xs mx-auto">Every sale updates your
                        stock and your day's total — no manual tallying at closing time.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- PRICING                                                        -->
    <!-- ============================================================ -->
    <section id="pricing" class="py-20 lg:py-28 bg-white scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-2xl mx-auto text-center mb-16">
                <span class="text-xs font-black uppercase tracking-widest text-indigo-600">Pricing</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">
                    Simple pricing, no surprises
                </h2>
                <p class="mt-4 text-base sm:text-lg text-gray-600 font-medium">
                    Start free. Upgrade only when your store outgrows it.
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-6 max-w-5xl mx-auto items-stretch">

                <!-- Starter -->
                <div class="p-8 rounded-2xl border border-gray-200 flex flex-col">
                    <h3 class="font-extrabold text-lg text-gray-900">Starter</h3>
                    <p class="mt-1 text-sm text-gray-500 font-medium">For a single-counter tindahan just getting
                        started.</p>
                    <p class="mt-6"><span class="text-4xl font-black text-gray-900">Free</span></p>
                    <ul class="mt-6 space-y-3 text-sm text-gray-600 flex-1">
                        <li class="flex items-start gap-2"><span class="text-indigo-600 font-bold">✓</span> 1 store
                            account</li>
                        <li class="flex items-start gap-2"><span class="text-indigo-600 font-bold">✓</span> Up to 100
                            products</li>
                        <li class="flex items-start gap-2"><span class="text-indigo-600 font-bold">✓</span> Barcode
                            scanning</li>
                        <li class="flex items-start gap-2"><span class="text-indigo-600 font-bold">✓</span> Basic
                            daily sales summary</li>
                    </ul>
                    <a href="/register" wire:navigate
                        class="mt-8 w-full text-center px-6 py-3 rounded-xl border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition-colors">
                        Get Started
                    </a>
                </div>

                <!-- Growth (highlighted) -->
                <div
                    class="p-8 rounded-2xl bg-indigo-600 text-white flex flex-col relative shadow-hover-indigo lg:-translate-y-2">
                    <span
                        class="absolute -top-3 left-8 px-3 py-1 rounded-full bg-white text-indigo-700 text-xs font-black uppercase tracking-wide">Most
                        Popular</span>
                    <h3 class="font-extrabold text-lg">Growth</h3>
                    <p class="mt-1 text-sm text-indigo-100 font-medium">For stores tracking real margins, batches, and
                        stock.</p>
                    <p class="mt-6"><span class="text-4xl font-black">₱299</span><span
                            class="text-indigo-200 font-semibold">/month</span></p>
                    <ul class="mt-6 space-y-3 text-sm text-indigo-50 flex-1">
                        <li class="flex items-start gap-2"><span class="font-bold">✓</span> Unlimited products</li>
                        <li class="flex items-start gap-2"><span class="font-bold">✓</span> Pack & piece unit
                            conversion</li>
                        <li class="flex items-start gap-2"><span class="font-bold">✓</span> Private/custom catalog
                            items</li>
                        <li class="flex items-start gap-2"><span class="font-bold">✓</span> Low-stock alerts</li>
                        <li class="flex items-start gap-2"><span class="font-bold">✓</span> Up to 3 staff accounts
                        </li>
                    </ul>
                    <a href="/register" wire:navigate
                        class="mt-8 w-full text-center px-6 py-3 rounded-xl bg-white text-indigo-700 font-bold hover:bg-indigo-50 transition-colors">
                        Start Free Trial
                    </a>
                </div>

                <!-- Enterprise -->
                <div class="p-8 rounded-2xl border border-gray-200 flex flex-col">
                    <h3 class="font-extrabold text-lg text-gray-900">Enterprise</h3>
                    <p class="mt-1 text-sm text-gray-500 font-medium">For multi-branch chains and cooperatives.</p>
                    <p class="mt-6"><span class="text-4xl font-black text-gray-900">Custom</span></p>
                    <ul class="mt-6 space-y-3 text-sm text-gray-600 flex-1">
                        <li class="flex items-start gap-2"><span class="text-indigo-600 font-bold">✓</span>
                            Multi-branch inventory</li>
                        <li class="flex items-start gap-2"><span class="text-indigo-600 font-bold">✓</span>
                            Centralized product catalog</li>
                        <li class="flex items-start gap-2"><span class="text-indigo-600 font-bold">✓</span> Priority
                            onboarding & support</li>
                        <li class="flex items-start gap-2"><span class="text-indigo-600 font-bold">✓</span> Custom
                            reporting</li>
                    </ul>
                    <a href="#" onclick="return false;"
                        class="mt-8 w-full text-center px-6 py-3 rounded-xl border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition-colors">
                        Contact Sales
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- TESTIMONIALS                                                   -->
    <!-- ============================================================ -->
    <section id="testimonials" class="py-20 lg:py-28 bg-gray-50 scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-2xl mx-auto text-center mb-16">
                <span class="text-xs font-black uppercase tracking-widest text-indigo-600">Success Stories</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">
                    Trusted by store owners like you
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="p-6 rounded-2xl bg-white border border-gray-100">
                    <p class="text-sm text-gray-700 leading-relaxed">"Alam ko na ngayon kung magkano talaga ang kita ko
                        sa bawat paninda. Dati, tinatantiya lang."</p>
                    <div class="mt-5 flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-sm">
                            AN</div>
                        <div>
                            <p class="font-extrabold text-gray-900 text-sm">Aling Nena</p>
                            <p class="text-xs text-gray-500">Store Owner, Bulacan</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-white border border-gray-100">
                    <p class="text-sm text-gray-700 leading-relaxed">"Yung tingi-tingi naming stock, kasama na sa
                        bilang. Hindi na ako nalilito sa dami ng paninda."</p>
                    <div class="mt-5 flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-sm">
                            MA</div>
                        <div>
                            <p class="font-extrabold text-gray-900 text-sm">Mang Ador</p>
                            <p class="text-xs text-gray-500">Store Owner, Cavite</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-white border border-gray-100">
                    <p class="text-sm text-gray-700 leading-relaxed">"Mabilis mag-checkout kahit pila ang customer.
                        Malaking tulong yung barcode scan sa mga pack ng noodles."</p>
                    <div class="mt-5 flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-sm">
                            KJ</div>
                        <div>
                            <p class="font-extrabold text-gray-900 text-sm">Kuya Jun</p>
                            <p class="text-xs text-gray-500">Store Owner, Laguna</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- FINAL CTA                                                      -->
    <!-- ============================================================ -->
    <section class="py-16 lg:py-20 bg-indigo-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                Ready to modernize your tindahan?
            </h2>
            <p class="mt-4 text-indigo-100 font-medium text-base sm:text-lg">
                Set up your store in under a minute — no credit card required.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/register" wire:navigate
                    class="w-full sm:w-auto px-8 py-3.5 bg-white hover:bg-indigo-50 text-indigo-700 font-bold text-base rounded-xl transition-all duration-200">
                    Get Started Free
                </a>
                <a href="/login" wire:navigate
                    class="w-full sm:w-auto px-8 py-3.5 text-white font-bold text-base rounded-xl border border-indigo-400 hover:bg-indigo-500 transition-all duration-200">
                    Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- FOOTER                                                         -->
    <!-- ============================================================ -->
    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <a href="{{ url('/') }}" wire:navigate
                    class="flex items-center gap-2 font-extrabold text-lg tracking-tight text-gray-900">
                    <span
                        class="inline-flex items-center justify-center w-9 h-9 bg-linear-to-br from-indigo-600 to-indigo-800 text-white rounded-xl">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7" />
                            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8" />
                        </svg>
                    </span>
                    <span>Tinda<span class="text-indigo-600">Hub</span></span>
                </a>

                <div
                    class="flex flex-wrap items-center justify-center gap-x-8 gap-y-2 text-sm font-semibold text-gray-500">
                    <a href="#features" class="hover:text-indigo-600 transition-colors">Features</a>
                    <a href="#how-it-works" class="hover:text-indigo-600 transition-colors">How It Works</a>
                    <a href="#pricing" class="hover:text-indigo-600 transition-colors">Pricing</a>
                    <a href="#testimonials" class="hover:text-indigo-600 transition-colors">Success Stories</a>
                </div>
            </div>

            <div
                class="mt-8 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-400 font-medium">
                <span>© {{ date('Y') }} TindaHub. All rights reserved.</span>
                <span>Made for Philippine sari-sari stores.</span>
            </div>
        </div>
    </footer>

</div>
