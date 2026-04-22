<x-layouts.admin title="Pembayaran">

<div class="space-y-5 font-jost">

  {{-- ── Header ── --}}
  <div class="flex items-end justify-between" data-aos="fade-down" data-aos-duration="400">
    <div>
      <p class="text-[10px] font-medium uppercase tracking-[3px] text-gold-500 mb-1">Admin</p>
      <h1 class="font-cormorant text-3xl font-normal text-brand-900">Pembayaran</h1>
    </div>
  </div>

  {{-- ── Divider ── --}}
  <div class="flex items-center gap-3" data-aos="fade-right" data-aos-duration="300">
    <div class="h-px flex-1 bg-brand-200"></div>
    <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
    <div class="h-px w-8 bg-brand-200"></div>
  </div>

  {{-- Flash --}}
  @if(session('success'))
  <div class="border border-brand-200 bg-brand-50 px-4 py-3
              text-[11px] font-medium uppercase tracking-[2px] text-brand-700"
       data-aos="fade-down">
    {{ session('success') }}
  </div>
  @endif

  {{-- ── MOBILE: Card List ── --}}
  <div class="space-y-3 md:hidden" data-aos="fade-up" data-aos-duration="500">
    @forelse($payments as $payment)
    @php
      $statusStyle = match($payment->status) {
        'pending'    => ['dot' => 'bg-gold-400',    'text' => 'text-gold-500'],
        'paid'       => ['dot' => 'bg-green-500', 'text' => 'text-brand-600'],
        'settlement' => ['dot' => 'bg-green-500', 'text' => 'text-brand-600'],
        'failed'     => ['dot' => 'bg-red-600',     'text' => 'text-red-600 font-semibold'],
        default      => ['dot' => 'bg-brand-200', 'text' => 'text-brand-600'],
      };
    @endphp
    <div class="border border-brand-200 bg-cream px-4 py-4 space-y-3">

      {{-- Row 1: Payment ID + Status --}}
      <div class="flex items-center justify-between">
        <span class="text-[12px] font-medium text-brand-900">#PAY-{{ $payment->payment_id }}</span>
        <div class="flex items-center gap-1.5">
          <span class="h-1.5 w-1.5 rounded-full {{ $statusStyle['dot'] }}"></span>
          <span class="text-[11px] font-light capitalize {{ $statusStyle['text'] }}">
            {{ ucfirst($payment->status) }}
          </span>
        </div>
      </div>

      {{-- Divider --}}
      <div class="h-px bg-brand-100"></div>

      {{-- Row 2: Order ID + Metode --}}
      <div class="flex items-center justify-between">
        <div>
          <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-600 mb-0.5">Order</p>
          <a href="{{ route('admin.orders.show', $payment->order_id) }}"
             class="text-[12px] font-medium text-brand-800 transition-colors
                    hover:text-gold-500 underline-offset-2 hover:underline">
            #ORD-{{ $payment->order_id }}
          </a>
        </div>
        <div class="text-right">
          <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-600 mb-0.5">Metode</p>
          <p class="text-[12px] font-medium text-brand-800">{{ $payment->method ?? '-' }}</p>
        </div>
      </div>

      {{-- Row 3: Jumlah + Tanggal --}}
      <div class="flex items-center justify-between">
        <div>
          <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-600 mb-0.5">Jumlah</p>
          <p class="text-[13px] font-medium text-brand-900">
            Rp {{ number_format($payment->amount, 0, ',', '.') }}
          </p>
        </div>
        <div class="text-right">
          <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-600 mb-0.5">Dibayar Pada</p>
          <p class="text-[11px] font-light text-brand-600">
            {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') : '-' }}
          </p>
        </div>
      </div>

    </div>
    @empty
    <div class="border border-brand-200 bg-cream px-5 py-16 text-center">
      <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center border border-brand-200 bg-brand-50">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
        </svg>
      </div>
      <p class="font-cormorant text-xl font-normal text-brand-800">Belum ada data pembayaran</p>
    </div>
    @endforelse
  </div>

  {{-- ── DESKTOP: Table ── --}}
  <div class="hidden overflow-hidden border border-brand-200 bg-cream md:block"
       data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
    <table class="w-full">
      <thead>
        <tr class="border-b border-brand-200 bg-brand-50/60">
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Payment ID</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Order ID</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Metode</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Jumlah</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Status</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Dibayar Pada</th>
        </tr>
      </thead>
      <tbody>
        @forelse($payments as $payment)
        @php
          $statusStyle = match($payment->status) {
            'pending'    => ['dot' => 'bg-gold-400',    'text' => 'text-gold-500'],
            'paid'       => ['dot' => 'bg-green-500', 'text' => 'text-brand-600'],
            'settlement' => ['dot' => 'bg-green-500', 'text' => 'text-brand-600'],
            'failed'     => ['dot' => 'bg-red-600',     'text' => 'text-red-600 font-semibold'],
            default      => ['dot' => 'bg-brand-200', 'text' => 'text-brand-600'],
          };
        @endphp
        <tr class="border-b border-brand-100 transition-colors last:border-0 hover:bg-brand-50/40">
          <td class="px-5 py-4">
            <span class="text-[12px] font-medium text-brand-900">#PAY-{{ $payment->payment_id }}</span>
          </td>
          <td class="px-5 py-4">
            <a href="{{ route('admin.orders.show', $payment->order_id) }}"
               class="text-[12px] font-medium text-brand-800 transition-colors
                      hover:text-gold-500 underline-offset-2 hover:underline">
              #ORD-{{ $payment->order_id }}
            </a>
          </td>
          <td class="px-5 py-4">
            <span class="text-[12px] font-medium text-brand-800">{{ $payment->method ?? '-' }}</span>
          </td>
          <td class="px-5 py-4">
            <span class="text-[13px] font-medium text-brand-900">
              Rp {{ number_format($payment->amount, 0, ',', '.') }}
            </span>
          </td>
          <td class="px-5 py-4">
            <div class="flex items-center gap-1.5">
              <span class="h-1.5 w-1.5 rounded-full {{ $statusStyle['dot'] }}"></span>
              <span class="text-[11px] font-light capitalize {{ $statusStyle['text'] }}">
                {{ ucfirst($payment->status) }}
              </span>
            </div>
          </td>
          <td class="px-5 py-4">
            <span class="text-[11px] font-light text-brand-600">
              {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') : '-' }}
            </span>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-5 py-16 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center border border-brand-200 bg-brand-50">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
              </svg>
            </div>
            <p class="font-cormorant text-xl font-normal text-brand-800">Belum ada data pembayaran</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Count + Pagination --}}
  @if($payments->count() > 0)
  <div class="flex items-center justify-between" data-aos="fade-up" data-aos-delay="200">
    <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-700">
      {{ $payments->total() }} pembayaran
    </p>
    @if($payments->hasPages())
      <div class="text-[11px] font-medium text-brand-700">
        {{ $payments->links() }}
      </div>
    @endif
  </div>
  @endif

</div>

</x-layouts.admin>