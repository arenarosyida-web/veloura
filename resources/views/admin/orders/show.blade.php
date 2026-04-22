<x-layouts.admin title="Detail Pesanan">

<div class="max-w-4xl font-jost space-y-5">

  {{-- ── Header ── --}}
  <div data-aos="fade-down" data-aos-duration="400">
    <a href="{{ route('admin.orders.index') }}"
       class="mb-4 inline-flex items-center gap-2 text-[10px] font-medium uppercase
              tracking-[2px] text-brand-700 transition-colors hover:text-brand-900">
      <svg width="12" height="8" viewBox="0 0 12 8" fill="none" stroke="currentColor" stroke-width="1.5">
        <line x1="12" y1="4" x2="2" y2="4"/><polyline points="5,1 2,4 5,7"/>
      </svg>
      Kembali ke Pesanan
    </a>
    <p class="text-[10px] font-medium uppercase tracking-[3px] text-gold-500 mb-1 mt-4">Admin</p>
    <h1 class="font-cormorant text-3xl font-normal text-brand-900">
      Detail Pesanan &nbsp;<span class="text-gold-500">#ORD-{{ $order->order_id }}</span>
    </h1>
    <div class="mt-3 flex items-center gap-3">
      <div class="h-px w-12 bg-brand-200"></div>
      <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
      <div class="h-px w-6 bg-brand-200"></div>
    </div>
  </div>

  {{-- Flash --}}
  @if(session('success'))
  <div class="border border-brand-200 bg-brand-50 px-4 py-3
              text-[11px] font-medium uppercase tracking-[2px] text-brand-700"
       data-aos="fade-down">
    {{ session('success') }}
  </div>
  @endif
  @if(session('error'))
  <div class="border border-red-200 bg-red-50 px-4 py-3
              text-[11px] font-medium uppercase tracking-[2px] text-red-600"
       data-aos="fade-down">
    {{ session('error') }}
  </div>
  @endif

  {{-- ── Informasi Pelanggan ── --}}
  <div class="border border-brand-200 bg-cream p-6"
       data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">

    <p class="text-[10px] font-medium uppercase tracking-[3px] text-brand-600 mb-4">
      Informasi Pelanggan
    </p>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

      <div class="flex flex-col gap-1">
        <p class="text-[10px] font-medium uppercase tracking-[3px] text-brand-700">Nama</p>
        <p class="text-[13px] font-medium text-brand-900">{{ $order->receiver_name }}</p>
      </div>

      <div class="flex flex-col gap-1">
        <p class="text-[10px] font-medium uppercase tracking-[3px] text-brand-700">Telepon</p>
        <p class="text-[13px] font-medium text-brand-900">{{ $order->phone }}</p>
      </div>

      <div class="flex flex-col gap-1">
        <p class="text-[10px] font-medium uppercase tracking-[3px] text-brand-700">Alamat</p>
        <p class="text-[13px] font-medium text-brand-900">{{ $order->full_address }}</p>
      </div>

      <div class="flex flex-col gap-1">
        <p class="text-[10px] font-medium uppercase tracking-[3px] text-brand-700">Tanggal Pemesanan</p>
        <p class="text-[13px] font-medium text-brand-900">
          {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
        </p>
      </div>

      <div class="flex flex-col gap-1">
        <p class="text-[10px] font-medium uppercase tracking-[3px] text-brand-700">Metode Pembayaran</p>
        <p class="text-[13px] font-medium text-brand-900">
          {{ $order->payment->method ?? '-' }}
        </p>
      </div>

      <div class="flex flex-col gap-1">
        <p class="text-[10px] font-medium uppercase tracking-[3px] text-brand-700">Status</p>
        @php
          $statusStyle = match($order->status) {
            'pending'   => ['dot' => 'bg-gold-400',    'text' => 'text-gold-500'],
            'paid'      => ['dot' => 'bg-green-500', 'text' => 'text-brand-600'],
            'shipped'   => ['dot' => 'bg-brand-600', 'text' => 'text-brand-700'],
            'completed' => ['dot' => 'bg-brand-800', 'text' => 'text-brand-800'],
            'canceled'  => ['dot' => 'bg-red-600',     'text' => 'text-red-600 font-semibold'],
            default     => ['dot' => 'bg-brand-200', 'text' => 'text-brand-600'],
          };
        @endphp
        <div class="flex items-center gap-1.5 mt-0.5">
          <span class="h-1.5 w-1.5 rounded-full {{ $statusStyle['dot'] }}"></span>
          <span class="text-[13px] font-light capitalize {{ $statusStyle['text'] }}">
            {{ ucfirst($order->status) }}
          </span>
        </div>
      </div>

    </div>
  </div>

  {{-- ── Order Items ── --}}
  <div class="overflow-hidden border border-brand-200 bg-cream"
       data-aos="fade-up" data-aos-duration="500" data-aos-delay="150">

    <div class="border-b border-brand-200 bg-brand-50/60 px-5 py-3">
      <p class="text-[10px] font-medium uppercase tracking-[4px] text-brand-600">Item Pesanan</p>
    </div>

    {{-- Items header --}}
    <div class="border-b border-brand-200 bg-brand-50/40">
      <table class="w-full">
        <thead>
          <tr>
            <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800" colspan="2">
              Produk
            </th>
            <th class="hidden px-5 py-3 text-right text-[10px] font-medium uppercase tracking-[2px] text-brand-800 sm:table-cell">
              Harga
            </th>
            <th class="px-5 py-3 text-right text-[10px] font-medium uppercase tracking-[2px] text-brand-800">
              Qty
            </th>
            <th class="px-5 py-3 text-right text-[10px] font-medium uppercase tracking-[2px] text-brand-800">
              Subtotal
            </th>
          </tr>
        </thead>
      </table>
    </div>

    <table class="w-full">
      <tbody>
        @foreach($order->items as $item)
        <tr class="border-b border-brand-100 last:border-0">
          {{-- Thumbnail --}}
          <td class="px-5 py-4 w-14">
            <div class="h-10 w-10 shrink-0 overflow-hidden border border-brand-200 bg-brand-50">
              @if($item->product && $item->product->image)
                <img src="{{ asset('storage/' . $item->product->image) }}"
                     class="h-full w-full object-cover" alt="{{ $item->product->name }}">
              @else
                <div class="flex h-full w-full items-center justify-center">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                  </svg>
                </div>
              @endif
            </div>
          </td>
          {{-- Nama --}}
          <td class="px-5 py-4">
            <p class="text-[12px] font-medium text-brand-900">
              {{ $item->product->name ?? 'Produk dihapus' }}
            </p>
          </td>
          {{-- Harga --}}
          <td class="hidden px-5 py-4 text-right sm:table-cell">
            <span class="text-[12px] font-medium text-brand-800">
              Rp {{ number_format($item->price, 0, ',', '.') }}
            </span>
          </td>
          {{-- Qty --}}
          <td class="px-5 py-4 text-right">
            <span class="text-[12px] font-medium text-brand-800">
              {{ $item->quantity }}
            </span>
          </td>
          {{-- Subtotal --}}
          <td class="px-5 py-4 text-right">
            <span class="text-[13px] font-medium text-brand-900">
              Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
            </span>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    {{-- Total --}}
    <div class="flex items-center justify-between border-t border-brand-200 bg-brand-50/40 px-5 py-4">
      <span class="text-[10px] font-medium uppercase tracking-[2px] text-brand-700">
        Total {{ $order->items->sum('quantity') }} item
      </span>
      <div class="flex items-center gap-3">
        <span class="text-[10px] font-medium uppercase tracking-[2px] text-brand-600">Total Harga</span>
        <span class="font-cormorant text-xl font-normal text-brand-900">
          Rp {{ number_format($order->total_price, 0, ',', '.') }}
        </span>
      </div>
    </div>

  </div>

  {{-- ── Update Status ── --}}
  @php
    $allowedTransitions = match($order->status) {
      'pending'   => ['canceled'],
      'paid'      => ['shipped', 'completed', 'canceled'],
      'shipped'   => ['completed', 'canceled'],
      'completed' => [],
      'canceled'  => [],
      default     => [],
    };
    // Status yang bersifat final/irreversible - wajib konfirmasi modal
    $dangerousStatus = ['completed', 'canceled'];
  @endphp

  <div class="border border-brand-200 bg-cream p-6"
       data-aos="fade-up" data-aos-duration="500" data-aos-delay="200">

    <p class="text-[10px] font-medium uppercase tracking-[3px] text-brand-600 mb-4">
      Update Status Pesanan
    </p>

    @if(count($allowedTransitions) > 0)

      <p class="text-[11px] font-light text-brand-600 mb-5">
        Status saat ini:
        <span class="font-medium capitalize {{ $statusStyle['text'] }}">{{ ucfirst($order->status) }}</span>
      </p>

      <form id="status-form"
            action="{{ route('admin.orders.updateStatus', $order->order_id) }}"
            method="POST" class="flex flex-col gap-5">
        @csrf
        @method('PATCH')

        <div class="flex flex-col gap-1.5">
          <label class="text-[11px] font-medium uppercase tracking-[2px] text-brand-900">
            Ubah Status ke
          </label>
          <select name="status" id="status-select"
                  class="w-64 border border-brand-200 bg-cream px-4 py-2.5 text-[13px] font-medium text-brand-900 focus:border-gold-400 focus:outline-none transition-colors">
            @foreach($allowedTransitions as $s)
              <option value="{{ $s }}" data-dangerous="{{ in_array($s, $dangerousStatus) ? 'true' : 'false' }}">
                {{ ucfirst($s) }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Divider --}}
        <div class="flex items-center gap-3">
          <div class="h-px w-24 bg-brand-200"></div>
          <div class="h-1 w-1 rotate-45 bg-gold-400"></div>
        </div>

        <div>
          <button type="button" id="btn-update-status"
                  class="bg-brand-800 px-6 py-2.5 text-[11px] font-medium uppercase
                         tracking-[2px] text-gold-100 transition-colors hover:bg-brand-900">
            Update Status
          </button>
        </div>

      </form>

    @else

      {{-- Status final --}}
      <div class="flex items-start gap-3 border border-brand-100 bg-brand-50/60 px-4 py-3">
        <div class="mt-0.5 h-1.5 w-1.5 shrink-0 rotate-45
                    {{ $order->status === 'canceled' ? 'bg-red-600' : 'bg-brand-800' }}">
        </div>
        <p class="text-[12px] font-medium text-brand-800">
          Status
          <span class="font-medium capitalize {{ $statusStyle['text'] }}">{{ ucfirst($order->status) }}</span>
          adalah status final dan tidak dapat diubah lagi.
        </p>
      </div>

    @endif

  </div>

</div>

{{-- ── Confirmation Modal ── --}}
<div id="confirm-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-brand-950/40 backdrop-blur-sm">

  <div class="mx-4 w-full max-w-sm border border-brand-200 bg-cream p-6 shadow-xl font-jost"
       data-aos="zoom-in">

    {{-- Diamond accent --}}
    <div class="mb-4 flex items-center gap-3">
      <div class="h-px w-8 bg-brand-200"></div>
      <div class="h-2 w-2 rotate-45" id="modal-diamond"></div>
      <div class="h-px flex-1 bg-brand-200"></div>
    </div>

    <p class="text-[10px] font-medium uppercase tracking-[3px] text-gold-500 mb-1" id="modal-label">
      Konfirmasi
    </p>
    <h3 class="font-cormorant text-2xl font-normal text-brand-900 mb-3" id="modal-title">
      Yakin mengubah status?
    </h3>
    <p class="text-[13px] font-medium text-brand-800 leading-relaxed mb-6" id="modal-body">
      Tindakan ini tidak dapat dibatalkan.
    </p>

    <div class="flex items-center gap-3">
      <button id="btn-confirm"
              class="px-6 py-2.5 text-[11px] font-medium uppercase tracking-[2px]
                     text-gold-100 transition-colors"
              onclick="document.getElementById('status-form').submit()">
        Ya, Lanjutkan
      </button>
      <button onclick="closeModal()"
              class="border border-brand-200 px-6 py-2.5 text-[11px] font-medium uppercase
                     tracking-[2px] text-brand-700 transition-colors
                     hover:border-brand-800 hover:text-brand-900">
        Batal
      </button>
    </div>

  </div>
</div>

<script>
  const dangerConfig = {
    completed: {
      label: 'Status Final',
      title: 'Tandai sebagai Selesai?',
      body: 'Pesanan akan ditandai Completed dan tidak dapat diubah lagi. Pastikan pesanan benar-benar telah diterima pelanggan.',
      btnClass: 'bg-brand-800 hover:bg-brand-900',
      diamondClass: 'bg-brand-600',
    },
    canceled: {
      label: 'Tindakan Tidak Dapat Dibatalkan',
      title: 'Batalkan Pesanan Ini?',
      body: 'Pesanan akan dibatalkan secara permanen dan tidak dapat dipulihkan. Pastikan Anda sudah yakin sebelum melanjutkan.',
      btnClass: 'bg-red-600 hover:bg-red-700',
      diamondClass: 'bg-red-600',
    },
  };

  document.getElementById('btn-update-status').addEventListener('click', function () {
    const select = document.getElementById('status-select');
    const selected = select.value;
    const isDangerous = select.options[select.selectedIndex].dataset.dangerous === 'true';

    if (isDangerous && dangerConfig[selected]) {
      const cfg = dangerConfig[selected];
      document.getElementById('modal-label').textContent  = cfg.label;
      document.getElementById('modal-title').textContent  = cfg.title;
      document.getElementById('modal-body').textContent   = cfg.body;
      document.getElementById('modal-diamond').className  = 'h-2 w-2 rotate-45 ' + cfg.diamondClass;
      document.getElementById('btn-confirm').className    =
        'px-6 py-2.5 text-[11px] font-medium uppercase tracking-[2px] text-gold-100 transition-colors ' + cfg.btnClass;
      openModal();
    } else {
      document.getElementById('status-form').submit();
    }
  });

  function openModal() {
    const modal = document.getElementById('confirm-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeModal() {
    const modal = document.getElementById('confirm-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  // Tutup modal jika klik backdrop
  document.getElementById('confirm-modal').addEventListener('click', function (e) {
    if (e.target === this) closeModal();
  });

  // Tutup dengan Escape
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
  });
</script>

</x-layouts.admin>