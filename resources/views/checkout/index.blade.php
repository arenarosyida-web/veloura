<x-layouts.checkout title="Checkout" :showCart="true">

@push('styles')
<style>
  @keyframes chkFadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .chk-anim-1 { opacity:0; animation: chkFadeUp .55s ease forwards .08s; }
  .chk-anim-2 { opacity:0; animation: chkFadeUp .60s ease forwards .18s; }

  .chk-input {
    width: 100%;
    padding: 11px 14px;
    border: 0.5px solid #A8D5B5;
    background: #FDFCFA;
    font-family: 'Jost', sans-serif;
    font-size: 13px;
    font-weight: 300;
    color: #0D2B20;
    outline: none;
    transition: border-color .2s;
  }
  .chk-input:focus { border-color: #1A4A33; }
  .chk-input.error { border-color: #E24B4A; }
  .chk-input::placeholder { color: #A8D5B5; }
</style>
@endpush

<div class="grid gap-10 md:grid-cols-[1fr_380px]">

  {{-- ── LEFT: Form ── --}}
  <div class="chk-anim-1">

    <div class="mb-5 flex items-center gap-3">
      <div class="h-px w-6 bg-gold-500"></div>
      <span class="text-[10px] font-light uppercase tracking-[4px] text-gold-500">Detail Pengiriman</span>
    </div>
    <h2 class="mb-8 font-cormorant text-3xl font-normal text-emerald-900">
      Delivery Details
    </h2>

    <form method="POST" action="{{ route('checkout.store') }}" class="flex flex-col gap-5">
      @csrf

      {{-- Nama Penerima --}}
      <div>
        <label class="mb-1.5 block text-[10px] font-light uppercase tracking-[3px] text-emerald-700">
          Nama Penerima <span class="text-red-400">*</span>
        </label>
        <input type="text" name="receiver_name"
               value="{{ old('receiver_name', Auth::user()->name) }}"
               required
               class="chk-input {{ $errors->has('receiver_name') ? 'error' : '' }}">
        @error('receiver_name')
          <p class="mt-1 text-[11px] font-light text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- Nomor Telepon --}}
      <div>
        <label class="mb-1.5 block text-[10px] font-light uppercase tracking-[3px] text-emerald-700">
          Nomor Telepon <span class="text-red-400">*</span>
        </label>
        <input type="text" name="phone"
               value="{{ old('phone') }}"
               required
               placeholder="08xx-xxxx-xxxx"
               class="chk-input {{ $errors->has('phone') ? 'error' : '' }}">
        @error('phone')
          <p class="mt-1 text-[11px] font-light text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- Alamat Lengkap --}}
      <div>
        <label class="mb-1.5 block text-[10px] font-light uppercase tracking-[3px] text-emerald-700">
          Alamat Lengkap <span class="text-red-400">*</span>
        </label>
        <textarea name="full_address"
                  rows="3"
                  required
                  placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi..."
                  class="chk-input resize-none {{ $errors->has('full_address') ? 'error' : '' }}">{{ old('full_address') }}</textarea>
        @error('full_address')
          <p class="mt-1 text-[11px] font-light text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- Info Midtrans --}}
      <div class="flex items-center gap-3 border border-emerald-100 bg-emerald-50 px-4 py-3">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1A4A33" stroke-width="1.5">
          <rect x="2" y="6" width="20" height="12" rx="2"/>
          <path d="M2 10h20M6 14h2M10 14h4"/>
        </svg>
        <p class="text-[11px] font-light text-emerald-700">
          Pilih metode pembayaran (Transfer, GoPay, QRIS, dll) di langkah berikutnya
        </p>
      </div>

      <button type="submit"
              class="mt-2 flex w-full items-center justify-center gap-3 bg-emerald-800 py-4
                     text-[11px] font-light uppercase tracking-[3px] text-gold-100
                     transition-colors hover:bg-emerald-900">
        Lanjut ke Pembayaran
        <svg width="14" height="9" viewBox="0 0 14 9" fill="none" stroke="#E8C97A" stroke-width="1.5">
          <line x1="0" y1="4.5" x2="12" y2="4.5"/>
          <polyline points="8,1 12,4.5 8,8"/>
        </svg>
      </button>

    </form>
  </div>

  {{-- ── RIGHT: Summary ── --}}
  <div class="chk-anim-2">
    <div class="sticky top-24 border border-emerald-200 bg-cream p-6">

      <div class="mb-5 flex items-center gap-3">
        <div class="h-px w-5 bg-gold-500"></div>
        <span class="text-[10px] font-light uppercase tracking-[4px] text-gold-500">Ringkasan Pesanan</span>
      </div>

      <div class="mb-5 flex flex-col gap-3">
        @foreach($cartItems as $item)
        <div class="flex items-center gap-3">
          <div class="h-12 w-12 shrink-0 overflow-hidden border border-emerald-200 bg-emerald-50">
            @if($item->product->image)
              <img src="{{ asset('storage/'.$item->product->image) }}"
                   alt="{{ $item->product->name }}"
                   class="h-full w-full object-cover">
            @else
              <div class="flex h-full w-full items-center justify-center">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                  <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
              </div>
            @endif
          </div>
          <div class="min-w-0 flex-1">
            <p class="truncate text-[12px] font-normal text-emerald-900">{{ $item->product->name }}</p>
            <p class="text-[10px] font-light uppercase tracking-[1px] text-emerald-500">×{{ $item->quantity }}</p>
          </div>
          <span class="shrink-0 text-[12px] font-light text-emerald-800">
            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
          </span>
        </div>
        @endforeach
      </div>

      <div class="mb-4 flex items-center gap-2">
        <div class="h-px flex-1 bg-emerald-200"></div>
        <div class="h-1 w-1 rotate-45 bg-gold-400 opacity-50"></div>
      </div>

      <div class="mb-5 flex flex-col gap-2.5">
        <div class="flex justify-between text-[12px] font-light text-emerald-700">
          <span>Subtotal</span>
          <span>Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-[12px] font-light text-emerald-700">
          <span>Ongkos Kirim</span>
          <span class="text-[10px] font-light uppercase tracking-[1px] text-emerald-500">Gratis</span>
        </div>
      </div>

      <div class="flex items-baseline justify-between border-t border-emerald-200 pt-4">
        <span class="text-[11px] font-medium uppercase tracking-[3px] text-emerald-900">Total</span>
        <span class="font-cormorant text-2xl font-normal text-emerald-900">
          Rp {{ number_format($total ?? 0, 0, ',', '.') }}
        </span>
      </div>

      <div class="mt-5 flex items-center gap-2 border-t border-emerald-100 pt-4">
        <svg width="12" height="14" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
        </svg>
        <span class="text-[10px] font-light uppercase tracking-[2px] text-emerald-400">
          Transaksi aman & terenkripsi
        </span>
      </div>

    </div>
  </div>

</div>

</x-layouts.checkout>