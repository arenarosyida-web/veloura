<x-layouts.app :title="$product->name">

@push('styles')
<style>
  /* ── Image zoom (child selector, tidak bisa Tailwind) ── */
  .prd-main-img { transition: transform .7s ease; }
  .prd-img-wrap:hover .prd-main-img { transform: scale(1.03); }

  /* ── Related card corner & zoom (child selector) ── */
  .rel-card-corner-tl, .rel-card-corner-br {
    position: absolute; width: 12px; height: 12px;
    pointer-events: none; z-index: 10; opacity: .45;
    transition: opacity .3s;
  }
  .rel-card:hover .rel-card-corner-tl,
  .rel-card:hover .rel-card-corner-br { opacity: 1; }
  .rel-card-corner-tl { top: -1px; left: -1px; border-top: 1px solid #C9960F; border-left: 1px solid #C9960F; }
  .rel-card-corner-br { bottom: -1px; right: -1px; border-bottom: 1px solid #C9960F; border-right: 1px solid #C9960F; }
  .rel-img { transition: transform .7s ease; }
  .rel-card:hover .rel-img { transform: scale(1.05); }
</style>
@endpush


<div class="min-h-screen bg-cream font-jost">
  <div class="mx-auto max-w-7xl px-6 py-12 md:py-16">

    {{-- ── Breadcrumb ── --}}
    <nav data-aos="fade-up" data-aos-delay="50"
         class="mb-8 flex items-center gap-2 text-[10px] font-light uppercase tracking-[3px] md:mb-10">
      <a href="{{ route('home') }}"
         class="text-emerald-500 transition-colors hover:text-gold-500">Beranda</a>
      <span class="text-emerald-300">/</span>
      <a href="{{ route('shop.index') }}"
         class="text-emerald-500 transition-colors hover:text-gold-500">Koleksi</a>
      <span class="text-emerald-300">/</span>
      <span class="truncate text-emerald-800">{{ $product->name }}</span>
    </nav>


    {{-- ── PRODUCT DETAIL ── --}}
    <div class="grid gap-10 md:grid-cols-2 md:gap-16">

      {{-- ── Image ── --}}
      <div data-aos="fade-up" data-aos-delay="80">
        <div class="relative">

          {{-- Image --}}
          <div class="prd-img-wrap relative z-[1] aspect-square overflow-hidden
                      border border-emerald-200 bg-emerald-50">
            @if($product->image)
              <img src="{{ asset('storage/'.$product->image) }}"
                   alt="{{ $product->name }}"
                   class="prd-main-img h-full w-full object-cover">
            @else
              <div class="flex h-full w-full items-center justify-center">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none"
                     stroke="#A8D5B5" stroke-width="0.8">
                  <circle cx="12" cy="8" r="4"/>
                  <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
              </div>
            @endif
          </div>

        </div>
      </div>


      {{-- ── Info ── --}}
      <div class="flex flex-col justify-center">

        {{-- Name --}}
        <h1 data-aos="fade-up" data-aos-delay="130"
            class="font-cormorant text-3xl font-normal leading-tight text-emerald-900 md:text-5xl">
          {{ $product->name }}
        </h1>

        {{-- Price --}}
        <div data-aos="fade-up" data-aos-delay="160" class="mt-4 md:mt-5">
          <span class="font-cormorant text-2xl font-normal text-gold-500 md:text-3xl">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </span>
        </div>

        {{-- Description --}}
        @if($product->description)
        <p data-aos="fade-up" data-aos-delay="190"
           class="mt-4 text-[13px] font-light leading-[1.85] text-emerald-700 md:mt-5">
          {{ $product->description }}
        </p>
        @endif

        {{-- Stock status --}}
        <div data-aos="fade-up" data-aos-delay="210"
             class="mt-4 flex items-center gap-2 md:mt-5">
          <span class="h-2 w-2 rounded-full {{ $product->stock > 0 ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
          <span class="text-[11px] font-light uppercase tracking-[2px]
                       {{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-500' }}">
            {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Stok habis' }}
          </span>
        </div>

        {{-- ── Add to cart ── --}}
        <div data-aos="fade-up" data-aos-delay="240" class="mt-8">

          @auth
            @if($product->stock > 0)
            <form method="POST" action="{{ route('cart.add') }}">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->product_id }}">

              {{-- Qty controls — full Tailwind --}}
              <div class="mb-5 flex items-center gap-4">
                <span class="text-[10px] font-light uppercase tracking-[3px] text-emerald-700">Jumlah</span>
                <div class="flex items-center">
                  {{-- Minus --}}
                  <button type="button"
                          onclick="adjustQty(-1)"
                          class="flex h-9 w-9 items-center justify-center border border-[#A8D5B5]
                                 bg-[#FDFCFA] text-lg text-emerald-700 transition-colors
                                 hover:border-emerald-800 hover:bg-emerald-800 hover:text-gold-300
                                 select-none cursor-pointer">
                    −
                  </button>
                  <input type="number" id="qty-input" name="quantity"
                         value="1" min="1" max="{{ $product->stock }}"
                         class="h-9 w-14 border-y border-emerald-200 bg-cream text-center
                                text-[13px] font-light text-emerald-900 focus:outline-none
                                [appearance:textfield]
                                [&::-webkit-inner-spin-button]:appearance-none
                                [&::-webkit-outer-spin-button]:appearance-none">
                  {{-- Plus --}}
                  <button type="button"
                          onclick="adjustQty(1)"
                          class="flex h-9 w-9 items-center justify-center border border-[#A8D5B5]
                                 bg-[#FDFCFA] text-lg text-emerald-700 transition-colors
                                 hover:border-emerald-800 hover:bg-emerald-800 hover:text-gold-300
                                 select-none cursor-pointer">
                    +
                  </button>
                </div>
              </div>

              <button type="submit"
                      class="w-full border border-emerald-800 bg-emerald-800 py-3.5
                             text-[11px] font-light uppercase tracking-[3px] text-gold-100
                             transition-colors hover:bg-emerald-900">
                Tambah ke Keranjang
              </button>
            </form>

            @else
            <div class="w-full cursor-not-allowed border border-emerald-200 bg-emerald-50 py-3.5
                        text-center text-[11px] font-light uppercase tracking-[3px] text-emerald-400">
              Stok Habis
            </div>
            @endif

          @else
          <a href="{{ route('login') }}"
             class="flex w-full items-center justify-center gap-3 border border-emerald-800
                    bg-emerald-800 py-3.5 text-[11px] font-light uppercase tracking-[3px] text-gold-100
                    transition-colors hover:bg-emerald-900">
            Masuk untuk Memesan
            <svg width="14" height="9" viewBox="0 0 14 9" fill="none" stroke="#E8C97A" stroke-width="1.5">
              <line x1="0" y1="4.5" x2="12" y2="4.5"/>
              <polyline points="8,1 12,4.5 8,8"/>
            </svg>
          </a>
          @endauth

        </div>

      </div>
    </div>


    {{-- ── RELATED PRODUCTS ── --}}
    @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
    <div class="mt-16 md:mt-24">

      <div data-aos="fade-up" class="mb-8 md:mb-10">
        <div class="mb-3 flex items-center gap-3">
          <div class="h-px w-6 bg-gold-500"></div>
          <span class="text-[10px] font-light uppercase tracking-[4px] text-gold-500">
            Produk Serupa
          </span>
        </div>
        <h2 class="font-cormorant text-3xl font-normal text-emerald-900 md:text-4xl">
          Mungkin Anda Suka
        </h2>
        <div class="mt-4 flex items-center gap-3">
          <div class="h-px flex-1 bg-emerald-200"></div>
          <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
          <div class="h-px w-10 bg-emerald-200"></div>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-4">
        @foreach($relatedProducts as $i => $rel)
        <div class="rel-card relative flex flex-col border border-[#A8D5B5] bg-[#FDFCFA]
                    transition-colors duration-300 hover:border-gold-400"
             data-aos="fade-up"
             data-aos-delay="{{ $i * 80 }}">

          <a href="{{ route('shop.product', $rel->product_id) }}"
             class="absolute inset-0 z-10" aria-label="{{ $rel->name }}"></a>

          <div class="relative overflow-hidden" style="padding-bottom: 100%;">
            <div class="absolute inset-0 overflow-hidden bg-emerald-50">
              @if($rel->image)
                <img src="{{ asset('storage/'.$rel->image) }}"
                     alt="{{ $rel->name }}"
                     class="rel-img h-full w-full object-cover"
                     loading="lazy">
              @else
                <div class="flex h-full w-full items-center justify-center">
                  <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                       stroke="#A8D5B5" stroke-width="1">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                  </svg>
                </div>
              @endif
            </div>
          </div>

          <div class="flex flex-col gap-1 p-3 md:p-3">
            <h3 class="font-cormorant text-base font-normal leading-snug text-emerald-900 md:text-lg">
              {{ $rel->name }}
            </h3>
            <p class="text-[11px] font-light text-[#B8860B]">
              Rp {{ number_format($rel->price, 0, ',', '.') }}
            </p>
          </div>

        </div>
        @endforeach
      </div>

    </div>
    @endif

  </div>
</div>


@push('scripts')
<script>
function adjustQty(delta) {
  var input = document.getElementById('qty-input');
  if (!input) return;
  var min  = parseInt(input.min, 10)   || 1;
  var max  = parseInt(input.max, 10)   || 999;
  var val  = parseInt(input.value, 10) || 1;
  input.value = Math.min(max, Math.max(min, val + delta));
}
</script>
@endpush

</x-layouts.app>