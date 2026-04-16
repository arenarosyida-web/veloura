<x-layouts.checkout title="Pesanan Dikonfirmasi" :showCart="false">

<div class="min-h-screen bg-cream font-jost">
  <div class="mx-auto max-w-lg px-6 py-20 text-center">

    @php
      $isPaid = isset($order) && $order->payment && $order->payment->status === 'paid';
    @endphp

    {{-- ── Icon ── --}}
    <div class="relative mx-auto mb-8 flex h-20 w-20 items-center justify-center"
         data-aos="zoom-in" data-aos-duration="600">
      <div class="relative flex h-20 w-20 items-center justify-center border
                  {{ $isPaid ? 'border-emerald-200 bg-emerald-50' : 'border-yellow-200 bg-yellow-50' }}">
        @if($isPaid)
          <svg width="28" height="22" viewBox="0 0 28 22" fill="none">
            <polyline points="2,12 10,20 26,2"
                      stroke="#1A4A33" stroke-width="2.5"
                      stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        @else
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="1.5">
            <circle cx="12" cy="12" r="10"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
          </svg>
        @endif
      </div>
    </div>

    {{-- Heading --}}
    <div class="mb-2 flex items-center justify-center gap-3"
         data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
      <div class="h-px w-8 {{ $isPaid ? 'bg-gold-500' : 'bg-yellow-400' }}"></div>
      <span class="text-[10px] font-light uppercase tracking-[4px]
                   {{ $isPaid ? 'text-gold-500' : 'text-yellow-600' }}">
        {{ $isPaid ? 'Pesanan Dikonfirmasi' : 'Menunggu Pembayaran' }}
      </span>
      <div class="h-px w-8 {{ $isPaid ? 'bg-gold-500' : 'bg-yellow-400' }}"></div>
    </div>

    <h1 class="font-cormorant text-4xl font-normal md:text-5xl
               {{ $isPaid ? 'text-emerald-900' : 'text-yellow-800' }}"
        data-aos="fade-up" data-aos-duration="600" data-aos-delay="150">
      {{ $isPaid ? 'Terima Kasih!' : 'Pesanan Dibuat!' }}
    </h1>

    <p class="mt-4 text-[13px] font-light leading-[1.85]
              {{ $isPaid ? 'text-emerald-700' : 'text-yellow-700' }}"
       data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
      @if($isPaid)
        Pesanan Anda sedang kami siapkan dengan penuh perhatian.<br>
        Kami akan menghubungi Anda segera setelah pesanan siap dikirim.
      @else
        Pesanan Anda telah dibuat namun pembayaran belum selesai.<br>
        Selesaikan pembayaran agar pesanan segera diproses.
      @endif
    </p>

    {{-- ── Order Detail Card ── --}}
    @if(isset($order))
    <div class="mb-8 mt-8 border text-left
                {{ $isPaid ? 'border-emerald-200' : 'border-yellow-200' }} bg-cream"
         data-aos="fade-up" data-aos-duration="600" data-aos-delay="250">
      <div class="p-5">

        <p class="mb-4 text-[10px] font-light uppercase tracking-[3px]
                  {{ $isPaid ? 'text-gold-500' : 'text-yellow-600' }}">
          Detail Pesanan
        </p>

        <div class="flex flex-col gap-3">

          <div class="flex items-center justify-between">
            <span class="text-[11px] font-light uppercase tracking-[2px] text-emerald-600">Order ID</span>
            <span class="font-cormorant text-base font-normal text-emerald-900">
              #ORD-{{ $order->order_id }}
            </span>
          </div>
          <div class="h-px bg-emerald-100"></div>

          <div class="flex items-center justify-between">
            <span class="text-[11px] font-light uppercase tracking-[2px] text-emerald-600">Penerima</span>
            <span class="font-cormorant text-base font-normal text-emerald-900">
              {{ $order->receiver_name }}
            </span>
          </div>
          <div class="h-px bg-emerald-100"></div>

          <div class="flex items-start justify-between gap-4">
            <span class="shrink-0 text-[11px] font-light uppercase tracking-[2px] text-emerald-600">Alamat</span>
            <span class="text-right text-[12px] font-light text-emerald-900">
              {{ $order->full_address }}
            </span>
          </div>
          <div class="h-px bg-emerald-100"></div>

          @if($order->payment)
          <div class="flex items-center justify-between">
            <span class="text-[11px] font-light uppercase tracking-[2px] text-emerald-600">Pembayaran</span>
            <span class="font-cormorant text-base font-normal text-emerald-900">
              {{ $order->payment->method ?? '-' }}
            </span>
          </div>
          <div class="h-px bg-emerald-100"></div>
          @endif

          <div class="flex flex-col gap-2 py-1">
            <span class="mb-1 text-[11px] font-light uppercase tracking-[2px] text-emerald-600">Item</span>
            @foreach($order->items as $item)
              <div class="flex items-center justify-between">
                <span class="text-[12px] font-light text-emerald-800">
                  {{ $item->product->name ?? 'Produk' }}
                  <span class="text-emerald-500">×{{ $item->quantity }}</span>
                </span>
                <span class="text-[12px] font-light text-emerald-900">
                  Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                </span>
              </div>
            @endforeach
          </div>
          <div class="h-px bg-emerald-100"></div>

          <div class="flex items-center justify-between">
            <span class="text-[11px] font-light uppercase tracking-[2px] text-emerald-600">Total</span>
            <span class="font-cormorant text-lg font-semibold text-emerald-900">
              Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </span>
          </div>
          <div class="h-px bg-emerald-100"></div>

          <div class="flex items-center justify-between">
            <span class="text-[11px] font-light uppercase tracking-[2px] text-emerald-600">Status</span>
            <div class="flex items-center gap-2">
              <span class="h-1.5 w-1.5 rounded-full
                           {{ $isPaid ? 'bg-gold-400' : 'bg-yellow-400' }}"></span>
              <span class="text-[11px] font-light uppercase tracking-[2px]
                           {{ $isPaid ? 'text-gold-500' : 'text-yellow-600' }}">
                {{ $isPaid ? 'Diproses' : 'Menunggu Pembayaran' }}
              </span>
            </div>
          </div>

        </div>
      </div>
    </div>
    @endif


    {{-- ══════════════════════════════════════
         CTA BUTTONS
         Mobile  : stack vertikal, lebar penuh
         Desktop : jika pending ada 3 tombol → row wrap
                   jika paid ada 2 tombol → row center
    ══════════════════════════════════════ --}}
    <div class="flex flex-col gap-3"
     data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">

  @if(!$isPaid && isset($order))
    <a href="{{ route('user.orders.pay', $order->order_id) }}"
       class="flex min-h-[48px] w-full items-center justify-center gap-3
              bg-yellow-600 px-6 py-3 text-[11px] font-light uppercase
              tracking-[3px] text-white transition-colors hover:bg-yellow-700">
      Selesaikan Pembayaran
      <svg width="14" height="9" viewBox="0 0 14 9" fill="none" stroke="white" stroke-width="1.5">
        <line x1="0" y1="4.5" x2="12" y2="4.5"/>
        <polyline points="8,1 12,4.5 8,8"/>
      </svg>
    </a>
  @endif

  <a href="{{ route('user.orders.index') }}"
     class="flex min-h-[48px] w-full items-center justify-center gap-3
            bg-emerald-800 px-6 py-3 text-[11px] font-light uppercase
            tracking-[3px] text-gold-100 transition-colors hover:bg-emerald-900">
    Lihat Pesanan
    <svg width="14" height="9" viewBox="0 0 14 9" fill="none" stroke="#E8C97A" stroke-width="1.5">
      <line x1="0" y1="4.5" x2="12" y2="4.5"/>
      <polyline points="8,1 12,4.5 8,8"/>
    </svg>
  </a>

  <a href="{{ route('shop.index') }}"
     class="flex min-h-[48px] w-full items-center justify-center gap-2
            border border-emerald-400 px-6 py-3 text-[11px] font-light
            uppercase tracking-[3px] text-emerald-800 transition-colors
            hover:border-emerald-800 hover:bg-emerald-800 hover:text-gold-100">
    Lihat Koleksi
  </a>

</div>

  </div>
</div>

</x-layouts.checkout>