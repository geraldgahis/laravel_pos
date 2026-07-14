<?php

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

new #[Title('POS Terminal')] class extends Component {
    public string $barcodeQuery = '';
    public array $cart = [];
    public float $total = 0.0;

    // A product that's been scanned/looked up but not yet committed to the
    // cart — lets the cashier adjust quantity before actually adding it.
    // Null when nothing is currently staged.
    public ?array $stagedProduct = null;
    public $stagedQuantity = 1;

    public string $statusMessage = '';
    public string $statusType = '';

    // 1. Manual barcode entry (typed or physical USB scanner + Enter)
    public function scanProduct()
    {
        $barcode = trim($this->barcodeQuery);

        if (empty($barcode)) {
            return;
        }

        $this->processBarcode($barcode);
        $this->barcodeQuery = '';
    }

    // 2. Camera scan event (fired by the JS below)
    #[On('barcode-scanned')]
    public function handleCameraScan($barcode)
    {
        $this->processBarcode($barcode);
    }

    // 3. Core scan logic
    private function processBarcode(string $barcode): void
    {
        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            $this->statusMessage = "Barcode [{$barcode}] not found in inventory!";
            $this->statusType = 'error';
            return;
        }

        if ($product->quantity <= 0) {
            $this->statusMessage = "Out of stock: {$product->name}";
            $this->statusType = 'error';
            $this->stagedProduct = null;
            return;
        }

        $cartKey = $product->id;

        if (isset($this->cart[$cartKey])) {
            // Already in the cart — a rescan just bumps the quantity by 1.
            // No staging step, no extra click.
            $newQty = $this->cart[$cartKey]['quantity'] + 1;

            if ($newQty > $product->quantity) {
                $this->statusMessage = "Cannot add more. Limit reached for {$product->name}.";
                $this->statusType = 'error';
                return;
            }

            $this->cart[$cartKey]['quantity'] = $newQty;
            $this->cart[$cartKey]['subtotal'] = $newQty * $product->selling_price;
            $this->calculateTotal();

            $this->statusMessage = "Added another {$product->name}. Now {$this->formatQty($newQty)} {$product->unit} in cart.";
            $this->statusType = 'success';

            // A rescan resolves whatever was staged before.
            $this->stagedProduct = null;
            $this->stagedQuantity = 1;
            return;
        }

        // Not yet in the cart — stage it so quantity can be reviewed/adjusted
        // (e.g. typing "2.5" for a kg-based item) before it's actually added.
        $this->stagedProduct = [
            'id' => $product->id,
            'name' => $product->name,
            'selling_price' => (float) $product->selling_price,
            'available' => (float) $product->quantity,
            'unit' => $product->unit,
            'image_url' => $product->image_url,
        ];
        $this->stagedQuantity = 1;

        $this->statusMessage = "Scanned: {$product->name}. Review the quantity and add to cart.";
        $this->statusType = 'info';
    }

    public function incrementStaged(): void
    {
        if (!$this->stagedProduct) {
            return;
        }

        $next = (float) $this->stagedQuantity + 1;

        if ($next <= $this->stagedProduct['available']) {
            $this->stagedQuantity = $next;
        }
    }

    public function decrementStaged(): void
    {
        if (!$this->stagedProduct) {
            return;
        }

        $next = (float) $this->stagedQuantity - 1;
        $this->stagedQuantity = $next >= 1 ? $next : 1;
    }

    public function addStagedToCart(): void
    {
        if (!$this->stagedProduct) {
            return;
        }

        $qty = (float) $this->stagedQuantity;

        if ($qty <= 0) {
            $this->statusMessage = 'Quantity must be greater than zero.';
            $this->statusType = 'error';
            return;
        }

        if ($qty > $this->stagedProduct['available']) {
            $this->statusMessage = "Only {$this->formatQty($this->stagedProduct['available'])} {$this->stagedProduct['unit']} available for \"{$this->stagedProduct['name']}\".";
            $this->statusType = 'error';
            return;
        }

        $cartKey = $this->stagedProduct['id'];

        // Guard: product could have been added to the cart via a rescan by
        // the time "Add to Cart" is clicked. Merge instead of overwriting.
        if (isset($this->cart[$cartKey])) {
            $newQty = $this->cart[$cartKey]['quantity'] + $qty;

            if ($newQty > $this->stagedProduct['available']) {
                $this->statusMessage = "Cannot add. Limit reached for \"{$this->stagedProduct['name']}\".";
                $this->statusType = 'error';
                return;
            }

            $this->cart[$cartKey]['quantity'] = $newQty;
            $this->cart[$cartKey]['subtotal'] = $newQty * $this->stagedProduct['selling_price'];
        } else {
            $this->cart[$cartKey] = [
                'id' => $this->stagedProduct['id'],
                'name' => $this->stagedProduct['name'],
                'selling_price' => $this->stagedProduct['selling_price'],
                'unit' => $this->stagedProduct['unit'],
                'quantity' => $qty,
                'subtotal' => $qty * $this->stagedProduct['selling_price'],
            ];
        }

        $this->calculateTotal();

        $this->statusMessage = "Added {$this->formatQty($qty)} {$this->stagedProduct['unit']} of \"{$this->stagedProduct['name']}\" to cart.";
        $this->statusType = 'success';

        $this->stagedProduct = null;
        $this->stagedQuantity = 1;
    }

    public function cancelStaged(): void
    {
        $this->stagedProduct = null;
        $this->stagedQuantity = 1;
        $this->statusMessage = '';
        $this->statusType = '';
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        $this->calculateTotal();
        $this->statusMessage = 'Item removed from cart.';
        $this->statusType = 'info';
    }

    private function calculateTotal()
    {
        $this->total = collect($this->cart)->sum('subtotal');
    }

    // Trims trailing zeros so "3.00" displays as "3" but "2.5" stays "2.5"
    private function formatQty(float $qty): string
    {
        return rtrim(rtrim(number_format($qty, 2), '0'), '.');
    }
};
?>

<style>
    #reader video {
        object-fit: cover;
        border-radius: 0.5rem;
        width: 100%;
    }
</style>

<div class="max-w-6xl p-6 mx-auto space-y-6">
    <div class="flex flex-col gap-6 md:flex-row">

        <div class="flex-1 space-y-6 rounded-lg border border-[#e5e7eb] bg-white p-6" x-data="barcodeScanner()"
            x-init="initScanner()">

            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-[#101828]">Register Checkout</h2>
                    <p class="text-xs text-[#6a7282]">Point-of-Sale Scan Module</p>
                </div>

                <button @click="toggleCamera()" type="button"
                    class="inline-flex items-center gap-2 rounded-md border px-3 py-1.5 text-sm font-medium transition-colors"
                    :class="isScanning ? 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100' :
                        'bg-[#101828] text-white hover:bg-[#1e2939]'">
                    <span x-text="isScanning ? 'Stop Camera' : 'Start Camera Scanner'"></span>
                </button>
            </div>

            <!--
                wire:ignore is required: html5-qrcode injects a live video/canvas
                into #reader via JS, but Blade always renders it empty. Without
                wire:ignore, any Livewire re-render (which happens on every scan)
                would rip the live feed out of the DOM.
            -->
            <div x-show="isScanning" style="display: none;"
                class="relative min-h-62.5 w-full overflow-hidden rounded-lg border-2 border-dashed border-[#d1d5dc] bg-[#f9fafb]"
                wire:ignore>
                <div id="reader" class="h-full w-full"></div>
            </div>

            <div x-show="cameraError" style="display: none;" class="rounded-md bg-red-100 p-3 text-sm text-red-700">
                <span class="font-bold">Camera Blocked:</span> <span x-text="cameraError"></span>
                <p class="mt-1 text-xs">Ensure you are using an HTTPS connection (like Ngrok) on your phone.</p>
            </div>

            <form wire:submit.prevent="scanProduct" class="space-y-4">
                <div>
                    <label for="barcodeQuery" class="mb-1 block text-sm font-semibold text-[#101828]">
                        Manual Entry / Physical Scanner
                    </label>
                    <input wire:model="barcodeQuery" type="text" id="barcodeQuery"
                        class="block w-full rounded-md border-0 py-3 px-3 text-[#101828] ring-1 ring-inset ring-[#e5e7eb] placeholder:text-[#99a1af] focus:ring-2 focus:ring-inset focus:ring-[#101828] sm:text-sm"
                        placeholder="Type barcode and press Enter..." autocomplete="off" autofocus>
                </div>
            </form>

            @if ($statusMessage)
                <div
                    class="rounded-md p-4 {{ $statusType === 'success' ? 'bg-green-50 text-green-800' : ($statusType === 'error' ? 'bg-red-50 text-red-800' : 'bg-blue-50 text-blue-800') }}">
                    <p class="text-sm font-medium">{{ $statusMessage }}</p>
                </div>
            @endif

            <!-- Staging panel: scanned, not yet added — adjust quantity here -->
            @if ($stagedProduct)
                <div class="rounded-lg border border-[#e5e7eb] bg-[#f9fafb] p-4 space-y-4">
                    <div class="flex items-center gap-3">
                        @if ($stagedProduct['image_url'])
                            <img src="{{ $stagedProduct['image_url'] }}"
                                class="h-14 w-14 rounded-md border border-[#e5e7eb] object-cover">
                        @else
                            <div
                                class="flex h-14 w-14 items-center justify-center rounded-md border border-dashed border-[#d1d5dc] bg-white text-[#99a1af]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0A2.25 2.25 0 015.25 6h13.5A2.25 2.25 0 0121 8.25m-18 0v.243a2.25 2.25 0 00.659 1.591l.5.5m16.591-2.334a2.25 2.25 0 01-.659 1.591l-.5.5M21 8.25v.243a2.25 2.25 0 01-.659 1.591l-.5.5M9 12.75a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-[#101828]">{{ $stagedProduct['name'] }}</p>
                            <p class="text-xs text-[#6a7282]">
                                ₱{{ number_format($stagedProduct['selling_price'], 2) }} / {{ $stagedProduct['unit'] }}
                                &middot; {{ rtrim(rtrim(number_format($stagedProduct['available'], 2), '0'), '.') }}
                                {{ $stagedProduct['unit'] }} in stock
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="text-sm font-medium text-[#101828]">Quantity</label>
                        <div class="flex items-center gap-1">
                            <button type="button" wire:click="decrementStaged"
                                class="flex h-8 w-8 items-center justify-center rounded-md border border-[#e5e7eb] bg-white text-[#374151] hover:bg-[#f9fafb]">
                                −
                            </button>
                            <input wire:model="stagedQuantity" type="number" step="0.01" min="0.01"
                                class="w-24 rounded-md border-0 py-1.5 px-2 text-center text-sm text-[#101828] ring-1 ring-inset ring-[#e5e7eb] focus:ring-2 focus:ring-inset focus:ring-[#101828]">
                            <button type="button" wire:click="incrementStaged"
                                class="flex h-8 w-8 items-center justify-center rounded-md border border-[#e5e7eb] bg-white text-[#374151] hover:bg-[#f9fafb]">
                                +
                            </button>
                        </div>
                        <span class="text-xs text-[#6a7282]">{{ $stagedProduct['unit'] }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button" wire:click="addStagedToCart"
                            class="flex-1 rounded-md bg-[#101828] py-2.5 text-sm font-semibold text-white hover:bg-[#1e2939] transition-colors">
                            Add to Cart
                        </button>
                        <button type="button" wire:click="cancelStaged"
                            class="rounded-md border border-[#e5e7eb] px-4 py-2.5 text-sm font-medium text-[#374151] hover:bg-[#f9fafb] transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            @endif

        </div>

        <div
            class="flex min-h-100 w-full flex-col justify-between rounded-lg border border-[#e5e7eb] bg-white p-6 md:w-96">
            <div>
                <h3 class="mb-4 border-b border-[#e5e7eb] pb-3 text-md font-bold text-[#101828]">Current Order</h3>

                @if (count($cart) > 0)
                    <div class="max-h-96 divide-y divide-[#e5e7eb] overflow-y-auto pr-1">
                        @foreach ($cart as $id => $item)
                            <div class="flex items-center justify-between py-3"
                                wire:key="cart-item-{{ $id }}">
                                <div class="space-y-0.5">
                                    <h4 class="text-sm font-medium text-[#101828]">{{ $item['name'] }}</h4>
                                    <p class="text-xs text-[#6a7282]">
                                        ₱{{ number_format($item['selling_price'], 2) }} x
                                        {{ rtrim(rtrim(number_format($item['quantity'], 2), '0'), '.') }}
                                        {{ $item['unit'] ?? '' }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-bold text-[#101828]">
                                        ₱{{ number_format($item['subtotal'], 2) }}
                                    </span>
                                    <button wire:click="removeFromCart({{ $id }})" type="button"
                                        class="text-sm font-medium text-red-500 transition hover:text-red-700">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center text-gray-400">
                        <p class="text-sm">Scan items to start checkout</p>
                    </div>
                @endif
            </div>

            <div class="mt-4 space-y-4 border-t border-[#e5e7eb] pt-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-[#6a7282]">Total Amount Due</span>
                    <span class="text-2xl font-black text-[#101828]">₱{{ number_format($total, 2) }}</span>
                </div>
                <button type="button"
                    class="w-full rounded-md bg-[#101828] py-3 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-[#1e2939] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#101828] disabled:cursor-not-allowed disabled:opacity-50"
                    @if (count($cart) === 0) disabled @endif>
                    Process Payment
                </button>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        Alpine.data('barcodeScanner', () => ({
            isScanning: false,
            cameraError: null,
            scanner: null,
            libraryReady: null,

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
                this.libraryReady = this.loadScannerLibrary().then(() => {
                    this.scanner = new Html5Qrcode("reader");
                }).catch(err => {
                    this.cameraError = err.message || String(err);
                });
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
                    this.scanner.stop().then(() => {
                        this.scanner.clear();
                        this.isScanning = false;
                    }).catch(err => console.error("Failed to stop scanner", err));
                    return;
                }

                if (!this.libraryReady) {
                    this.cameraError = 'Scanner library is not ready yet.';
                    return;
                }

                this.libraryReady.then(() => {
                    if (!this.scanner) return;

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
                            (decodedText) => {
                                this.playBeep();
                                this.scanner.pause();

                                $wire.dispatch('barcode-scanned', {
                                    barcode: decodedText
                                });

                                setTimeout(() => {
                                    if (this.isScanning) this.scanner.resume();
                                }, 1200);
                            },
                            () => {
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

        Livewire.hook('morph.updated', ({
            el
        }) => {
            const input = el.querySelector ? el.querySelector('#barcodeQuery') : null;
            if (input && document.activeElement !== input && document.activeElement === document.body) {
                input.focus();
            }
        });
    </script>
@endscript
