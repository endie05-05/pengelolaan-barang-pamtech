@props(['inputId' => 'barcode', 'onScan' => null])

<div x-data="barcodeScanner('{{ $inputId }}')" class="relative">
    <!-- Scanner Button -->
    <button type="button" 
        @click="toggleScanner()"
        class="inline-flex items-center px-4 py-2 bg-slate-100 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-200 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
        </svg>
        <span x-text="isScanning ? 'Tutup Scanner' : 'Scan Barcode'"></span>
    </button>

    <!-- Scanner Modal -->
    <div x-show="isScanning" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
        @click.self="toggleScanner()">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4 overflow-hidden">
            <div class="p-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Scan Barcode</h3>
                <button type="button" @click="toggleScanner()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <div :id="'scanner-' + inputId" class="w-full aspect-square bg-slate-100 rounded-lg overflow-hidden"></div>
                <p class="text-sm text-slate-500 text-center mt-3">Arahkan kamera ke barcode barang</p>
                <div x-show="lastResult" class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-700">
                        <span class="font-medium">Terdeteksi:</span> <span x-text="lastResult"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function barcodeScanner(inputId) {
    return {
        isScanning: false,
        scanner: null,
        lastResult: '',
        inputId: inputId,

        toggleScanner() {
            if (this.isScanning) {
                this.stopScanner();
            } else {
                this.startScanner();
            }
            this.isScanning = !this.isScanning;
        },

        async startScanner() {
            // Load html5-qrcode library if not loaded
            if (typeof Html5Qrcode === 'undefined') {
                await this.loadScript('https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js');
            }

            await this.$nextTick();
            
            const scannerId = 'scanner-' + this.inputId;
            this.scanner = new Html5Qrcode(scannerId);
            
            const config = {
                fps: 10,
                qrbox: { width: 250, height: 150 },
                formatsToSupport: [
                    Html5QrcodeSupportedFormats.CODE_128,
                    Html5QrcodeSupportedFormats.CODE_39,
                    Html5QrcodeSupportedFormats.EAN_13,
                    Html5QrcodeSupportedFormats.EAN_8,
                    Html5QrcodeSupportedFormats.UPC_A,
                    Html5QrcodeSupportedFormats.UPC_E,
                    Html5QrcodeSupportedFormats.QR_CODE,
                ]
            };

            try {
                await this.scanner.start(
                    { facingMode: "environment" },
                    config,
                    (decodedText) => {
                        this.onScanSuccess(decodedText);
                    },
                    (errorMessage) => {
                        // Ignore scan errors (no code found)
                    }
                );
            } catch (err) {
                console.error('Scanner error:', err);
                alert('Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.');
                this.isScanning = false;
            }
        },

        async stopScanner() {
            if (this.scanner) {
                try {
                    await this.scanner.stop();
                    this.scanner.clear();
                } catch (err) {
                    console.error('Error stopping scanner:', err);
                }
            }
        },

        onScanSuccess(decodedText) {
            this.lastResult = decodedText;
            
            // Set the value to the input field
            const input = document.getElementById(this.inputId);
            if (input) {
                input.value = decodedText;
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }

            // Dispatch custom event for additional handling
            window.dispatchEvent(new CustomEvent('barcode-scanned', { 
                detail: { barcode: decodedText, inputId: this.inputId }
            }));

            // Stop scanner after successful scan
            setTimeout(() => {
                this.toggleScanner();
            }, 500);
        },

        loadScript(src) {
            return new Promise((resolve, reject) => {
                if (document.querySelector(`script[src="${src}"]`)) {
                    resolve();
                    return;
                }
                const script = document.createElement('script');
                script.src = src;
                script.onload = resolve;
                script.onerror = reject;
                document.head.appendChild(script);
            });
        }
    }
}
</script>
