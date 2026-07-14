<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

new #[Title('Add / Edit Product')] class extends Component {
    use WithFileUploads;

    // The scanned/typed barcode
    public string $barcode = '';

    // Set when the scanned barcode matches an existing product —
    // we link out to it instead of editing inline.
    public ?string $existingProductUrl = null;
    public ?string $existingProductName = null;

    // Confirmation modal state for registering a brand-new barcode
    public bool $showRegisterConfirm = false;
    public string $pendingBarcode = '';

    // True when the user chose "Add without a barcode" (tingi-tingi / own
    // product with no printed barcode) — bypasses the scan requirement.
    public bool $manualEntry = false;

    // Product form fields (only used when actually registering a NEW product)
    public string $name = '';
    public string $description = '';
    public $quantity = 0;
    public $selling_price = 0;
    public $cost_price = 0;
    public string $unit = 'pcs';

    // Temporary uploaded file (Livewire handles this specially — not a
    // plain property, it's an UploadedFile instance while pending)
    public $imageUpload = null;

    public string $statusMessage = '';
    public string $statusType = '';

    // 1. Manual barcode entry (typed or physical USB scanner + Enter)
    public function scanBarcode()
    {
        $barcode = trim($this->barcode);

        if (empty($barcode)) {
            return;
        }

        $this->lookupBarcode($barcode);
    }

    // 2. Camera scan event (fired by the JS below)
    #[On('barcode-scanned')]
    public function handleCameraScan($barcode)
    {
        $this->barcode = $barcode;
        $this->lookupBarcode($barcode);
    }

    // 3. Core lookup logic: does this barcode already belong to a product?
    private function lookupBarcode(string $barcode): void
    {
        $product = Product::where('barcode', $barcode)->first();

        if ($product) {
            // Existing product — don't edit inline, just link out to it.
            // Adjust 'products.edit' to whatever your actual route name is.
            $this->existingProductUrl = route('products.edit', $product);
            $this->existingProductName = $product->name;

            $this->showRegisterConfirm = false;
            $this->pendingBarcode = '';
            $this->manualEntry = false;
            $this->resetProductFields();

            $this->statusMessage = "This barcode is already registered to \"{$product->name}\".";
            $this->statusType = 'info';

            $this->dispatch('stop-camera');
        } else {
            // New barcode — ask for confirmation before showing the add-product form
            $this->existingProductUrl = null;
            $this->existingProductName = null;

            $this->pendingBarcode = $barcode;
            $this->showRegisterConfirm = true;

            $this->statusMessage = '';
            $this->statusType = '';
        }
    }

    // User confirmed "Yes" on the register-new-product modal
    public function confirmRegister(): void
    {
        $this->barcode = $this->pendingBarcode;
        $this->pendingBarcode = '';
        $this->showRegisterConfirm = false;
        $this->manualEntry = false;

        $this->resetProductFields();

        $this->statusMessage = 'New barcode. Fill in the details to add this product.';
        $this->statusType = 'info';

        $this->dispatch('stop-camera');
    }

    // User chose "No" — discard the scanned barcode entirely
    public function cancelRegister(): void
    {
        $this->pendingBarcode = '';
        $this->showRegisterConfirm = false;
        $this->barcode = '';
        $this->statusMessage = '';
        $this->statusType = '';

        $this->dispatch('stop-camera');
    }

    // "Add a product without a barcode" — tingi-tingi / own products that
    // don't have a printed barcode at all. Skips the scan/confirm flow
    // entirely and goes straight to the form.
    public function startManualEntry(): void
    {
        $this->barcode = '';
        $this->pendingBarcode = '';
        $this->showRegisterConfirm = false;
        $this->existingProductUrl = null;
        $this->existingProductName = null;
        $this->resetProductFields();

        $this->manualEntry = true;

        $this->statusMessage = 'Fill in the details below. No barcode needed for this product.';
        $this->statusType = 'info';

        $this->dispatch('stop-camera');
    }

    private function resetProductFields(): void
    {
        $this->name = '';
        $this->description = '';
        $this->quantity = 0;
        $this->selling_price = 0;
        $this->cost_price = 0;
        $this->unit = 'pcs';
        $this->imageUpload = null;
    }

    // 4. Save — this form only ever creates a NEW product now
    public function save()
    {
        $validated = $this->validate([
            'barcode' => 'nullable|string|max:255|unique:products,barcode',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|in:pcs,kg,g,sachets',
            'selling_price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'imageUpload' => 'nullable|image|max:2048', // 2MB
        ]);

        // Barcode is optional (tingi-tingi / own products without one) —
        // an empty string should be stored as null, not "".
        $validated['barcode'] = $this->barcode !== '' ? $this->barcode : null;

        // Store the uploaded image (if any) and swap it into the validated
        // data as a path; imageUpload itself never gets mass-assigned.
        if ($this->imageUpload) {
            $validated['image'] = $this->imageUpload->store('products', 'public');
        }
        unset($validated['imageUpload']);

        $product = Product::create($validated);

        $this->statusMessage = "Added \"{$product->name}\" successfully.";
        $this->statusType = 'success';

        // Ready for the next scan
        $this->barcode = '';
        $this->manualEntry = false;
        $this->resetProductFields();
    }

    // Start over: clear everything, ready for the next scan
    public function newScan()
    {
        $this->barcode = '';
        $this->pendingBarcode = '';
        $this->showRegisterConfirm = false;
        $this->existingProductUrl = null;
        $this->existingProductName = null;
        $this->manualEntry = false;
        $this->resetProductFields();
        $this->statusMessage = '';
        $this->statusType = '';

        $this->dispatch('stop-camera');
    }
};
?>

<style>
    /* Ensure the camera feed fills the box nicely */
    #reader video {
        object-fit: cover;
        border-radius: 0.5rem;
        width: 100%;
    }
</style>

<div class="max-w-3xl p-6 mx-auto space-y-6">
    <div class="p-6 space-y-6 bg-white border rounded-lg border-[#e5e7eb]" x-data="barcodeScanner()" x-init="initScanner()">

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-[#101828]">Scan Product Barcode</h2>
                <p class="text-xs text-[#6a7282]">Scan a barcode to look up or register a product</p>
            </div>

            <button @click="toggleCamera()" type="button"
                class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium transition-colors border rounded-md"
                :class="isScanning ? 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100' :
                    'bg-[#101828] text-white hover:bg-[#1e2939]'">
                <span x-text="isScanning ? 'Stop Camera' : 'Start Camera Scanner'"></span>
            </button>
        </div>

        <!--
            wire:ignore is required here: html5-qrcode injects a live <video>/<canvas>
            element into #reader via JavaScript, but Blade always renders #reader empty.
            Without wire:ignore, any Livewire re-render (e.g. after a scan updates the
            form fields) would see the server HTML as empty and rip the live video
            feed out of the DOM.
        -->
        <div x-show="isScanning" style="display: none;"
            class="relative overflow-hidden border-2 border-dashed border-[#d1d5dc] rounded-lg bg-[#f9fafb] w-full min-h-[250px]"
            wire:ignore>
            <div id="reader" class="w-full h-full"></div>
        </div>

        <div x-show="cameraError" style="display: none;" class="p-3 text-sm text-red-700 bg-red-100 rounded-md">
            <span class="font-bold">Camera Blocked:</span> <span x-text="cameraError"></span>
            <p class="mt-1 text-xs">Ensure you are using an HTTPS connection (like Ngrok) on your phone.</p>
        </div>

        <form wire:submit.prevent="scanBarcode" class="space-y-4">
            <div>
                <label for="barcode" class="block text-sm font-semibold text-[#101828] mb-1">
                    Barcode
                </label>
                <div class="relative rounded-md shadow-sm">
                    <input wire:model="barcode" type="text" id="barcode" x-ref="barcodeInput"
                        class="block w-full rounded-md border-0 py-3 pl-3 pr-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] placeholder:text-[#99a1af] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm"
                        placeholder="Scan or type a barcode, then press Enter..." autocomplete="off" autofocus>
                </div>
                @error('barcode')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </form>

        <div class="text-center">
            <button type="button" wire:click="startManualEntry"
                class="text-sm font-medium text-[#374151] underline decoration-dotted underline-offset-4 hover:text-[#101828] transition-colors">
                No barcode? Add a tingi-tingi / own product instead
            </button>
        </div>

        @if ($statusMessage)
            <div
                class="rounded-md p-4 {{ $statusType === 'success' ? 'bg-green-50 text-green-800' : ($statusType === 'error' ? 'bg-red-50 text-red-800' : 'bg-blue-50 text-blue-800') }}">
                <p class="text-sm font-medium">{{ $statusMessage }}</p>
            </div>
        @endif

        <!-- Existing product found: link out instead of editing inline -->
        @if ($existingProductUrl)
            <div class="flex items-center justify-between rounded-md border border-[#e5e7eb] bg-[#f9fafb] p-4">
                <div>
                    <p class="text-sm font-semibold text-[#101828]">{{ $existingProductName }}</p>
                    <p class="text-xs text-[#6a7282]">Barcode: {{ $barcode }}</p>
                </div>
                <a href="{{ $existingProductUrl }}"
                    class="inline-flex items-center gap-1 rounded-md bg-[#101828] px-4 py-2 text-sm font-semibold text-white hover:bg-[#1e2939] transition-colors">
                    View / Edit Product →
                </a>
            </div>
        @endif

        <!-- Confirmation modal: new barcode, ask before showing the add-product form -->
        @if ($showRegisterConfirm)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
                wire:key="register-confirm-modal">
                <div class="w-full max-w-sm rounded-lg bg-white p-6 shadow-xl space-y-4">
                    <div>
                        <h3 class="text-base font-bold text-[#101828]">Register a new product?</h3>
                        <p class="mt-1 text-sm text-[#6a7282]">
                            The barcode <span
                                class="font-mono font-semibold text-[#101828]">{{ $pendingBarcode }}</span>
                            isn't registered to any product yet.
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" wire:click="confirmRegister"
                            class="flex-1 rounded-md bg-[#101828] py-2.5 text-sm font-semibold text-white hover:bg-[#1e2939] transition-colors">
                            Yes, register it
                        </button>
                        <button type="button" wire:click="cancelRegister"
                            class="flex-1 rounded-md border border-[#e5e7eb] py-2.5 text-sm font-medium text-[#374151] hover:bg-[#f9fafb] transition-colors">
                            No
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Add-product form — shown once a new barcode is confirmed, OR the user chose manual entry (no barcode) -->
        @if (($barcode || $manualEntry) && !$existingProductUrl && !$showRegisterConfirm)
            <form wire:submit.prevent="save" class="pt-4 space-y-4 border-t border-[#e5e7eb]"
                enctype="multipart/form-data">
                @if ($manualEntry)
                    <p class="text-xs text-[#6a7282]">
                        No barcode — this product will be saved without one. You can add one later from the edit page.
                    </p>
                @endif

                <div>
                    <label for="name" class="block text-sm font-semibold text-[#101828] mb-1">Product Name</label>
                    <input wire:model="name" type="text" id="name"
                        class="block w-full rounded-md border-0 py-2.5 pl-3 pr-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-[#101828] mb-1">Description
                        (optional)</label>
                    <textarea wire:model="description" id="description" rows="2"
                        class="block w-full rounded-md border-0 py-2.5 pl-3 pr-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm"></textarea>
                </div>

                <div>
                    <label for="imageUpload" class="block text-sm font-semibold text-[#101828] mb-1">Product Image
                        (optional)</label>
                    <input wire:model="imageUpload" type="file" id="imageUpload" accept="image/*"
                        class="block w-full text-sm text-[#101828] file:mr-4 file:rounded-md file:border-0 file:bg-[#101828] file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-[#1e2939]">
                    @error('imageUpload')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="imageUpload" class="mt-2 text-xs text-[#6a7282]">Uploading...</div>

                    @if ($imageUpload)
                        <img src="{{ $imageUpload->temporaryUrl() }}"
                            class="mt-3 h-24 w-24 rounded-md border border-[#e5e7eb] object-cover">
                    @endif
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="quantity" class="block text-sm font-semibold text-[#101828] mb-1">Quantity</label>
                        <input wire:model="quantity" type="number" step="0.01" min="0" id="quantity"
                            class="block w-full rounded-md border-0 py-2.5 pl-3 pr-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm">
                        @error('quantity')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="unit" class="block text-sm font-semibold text-[#101828] mb-1">Unit</label>
                        <select wire:model="unit" id="unit"
                            class="block w-full rounded-md border-0 py-2.5 pl-3 pr-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm">
                            <option value="pcs">pcs</option>
                            <option value="kg">kg</option>
                            <option value="g">g</option>
                            <option value="sachets">sachets</option>
                        </select>
                        @error('unit')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cost_price" class="block text-sm font-semibold text-[#101828] mb-1">Cost
                            Price</label>
                        <input wire:model="cost_price" type="number" step="0.01" min="0" id="cost_price"
                            class="block w-full rounded-md border-0 py-2.5 pl-3 pr-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm">
                        @error('cost_price')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="selling_price" class="block text-sm font-semibold text-[#101828] mb-1">Selling
                        Price</label>
                    <input wire:model="selling_price" type="number" step="0.01" min="0"
                        id="selling_price"
                        class="block w-full rounded-md border-0 py-2.5 pl-3 pr-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm">
                    @error('selling_price')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 rounded-md bg-[#101828] py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#1e2939] transition-colors">
                        Add Product
                    </button>
                    <button type="button" wire:click="newScan"
                        class="rounded-md border border-[#e5e7eb] px-4 py-3 text-sm font-medium text-[#374151] hover:bg-[#f9fafb] transition-colors">
                        New Scan
                    </button>
                </div>
            </form>
        @endif

    </div>
</div>

@script
    <script>
        Alpine.data('barcodeScanner', () => ({
            isScanning: false,
            cameraError: null,
            scanner: null,
            libraryReady: null,

            // Loads html5-qrcode dynamically instead of relying on a <script src>
            // tag inside the Livewire component (which does not reliably execute).
            loadScannerLibrary() {
                if (window.Html5Qrcode) {
                    return Promise.resolve();
                }

                let existing = document.querySelector('script[data-html5-qrcode]');
                if (existing) {
                    return new Promise((resolve, reject) => {
                        existing.addEventListener('load', () => resolve());
                        existing.addEventListener('error', reject);
                    });
                }

                return new Promise((resolve, reject) => {
                    const script = document.createElement('script');
                    script.src = 'https://unpkg.com/html5-qrcode';
                    script.dataset.html5Qrcode = 'true';
                    script.onload = () => resolve();
                    script.onerror = () => reject(new Error('Failed to load html5-qrcode library'));
                    document.head.appendChild(script);
                });
            },

            initScanner() {
                // Livewire tells us to close the camera once a barcode has
                // been resolved (existing product found, Yes/No answered,
                // or a fresh scan reset) — we don't decide this ourselves.
                this.$wire.on('stop-camera', () => {
                    this.stopCamera();
                });

                this.libraryReady = this.loadScannerLibrary().then(() => {
                    this.scanner = new Html5Qrcode("reader");
                }).catch(err => {
                    this.cameraError = err.message || String(err);
                });
            },

            stopCamera() {
                if (!this.isScanning || !this.scanner) {
                    return;
                }
                this.scanner.stop().then(() => {
                    this.scanner.clear();
                    this.isScanning = false;
                }).catch(err => console.error("Failed to stop scanner", err));
            },

            playBeep() {
                try {
                    const ctx = new(window.AudioContext || window.webkitAudioContext)();
                    const osc = ctx.createOscillator();
                    osc.connect(ctx.destination);
                    osc.frequency.value = 800;
                    osc.start();
                    setTimeout(() => osc.stop(), 100);
                } catch (e) {
                    console.log("Audio beep not supported");
                }
            },

            toggleCamera() {
                this.cameraError = null;

                if (this.isScanning) {
                    this.stopCamera();
                    return;
                }

                if (!this.libraryReady) {
                    this.cameraError = 'Scanner library is not ready yet.';
                    return;
                }

                this.libraryReady.then(() => {
                    if (!this.scanner) {
                        return;
                    }

                    this.isScanning = true;

                    this.$nextTick(() => {
                        this.scanner.start({
                                facingMode: "environment"
                            }, {
                                fps: 10,
                                qrbox: {
                                    width: 250,
                                    height: 250
                                },
                                formatsToSupport: [
                                    Html5QrcodeSupportedFormats.QR_CODE,
                                    Html5QrcodeSupportedFormats.EAN_13,
                                    Html5QrcodeSupportedFormats.CODE_128,
                                    Html5QrcodeSupportedFormats.UPC_A
                                ]
                            },
                            (decodedText, decodedResult) => {
                                this.playBeep();
                                this.scanner.pause();

                                // This is the ONLY job of the camera scan:
                                // capture the number and hand it to Livewire
                                // to look up. No cart, no transaction.
                                $wire.dispatch('barcode-scanned', {
                                    barcode: decodedText
                                });

                                setTimeout(() => {
                                    if (this.isScanning) this.scanner.resume();
                                }, 1500);
                            },
                            (errorMessage) => {
                                /* Ignored — fires continuously while searching */
                            }
                        ).catch(err => {
                            this.cameraError = err.message || err;
                            this.isScanning = false;
                        });
                    });
                });
            }
        }));

        // Keep the barcode input focused after Livewire updates so a physical
        // USB scanner can keep firing scans back to back.
        Livewire.hook('morph.updated', ({
            el
        }) => {
            const input = el.querySelector ? el.querySelector('#barcode') : null;
            if (input && !input.readOnly && document.activeElement !== input && document.activeElement === document
                .body) {
                input.focus();
            }
        });
    </script>
@endscript
