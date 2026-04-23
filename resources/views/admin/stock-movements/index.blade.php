<x-layouts.admin title="Barang Masuk & Keluar">

<div class="space-y-5 font-jost">

  {{-- ── Header ── --}}
  <div class="flex items-end justify-between" data-aos="fade-down" data-aos-duration="400">
    <div>
      <p class="text-[10px] font-medium uppercase tracking-[3px] text-gold-500 mb-1">Inventori</p>
      <h1 class="font-cormorant text-3xl font-normal text-brand-900">Barang Masuk & Keluar</h1>
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

  {{-- ── Filter Tabs ── --}}
  <div class="flex items-center gap-2" data-aos="fade-up" data-aos-duration="400">
    <a href="{{ route('admin.stock-movements.index') }}"
       class="px-4 py-2 text-[10px] font-medium uppercase tracking-[2px] border transition-colors
              {{ !request('type') ? 'border-gold-400 bg-gold-50 text-gold-500' : 'border-brand-200 text-brand-700 hover:border-gold-400' }}">
      Semua
    </a>
    <a href="{{ route('admin.stock-movements.index', ['type' => 'in']) }}"
       class="px-4 py-2 text-[10px] font-medium uppercase tracking-[2px] border transition-colors
              {{ request('type') === 'in' ? 'border-green-400 bg-green-50 text-green-600' : 'border-brand-200 text-brand-700 hover:border-green-400' }}">
      ↓ Masuk
    </a>
    <a href="{{ route('admin.stock-movements.index', ['type' => 'out']) }}"
       class="px-4 py-2 text-[10px] font-medium uppercase tracking-[2px] border transition-colors
              {{ request('type') === 'out' ? 'border-red-400 bg-red-50 text-red-600' : 'border-brand-200 text-brand-700 hover:border-red-400' }}">
      ↑ Keluar
    </a>
  </div>

  {{-- ── MOBILE: Card List ── --}}
  <div class="space-y-3 md:hidden" data-aos="fade-up" data-aos-duration="500">
    @forelse($movements as $mv)
    <div class="border border-brand-200 bg-cream px-4 py-4 space-y-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span class="inline-flex h-6 w-6 items-center justify-center text-[10px] font-bold
                        {{ $mv->type === 'in' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
            {{ $mv->type === 'in' ? '↓' : '↑' }}
          </span>
          <span class="text-[12px] font-medium text-brand-900">{{ $mv->product->name ?? '-' }}</span>
        </div>
        <span class="text-[11px] font-semibold {{ $mv->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
          {{ $mv->type === 'in' ? '+' : '-' }}{{ $mv->quantity }}
        </span>
      </div>
      <div class="h-px bg-brand-100"></div>
      <div class="flex items-center justify-between">
        <p class="text-[11px] text-brand-600">{{ $mv->description ?? '-' }}</p>
        <p class="text-[10px] text-brand-400">{{ $mv->created_at?->format('d M Y H:i') }}</p>
      </div>
      <div class="flex justify-end">
        <form method="POST" action="{{ route('admin.stock-movements.destroy', $mv->id) }}"
              onsubmit="return confirm('Hapus record ini?')">
          @csrf @method('DELETE')
          <button type="submit"
                  class="border border-red-200 px-3 py-1.5 text-[10px] font-medium uppercase tracking-[1px] text-red-600 font-semibold
                         transition-colors hover:border-red-400 hover:bg-red-50">
            Hapus
          </button>
        </form>
      </div>
    </div>
    @empty
    <div class="border border-brand-200 bg-cream px-5 py-16 text-center">
      <p class="font-cormorant text-xl font-normal text-brand-800">Belum ada record</p>
    </div>
    @endforelse
  </div>

  {{-- ── DESKTOP: Table ── --}}
  <div class="hidden overflow-hidden border border-brand-200 bg-cream md:block"
       data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
    <table class="w-full">
      <thead>
        <tr class="border-b border-brand-200 bg-brand-50/60">
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Tipe</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Produk</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Jumlah</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Keterangan</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Tanggal</th>
          <th class="px-5 py-3 text-right text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($movements as $mv)
        <tr class="border-b border-brand-100 transition-colors last:border-0 hover:bg-brand-50/40">

          {{-- Tipe --}}
          <td class="px-5 py-4">
            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[1px]
                          {{ $mv->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
              <span class="inline-flex h-5 w-5 items-center justify-center text-[9px]
                            {{ $mv->type === 'in' ? 'bg-green-100' : 'bg-red-100' }}">
                {{ $mv->type === 'in' ? '↓' : '↑' }}
              </span>
              {{ $mv->type === 'in' ? 'Masuk' : 'Keluar' }}
            </span>
          </td>

          {{-- Produk --}}
          <td class="px-5 py-4">
            <span class="text-[12px] font-medium text-brand-900">{{ $mv->product->name ?? '-' }}</span>
          </td>

          {{-- Jumlah --}}
          <td class="px-5 py-4">
            <span class="text-[13px] font-semibold {{ $mv->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
              {{ $mv->type === 'in' ? '+' : '-' }}{{ $mv->quantity }}
            </span>
          </td>

          {{-- Keterangan --}}
          <td class="px-5 py-4">
            <span class="text-[12px] text-brand-700">{{ $mv->description ?? '-' }}</span>
          </td>

          {{-- Tanggal --}}
          <td class="px-5 py-4">
            <span class="text-[11px] text-brand-600">{{ $mv->created_at?->format('d M Y H:i') }}</span>
          </td>

          {{-- Aksi --}}
          <td class="px-5 py-4 text-right">
            <form method="POST" action="{{ route('admin.stock-movements.destroy', $mv->id) }}"
                  onsubmit="return confirm('Hapus record ini?')">
              @csrf @method('DELETE')
              <button type="submit"
                      class="border border-red-200 px-3 py-1.5 text-[10px] font-medium uppercase tracking-[1px] text-red-600 font-semibold
                             transition-colors hover:border-red-400 hover:bg-red-50 hover:text-red-600">
                Hapus
              </button>
            </form>
          </td>

        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-5 py-16 text-center">
            <p class="font-cormorant text-xl font-normal text-brand-800">Belum ada record</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($movements->count() > 0)
  <div class="flex items-center justify-between" data-aos="fade-up" data-aos-delay="200">
    <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-700">
      {{ $movements->total() }} record
    </p>
    @if($movements->hasPages())
      <div class="text-[11px] font-medium text-brand-700">
        {{ $movements->appends(request()->query())->links() }}
      </div>
    @endif
  </div>
  @endif

</div>

</x-layouts.admin>