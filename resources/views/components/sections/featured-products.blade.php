@push('styles')
<style>
  /* ── Mobile slider ── */
  .feat-slider-wrap {
    overflow: hidden;
    cursor: grab;
    user-select: none;
  }
  .feat-slider-wrap.dragging { cursor: grabbing; }

  .feat-track {
    display: flex;
    gap: 16px;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
    will-change: transform;
  }
  .feat-track.no-transition { transition: none; }

  .feat-slide-item { flex: 0 0 100%; }

  /* ── Dots ── */
  .feat-dot {
    height: 4px; border-radius: 2px;
    background: #A8D5B5;
    transition: width .3s, background .3s;
    width: 6px;
    cursor: pointer;
  }
  .feat-dot.active { width: 20px; background: #C9960F; }

  /* ── Card corner hover ── */
  .feat-card-corner-tl,
  .feat-card-corner-br {
    position: absolute;
    width: 14px; height: 14px;
    pointer-events: none;
    z-index: 10;
    opacity: 0.5;
    transition: opacity .3s ease;
  }
  .feat-card:hover .feat-card-corner-tl,
  .feat-card:hover .feat-card-corner-br { opacity: 1; }
  .feat-card-corner-tl { top: -1px; left: -1px; border-top: 1px solid #C9960F; border-left: 1px solid #C9960F; }
  .feat-card-corner-br { bottom: -1px; right: -1px; border-bottom: 1px solid #C9960F; border-right: 1px solid #C9960F; }

  /* ── Image zoom on hover ── */
  .feat-img { transition: transform .7s ease; }
  .feat-card:hover .feat-img { transform: scale(1.05); }

  /* ── "Lihat Semua" underline animasi ── */
  .feat-see-all { position: relative; display: inline-block; }
  .feat-see-all::after {
    content: '';
    position: absolute;
    bottom: -2px; left: 0;
    width: 100%; height: 0.5px;
    background: #C9960F;
    transform-origin: right;
    transition: transform .3s ease;
  }
  .feat-see-all:hover::after { transform-origin: left; }
</style>
@endpush


<section id="produk-unggulan" class="relative overflow-hidden bg-cream py-20 font-jost">

  <div class="relative z-10 mx-auto max-w-7xl px-6">

    {{-- ── HEADER ── --}}

    {{-- Mobile header --}}
    <div class="mb-10 md:hidden">
      <div data-aos="fade-up" data-aos-delay="50"
           class="mb-3 flex items-center gap-3">
        <div class="h-px w-6 bg-gold-500"></div>
        <span class="text-[10px] font-light uppercase tracking-[4px] text-gold-500">Our Selection</span>
      </div>
      <h2 data-aos="fade-up" data-aos-delay="100"
          class="font-cormorant text-4xl font-normal leading-tight text-emerald-900">
        Signature Creations
      </h2>
    </div>

    {{-- Desktop header --}}
    <div class="mb-10 hidden items-end justify-between md:flex">
      <div>
        <div data-aos="fade-up" data-aos-delay="50"
             class="mb-3 flex items-center gap-3">
          <div class="h-px w-6 bg-gold-500"></div>
          <span class="text-[10px] font-light uppercase tracking-[4px] text-gold-500">Our Selection</span>
        </div>
        <h2 data-aos="fade-up" data-aos-delay="100"
            class="font-cormorant text-4xl font-normal leading-[1.15] text-emerald-900 md:text-5xl">
          Signature Creations
        </h2>
      </div>
      <a href="{{ route('shop.index') }}"
         data-aos="fade-up" data-aos-delay="150"
         class="feat-see-all mb-1 pb-0.5 text-[10px] font-light
                uppercase tracking-[4px] text-emerald-800 transition-colors hover:text-gold-500">
        Lihat Semua Produk
      </a>
    </div>

    {{-- Diamond divider --}}
    <div data-aos="fade-up" data-aos-delay="150"
         class="mb-10 flex items-center gap-3">
      <div class="h-px flex-1 bg-emerald-200"></div>
      <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
      <div class="h-px w-10 bg-emerald-200"></div>
    </div>


    {{-- ── MOBILE — Slider ── --}}
    <div class="md:hidden">

      <div class="feat-slider-wrap" id="feat-slider-wrap">
        <div class="feat-track" id="feat-track">

          @foreach ($products->take(4) as $index => $product)
          <div class="feat-slide-item">
            <div class="feat-card relative flex flex-col border border-[#A8D5B5] bg-[#FDFCFA]
                        transition-colors duration-300 hover:border-gold-400">
              <div class="feat-card-corner-tl"></div>
              <div class="feat-card-corner-br"></div>
              <a href="{{ route('shop.product', $product->product_id) }}"
                 class="absolute inset-0 z-10" aria-label="{{ $product->name }}"></a>
              <div class="relative overflow-hidden" style="padding-bottom: 100%;">
                <div class="absolute inset-0 overflow-hidden bg-emerald-50">
                  @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="feat-img h-full w-full object-cover"
                         loading="lazy">
                  @else
                    <div class="flex h-full w-full items-center justify-center">
                      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                      </svg>
                    </div>
                  @endif
                </div>
              </div>
              <div class="flex flex-col gap-1.5 p-4">
                <h3 class="font-cormorant text-xl font-normal leading-snug text-emerald-900">
                  {{ $product->name }}
                </h3>
                <p class="text-[12px] font-light text-[#B8860B]">
                  Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
              </div>
            </div>
          </div>
          @endforeach

        </div>
      </div>

      {{-- Dots --}}
      <div id="feat-dots" class="mt-5 flex items-center justify-center gap-2"></div>

      {{-- Tombol lihat semua — mobile only --}}
      <div class="mt-8 flex justify-center">
        <a href="{{ route('shop.index') }}"
           class="inline-flex min-h-[44px] items-center gap-3 border border-emerald-400 px-8 py-3
                  text-[11px] font-normal uppercase tracking-[3px] text-emerald-800
                  transition-colors hover:border-emerald-800 hover:bg-emerald-800 hover:text-gold-100">
          Lihat Semua Produk
          <svg width="14" height="9" viewBox="0 0 14 9" fill="none" stroke="currentColor" stroke-width="1.5">
            <line x1="0" y1="4.5" x2="12" y2="4.5"/>
            <polyline points="8,1 12,4.5 8,8"/>
          </svg>
        </a>
      </div>

    </div>


    {{-- ── DESKTOP — 4 kolom grid ── --}}
    <div class="hidden gap-4 md:grid md:grid-cols-4">
      @foreach ($products->take(4) as $index => $product)
      <div class="feat-card relative flex flex-col border border-[#A8D5B5] bg-[#FDFCFA]
                  transition-colors duration-300 hover:border-gold-400"
           data-aos="fade-up"
           data-aos-delay="{{ $index * 100 }}">
        <a href="{{ route('shop.product', $product->product_id) }}"
           class="absolute inset-0 z-10" aria-label="{{ $product->name }}"></a>
        <div class="relative overflow-hidden" style="padding-bottom: 100%;">
          <div class="absolute inset-0 overflow-hidden bg-emerald-50">
            @if ($product->image)
              <img src="{{ asset('storage/' . $product->image) }}"
                   alt="{{ $product->name }}"
                   class="feat-img h-full w-full object-cover"
                   loading="lazy"
                   onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><svg width=\'48\' height=\'48\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'#A8D5B5\' stroke-width=\'1\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-4 3.6-7 8-7s8 3 8 7\'/></svg></div>'">
            @else
              <div class="flex h-full w-full items-center justify-center">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                  <circle cx="12" cy="8" r="4"/>
                  <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
              </div>
            @endif
          </div>
        </div>
        <div class="flex flex-col gap-1.5 p-4">
          <h3 class="font-cormorant text-xl font-normal leading-snug text-emerald-900">
            {{ $product->name }}
          </h3>
          <p class="text-[12px] font-light text-[#B8860B]">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </p>
        </div>
      </div>
      @endforeach
    </div>

  </div>
</section>


@push('scripts')
<script>
(function () {

  /* ── Mobile slider ── */
  const wrap   = document.getElementById('feat-slider-wrap');
  const track  = document.getElementById('feat-track');
  const dotsEl = document.getElementById('feat-dots');

  if (!wrap || !track || !dotsEl) return;

  const items = Array.from(track.querySelectorAll('.feat-slide-item'));
  const total = items.length;
  let current = 0;

  function getItemWidth() {
    return items[0] ? items[0].getBoundingClientRect().width + 16 : 0;
  }

  function buildDots() {
    dotsEl.innerHTML = '';
    for (let i = 0; i < total; i++) {
      const d = document.createElement('div');
      d.className = 'feat-dot' + (i === current ? ' active' : '');
      d.addEventListener('click', function() { goTo(i); });
      dotsEl.appendChild(d);
    }
  }

  function updateDots() {
    dotsEl.querySelectorAll('.feat-dot').forEach(function(d, i) {
      d.classList.toggle('active', i === current);
    });
  }

  function goTo(idx, animate) {
    current = Math.max(0, Math.min(idx, total - 1));
    if (animate === false) track.classList.add('no-transition');
    else track.classList.remove('no-transition');
    track.style.transform = 'translateX(-' + (current * getItemWidth()) + 'px)';
    updateDots();
  }

  /* Touch swipe */
  let touchStartX = 0;
  wrap.addEventListener('touchstart', function(e) {
    touchStartX = e.touches[0].clientX;
  }, { passive: true });
  wrap.addEventListener('touchend', function(e) {
    const diff = touchStartX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) goTo(diff > 0 ? current + 1 : current - 1);
  });

  /* Mouse drag */
  let isDragging = false, dragStartX = 0, dragStartTranslate = 0;
  wrap.addEventListener('mousedown', function(e) {
    if (e.button !== 0) return;
    isDragging = true;
    dragStartX = e.clientX;
    dragStartTranslate = current * getItemWidth();
    wrap.classList.add('dragging');
    track.classList.add('no-transition');
    e.preventDefault();
  });
  window.addEventListener('mousemove', function(e) {
    if (!isDragging) return;
    const diff = dragStartX - e.clientX;
    const max  = (total - 1) * getItemWidth();
    track.style.transform = 'translateX(-' + Math.max(-30, Math.min(dragStartTranslate + diff, max + 30)) + 'px)';
  });
  window.addEventListener('mouseup', function(e) {
    if (!isDragging) return;
    isDragging = false;
    wrap.classList.remove('dragging');
    track.classList.remove('no-transition');
    const diff = dragStartX - e.clientX;
    if (Math.abs(diff) > getItemWidth() * 0.25) goTo(diff > 0 ? current + 1 : current - 1);
    else goTo(current);
  });
  wrap.addEventListener('dragstart', function(e) { e.preventDefault(); });

  /* Resize */
  let resizeTimer;
  window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() { goTo(current, false); }, 150);
  });

  buildDots();
  goTo(0);

}());
</script>
@endpush