<?php

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Product Details')] class extends Component {
    // Route model binding: resolves via {product} in the route using the
    // model's primary key (id), same as the edit page.
    public Product $product;

    public function mount(Product $product): void
    {
        $this->product = $product;
    }

    public function delete()
    {
        $name = $this->product->name;

        // Soft delete — row stays for referential integrity with past
        // order/transaction records, just hidden from normal queries.
        $this->product->delete();

        return redirect()
            ->route('products.index')
            ->with('status', "\"{$name}\" was deleted.");
    }
};
?>

<div class="max-w-2xl p-6 mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('products.index') }}" wire:navigate
            class="text-sm text-[#6a7282] hover:text-[#101828] transition-colors">
            ← Back to Products
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('products.edit', $product) }}" wire:navigate
                class="rounded-md border border-[#e5e7eb] px-4 py-2 text-sm font-medium text-[#374151] hover:bg-[#f9fafb] transition-colors">
                Edit
            </a>
            <button type="button" wire:click="delete"
                wire:confirm="Are you sure you want to delete this product? This can be restored later if needed."
                class="rounded-md border border-red-200 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                Delete
            </button>
        </div>
    </div>

    <div class="space-y-6 rounded-lg border border-[#e5e7eb] bg-white p-6">
        <div class="flex items-start gap-6">
            @if ($product->image_url)
                <img src="{{ $product->image_url }}" class="h-32 w-32 rounded-md border border-[#e5e7eb] object-cover">
            @else
                <div
                    class="flex h-32 w-32 items-center justify-center rounded-md border border-dashed border-[#d1d5dc] bg-[#f9fafb] text-[#99a1af]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0A2.25 2.25 0 015.25 6h13.5A2.25 2.25 0 0121 8.25m-18 0v.243a2.25 2.25 0 00.659 1.591l.5.5m16.591-2.334a2.25 2.25 0 01-.659 1.591l-.5.5M21 8.25v.243a2.25 2.25 0 01-.659 1.591l-.5.5M9 12.75a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                    </svg>
                </div>
            @endif

            <div class="flex-1 space-y-1">
                <h2 class="text-xl font-bold text-[#101828]">{{ $product->name }}</h2>

                @if ($product->barcode)
                    <p class="font-mono text-sm text-[#6a7282]">Barcode: {{ $product->barcode }}</p>
                @else
                    <p class="text-sm italic text-[#99a1af]">No barcode (tingi-tingi / own product)</p>
                @endif

                @if ($product->description)
                    <p class="mt-2 text-sm text-[#374151]">{{ $product->description }}</p>
                @endif

                @if ($product->quantity <= 5)
                    <span
                        class="mt-2 inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-semibold text-amber-700">
                        Low stock
                    </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 border-t border-[#e5e7eb] pt-4">
            <div>
                <p class="text-xs font-medium text-[#6a7282]">Quantity</p>
                <p class="text-lg font-bold text-[#101828]">
                    {{ rtrim(rtrim(number_format($product->quantity, 2), '0'), '.') }} {{ $product->unit }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium text-[#6a7282]">Cost Price</p>
                <p class="text-lg font-bold text-[#101828]">
                    {{ $product->cost_price !== null ? '₱' . number_format($product->cost_price, 2) : '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium text-[#6a7282]">Selling Price</p>
                <p class="text-lg font-bold text-[#101828]">₱{{ number_format($product->selling_price, 2) }}</p>
            </div>
        </div>
    </div>
</div>
