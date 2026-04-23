@push('styles')
<style>
  /* â”€â”€ Slider â”€â”€ */
  .cat-slider-wrap {
    overflow: hidden;
    position: relative;
    cursor: grab;
    user-select: none;
  }
  .cat-slider-wrap.dragging { cursor: grabbing; }

  .cat-track {
    display: flex;
    gap: 20px;
    transition: transform 0.5s cubic-bezier(.4,0,.2,1);
    will-change: transform;
  }
  .cat-track.no-transition { transition: none; }

  .cat-slide-item { flex: 0 0 calc((100% - 40px) / 3); }
  @media (max-width: 767px) { .cat-slide-item { flex: 0 0 100%; } }

  /* â”€â”€ Dots â”€â”€ */
  .cat-dot {
    height: 4px; border-radius: 2px;
    background: #A8D5B5;
    transition: width .3s ease, background .3s ease;
    width: 6px;
    cursor: pointer;
  }
  .cat-dot.active { width: 20px; background: #C9960F; }

  /* â”€â”€ Arrow (posisi & disabled state) â”€â”€ */
  .cat-arrow {
    width: 44px; height: 44px;
    border: 0.5px solid #C9960F;
    background: #FDFCFA;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; flex-shrink: 0;
    transition: all .3s ease;
    position: absolute;
    top: 50%;
    z-index: 10;
    opacity: 0;
    pointer-events: none;
    box-shadow: 0 4px 12px rgba(13, 43, 32, 0.1);
  }
  .cat-arrow-left  { left: -22px; transform: translate(-10px, -50%); }
  .cat-arrow-right { right: -22px; transform: translate(10px, -50%); }

  .cat-slider-container:hover .cat-arrow-left { transform: translate(0, -50%); }
  .cat-slider-container:hover .cat-arrow-right { transform: translate(0, -50%); }

  .cat-slider-container:hover .cat-arrow:not(:disabled) {
    opacity: 1;
    pointer-events: auto;
  }
  .cat-slider-container:hover .cat-arrow:disabled {
    opacity: .3;
    pointer-events: none;
  }

  .cat-arrow:hover { background: #C9960F; border-color: #C9960F; }
  .cat-arrow:hover svg { stroke: #FDFCFA; }
  .cat-arrow svg { stroke: #C9960F; transition: stroke .2s; }
  @media (max-width: 767px) { .cat-arrow { display: none; } }

  /* â”€â”€ Card effects â”€â”€ */
  .cat-card-img { transition: transform .7s ease; }
  .cat-card:hover .cat-card-img { transform: scale(1.06); }

  .cat-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, #0D2B20 0%, rgba(13,43,32,.15) 55%, transparent 100%);
    opacity: .65;
    transition: opacity .4s ease;
  }
  .cat-card:hover .cat-overlay { opacity: .80; }

  .cat-card-body { transform: translateY(6px); transition: transform .4s ease; }
  .cat-card:hover .cat-card-body { transform: translateY(0); }

  .cat-cta {
    opacity: 0;
    transform: translateY(4px);
    transition: opacity .3s ease, transform .3s ease;
  }
  .cat-card:hover .cat-cta { opacity: 1; transform: translateY(0); }
</style>
@endpush


<section id="kategori" class="relative overflow-hidden bg-cream py-16 font-jost md:py-24">

  <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- â”€â”€ Header â”€â”€ --}}
    <div class="mb-10 text-center md:mb-12">

      <div data-aos="fade-up" data-aos-delay="50"
           class="mb-6 inline-flex items-center justify-center gap-4">
        <div class="h-px w-12 bg-gold-500"></div>
        <span class="text-xs font-light uppercase tracking-widest text-gold-500 md:text-sm">Jelajahi Berdasarkan</span>
        <div class="h-px w-12 bg-gold-500"></div>
      </div>

      <h2 data-aos="fade-up" data-aos-delay="100"
          class="font-cormorant text-4xl font-normal leading-tight text-brand-900 md:text-5xl lg:text-6xl">
        Kategori
      </h2>

    </div>

    @php
      $cats      = $categories->values();
      $totalCats = $cats->count();
    @endphp

    {{-- â”€â”€ Slider â”€â”€ --}}
    <div data-aos="fade-up" data-aos-delay="150" class="cat-slider-container">

      <div class="relative">

        {{-- Arrow kiri --}}
        <button id="cat-prev" class="cat-arrow cat-arrow-left" aria-label="Sebelumnya" disabled>
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke-width="1.5">
            <polyline points="9,1 3,7 9,13"/>
          </svg>
        </button>

        {{-- Arrow kanan --}}
        <button id="cat-next" class="cat-arrow cat-arrow-right" aria-label="Berikutnya">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke-width="1.5">
            <polyline points="5,1 11,7 5,13"/>
          </svg>
        </button>

        <div class="cat-slider-wrap" id="cat-slider-wrap">
          <div class="cat-track" id="cat-track">

            @foreach ($cats as $index => $cat)
            @php
              $imgSrc = $cat->image
                ? asset('storage/' . $cat->image)
                : asset('images/categories/default.jpg');
            @endphp

            <div class="cat-slide-item">
              <a href="{{ route('shop.index', ['category' => $cat->category_id]) }}"
                 class="cat-card group relative block overflow-hidden border border-[#A8D5B5] bg-[#D4EDD9]">

                {{-- Image --}}
                <div class="aspect-[3/4] overflow-hidden">
                  <img src="{{ $imgSrc }}"
                       alt="{{ $cat->name }}"
                       class="cat-card-img h-full w-full object-cover"
                       loading="lazy"
                       onerror="this.src='{{ asset('images/categories/default.jpg') }}'">
                </div>

                {{-- Gradient overlay --}}
                <div class="cat-overlay"></div>

                {{-- Card body --}}
                <div class="cat-card-body absolute bottom-0 left-0 right-0 z-10 p-5">

                  @if($cat->tagline ?? false)
                    <p class="mb-2 text-xs font-light uppercase tracking-widest text-brand-300">
                      {{ $cat->tagline }}
                    </p>
                  @endif

                  <p class="font-cormorant text-3xl font-normal leading-tight text-cream md:text-4xl">
                    {{ $cat->name }}
                  </p>

                  <div class="mt-3 flex items-center gap-2">
                    <div class="h-px w-6 bg-gold-400 opacity-60"></div>
                    <div class="h-1 w-1 rotate-45 bg-gold-400 opacity-60"></div>
                  </div>

                  <div class="cat-cta mt-4 inline-flex items-center gap-3">
                    <span class="text-xs font-light uppercase tracking-widest text-gold-200">Lihat produk</span>
                    <svg width="16" height="11" viewBox="0 0 14 9" fill="none" stroke="#E8C97A" stroke-width="1.5">
                      <line x1="0" y1="4.5" x2="12" y2="4.5"/>
                      <polyline points="8,1 12,4.5 8,8"/>
                    </svg>
                  </div>

                </div>
              </a>
            </div>
            @endforeach

          </div>
        </div>

      </div>

      {{-- Dots --}}
      <div id="cat-dots" class="mt-6 flex items-center justify-center gap-2"></div>

    </div>

    {{-- â”€â”€ Lihat semua â”€â”€ --}}
    <div data-aos="fade-up" data-aos-delay="100"
         class="mt-12 flex justify-center">
      <a href="{{ route('shop.index') }}"
         class="inline-flex items-center gap-3 border border-brand-400 px-10 py-4
                text-xs font-normal uppercase tracking-widest text-brand-800
                transition-colors duration-200
                hover:border-brand-800 hover:bg-brand-800 hover:text-gold-100 md:text-sm">
        Lihat Semua Koleksi
        <svg width="16" height="11" viewBox="0 0 14 9" fill="none" stroke="currentColor" stroke-width="1.5">
          <line x1="0" y1="4.5" x2="12" y2="4.5"/>
          <polyline points="8,1 12,4.5 8,8"/>
        </svg>
      </a>
    </div>

  </div>
</section>


@push('scripts')
<script>
(function () {

  const wrap    = document.getElementById('cat-slider-wrap');
  const track   = document.getElementById('cat-track');
  const btnPrev = document.getElementById('cat-prev');
  const btnNext = document.getElementById('cat-next');
  const dotsEl  = document.getElementById('cat-dots');
  const items   = track ? Array.from(track.querySelectorAll('.cat-slide-item')) : [];
  const total   = items.length;
  let   current = 0;

  function getVisible()     { return window.innerWidth < 768 ? 1 : 3; }
  function getItemWidth()   { return items[0] ? items[0].getBoundingClientRect().width + 20 : 0; }
  function getPages()       { return Math.ceil(total / getVisible()); }
  function getCurrentPage() { return Math.floor(current / getVisible()); }

  function buildDots() {
    dotsEl.innerHTML = '';
    for (var i = 0; i < getPages(); i++) {
      var d = document.createElement('div');
      d.className = 'cat-dot' + (i === getCurrentPage() ? ' active' : '');
      (function(idx) { d.addEventListener('click', function() { goToPage(idx); }); })(i);
      dotsEl.appendChild(d);
    }
  }

  function updateDots() {
    dotsEl.querySelectorAll('.cat-dot').forEach(function(d, i) {
      d.classList.toggle('active', i === getCurrentPage());
    });
  }

  function goTo(idx, animate) {
    var maxSlide = Math.max(0, total - getVisible());
    current = Math.max(0, Math.min(idx, maxSlide));
    if (animate === false) track.classList.add('no-transition');
    else track.classList.remove('no-transition');
    if (track) track.style.transform = 'translateX(-' + (current * getItemWidth()) + 'px)';
    updateDots();
    if (btnPrev) btnPrev.disabled = current === 0;
    if (btnNext) btnNext.disabled = current >= maxSlide;
  }

  function goToPage(p) { goTo(p * getVisible()); }

  if (btnPrev) btnPrev.addEventListener('click', function() { goToPage(getCurrentPage() - 1); });
  if (btnNext) btnNext.addEventListener('click', function() { goToPage(getCurrentPage() + 1); });

  var touchStartX = 0;
  if (wrap) {
    wrap.addEventListener('touchstart', function(e) { touchStartX = e.touches[0].clientX; }, { passive: true });
    wrap.addEventListener('touchend', function(e) {
      var diff = touchStartX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 50) goToPage(diff > 0 ? getCurrentPage() + 1 : getCurrentPage() - 1);
    });

    var isDragging = false, dragStartX = 0, dragStartTx = 0;
    wrap.addEventListener('mousedown', function(e) {
      if (e.button !== 0) return;
      isDragging = true; dragStartX = e.clientX; dragStartTx = current * getItemWidth();
      wrap.classList.add('dragging'); track.classList.add('no-transition'); e.preventDefault();
    });
    window.addEventListener('mousemove', function(e) {
      if (!isDragging) return;
      var newTx = dragStartTx + (dragStartX - e.clientX);
      var maxTx = Math.max(0, total - getVisible()) * getItemWidth();
      track.style.transform = 'translateX(-' + Math.max(-30, Math.min(newTx, maxTx + 30)) + 'px)';
    });
    window.addEventListener('mouseup', function(e) {
      if (!isDragging) return;
      isDragging = false; wrap.classList.remove('dragging'); track.classList.remove('no-transition');
      var diff = dragStartX - e.clientX;
      if (Math.abs(diff) > getItemWidth() * 0.25) goToPage(diff > 0 ? getCurrentPage() + 1 : getCurrentPage() - 1);
      else goTo(current);
    });
    wrap.addEventListener('dragstart', function(e) { e.preventDefault(); });
  }

  var resizeTimer;
  window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() { buildDots(); goTo(getCurrentPage() * getVisible(), false); }, 150);
  });

  // Autoplay functionality
  var autoplayTimer;
  function startAutoplay() {
    stopAutoplay();
    autoplayTimer = setInterval(function() {
      var maxSlide = Math.max(0, total - getVisible());
      if (current >= maxSlide) {
        goTo(0);
      } else {
        goToPage(getCurrentPage() + 1);
      }
    }, 4000); // 4 seconds delay
  }

  function stopAutoplay() {
    if (autoplayTimer) clearInterval(autoplayTimer);
  }

  if (wrap) {
    wrap.addEventListener('mouseenter', stopAutoplay);
    wrap.addEventListener('mouseleave', startAutoplay);
    wrap.addEventListener('touchstart', stopAutoplay, { passive: true });
    wrap.addEventListener('touchend', startAutoplay);
  }

  buildDots();
  goTo(0);
  startAutoplay();

}());
</script>
@endpush