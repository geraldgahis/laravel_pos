<?php

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Title('Products')] class extends Component {
    use WithPagination;

    #[Url]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $productId): void
    {
        $product = Product::findOrFail($productId);
        $name = $product->name;

        // Soft delete — row stays for referential integrity with past
        // order/transaction records, just hidden from normal queries.
        $product->delete();

        session()->flash('status', "\"{$name}\" was deleted.");
    }

    public function with(): array
    {
        return [
            'products' => Product::query()
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', "%{$this->search}%")->orWhere('barcode', 'like', "%{$this->search}%");
                    });
                })
                ->latest()
                ->paginate(12),
        ];
    }
};
?>

<div class="max-w-7xl p-6 mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-[#101828]">Products</h2>
            <p class="text-xs text-[#6a7282]">Manage your product catalog</p>
        </div>
        <a href="{{ route('products.create') }}" wire:navigate
            class="rounded-md bg-[#101828] px-4 py-2 text-sm font-semibold text-white hover:bg-[#1e2939] transition-colors">
            + Add Product
        </a>
    </div>

    @if (session('status'))
        <div class="rounded-md bg-green-50 p-4 text-sm font-medium text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="relative">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name or barcode..."
            class="block w-full rounded-md border-0 py-2.5 px-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm">
    </div>

    <div class="overflow-hidden rounded-lg border border-[#e5e7eb] bg-white">
        <table class="min-w-full divide-y divide-[#e5e7eb]">
            <thead class="bg-[#f9fafb]">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-[#6a7282]">Product</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-[#6a7282]">Barcode</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-[#6a7282]">Quantity</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-[#6a7282]">Price</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#e5e7eb]">
                @forelse ($products as $product)
                    <tr wire:key="product-{{ $product->id }}" class="hover:bg-[#f9fafb]">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}"
                                        class="h-10 w-10 rounded-md border border-[#e5e7eb] object-cover">
                                @else
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-md border border-dashed border-[#d1d5dc] bg-[#f9fafb] text-[#99a1af]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0A2.25 2.25 0 015.25 6h13.5A2.25 2.25 0 0121 8.25m-18 0v.243a2.25 2.25 0 00.659 1.591l.5.5m16.591-2.334a2.25 2.25 0 01-.659 1.591l-.5.5M21 8.25v.243a2.25 2.25 0 01-.659 1.591l-.5.5M9 12.75a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('products.show', $product) }}" wire:navigate
                                        class="text-sm font-semibold text-[#101828] hover:underline">
                                        {{ $product->name }}
                                    </a>
                                    @if ($product->quantity <= 5)
                                        <span
                                            class="ml-2 inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-700">
                                            Low stock
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-[#6a7282]">
                            {{ $product->barcode ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-right text-sm text-[#101828]">
                            {{ rtrim(rtrim(number_format($product->quantity, 2), '0'), '.') }} {{ $product->unit }}
                        </td>
                        <td class="px-4 py-3 text-right text-sm font-semibold text-[#101828]">
                            ₱{{ number_format($product->selling_price, 2) }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('products.edit', $product) }}" wire:navigate
                                    class="text-sm font-medium text-[#374151] hover:text-[#101828]">
                                    Edit
                                </a>
                                <button type="button" wire:click="delete({{ $product->id }})"
                                    wire:confirm="Are you sure you want to delete this product?"
                                    class="text-sm font-medium text-red-600 hover:text-red-800">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-sm text-[#99a1af]">
                            @if ($search)
                                No products match "{{ $search }}".
                            @else
                                No products yet.
                                <a href="{{ route('products.create') }}" wire:navigate
                                    class="text-[#101828] underline">Add your first one</a>.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $products->links() }}
    </div>
</div>
