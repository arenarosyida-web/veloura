<x-layouts.app title="Riwayat Pesanan">

<div class="min-h-screen bg-cream font-jost">
  <div class="mx-auto max-w-7xl px-6 py-16">

    {{-- ── Page header ── --}}
    <div class="mb-10" data-aos="fade-up">
      <h1 class="font-cormorant text-5xl font-normal text-emerald-900">Riwayat Pesanan</h1>
    </div>

    {{-- Flash --}}
    @if(session('success'))
      <div class="mb-5 border border-emerald-200 bg-emerald-50 px-4 py-3
                  text-[11px] font-light uppercase tracking-[2px] text-emerald-700"
           data-aos="fade-up" data-aos-delay="100">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="mb-5 border border-red-200 bg-red-50 px-4 py-3
                  text-[11px] font-light uppercase tracking-[2px] text-red-600"
           data-aos="fade-up" data-aos-delay="100">
        {{ session('error') }}
      </div>
    @endif


    {{-- ORDER LIST --}}
    @forelse($orders as $index => $order)

    @php
      $statusConfig = match($order->status) {
        'pending'   => ['label' => 'Menunggu',   'text' => 'text-gold-500',    'dot' => 'bg-gold-400'],
        'paid'      => ['label' => 'Dibayar',    'text' => 'text-emerald-600', 'dot' => 'bg-emerald-400'],
        'shipped'   => ['label' => 'Dikirim',    'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
        'completed' => ['label' => 'Selesai',    'text' => 'text-emerald-500', 'dot' => 'bg-emerald-300'],
        'canceled'  => ['label' => 'Dibatalkan', 'text' => 'text-red-400',     'dot' => 'bg-red-300'],
        default     => ['label' => ucfirst($order->status), 'text' => 'text-emerald-500', 'dot' => 'bg-emerald-200'],
      };
    @endphp

    <div class="mb-3 border border-emerald-200 bg-cream
                transition-colors hover:border-gold-400"
         data-aos="fade-up"
         data-aos-delay="{{ $index * 80 }}">

      {{-- Header --}}
      <div class="flex items-center justify-between border-b border-emerald-100
                  bg-emerald-50/60 px-5 py-3">
        <div class="flex items-center gap-4">
          <span class="font-cormorant text-base text-emerald-900">
            #ORD-{{ $order->order_id }}
          </span>
          <span class="text-[10px] font-light uppercase tracking-[2px] text-emerald-500">
            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
          </span>
        </div>
        <div class="flex items-center gap-1.5">
          <span class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
          <span class="text-[10px] font-light uppercase tracking-[2px] {{ $statusConfig['text'] }}">
            {{ $statusConfig['label'] }}
          </span>
        </div>
      </div>

      {{-- Produk --}}
      <div class="flex flex-col gap-3 px-5 py-4">

        @foreach($order->items->take(2) as $item)
        <div class="flex items-center gap-3">
          <div class="h-12 w-12 shrink-0 overflow-hidden border border-emerald-200 bg-emerald-50">
            @if($item->product && $item->product->image)
              <img src="{{ asset('storage/'.$item->product->image) }}"
                   class="h-full w-full object-cover">
            @else
              <div class="flex h-full w-full items-center justify-center">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="#A8D5B5" stroke-width="1">
                  <circle cx="12" cy="8" r="4"/>
                  <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
              </div>
            @endif
          </div>
          <div class="min-w-0">
            <p class="font-cormorant text-base text-emerald-900">
              {{ $item->product->name ?? 'Produk dihapus' }}
            </p>
            <p class="text-[11px] font-light text-emerald-600">
              {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}
            </p>
          </div>
        </div>
        @endforeach

        @if($order->items->count() > 2)
          <p class="text-[10px] font-light uppercase tracking-[2px] text-emerald-400">
            +{{ $order->items->count() - 2 }} produk lainnya
          </p>
        @endif

      </div>

      {{-- Footer --}}
      <div class="flex flex-wrap items-center justify-between gap-3
                  border-t border-emerald-100 px-5 py-3">

        <div class="flex items-center gap-2">
          <span class="text-[10px] font-light uppercase tracking-[2px] text-emerald-500">Total</span>
          <span class="font-cormorant text-lg text-emerald-900">
            Rp {{ number_format($order->total_price, 0, ',', '.') }}
          </span>
        </div>

        <div class="flex items-center gap-2">

          @if($order->status === 'pending' && $order->payment && $order->payment->status !== 'paid')
            <a href="{{ route('user.orders.pay', $order->order_id) }}"
               class="border border-gold-400 bg-emerald-800 px-4 py-1.5
                      text-[10px] uppercase tracking-[2px] text-gold-100
                      hover:bg-emerald-900">
              Bayar Sekarang
            </a>
          @endif

          @if($order->status === 'pending')
            <form action="{{ route('user.orders.cancel', $order->order_id) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin membatalkan pesanan #ORD-{{ $order->order_id }}?')">
              @csrf
              @method('PATCH')
              <button type="submit"
                      class="border border-red-200 bg-red-50 px-4 py-1.5
                             text-[10px] uppercase tracking-[2px] text-red-500
                             hover:bg-red-100">
                Batalkan
              </button>
            </form>
          @endif

        </div>
      </div>

    </div>
    @empty

    {{-- Empty state --}}
    <div class="flex flex-col items-center py-24 text-center" data-aos="fade-up">
      <h2 class="font-cormorant text-3xl text-emerald-900">Belum Ada Pesanan</h2>
      <p class="mt-2 text-[11px] uppercase tracking-[3px] text-emerald-500">
        Mulai belanja dan temukan kue pilihan Anda
      </p>
    </div>

    @endforelse


    {{-- ── Pagination FULL (tidak dipotong lagi) ── --}}
    @if($orders->hasPages())
    <div class="mt-10" data-aos="fade-up">

      <div class="mb-6 flex items-center gap-3">
        <div class="h-px flex-1 bg-emerald-200"></div>
        <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
        <div class="h-px flex-1 bg-emerald-200"></div>
      </div>

      <div class="flex items-center justify-center gap-1">

        {{-- Prev --}}
        @if($orders->onFirstPage())
          <span class="flex h-9 w-9 cursor-not-allowed items-center justify-center
                       border border-emerald-200 text-emerald-300 opacity-40">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor">
              <polyline points="8,1 3,6 8,11"/>
            </svg>
          </span>
        @else
          <a href="{{ $orders->previousPageUrl() }}"
             class="flex h-9 w-9 items-center justify-center border border-emerald-200
                    text-emerald-700 hover:bg-emerald-800 hover:text-gold-100">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor">
              <polyline points="8,1 3,6 8,11"/>
            </svg>
          </a>
        @endif

        {{-- Numbers --}}
        @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
          @if($page == $orders->currentPage())
            <span class="flex h-9 w-9 items-center justify-center border border-gold-500
                         bg-emerald-800 text-[11px] text-gold-100">
              {{ $page }}
            </span>
          @else
            <a href="{{ $url }}"
               class="flex h-9 w-9 items-center justify-center border border-emerald-200
                      text-[11px] text-emerald-700 hover:bg-emerald-800 hover:text-gold-100">
              {{ $page }}
            </a>
          @endif
        @endforeach

        {{-- Next --}}
        @if($orders->hasMorePages())
          <a href="{{ $orders->nextPageUrl() }}"
             class="flex h-9 w-9 items-center justify-center border border-emerald-200
                    text-emerald-700 hover:bg-emerald-800 hover:text-gold-100">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor">
              <polyline points="4,1 9,6 4,11"/>
            </svg>
          </a>
        @else
          <span class="flex h-9 w-9 cursor-not-allowed items-center justify-center
                       border border-emerald-200 text-emerald-300 opacity-40">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor">
              <polyline points="4,1 9,6 4,11"/>
            </svg>
          </span>
        @endif

      </div>
    </div>
    @endif

  </div>
</div>

</x-layouts.app>