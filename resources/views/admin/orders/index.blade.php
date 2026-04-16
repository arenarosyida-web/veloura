<x-layouts.admin title="Pesanan">

<div class="space-y-5 font-jost">

  {{-- ── Header ── --}}
  <div class="flex items-end justify-between" data-aos="fade-down" data-aos-duration="400">
    <div>
      <p class="text-[10px] font-light uppercase tracking-[4px] text-gold-500 mb-1">Admin</p>
      <h1 class="font-cormorant text-3xl font-normal text-emerald-900">Pesanan</h1>
    </div>
  </div>

  {{-- ── Divider ── --}}
  <div class="flex items-center gap-3" data-aos="fade-right" data-aos-duration="300">
    <div class="h-px flex-1 bg-emerald-200"></div>
    <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
    <div class="h-px w-8 bg-emerald-200"></div>
  </div>

  {{-- Flash --}}
  @if(session('success'))
  <div class="border border-emerald-200 bg-emerald-50 px-4 py-3
              text-[11px] font-light uppercase tracking-[2px] text-emerald-700"
       data-aos="fade-down">
    {{ session('success') }}
  </div>
  @endif

  {{-- ── MOBILE: Card List ── --}}
  <div class="space-y-3 md:hidden" data-aos="fade-up" data-aos-duration="500">
    @forelse($orders as $order)
    @php
      $statusStyle = match($order->status) {
        'pending'   => ['dot' => 'bg-gold-400',    'text' => 'text-gold-500'],
        'paid'      => ['dot' => 'bg-emerald-400', 'text' => 'text-emerald-600'],
        'shipped'   => ['dot' => 'bg-emerald-600', 'text' => 'text-emerald-700'],
        'completed' => ['dot' => 'bg-emerald-800', 'text' => 'text-emerald-800'],
        'canceled'  => ['dot' => 'bg-red-400',     'text' => 'text-red-400'],
        default     => ['dot' => 'bg-emerald-200', 'text' => 'text-emerald-400'],
      };
    @endphp
    <div class="border border-emerald-200 bg-cream px-4 py-4 space-y-3">

      {{-- Row 1: Order ID + Status --}}
      <div class="flex items-center justify-between">
        <span class="text-[12px] font-medium text-emerald-900">#ORD-{{ $order->order_id }}</span>
        <div class="flex items-center gap-1.5">
          <span class="h-1.5 w-1.5 rounded-full {{ $statusStyle['dot'] }}"></span>
          <span class="text-[11px] font-light capitalize {{ $statusStyle['text'] }}">
            {{ ucfirst($order->status) }}
          </span>
        </div>
      </div>

      {{-- Divider --}}
      <div class="h-px bg-emerald-100"></div>

      {{-- Row 2: Customer + Tanggal --}}
      <div class="flex items-center justify-between">
        <div>
          <p class="text-[9px] font-light uppercase tracking-[2px] text-emerald-400 mb-0.5">Customer</p>
          <p class="text-[11px] font-light text-emerald-700">{{ $order->receiver_name }}</p>
        </div>
        <div class="text-right">
          <p class="text-[9px] font-light uppercase tracking-[2px] text-emerald-400 mb-0.5">Tanggal</p>
          <p class="text-[11px] font-light text-emerald-600">
            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
          </p>
        </div>
      </div>

      {{-- Row 3: Total + Aksi --}}
      <div class="flex items-center justify-between">
        <div>
          <p class="text-[9px] font-light uppercase tracking-[2px] text-emerald-400 mb-0.5">Total</p>
          <p class="text-[12px] font-light text-emerald-900">
            Rp {{ number_format($order->total_price, 0, ',', '.') }}
          </p>
        </div>
        <a href="{{ route('admin.orders.show', $order->order_id) }}"
           class="border border-emerald-200 px-3 py-1.5 text-[10px] font-light
                  uppercase tracking-[1px] text-emerald-700
                  transition-colors hover:border-gold-400 hover:text-gold-500">
          Lihat
        </a>
      </div>

    </div>
    @empty
    <div class="border border-emerald-200 bg-cream px-5 py-16 text-center">
      <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center border border-emerald-200 bg-emerald-50">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
      </div>
      <p class="font-cormorant text-xl font-normal text-emerald-800">Belum ada pesanan</p>
    </div>
    @endforelse
  </div>

  {{-- ── DESKTOP: Table ── --}}
  <div class="hidden overflow-x-auto border border-emerald-200 bg-cream md:block"
       data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
    <table class="w-full">
      <thead>
        <tr class="border-b border-emerald-200 bg-emerald-50/60">
          <th class="px-5 py-3 text-left text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Order ID</th>
          <th class="px-5 py-3 text-left text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Customer</th>
          <th class="px-5 py-3 text-left text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Total</th>
          <th class="px-5 py-3 text-left text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Status</th>
          <th class="px-5 py-3 text-left text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Tanggal</th>
          <th class="px-5 py-3 text-right text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
        @php
          $statusStyle = match($order->status) {
            'pending'   => ['dot' => 'bg-gold-400',    'text' => 'text-gold-500'],
            'paid'      => ['dot' => 'bg-emerald-400', 'text' => 'text-emerald-600'],
            'shipped'   => ['dot' => 'bg-emerald-600', 'text' => 'text-emerald-700'],
            'completed' => ['dot' => 'bg-emerald-800', 'text' => 'text-emerald-800'],
            'canceled'  => ['dot' => 'bg-red-400',     'text' => 'text-red-400'],
            default     => ['dot' => 'bg-emerald-200', 'text' => 'text-emerald-400'],
          };
        @endphp
        <tr class="border-b border-emerald-100 transition-colors last:border-0 hover:bg-emerald-50/40">
          <td class="px-5 py-4">
            <span class="text-[12px] font-medium text-emerald-900">#ORD-{{ $order->order_id }}</span>
          </td>
          <td class="px-5 py-4">
            <span class="text-[11px] font-light text-emerald-700">{{ $order->receiver_name }}</span>
          </td>
          <td class="px-5 py-4">
            <span class="text-[12px] font-light text-emerald-900">
              Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </span>
          </td>
          <td class="px-5 py-4">
            <div class="flex items-center gap-1.5">
              <span class="h-1.5 w-1.5 rounded-full {{ $statusStyle['dot'] }}"></span>
              <span class="text-[11px] font-light capitalize {{ $statusStyle['text'] }}">
                {{ ucfirst($order->status) }}
              </span>
            </div>
          </td>
          <td class="px-5 py-4">
            <span class="text-[11px] font-light text-emerald-600">
              {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
            </span>
          </td>
          <td class="px-5 py-4 text-right">
            <a href="{{ route('admin.orders.show', $order->order_id) }}"
               class="border border-emerald-200 px-3 py-1.5 text-[10px] font-light
                      uppercase tracking-[1px] text-emerald-700
                      transition-colors hover:border-gold-400 hover:text-gold-500">
              Lihat
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-5 py-16 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center border border-emerald-200 bg-emerald-50">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
              </svg>
            </div>
            <p class="font-cormorant text-xl font-normal text-emerald-800">Belum ada pesanan</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Count + Pagination --}}
  @if($orders->count() > 0)
  <div class="flex items-center justify-between" data-aos="fade-up" data-aos-delay="200">
    <p class="text-[10px] font-light uppercase tracking-[2px] text-emerald-500">
      {{ $orders->total() }} pesanan
    </p>
    @if($orders->hasPages())
      <div class="text-[10px] font-light text-emerald-500">
        {{ $orders->links() }}
      </div>
    @endif
  </div>
  @endif

</div>

</x-layouts.admin>