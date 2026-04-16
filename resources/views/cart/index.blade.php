<x-layouts.app title="Cart">

<div class="min-h-screen bg-cream font-jost">
  <div class="mx-auto max-w-7xl px-6 py-16">

    {{-- ── Page header ── --}}
    <div class="mb-10" data-aos="fade-up" data-aos-duration="600">

      <div class="mb-3 flex items-center gap-3">
        <div class="h-px w-6 bg-gold-500"></div>
        <span class="text-[10px] font-light uppercase tracking-[4px] text-gold-500">Pesanan Anda</span>
      </div>

      <h1 class="font-cormorant text-5xl font-normal text-emerald-900">Keranjang</h1>

    </div>

    {{-- Flash message --}}
    @if(session('success'))
      <div class="mb-6 border border-emerald-200 bg-emerald-50 px-4 py-3
                  text-[12px] font-light uppercase tracking-[2px] text-emerald-700"
           data-aos="fade-down">
        {{ session('success') }}
      </div>
    @endif


    {{-- ══════════════════════════════════════════════════
         CART FILLED
    ══════════════════════════════════════════════════ --}}
    @if(isset($cartItems) && $cartItems->isNotEmpty())

    <div class="grid gap-8 md:grid-cols-3">

      {{-- ── Cart items (2/3) ── --}}
      <div class="space-y-3 md:col-span-2">

        @foreach($cartItems as $item)
        <div class="flex gap-4 border border-emerald-200 bg-cream p-4 transition-colors hover:border-gold-400"
             data-aos="fade-up"
             data-aos-delay="{{ $loop->index * 80 }}"
             data-aos-duration="500">

          {{-- Image --}}
          <div class="h-20 w-20 shrink-0 overflow-hidden border border-emerald-200 bg-emerald-50">
            @if($item->product->image)
              <img src="{{ asset('storage/'.$item->product->image) }}"
                   alt="{{ $item->product->name }}"
                   class="h-full w-full object-cover">
            @else
              <div class="flex h-full w-full items-center justify-center">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="#A8D5B5" stroke-width="1">
                  <circle cx="12" cy="8" r="4"/>
                  <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
              </div>
            @endif
          </div>

          {{-- Info --}}
          <div class="min-w-0 flex-1">
            <h3 class="font-cormorant text-lg font-normal leading-snug text-emerald-900">
              {{ $item->product->name }}
            </h3>
            <p class="mt-0.5 text-[12px] font-light text-gold-500">
              Rp {{ number_format($item->product->price, 0, ',', '.') }}
            </p>
          </div>

          {{-- Quantity — live update, tanpa tombol update --}}
          <div class="flex shrink-0 flex-col items-end justify-between gap-2">

            <form method="POST"
                  action="{{ route('cart.update', $item->cart_item_id) }}"
                  class="cart-qty-form flex items-center gap-0"
                  data-price="{{ $item->product->price }}"
                  data-item-id="{{ $item->cart_item_id }}">
              @csrf
              @method('PATCH')

              {{-- Minus --}}
              <button type="button"
                      onclick="changeQty(this, -1)"
                      class="flex h-8 w-8 items-center justify-center border border-emerald-200
                             text-emerald-700 transition-colors hover:border-emerald-800
                             hover:bg-emerald-800 hover:text-gold-100 text-lg leading-none select-none">
                −
              </button>

              {{-- Input --}}
              <input type="number"
                     name="quantity"
                     value="{{ $item->quantity }}"
                     min="1"
                     max="{{ $item->product->stock }}"
                     class="cart-qty-input h-8 w-12 border-y border-emerald-200 bg-cream
                            text-center text-[13px] font-light text-emerald-900
                            focus:outline-none [appearance:textfield]
                            [&::-webkit-inner-spin-button]:appearance-none
                            [&::-webkit-outer-spin-button]:appearance-none">

              {{-- Plus --}}
              <button type="button"
                      onclick="changeQty(this, 1)"
                      class="flex h-8 w-8 items-center justify-center border border-emerald-200
                             text-emerald-700 transition-colors hover:border-emerald-800
                             hover:bg-emerald-800 hover:text-gold-100 text-lg leading-none select-none">
                +
              </button>
            </form>

            {{-- Subtotal item --}}
            <p class="text-[13px] font-medium text-emerald-900 item-subtotal"
               data-price="{{ $item->product->price }}"
               data-qty="{{ $item->quantity }}">
              Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
            </p>

            {{-- Remove --}}
            <form method="POST" action="{{ route('cart.remove', $item->cart_item_id) }}">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="text-[10px] font-light uppercase tracking-[2px] text-emerald-400
                             transition-colors hover:text-red-500">
                Hapus
              </button>
            </form>

          </div>
        </div>
        @endforeach

      </div>

      {{-- ── Order summary (1/3) ── --}}
      <div data-aos="fade-up" data-aos-delay="200" data-aos-duration="600">
        <div class="sticky top-24 border border-emerald-200 bg-cream p-6">

          <div class="relative">

            <h2 class="mb-5 text-[10px] font-light uppercase tracking-[4px] text-gold-500">
              Ringkasan Pesanan
            </h2>

            <div class="space-y-3 text-[12px]">

              <div class="flex justify-between font-light text-emerald-700">
                <span>Subtotal</span>
                <span id="summary-subtotal">
                  Rp {{ number_format($total ?? 0, 0, ',', '.') }}
                </span>
              </div>

              <div class="flex justify-between font-light text-emerald-700">
                <span>Pengiriman</span>
                <span class="font-light uppercase tracking-[1px] text-emerald-500 text-[10px]">Gratis</span>
              </div>

            </div>

            <div class="mt-4 flex items-center gap-3">
              <div class="h-px flex-1 bg-emerald-200"></div>
              <div class="h-1 w-1 rotate-45 bg-gold-400"></div>
            </div>

            <div class="mt-4 flex justify-between">
              <span class="text-[12px] font-medium uppercase tracking-[2px] text-emerald-900">Total</span>
              <span class="font-cormorant text-xl font-normal text-emerald-900" id="summary-total">
                Rp {{ number_format($total ?? 0, 0, ',', '.') }}
              </span>
            </div>

            <a href="{{ route('checkout.index') }}"
               class="mt-6 flex w-full items-center justify-center gap-3 bg-emerald-800 py-3.5
                      text-[11px] font-light uppercase tracking-[3px] text-gold-100
                      transition-colors hover:bg-emerald-900">
              Lanjut ke Checkout
              <svg width="14" height="9" viewBox="0 0 14 9" fill="none" stroke="#E8C97A" stroke-width="1.5">
                <line x1="0" y1="4.5" x2="12" y2="4.5"/>
                <polyline points="8,1 12,4.5 8,8"/>
              </svg>
            </a>

            <a href="{{ route('shop.index') }}"
               class="mt-3 flex w-full items-center justify-center gap-2
                      text-[10px] font-light uppercase tracking-[3px] text-emerald-600
                      transition-colors hover:text-emerald-900">
              <svg width="12" height="8" viewBox="0 0 12 8" fill="none" stroke="currentColor" stroke-width="1.5">
                <line x1="12" y1="4" x2="2" y2="4"/>
                <polyline points="5,1 2,4 5,7"/>
              </svg>
              Lanjut Belanja
            </a>

          </div>
        </div>
      </div>

    </div>


    {{-- ══════════════════════════════════════════════════
         CART EMPTY
    ══════════════════════════════════════════════════ --}}
    @else

    <div class="flex flex-col items-center py-24 text-center"
         data-aos="fade-up" data-aos-duration="700">

      <div class="mb-6 flex h-20 w-20 items-center justify-center border border-emerald-200 bg-emerald-50">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
          <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
      </div>

      <h2 class="font-cormorant text-3xl font-normal text-emerald-900">
        Keranjang Masih Kosong
      </h2>

      <p class="mt-2 text-[12px] font-light uppercase tracking-[3px] text-emerald-600">
        Belum ada produk yang ditambahkan
      </p>

      <div class="mt-5 flex items-center gap-3">
        <div class="h-px w-10 bg-emerald-200"></div>
        <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
        <div class="h-px w-10 bg-emerald-200"></div>
      </div>

      <a href="{{ route('shop.index') }}"
         class="mt-8 inline-flex items-center gap-3 border border-emerald-400 px-8 py-3
                text-[11px] font-normal uppercase tracking-[3px] text-emerald-800
                transition-colors hover:border-emerald-800 hover:bg-emerald-800 hover:text-gold-100">
        Lihat Koleksi
        <svg width="14" height="9" viewBox="0 0 14 9" fill="none" stroke="currentColor" stroke-width="1.5">
          <line x1="0" y1="4.5" x2="12" y2="4.5"/>
          <polyline points="8,1 12,4.5 8,8"/>
        </svg>
      </a>

    </div>

    @endif

  </div>
</div>


@push('scripts')
<script>

/* ── Toast ── */
function showToast(message, type) {
  var existing = document.getElementById('cart-toast');
  if (existing) existing.remove();

  var toast = document.createElement('div');
  toast.id = 'cart-toast';
  toast.textContent = message;
  toast.style.cssText = [
    'position:fixed',
    'top:24px',
    'left:50%',
    'transform:translateX(-50%)',
    'z-index:9999',
    'padding:10px 20px',
    'font-size:11px',
    'letter-spacing:2px',
    'text-transform:uppercase',
    'font-family:Jost,sans-serif',
    'opacity:1',
    'transition:opacity 0.3s ease',
    type === 'error'
      ? 'background:#B8860B;color:#0D2B20;'
      : 'background:#1A4A33;color:#F3E2AF;',
  ].join(';');

  document.body.appendChild(toast);

  setTimeout(function() { toast.style.opacity = '0'; }, 1600);
  setTimeout(function() { if (toast.parentNode) toast.remove(); }, 1900);
}


/* ── Recalc summary ── */
function formatRp(num) {
  return 'Rp ' + Math.round(num).toLocaleString('id-ID');
}

function recalcSummary() {
  var total = 0;
  document.querySelectorAll('.item-subtotal').forEach(function(el) {
    total += parseInt(el.dataset.price, 10) * parseInt(el.dataset.qty, 10);
  });
  var sub = document.getElementById('summary-subtotal');
  var tot = document.getElementById('summary-total');
  if (sub) sub.textContent = formatRp(total);
  if (tot) tot.textContent = formatRp(total);
}


/* ── Debounce timers ── */
var debounceTimers = {};


/* ── AJAX update ── */
function ajaxUpdate(form, qty) {
  var data = new FormData(form);
  data.set('quantity', qty);

  fetch(form.action, {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    body: data,
  })
  .then(function(res) {
    /* Server mengembalikan redirect atau JSON — dua-duanya diam-diam ok */
    if (!res.ok) showToast('Gagal menyimpan perubahan', 'error');
  })
  .catch(function() {
    showToast('Koneksi gagal', 'error');
  });
}


/* ── changeQty (dipanggil tombol +/−) ── */
function changeQty(btn, delta) {
  var form  = btn.closest('.cart-qty-form');
  var input = form.querySelector('.cart-qty-input');
  var min   = parseInt(input.min, 10) || 1;
  var max   = parseInt(input.max, 10) || 999;
  var val   = parseInt(input.value, 10) || 1;
  var newVal = val + delta;

  /* Sudah di max, jangan submit sama sekali */
  if (delta > 0 && val >= max) {
    showToast('Stok hanya tersedia ' + max, 'error');
    return; /* ← stop di sini, tidak ada debounce/submit */
  }

  newVal = Math.max(min, Math.min(max, newVal));
  input.value = newVal;
  onQtyChange(input);
}


/* ── onQtyChange (dipanggil changeQty & listener input) ── */
function onQtyChange(input) {
  var form   = input.closest('.cart-qty-form');
  var itemId = form.dataset.itemId;
  var price  = parseInt(form.dataset.price, 10);
  var qty    = parseInt(input.value, 10) || 1;

  /* Clamp sesuai min/max */
  var min = parseInt(input.min, 10) || 1;
  var max = parseInt(input.max, 10) || 999;
  if (qty < min) { qty = min; input.value = min; }
  if (qty > max) { qty = max; input.value = max; showToast('Stok hanya tersedia ' + max, 'error'); }

  /* Update subtotal item langsung di DOM */
  var row = input.closest('[data-item-row]') || form.closest('.flex.gap-4');
  if (row) {
    var subtotalEl = row.querySelector('.item-subtotal');
    if (subtotalEl) {
      subtotalEl.dataset.qty = qty;
      subtotalEl.textContent = formatRp(price * qty);
    }
  }

  /* Recalc summary */
  recalcSummary();

  /* Debounce AJAX (800ms) — tidak reload page */
  clearTimeout(debounceTimers[itemId]);
  debounceTimers[itemId] = setTimeout(function() {
    ajaxUpdate(form, qty);
  }, 800);
}


/* ── Attach listeners ── */
document.querySelectorAll('.cart-qty-input').forEach(function(input) {
  input.addEventListener('input',  function() { onQtyChange(this); });
  input.addEventListener('change', function() { onQtyChange(this); });
});

</script>
@endpush

</x-layouts.app>