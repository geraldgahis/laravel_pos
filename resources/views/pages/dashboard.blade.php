<?php

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Dashboard')] class extends Component {
    public function with(): array
    {
        $totalProducts = Product::count();
        $lowStockCount = Product::where('quantity', '<=', 5)->count();
        $noBarcodeCount = Product::whereNull('barcode')->count();

        // Inventory value at cost — falls back to selling price if a
        // product has no cost_price recorded yet.
        $inventoryValue = Product::query()->selectRaw('SUM(quantity * COALESCE(cost_price, selling_price, 0)) as value')->value('value') ?? 0;

        $recentProducts = Product::latest()->take(5)->get();
        $lowStockProducts = Product::where('quantity', '<=', 5)->orderBy('quantity')->take(5)->get();

        return compact('totalProducts', 'lowStockCount', 'noBarcodeCount', 'inventoryValue', 'recentProducts', 'lowStockProducts');
    }
};
?>

<div class="space-y-6 p-6">
    <div>
        <h1 class="text-xl font-bold text-[#101828]">Dashboard</h1>
        <p class="text-sm text-[#6a7282]">Overview of your store</p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border border-[#e5e7eb] bg-white p-5">
            <p class="text-xs font-medium text-[#6a7282]">Total Products</p>
            <p class="mt-1 text-2xl font-bold text-[#101828]">{{ $totalProducts }}</p>
        </div>

        <div class="rounded-lg border border-[#e5e7eb] bg-white p-5">
            <p class="text-xs font-medium text-[#6a7282]">Low Stock Items</p>
            <p class="mt-1 text-2xl font-bold {{ $lowStockCount > 0 ? 'text-amber-600' : 'text-[#101828]' }}">
                {{ $lowStockCount }}
            </p>
        </div>

        <div class="rounded-lg border border-[#e5e7eb] bg-white p-5">
            <p class="text-xs font-medium text-[#6a7282]">Inventory Value</p>
            <p class="mt-1 text-2xl font-bold text-[#101828]">₱{{ number_format($inventoryValue, 2) }}</p>
        </div>

        <div class="rounded-lg border border-[#e5e7eb] bg-white p-5">
            <p class="text-xs font-medium text-[#6a7282]">Tingi-tingi (no barcode)</p>
            <p class="mt-1 text-2xl font-bold text-[#101828]">{{ $noBarcodeCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        <div class="rounded-lg border border-[#e5e7eb] bg-white p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-sm font-bold text-[#101828]">Recently Added</h2>
                <a href="{{ route('products.index') }}" wire:navigate
                    class="text-xs font-medium text-[#374151] hover:text-[#101828]">
                    View all →
                </a>
            </div>
            <div class="divide-y divide-[#e5e7eb]">
                @forelse ($recentProducts as $product)
                    <div class="flex items-center justify-between py-2.5">
                        <div>
                            <a href="{{ route('products.show', $product) }}" wire:navigate
                                class="text-sm font-medium text-[#101828] hover:underline">
                                {{ $product->name }}
                            </a>
                            <p class="text-xs text-[#6a7282]">{{ $product->barcode ?? 'No barcode' }}</p>
                        </div>
                        <span class="text-sm font-semibold text-[#101828]">
                            ₱{{ number_format($product->selling_price, 2) }}
                        </span>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-[#99a1af]">No products yet.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-lg border border-[#e5e7eb] bg-white p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-sm font-bold text-[#101828]">Low Stock</h2>
                <span class="text-xs text-[#6a7282]">≤ 5 units</span>
            </div>
            <div class="divide-y divide-[#e5e7eb]">
                @forelse ($lowStockProducts as $product)
                    <div class="flex items-center justify-between py-2.5">
                        <a href="{{ route('products.show', $product) }}" wire:navigate
                            class="text-sm font-medium text-[#101828] hover:underline">
                            {{ $product->name }}
                        </a>
                        <span class="text-sm font-semibold text-amber-600">
                            {{ rtrim(rtrim(number_format($product->quantity, 2), '0'), '.') }} {{ $product->unit }}
                        </span>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-[#99a1af]">Nothing low on stock. 🎉</p>
                @endforelse
            </div>
        </div>

    </div>

    <div class="rounded-lg border border-dashed border-[#d1d5dc] bg-[#f9fafb] p-5 text-sm text-[#6a7282]">
        Transaction and report summaries will appear here once those modules are built.
    </div>
</div>
