<x-layouts.app title="Koleksi">

@push('styles')
<style>
  /* ── Sidebar category link (state active & hover kompleks, lebih ringkas pakai CSS) ── */
  .cat-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 9px 12px;
    font-size: 11px;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #256B47;
    border: 0.5px solid transparent;
    transition: color .2s, border-color .2s, background .2s;
    font-weight: 300;
  }
  .cat-link:hover  { color: #0D2B20; border-color: #A8D5B5; background: #EDF7EF; }
  .cat-link.active { color: #0D2B20; border-color: #C9960F; background: #FAF3DC; }
  .cat-link .cat-count { font-size: 10px; color: #A8D5B5; letter-spacing: 0; font-weight: 300; }
  .cat-link.active .cat-count { color: #B8860B; }

  /* ── Card corner & image zoom (child selector) ── */
  .prod-card-corner-tl, .prod-card-corner-br {
    position: absolute;
    width: 14px; height: 14px;
    pointer-events: none; z-index: 10;
    opacity: .5; transition: opacity .3s ease;
  }
  .prod-card:hover .prod-card-corner-tl,
  .prod-card:hover .prod-card-corner-br { opacity: 1; }
  .prod-card-corner-tl { top: -1px; left: -1px; border-top: 1px solid #C9960F; border-left: 1px solid #C9960F; }
  .prod-card-corner-br { bottom: -1px; right: -1px; border-bottom: 1px solid #C9960F; border-right: 1px solid #C9960F; }

  .prod-img { transition: transform .7s ease; }
  .prod-card:hover .prod-img { transform: scale(1.05); }
</style>
@endpush


<div class="relative overflow-hidden bg-cream font-jost">
  <div class="relative z-10 mx-auto max-w-7xl px-6 py-16">

    {{-- ── PAGE HEADER ── --}}
    <div class="mb-12">
      <div data-aos="fade-up" data-aos-delay="50"
           class="mb-3 flex items-center gap-3">
        <div class="h-px w-6 bg-gold-500"></div>
        <span class="text-[10px] font-light uppercase tracking-[4px] text-gold-500">Our Collection</span>
      </div>
      <h1 data-aos="fade-up" data-aos-delay="100"
          class="font-cormorant text-5xl font-normal leading-tight text-emerald-900">
        Semua Kue
      </h1>
    </div>


    {{-- ── LAYOUT: SIDEBAR + GRID ── --}}
    <div class="flex flex-col gap-10 md:flex-row md:gap-10">

      {{-- ── SIDEBAR ── --}}
      <aside data-aos="fade-up" data-aos-delay="100"
             class="w-full shrink-0 md:w-48">

        <div class="mb-4 flex items-center gap-3">
          <span class="text-[10px] font-light uppercase tracking-[4px] text-gold-500">Kategori</span>
          <div class="h-px flex-1 bg-emerald-200"></div>
        </div>

        {{-- Mobile: horizontal scroll, Desktop: vertical list --}}
        <ul class="flex gap-1 overflow-x-auto pb-2 md:flex-col md:overflow-x-visible md:pb-0">

          <li class="shrink-0 md:shrink">
            <a href="{{ route('shop.index') }}"
               class="cat-link {{ !request('category') ? 'active' : '' }}">
              <span>Semua</span>
              <span class="cat-count ml-2 md:ml-0">{{ $products->total() }}</span>
            </a>
          </li>

          @foreach ($categories as $category)
          <li class="shrink-0 md:shrink">
            <a href="{{ route('shop.index', ['category' => $category->category_id]) }}"
               class="cat-link {{ request('category') == $category->category_id ? 'active' : '' }}">
              <span>{{ $category->name }}</span>
              <span class="cat-count ml-2 md:ml-0">{{ $category->products->count() }}</span>
            </a>
          </li>
          @endforeach

        </ul>

        {{-- Ornament — desktop only --}}
        <div class="mt-6 hidden items-center gap-2 opacity-40 md:flex">
          <div class="h-px w-6 bg-gold-400"></div>
          <div class="h-1 w-1 rotate-45 bg-gold-400"></div>
        </div>

      </aside>


      {{-- ── PRODUCT GRID ── --}}
      <div class="flex-1">

        @if ($products->isEmpty())

          {{-- Empty state --}}
          <div data-aos="fade-up"
               class="flex flex-col items-center justify-center py-24 text-center">
            <div class="mb-5 flex h-16 w-16 items-center justify-center border border-emerald-200">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                   stroke="#A8D5B5" stroke-width="1">
                <circle cx="11" cy="11" r="8"/>
                <path d="M21 21l-4.35-4.35"/>
              </svg>
            </div>
            <p class="font-cormorant text-2xl font-normal text-emerald-900">Belum ada produk</p>
            <p class="mt-2 text-[11px] font-light uppercase tracking-[3px] text-emerald-600">
              di kategori ini
            </p>
            <a href="{{ route('shop.index') }}"
               class="mt-6 inline-flex items-center gap-2 border border-emerald-400 px-6 py-2.5
                      text-[10px] font-light uppercase tracking-[3px] text-emerald-800
                      transition-colors hover:border-emerald-800 hover:bg-emerald-800 hover:text-gold-100">
              Lihat Semua
              <svg width="12" height="8" viewBox="0 0 12 8" fill="none" stroke="currentColor" stroke-width="1.5">
                <line x1="0" y1="4" x2="10" y2="4"/>
                <polyline points="7,1 10,4 7,7"/>
              </svg>
            </a>
          </div>

        @else

          {{-- Grid produk --}}
          <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 lg:grid-cols-3 md:gap-4">

            @foreach ($products as $index => $product)
            <div class="prod-card relative flex flex-col border border-[#A8D5B5] bg-[#FDFCFA]
                        transition-colors duration-300 hover:border-gold-400"
                 data-aos="fade-up"
                 data-aos-delay="{{ ($index % 6) * 80 }}">

              <a href="{{ route('shop.product', $product->product_id) }}"
                 class="absolute inset-0 z-10"
                 aria-label="{{ $product->name }}"></a>

              {{-- Image 1:1 --}}
              <div class="relative overflow-hidden" style="padding-bottom: 100%;">
                <div class="absolute inset-0 overflow-hidden bg-emerald-50">
                  @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="prod-img h-full w-full object-cover"
                         loading="lazy">
                  @else
                    <div class="flex h-full w-full items-center justify-center">
                      <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                           stroke="#A8D5B5" stroke-width="1">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                      </svg>
                    </div>
                  @endif
                </div>

                {{-- Category badge --}}
                @if ($product->category)
                <div class="absolute left-2 top-2 z-10 md:left-3 md:top-3">
                  <span class="inline-flex items-center border border-emerald-200/60
                               bg-emerald-900/70 px-2 py-0.5 backdrop-blur-sm md:px-2.5 md:py-1">
                    <span class="text-[8px] font-light uppercase tracking-[2px] text-emerald-100">
                      {{ $product->category->name }}
                    </span>
                  </span>
                </div>
                @endif
              </div>

              {{-- Card info --}}
              <div class="flex flex-col gap-1 p-3 md:gap-1.5 md:p-4">
                <h3 class="font-cormorant text-lg font-normal leading-snug text-emerald-900 md:text-xl">
                  {{ $product->name }}
                </h3>
                <p class="text-[11px] font-light text-[#B8860B] md:text-[12px]">
                  Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
              </div>

            </div>
            @endforeach

          </div>


          {{-- ── Pagination ── --}}
          @if ($products->hasPages())
          <div data-aos="fade-up" class="mt-12">

            <div class="mb-6 flex items-center gap-3">
              <div class="h-px flex-1 bg-emerald-200"></div>
              <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
              <div class="h-px flex-1 bg-emerald-200"></div>
            </div>

            <div class="flex items-center justify-center gap-1">

              {{-- Prev --}}
              @if ($products->onFirstPage())
                <span class="flex h-9 w-9 cursor-not-allowed items-center justify-center
                             border border-emerald-200 text-emerald-300 opacity-40">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                    <polyline points="8,1 3,6 8,11"/>
                  </svg>
                </span>
              @else
                <a href="{{ $products->previousPageUrl() }}"
                   class="flex h-9 w-9 items-center justify-center border border-emerald-200
                          text-emerald-700 transition-colors hover:border-emerald-800 hover:bg-emerald-800 hover:text-gold-100">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                    <polyline points="8,1 3,6 8,11"/>
                  </svg>
                </a>
              @endif

              {{-- Page numbers --}}
              @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                @if ($page == $products->currentPage())
                  <span class="flex h-9 w-9 items-center justify-center border border-gold-500
                               bg-emerald-800 text-[11px] font-light text-gold-100">
                    {{ $page }}
                  </span>
                @else
                  <a href="{{ $url }}"
                     class="flex h-9 w-9 items-center justify-center border border-emerald-200
                            text-[11px] font-light text-emerald-700
                            transition-colors hover:border-emerald-800 hover:bg-emerald-800 hover:text-gold-100">
                    {{ $page }}
                  </a>
                @endif
              @endforeach

              {{-- Next --}}
              @if ($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}"
                   class="flex h-9 w-9 items-center justify-center border border-emerald-200
                          text-emerald-700 transition-colors hover:border-emerald-800 hover:bg-emerald-800 hover:text-gold-100">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                    <polyline points="4,1 9,6 4,11"/>
                  </svg>
                </a>
              @else
                <span class="flex h-9 w-9 cursor-not-allowed items-center justify-center
                             border border-emerald-200 text-emerald-300 opacity-40">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                    <polyline points="4,1 9,6 4,11"/>
                  </svg>
                </span>
              @endif

            </div>

            <p class="mt-4 text-center text-[10px] font-light uppercase tracking-[3px] text-emerald-600">
              Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}
              &nbsp;·&nbsp;
              {{ $products->total() }} produk
            </p>

          </div>
          @endif

        @endif

      </div>{{-- /grid --}}
    </div>{{-- /layout --}}

  </div>
</div>

{{-- Tidak ada @push('scripts') — AOS sudah handle di layout --}}

</x-layouts.app>