<x-layouts.admin title="Products">

<div class="space-y-5 font-jost">

  {{-- ── Header ── --}}
  <div class="flex items-end justify-between" data-aos="fade-down" data-aos-duration="400">
    <div>
      <p class="text-[10px] font-medium uppercase tracking-[3px] text-gold-500 mb-1">Admin</p>
      <h1 class="font-cormorant text-3xl font-normal text-brand-900">Products</h1>
    </div>
    <a href="{{ route('products.create') }}"
       class="inline-flex items-center gap-2 bg-brand-800 px-5 py-2.5
              text-[10px] font-medium uppercase tracking-[2px] text-gold-100
              transition-colors hover:bg-brand-900">
      <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
      </svg>
      Tambah Produk
    </a>
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
  @if(session('error'))
  <div class="border border-red-200 bg-red-50 px-4 py-3
              text-[11px] font-medium uppercase tracking-[2px] text-red-600"
       data-aos="fade-down">
    {{ session('error') }}
  </div>
  @endif

  {{-- ── MOBILE: Card List ── --}}
  <div class="space-y-3 md:hidden" data-aos="fade-up" data-aos-duration="500">
    @forelse($products as $product)
    <div class="border border-brand-200 bg-cream px-4 py-4 space-y-3">

      {{-- Row 1: Gambar + Nama + Kategori --}}
      <div class="flex items-center gap-3">
        <div class="h-12 w-12 shrink-0 overflow-hidden border border-brand-200 bg-brand-50">
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
          <p class="text-[12px] font-medium text-brand-900 truncate">{{ $product->name }}</p>
          <p class="text-[11px] font-medium text-brand-700">
            {{ $product->category->name ?? '-' }}
          </p>
          @if($product->description)
            <p class="text-[11px] font-medium text-brand-600 truncate">
              {{ Str::limit($product->description, 50) }}
            </p>
          @endif
        </div>
      </div>

      {{-- Divider --}}
      <div class="h-px bg-brand-100"></div>

      {{-- Row 2: Harga + Stok --}}
      <div class="flex items-center justify-between">
        <div>
          <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-600 mb-0.5">Harga</p>
          <p class="text-[13px] font-medium text-brand-900">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </p>
        </div>
        <div class="text-right">
          <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-600 mb-0.5">Stok</p>
          <div class="flex items-center justify-end gap-1.5">
            <span class="h-1.5 w-1.5 rounded-full {{ $product->stock > 0 ? 'bg-green-500' : 'bg-red-600' }}"></span>
            <span class="text-[11px] font-light {{ $product->stock > 0 ? 'text-brand-600' : 'text-red-600 font-semibold' }}">
              {{ $product->stock }}
            </span>
          </div>
        </div>
      </div>

      {{-- Row 3: Aksi --}}
      <div class="flex items-center justify-end gap-2">
        <button type="button" onclick="openStockModal('{{ $product->product_id }}', '{{ addslashes($product->name) }}')"
                class="border border-brand-200 px-3 py-1.5 text-[10px] font-medium uppercase tracking-[1px] text-brand-700
                       transition-colors hover:border-gold-400 hover:text-gold-500">
          Stok
        </button>
        <a href="{{ route('products.edit', $product->product_id) }}"
           class="border border-brand-200 px-3 py-1.5 text-[10px] font-medium uppercase tracking-[1px] text-brand-700
                  transition-colors hover:border-gold-400 hover:text-gold-500">
          Edit
        </a>
        <form method="POST" action="{{ route('products.destroy', $product->product_id) }}"
              onsubmit="return confirm('Hapus produk ini?')">
          @csrf
          @method('DELETE')
          <button type="submit"
                  class="border border-red-200 px-3 py-1.5 text-[10px] font-medium uppercase tracking-[1px] text-red-600 font-semibold
                         transition-colors hover:border-red-400 hover:bg-red-50 hover:text-red-600">
            Hapus
          </button>
        </form>
      </div>

    </div>
    @empty
    <div class="border border-brand-200 bg-cream px-5 py-16 text-center">
      <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center border border-brand-200 bg-brand-50">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
          <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
      </div>
      <p class="font-cormorant text-xl font-normal text-brand-800">Belum ada produk</p>
      <a href="{{ route('products.create') }}"
         class="mt-4 inline-flex items-center gap-2 border border-brand-400 px-5 py-2
                text-[10px] font-medium uppercase tracking-[2px] text-brand-800
                transition-colors hover:bg-brand-800 hover:text-gold-100">
        Tambah Produk
      </a>
    </div>
    @endforelse
  </div>

  {{-- ── DESKTOP: Table ── --}}
  <div class="hidden overflow-hidden border border-brand-200 bg-cream md:block"
       data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
    <table class="w-full">
      <thead>
        <tr class="border-b border-brand-200 bg-brand-50/60">
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Produk</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Kategori</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Harga</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Stok</th>
          <th class="px-5 py-3 text-right text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $product)
        <tr class="border-b border-brand-100 transition-colors last:border-0 hover:bg-brand-50/40">

          {{-- Produk --}}
          <td class="px-5 py-4">
            <div class="flex items-center gap-3">
              <div class="h-10 w-10 shrink-0 overflow-hidden border border-brand-200 bg-brand-50">
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
                <p class="text-[12px] font-medium text-brand-900 truncate max-w-[160px]">
                  {{ $product->name }}
                </p>
                @if($product->description)
                  <p class="text-[11px] font-medium text-brand-700 truncate max-w-[160px]">
                    {{ Str::limit($product->description, 40) }}
                  </p>
                @endif
              </div>
            </div>
          </td>

          {{-- Kategori --}}
          <td class="px-5 py-4">
            <span class="text-[12px] font-medium text-brand-800">
              {{ $product->category->name ?? '-' }}
            </span>
          </td>

          {{-- Harga --}}
          <td class="px-5 py-4">
            <span class="text-[13px] font-medium text-brand-900">
              Rp {{ number_format($product->price, 0, ',', '.') }}
            </span>
          </td>

          {{-- Stok --}}
          <td class="px-5 py-4">
            <div class="flex items-center gap-1.5">
              <span class="h-1.5 w-1.5 rounded-full {{ $product->stock > 0 ? 'bg-green-500' : 'bg-red-600' }}"></span>
              <span class="text-[11px] font-light {{ $product->stock > 0 ? 'text-brand-600' : 'text-red-600 font-semibold' }}">
                {{ $product->stock }}
              </span>
            </div>
          </td>

          {{-- Aksi --}}
          <td class="px-5 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <button type="button" onclick="openStockModal('{{ $product->product_id }}', '{{ addslashes($product->name) }}')"
                      class="border border-brand-200 px-3 py-1.5 text-[10px] font-medium uppercase tracking-[1px] text-brand-700
                             transition-colors hover:border-gold-400 hover:text-gold-500">
                Stok
              </button>
              <a href="{{ route('products.edit', $product->product_id) }}"
                 class="border border-brand-200 px-3 py-1.5 text-[10px] font-medium uppercase tracking-[1px] text-brand-700
                        transition-colors hover:border-gold-400 hover:text-gold-500">
                Edit
              </a>
              <form method="POST" action="{{ route('products.destroy', $product->product_id) }}"
                    onsubmit="return confirm('Hapus produk ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="border border-red-200 px-3 py-1.5 text-[10px] font-medium uppercase tracking-[1px] text-red-600 font-semibold
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
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center border border-brand-200 bg-brand-50">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
              </svg>
            </div>
            <p class="font-cormorant text-xl font-normal text-brand-800">Belum ada produk</p>
            <a href="{{ route('products.create') }}"
               class="mt-4 inline-flex items-center gap-2 border border-brand-400 px-5 py-2
                      text-[10px] font-medium uppercase tracking-[2px] text-brand-800
                      transition-colors hover:bg-brand-800 hover:text-gold-100">
              Tambah Produk
            </a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Count + Pagination --}}
  @if($products->count() > 0)
  <div class="flex items-center justify-between" data-aos="fade-up" data-aos-delay="200">
    <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-700">
      {{ $products->total() }} produk
    </p>
    @if($products->hasPages())
      <div class="text-[11px] font-medium text-brand-700">
        {{ $products->links() }}
      </div>
    @endif
  </div>
  @endif

</div>

{{-- -- Modal Update Stok -- --}}
<div id="stockModal" class="hidden fixed inset-0 z-50 flex items-center justify-center font-jost">
  <div class="absolute inset-0 bg-black/50" onclick="closeStockModal()"></div>
  <div class="relative z-10 w-[90%] max-w-sm border border-brand-200 bg-cream p-6 shadow-xl">
    <div class="mb-4">
      <p class="text-[10px] font-medium uppercase tracking-[3px] text-gold-500 mb-1">Update Cepat</p>
      <h3 class="font-cormorant text-2xl font-normal text-brand-900 leading-tight">
        Koreksi Stok
      </h3>
      <p id="stockModalProductName" class="mt-1 text-[12px] font-medium text-brand-700 truncate"></p>
    </div>

    <form id="stockForm" method="POST" action="">
      @csrf
      @method('PATCH')

      <div class="space-y-4">
        <div>
          <label class="block mb-1.5 text-[10px] font-medium uppercase tracking-[2px] text-brand-800">
            Aksi <span class="text-red-500">*</span>
          </label>
          <div class="flex gap-2">
            <label class="flex-1 cursor-pointer">
              <input type="radio" name="action" value="add" class="peer hidden" checked>
              <div class="border border-brand-200 py-2.5 text-center text-[10px] font-medium uppercase tracking-[1px]
                          text-brand-700 transition-colors
                          peer-checked:border-green-400 peer-checked:bg-green-50 peer-checked:text-green-600">
                + Tambah
              </div>
            </label>
            <label class="flex-1 cursor-pointer">
              <input type="radio" name="action" value="reduce" class="peer hidden">
              <div class="border border-brand-200 py-2.5 text-center text-[10px] font-medium uppercase tracking-[1px]
                          text-brand-700 transition-colors
                          peer-checked:border-red-400 peer-checked:bg-red-50 peer-checked:text-red-600">
                - Kurangi
              </div>
            </label>
          </div>
        </div>

        <div>
          <label class="block mb-1.5 text-[10px] font-medium uppercase tracking-[2px] text-brand-800">
            Jumlah <span class="text-red-500">*</span>
          </label>
          <input type="number" name="amount" min="1" required
                 class="w-full border border-brand-200 bg-white px-3 py-2 text-[12px] font-medium text-brand-900
                        focus:border-gold-400 focus:ring-0 focus:outline-none">
        </div>

        <div>
          <label class="block mb-1.5 text-[10px] font-medium uppercase tracking-[2px] text-brand-800">
            Keterangan
          </label>
          <input type="text" name="description" placeholder="Contoh: Barang cacat, barang hilang, dll."
                 class="w-full border border-brand-200 bg-white px-3 py-2 text-[12px] font-medium text-brand-900
                        placeholder:text-brand-400 focus:border-gold-400 focus:ring-0 focus:outline-none">
        </div>
      </div>

      <div class="mt-6 flex justify-end gap-2">
        <button type="button" onclick="closeStockModal()"
                class="border border-brand-200 px-4 py-2 text-[10px] font-medium uppercase tracking-[2px]
                       text-brand-700 transition-colors hover:bg-brand-50">
          Batal
        </button>
        <button type="submit"
                class="bg-brand-800 px-4 py-2 text-[10px] font-medium uppercase tracking-[2px] text-gold-100
                       transition-colors hover:bg-brand-900">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function openStockModal(productId, productName) {
    document.getElementById('stockModal').classList.remove('hidden');
    document.getElementById('stockModalProductName').innerText = productName;

    // Use absolute URL or replace the placeholder in route
    const form = document.getElementById('stockForm');
    form.action = `/admin/products/${productId}/stock`;
  }

  function closeStockModal() {
    document.getElementById('stockModal').classList.add('hidden');
    document.getElementById('stockForm').reset();
  }
</script>

</x-layouts.admin>