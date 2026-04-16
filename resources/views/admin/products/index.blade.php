<x-layouts.admin title="Products">

<div class="space-y-5 font-jost">

  {{-- ── Header ── --}}
  <div class="flex items-end justify-between" data-aos="fade-down" data-aos-duration="400">
    <div>
      <p class="text-[10px] font-light uppercase tracking-[4px] text-gold-500 mb-1">Admin</p>
      <h1 class="font-cormorant text-3xl font-normal text-emerald-900">Products</h1>
    </div>
    <a href="{{ route('products.create') }}"
       class="inline-flex items-center gap-2 bg-emerald-800 px-5 py-2.5
              text-[10px] font-light uppercase tracking-[2px] text-gold-100
              transition-colors hover:bg-emerald-900">
      <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
      </svg>
      Tambah Produk
    </a>
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
    @forelse($products as $product)
    <div class="border border-emerald-200 bg-cream px-4 py-4 space-y-3">

      {{-- Row 1: Gambar + Nama + Kategori --}}
      <div class="flex items-center gap-3">
        <div class="h-12 w-12 shrink-0 overflow-hidden border border-emerald-200 bg-emerald-50">
          @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}"
                 class="h-full w-full object-cover" alt="{{ $product->name }}">
          @else
            <div class="flex h-full w-full items-center justify-center">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
              </svg>
            </div>
          @endif
        </div>
        <div class="min-w-0 flex-1">
          <p class="text-[12px] font-medium text-emerald-900 truncate">{{ $product->name }}</p>
          <p class="text-[10px] font-light text-emerald-500">
            {{ $product->category->name ?? '—' }}
          </p>
          @if($product->description)
            <p class="text-[10px] font-light text-emerald-400 truncate">
              {{ Str::limit($product->description, 50) }}
            </p>
          @endif
        </div>
      </div>

      {{-- Divider --}}
      <div class="h-px bg-emerald-100"></div>

      {{-- Row 2: Harga + Stok --}}
      <div class="flex items-center justify-between">
        <div>
          <p class="text-[9px] font-light uppercase tracking-[2px] text-emerald-400 mb-0.5">Harga</p>
          <p class="text-[12px] font-light text-emerald-900">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </p>
        </div>
        <div class="text-right">
          <p class="text-[9px] font-light uppercase tracking-[2px] text-emerald-400 mb-0.5">Stok</p>
          <div class="flex items-center justify-end gap-1.5">
            <span class="h-1.5 w-1.5 rounded-full {{ $product->stock > 0 ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
            <span class="text-[11px] font-light {{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-400' }}">
              {{ $product->stock }}
            </span>
          </div>
        </div>
      </div>

      {{-- Row 3: Aksi --}}
      <div class="flex items-center justify-end gap-2">
        <a href="{{ route('products.edit', $product->product_id) }}"
           class="border border-emerald-200 px-3 py-1.5 text-[10px] font-light
                  uppercase tracking-[1px] text-emerald-700
                  transition-colors hover:border-gold-400 hover:text-gold-500">
          Edit
        </a>
        <form method="POST" action="{{ route('products.destroy', $product->product_id) }}"
              onsubmit="return confirm('Hapus produk ini?')">
          @csrf
          @method('DELETE')
          <button type="submit"
                  class="border border-red-200 px-3 py-1.5 text-[10px] font-light
                         uppercase tracking-[1px] text-red-400
                         transition-colors hover:border-red-400 hover:bg-red-50 hover:text-red-600">
            Hapus
          </button>
        </form>
      </div>

    </div>
    @empty
    <div class="border border-emerald-200 bg-cream px-5 py-16 text-center">
      <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center border border-emerald-200 bg-emerald-50">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
          <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
      </div>
      <p class="font-cormorant text-xl font-normal text-emerald-800">Belum ada produk</p>
      <a href="{{ route('products.create') }}"
         class="mt-4 inline-flex items-center gap-2 border border-emerald-400 px-5 py-2
                text-[10px] font-light uppercase tracking-[2px] text-emerald-800
                transition-colors hover:bg-emerald-800 hover:text-gold-100">
        Tambah Produk
      </a>
    </div>
    @endforelse
  </div>

  {{-- ── DESKTOP: Table ── --}}
  <div class="hidden overflow-hidden border border-emerald-200 bg-cream md:block"
       data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
    <table class="w-full">
      <thead>
        <tr class="border-b border-emerald-200 bg-emerald-50/60">
          <th class="px-5 py-3 text-left text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Produk</th>
          <th class="px-5 py-3 text-left text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Kategori</th>
          <th class="px-5 py-3 text-left text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Harga</th>
          <th class="px-5 py-3 text-left text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Stok</th>
          <th class="px-5 py-3 text-right text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $product)
        <tr class="border-b border-emerald-100 transition-colors last:border-0 hover:bg-emerald-50/40">

          {{-- Produk --}}
          <td class="px-5 py-4">
            <div class="flex items-center gap-3">
              <div class="h-10 w-10 shrink-0 overflow-hidden border border-emerald-200 bg-emerald-50">
                @if($product->image)
                  <img src="{{ asset('storage/'.$product->image) }}"
                       class="h-full w-full object-cover" alt="{{ $product->name }}">
                @else
                  <div class="flex h-full w-full items-center justify-center">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                      <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                  </div>
                @endif
              </div>
              <div class="min-w-0">
                <p class="text-[12px] font-medium text-emerald-900 truncate max-w-[160px]">
                  {{ $product->name }}
                </p>
                @if($product->description)
                  <p class="text-[10px] font-light text-emerald-500 truncate max-w-[160px]">
                    {{ Str::limit($product->description, 40) }}
                  </p>
                @endif
              </div>
            </div>
          </td>

          {{-- Kategori --}}
          <td class="px-5 py-4">
            <span class="text-[11px] font-light text-emerald-700">
              {{ $product->category->name ?? '—' }}
            </span>
          </td>

          {{-- Harga --}}
          <td class="px-5 py-4">
            <span class="text-[12px] font-light text-emerald-900">
              Rp {{ number_format($product->price, 0, ',', '.') }}
            </span>
          </td>

          {{-- Stok --}}
          <td class="px-5 py-4">
            <div class="flex items-center gap-1.5">
              <span class="h-1.5 w-1.5 rounded-full {{ $product->stock > 0 ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
              <span class="text-[11px] font-light {{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-400' }}">
                {{ $product->stock }}
              </span>
            </div>
          </td>

          {{-- Aksi --}}
          <td class="px-5 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('products.edit', $product->product_id) }}"
                 class="border border-emerald-200 px-3 py-1.5 text-[10px] font-light
                        uppercase tracking-[1px] text-emerald-700
                        transition-colors hover:border-gold-400 hover:text-gold-500">
                Edit
              </a>
              <form method="POST" action="{{ route('products.destroy', $product->product_id) }}"
                    onsubmit="return confirm('Hapus produk ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="border border-red-200 px-3 py-1.5 text-[10px] font-light
                               uppercase tracking-[1px] text-red-400
                               transition-colors hover:border-red-400 hover:bg-red-50 hover:text-red-600">
                  Hapus
                </button>
              </form>
            </div>
          </td>

        </tr>
        @empty
        <tr>
          <td colspan="5" class="px-5 py-16 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center border border-emerald-200 bg-emerald-50">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
              </svg>
            </div>
            <p class="font-cormorant text-xl font-normal text-emerald-800">Belum ada produk</p>
            <a href="{{ route('products.create') }}"
               class="mt-4 inline-flex items-center gap-2 border border-emerald-400 px-5 py-2
                      text-[10px] font-light uppercase tracking-[2px] text-emerald-800
                      transition-colors hover:bg-emerald-800 hover:text-gold-100">
              Tambah Produk
            </a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Count --}}
  @if($products->count() > 0)
  <p class="text-[10px] font-light uppercase tracking-[2px] text-emerald-500"
     data-aos="fade-up" data-aos-delay="200">
    {{ $products->count() }} produk ditampilkan
  </p>
  @endif

</div>

</x-layouts.admin>