<x-layouts.admin title="Categories">

<div class="space-y-5 font-jost">

  {{-- ── Header ── --}}
  <div class="flex items-end justify-between" data-aos="fade-down" data-aos-duration="400">
    <div>
      <p class="text-[10px] font-light uppercase tracking-[4px] text-gold-500 mb-1">Admin</p>
      <h1 class="font-cormorant text-3xl font-normal text-emerald-900">Categories</h1>
    </div>
    <a href="{{ route('categories.create') }}"
       class="inline-flex items-center gap-2 bg-emerald-800 px-5 py-2.5
              text-[10px] font-light uppercase tracking-[2px] text-gold-100
              transition-colors hover:bg-emerald-900">
      <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
      </svg>
      Tambah Kategori
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
  <div class="space-y-3 sm:hidden" data-aos="fade-up" data-aos-duration="500">
    @forelse($categories as $category)
    <div class="border border-emerald-200 bg-cream px-4 py-4">
      <div class="flex items-center justify-between gap-3">

        {{-- Gambar + Nama + Jumlah Produk --}}
        <div class="flex items-center gap-3 min-w-0">
          <div class="h-12 w-12 shrink-0 overflow-hidden border border-emerald-200 bg-emerald-50">
            @if($category->image)
              <img src="{{ asset('storage/' . $category->image) }}"
                   class="h-full w-full object-cover" alt="{{ $category->name }}">
            @else
              <div class="flex h-full w-full items-center justify-center">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                  <rect x="3" y="3" width="18" height="18" rx="0"/><path d="M3 9l4-4 4 4 4-4 4 4"/>
                  <circle cx="8.5" cy="13.5" r="1.5"/>
                </svg>
              </div>
            @endif
          </div>
          <div>
            <p class="text-[12px] font-medium text-emerald-900">{{ $category->name }}</p>
            <p class="text-[10px] font-light text-emerald-500">
              {{ $category->products->count() }} produk
            </p>
          </div>
        </div>

        {{-- Aksi --}}
        <div class="flex items-center gap-2 shrink-0">
          <a href="{{ route('categories.edit', $category->category_id) }}"
             class="border border-emerald-200 px-3 py-1.5 text-[10px] font-light
                    uppercase tracking-[1px] text-emerald-700
                    transition-colors hover:border-gold-400 hover:text-gold-500">
            Edit
          </a>
          <form method="POST" action="{{ route('categories.destroy', $category->category_id) }}"
                onsubmit="return confirm('Hapus kategori ini?')">
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
    </div>
    @empty
    <div class="border border-emerald-200 bg-cream px-5 py-16 text-center">
      <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center border border-emerald-200 bg-emerald-50">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
          <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
        </svg>
      </div>
      <p class="font-cormorant text-xl font-normal text-emerald-800">Belum ada kategori</p>
      <a href="{{ route('categories.create') }}"
         class="mt-4 inline-flex items-center gap-2 border border-emerald-400 px-5 py-2
                text-[10px] font-light uppercase tracking-[2px] text-emerald-800
                transition-colors hover:bg-emerald-800 hover:text-gold-100">
        Tambah Kategori
      </a>
    </div>
    @endforelse
  </div>

  {{-- ── DESKTOP: Table ── --}}
  <div class="hidden overflow-hidden border border-emerald-200 bg-cream sm:block"
       data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
    <table class="w-full">
      <thead>
        <tr class="border-b border-emerald-200 bg-emerald-50/60">
          <th class="px-5 py-3 text-left text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Kategori</th>
          <th class="px-5 py-3 text-left text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Produk</th>
          <th class="px-5 py-3 text-right text-[9px] font-light uppercase tracking-[3px] text-emerald-600">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($categories as $category)
        <tr class="border-b border-emerald-100 transition-colors last:border-0 hover:bg-emerald-50/40">

          {{-- Kategori --}}
          <td class="px-5 py-4">
            <div class="flex items-center gap-3">
              <div class="h-10 w-10 shrink-0 overflow-hidden border border-emerald-200 bg-emerald-50">
                @if($category->image)
                  <img src="{{ asset('storage/' . $category->image) }}"
                       class="h-full w-full object-cover" alt="{{ $category->name }}">
                @else
                  <div class="flex h-full w-full items-center justify-center">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                      <rect x="3" y="3" width="18" height="18" rx="0"/><path d="M3 9l4-4 4 4 4-4 4 4"/>
                      <circle cx="8.5" cy="13.5" r="1.5"/>
                    </svg>
                  </div>
                @endif
              </div>
              <p class="text-[12px] font-medium text-emerald-900">{{ $category->name }}</p>
            </div>
          </td>

          {{-- Produk --}}
          <td class="px-5 py-4">
            <span class="text-[11px] font-light text-emerald-700">
              {{ $category->products->count() }} produk
            </span>
          </td>

          {{-- Aksi --}}
          <td class="px-5 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('categories.edit', $category->category_id) }}"
                 class="border border-emerald-200 px-3 py-1.5 text-[10px] font-light
                        uppercase tracking-[1px] text-emerald-700
                        transition-colors hover:border-gold-400 hover:text-gold-500">
                Edit
              </a>
              <form method="POST" action="{{ route('categories.destroy', $category->category_id) }}"
                    onsubmit="return confirm('Hapus kategori ini?')">
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
          <td colspan="3" class="px-5 py-16 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center border border-emerald-200 bg-emerald-50">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
              </svg>
            </div>
            <p class="font-cormorant text-xl font-normal text-emerald-800">Belum ada kategori</p>
            <a href="{{ route('categories.create') }}"
               class="mt-4 inline-flex items-center gap-2 border border-emerald-400 px-5 py-2
                      text-[10px] font-light uppercase tracking-[2px] text-emerald-800
                      transition-colors hover:bg-emerald-800 hover:text-gold-100">
              Tambah Kategori
            </a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Count --}}
  @if($categories->count() > 0)
  <p class="text-[10px] font-light uppercase tracking-[2px] text-emerald-500"
     data-aos="fade-up" data-aos-delay="200">
    {{ $categories->count() }} kategori ditampilkan
  </p>
  @endif

</div>

</x-layouts.admin>