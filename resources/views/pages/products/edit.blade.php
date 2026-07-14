<?php

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Edit Product')] class extends Component {
    use WithFileUploads;

    // Route model binding: Livewire resolves this from {product} in the
    // route using the model's primary key (id), not the barcode.
    public Product $product;

    public string $barcode = '';
    public string $name = '';
    public string $description = '';
    public $quantity = 0;
    public $selling_price = 0;
    public $cost_price = 0;
    public string $unit = 'pcs';

    // Temporary uploaded file, if the user picks a replacement image
    public $imageUpload = null;
    // Ticked if the user wants to clear the existing image without
    // uploading a new one
    public bool $removeImage = false;

    public string $statusMessage = '';
    public string $statusType = '';

    public function mount(Product $product): void
    {
        $this->product = $product;

        $this->barcode = $product->barcode ?? '';
        $this->name = $product->name;
        $this->description = $product->description ?? '';
        $this->quantity = $product->quantity;
        $this->selling_price = $product->selling_price;
        $this->cost_price = $product->cost_price ?? 0;
        $this->unit = $product->unit;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'barcode' => ['nullable', 'string', 'max:255', Rule::unique('products', 'barcode')->ignore($this->product->id)],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'unit' => 'required|string|in:pcs,kg,g,sachets',
            'imageUpload' => 'nullable|image|max:2048', // 2MB
        ]);

        // Empty string barcode should be stored as null, not "".
        $validated['barcode'] = $this->barcode !== '' ? $this->barcode : null;

        if ($this->removeImage && $this->product->image) {
            Storage::disk('public')->delete($this->product->image);
            $validated['image'] = null;
        } elseif ($this->imageUpload) {
            if ($this->product->image) {
                Storage::disk('public')->delete($this->product->image);
            }
            $validated['image'] = $this->imageUpload->store('products', 'public');
        }
        unset($validated['imageUpload']);

        $this->product->update($validated);

        $this->imageUpload = null;
        $this->removeImage = false;

        $this->statusMessage = "Updated \"{$this->product->name}\" successfully.";
        $this->statusType = 'success';
    }

    public function delete()
    {
        $name = $this->product->name;

        // Soft delete — the row stays for referential integrity with
        // past order/transaction records, just hidden from normal queries.
        $this->product->delete();

        return redirect()
            ->route('products.index')
            ->with('status', "\"{$name}\" was deleted.");
    }
};
?>

<div class="max-w-3xl p-6 mx-auto space-y-6">
    <div class="p-6 space-y-6 bg-white border rounded-lg border-[#e5e7eb]">

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-[#101828]">Edit Product</h2>
                <p class="text-xs text-[#6a7282]">Product #{{ $product->id }}</p>
            </div>
            <a href="{{ route('products.index') }}" wire:navigate
                class="text-sm text-[#6a7282] hover:text-[#101828] transition-colors">
                ← Back to Products
            </a>
        </div>

        @if ($statusMessage)
            <div
                class="rounded-md p-4 {{ $statusType === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' }}">
                <p class="text-sm font-medium">{{ $statusMessage }}</p>
            </div>
        @endif

        <form wire:submit.prevent="update" class="space-y-4">
            <div>
                <label for="barcode" class="block text-sm font-semibold text-[#101828] mb-1">Barcode</label>
                <input wire:model="barcode" type="text" id="barcode"
                    class="block w-full rounded-md border-0 py-2.5 px-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm">
                @error('barcode')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-semibold text-[#101828] mb-1">Product Name</label>
                <input wire:model="name" type="text" id="name"
                    class="block w-full rounded-md border-0 py-2.5 px-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm">
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-[#101828] mb-1">Description
                    (optional)</label>
                <textarea wire:model="description" id="description" rows="2"
                    class="block w-full rounded-md border-0 py-2.5 px-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm"></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#101828] mb-1">Product Image</label>

                <div class="flex items-start gap-4">
                    @if ($imageUpload)
                        <img src="{{ $imageUpload->temporaryUrl() }}"
                            class="h-24 w-24 rounded-md border border-[#e5e7eb] object-cover">
                    @elseif ($product->image_url && !$removeImage)
                        <img src="{{ $product->image_url }}"
                            class="h-24 w-24 rounded-md border border-[#e5e7eb] object-cover">
                    @else
                        <!-- No image set — simple inline placeholder, no default file required on disk -->
                        <div
                            class="flex h-24 w-24 items-center justify-center rounded-md border border-dashed border-[#d1d5dc] bg-[#f9fafb] text-[#99a1af]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0A2.25 2.25 0 015.25 6h13.5A2.25 2.25 0 0121 8.25m-18 0v.243a2.25 2.25 0 00.659 1.591l.5.5m16.591-2.334a2.25 2.25 0 01-.659 1.591l-.5.5M21 8.25v.243a2.25 2.25 0 01-.659 1.591l-.5.5M9 12.75a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                            </svg>
                        </div>
                    @endif

                    <div class="flex-1 space-y-2">
                        <input wire:model="imageUpload" type="file" id="imageUpload" accept="image/*"
                            class="block w-full text-sm text-[#101828] file:mr-4 file:rounded-md file:border-0 file:bg-[#101828] file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-[#1e2939]">
                        @error('imageUpload')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        <div wire:loading wire:target="imageUpload" class="text-xs text-[#6a7282]">Uploading...</div>

                        @if ($product->image_url && !$imageUpload)
                            <label class="flex items-center gap-2 text-xs text-[#6a7282]">
                                <input type="checkbox" wire:model="removeImage" class="rounded border-[#d1d5dc]">
                                Remove current image
                            </label>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="quantity" class="block text-sm font-semibold text-[#101828] mb-1">Quantity</label>
                    <input wire:model="quantity" type="number" step="0.01" min="0" id="quantity"
                        class="block w-full rounded-md border-0 py-2.5 px-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm">
                    @error('quantity')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="unit" class="block text-sm font-semibold text-[#101828] mb-1">Unit</label>
                    <select wire:model="unit" id="unit"
                        class="block w-full rounded-md border-0 py-2.5 px-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm">
                        <option value="pcs">pcs</option>
                        <option value="kg">kg</option>
                        <option value="g">g</option>
                        <option value="sachets">sachets</option>
                    </select>
                    @error('unit')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="cost_price" class="block text-sm font-semibold text-[#101828] mb-1">Cost
                        Price</label>
                    <input wire:model="cost_price" type="number" step="0.01" min="0" id="cost_price"
                        class="block w-full rounded-md border-0 py-2.5 px-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm">
                    @error('cost_price')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="selling_price" class="block text-sm font-semibold text-[#101828] mb-1">Selling
                        Price</label>
                    <input wire:model="selling_price" type="number" step="0.01" min="0" id="selling_price"
                        class="block w-full rounded-md border-0 py-2.5 px-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm">
                    @error('selling_price')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="flex-1 rounded-md bg-[#101828] py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#1e2939] transition-colors">
                    Update Product
                </button>
                <button type="button" wire:click="delete"
                    wire:confirm="Are you sure you want to delete this product? This can be restored later if needed."
                    class="rounded-md border border-red-200 px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                    Delete
                </button>
            </div>
        </form>

    </div>
</div>
