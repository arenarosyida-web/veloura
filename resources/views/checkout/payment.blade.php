<x-layouts.checkout title="Pembayaran" :showCart="false">

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<div class="mx-auto max-w-lg py-16 text-center">

    {{-- Icon loading --}}
    <div id="loading-state">
        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center border border-emerald-200 bg-emerald-50">
            <svg class="animate-spin w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
            </svg>
        </div>
        <p class="text-[12px] font-light uppercase tracking-[3px] text-emerald-600">
            Memuat halaman pembayaran...
        </p>
    </div>

    {{-- Order summary --}}
    <div class="mt-8 border border-emerald-200 bg-cream p-6 text-left">
        <p class="mb-4 text-[10px] font-light uppercase tracking-[3px] text-gold-500">
            Ringkasan Pesanan
        </p>
        <div class="flex flex-col gap-3">
            <div class="flex justify-between text-sm">
                <span class="font-light text-emerald-600">Order ID</span>
                <span class="font-cormorant text-emerald-900">#ORD-{{ $order->order_id }}</span>
            </div>
            <div class="h-px bg-emerald-100"></div>
            <div class="flex justify-between text-sm">
                <span class="font-light text-emerald-600">Penerima</span>
                <span class="font-light text-emerald-900">{{ $order->receiver_name }}</span>
            </div>
            <div class="h-px bg-emerald-100"></div>
            <div class="flex justify-between text-sm">
                <span class="font-light text-emerald-600">Total</span>
                <span class="font-cormorant text-lg font-semibold text-emerald-900">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Tombol fallback jika popup tidak auto-open --}}
    <button id="pay-btn"
            class="mt-6 hidden w-full items-center justify-center gap-3 bg-emerald-800 py-4
                   text-[11px] font-light uppercase tracking-[3px] text-gold-100
                   transition-colors hover:bg-emerald-900">
        Buka Pembayaran
        <svg width="14" height="9" viewBox="0 0 14 9" fill="none" stroke="#E8C97A" stroke-width="1.5">
            <line x1="0" y1="4.5" x2="12" y2="4.5"/>
            <polyline points="8,1 12,4.5 8,8"/>
        </svg>
    </button>

</div>

<script>
    const snapToken = @json($snapToken);

    function openSnap() {
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
    // Tunggu sebentar agar AJAX callback selesai dulu
    sendCallback(result, '{{ route("checkout.success") }}');
},
            onPending: function(result) {
                sendCallback(result);
            },
            onError: function(result) {
                sendCallback(result);
            },
            onClose: function() {
                // User tutup popup — tampilkan tombol buka lagi
                document.getElementById('loading-state').classList.add('hidden');
                document.getElementById('pay-btn').classList.remove('hidden');
                document.getElementById('pay-btn').classList.add('flex');
            }
        });
    }

    function sendCallback(result) {
        fetch('{{ route("midtrans.callback") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(result)
        })
        .then(res => res.json())
        .then(() => {
            window.location.href = '{{ route("checkout.success") }}';
        })
        .catch(() => {
            window.location.href = '{{ route("checkout.success") }}';
        });
    }

    // Auto-open saat halaman siap
    document.addEventListener('DOMContentLoaded', function () {
        // Tunggu snap.js selesai load
        setTimeout(function () {
            document.getElementById('loading-state').classList.add('hidden');
            openSnap();
        }, 800);
    });

    // Tombol fallback
    document.getElementById('pay-btn').addEventListener('click', openSnap);
</script>

</x-layouts.checkout>