@push('styles')
<style>
  /* â”€â”€ Slider â”€â”€ */
  .tr-slider-wrap {
    overflow: hidden;
    position: relative;
    cursor: grab;
    user-select: none;
  }
  .tr-slider-wrap.dragging { cursor: grabbing; }

  .tr-track {
    display: flex;
    gap: 20px;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
    will-change: transform;
  }
  .tr-track.no-transition { transition: none; }

  .tr-item { flex: 0 0 calc((100% - 40px) / 3); }
  @media (max-width: 767px) { .tr-item { flex: 0 0 100%; } }

  /* â”€â”€ Arrow (posisi & disabled state) â”€â”€ */
  .tr-arrow {
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
  .tr-arrow-left  { left: -22px; transform: translate(-10px, -50%); }
  .tr-arrow-right { right: -22px; transform: translate(10px, -50%); }

  .tr-slider-container:hover .tr-arrow-left { transform: translate(0, -50%); }
  .tr-slider-container:hover .tr-arrow-right { transform: translate(0, -50%); }

  .tr-slider-container:hover .tr-arrow:not(:disabled) {
    opacity: 1;
    pointer-events: auto;
  }
  .tr-slider-container:hover .tr-arrow:disabled {
    opacity: .3;
    pointer-events: none;
  }

  .tr-arrow:hover { background: #C9960F; border-color: #C9960F; }
  .tr-arrow:hover svg { stroke: #FDFCFA; }
  .tr-arrow svg { stroke: #C9960F; transition: stroke .2s; }
  @media (max-width: 767px) { .tr-arrow { display: none; } }

  /* â”€â”€ Dots  â”€â”€ */
  .tr-dot {
    height: 4px; border-radius: 2px;
    background: #A8D5B5;
    transition: width .3s, background .3s;
    width: 6px;
    cursor: pointer;
  }
  .tr-dot.active { width: 20px; background: #C9960F; }

  /* â”€â”€ Card corner hover â”€â”€ */
  .tr-card-corner-tl, .tr-card-corner-br {
    position: absolute;
    width: 12px; height: 12px;
    pointer-events: none; opacity: .4;
    transition: opacity .25s;
  }
  .tr-card:hover .tr-card-corner-tl,
  .tr-card:hover .tr-card-corner-br { opacity: 1; }
  .tr-card-corner-tl { top: -1px; left: -1px; border-top: 1px solid #C9960F; border-left: 1px solid #C9960F; }
  .tr-card-corner-br { bottom: -1px; right: -1px; border-bottom: 1px solid #C9960F; border-right: 1px solid #C9960F; }
</style>
@endpush


<section id="testimoni" class="relative overflow-hidden bg-cream py-16 font-jost md:py-24">

  <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- â”€â”€ Header â”€â”€ --}}
    <div class="mb-14 text-center">

      <div data-aos="fade-up" data-aos-delay="50"
           class="mb-6 inline-flex items-center justify-center gap-4">
        <div class="h-px w-12 bg-gold-500"></div>
        <span class="text-xs font-light uppercase tracking-widest text-gold-500 md:text-sm">Kata Mereka</span>
        <div class="h-px w-12 bg-gold-500"></div>
      </div>

      <h2 data-aos="fade-up" data-aos-delay="100"
          class="font-cormorant text-4xl font-normal leading-tight text-brand-900 md:text-5xl lg:text-6xl">
        Dipercaya Ribuan Pelanggan
      </h2>

    </div>


    {{-- â”€â”€ Slider â”€â”€ --}}
    @php
      $testimonials = [
        ['name' => 'Anindita R.',  'role' => 'Bride, Pernikahan 2024', 'initial' => 'A',
         'quote' => 'Kue pengantin kami persis seperti yang kami bayangkan. Tim Veloura mendengarkan setiap detail keinginan kami. Tamu-tamu bilang ini kue paling cantik yang pernah mereka lihat.'],
        ['name' => 'Clarissa M.', 'role' => 'Event Organizer',        'initial' => 'C',
         'quote' => 'Sebagai EO yang sering kerja sama dengan vendor kue, Veloura selalu jadi rekomendasi utama saya ke klien. Profesional, komunikatif, dan hasilnya selalu wow.'],
        ['name' => 'Bram Santoso','role' => 'Pelanggan Setia',        'initial' => 'B',
         'quote' => 'Sudah tiga kali pesan untuk ulang tahun keluarga dan selalu memuaskan. Rasanya konsisten, packagingnya elegan, dan pengirimannya selalu tepat waktu.'],
        ['name' => 'Denny W.',    'role' => 'Pelanggan, Jakarta',     'initial' => 'D',
         'quote' => 'Custom birthday cake untuk anak saya luar biasa. Desainnya persis seperti referensi yang dikirim, bahkan lebih bagus. Anak saya tidak mau kuenya dipotong.'],
        ['name' => 'Erlin K.',    'role' => 'Pelanggan, Bandung',     'initial' => 'E',
         'quote' => 'Hampers Lebaran dari Veloura jadi yang paling ditunggu-tunggu keluarga besar kami setiap tahun. Kualitasnya tidak pernah mengecewakan.'],
        ['name' => 'Fajar H.',    'role' => 'Pelanggan, Surabaya',    'initial' => 'F',
         'quote' => 'Pelayanannya cepat dan ramah. Kuenya datang dalam kondisi sempurna dan rasanya benar-benar premium. Pasti akan order lagi untuk acara berikutnya.'],
      ];
    @endphp

    <div data-aos="fade-up" data-aos-delay="150" class="tr-slider-container">

      <div class="relative">

        <button id="tr-prev" class="tr-arrow tr-arrow-left" aria-label="Sebelumnya" disabled>
          <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke-width="1.5">
            <polyline points="8,1 3,6.5 8,12"/>
          </svg>
        </button>

        <button id="tr-next" class="tr-arrow tr-arrow-right" aria-label="Berikutnya">
          <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke-width="1.5">
            <polyline points="5,1 10,6.5 5,12"/>
          </svg>
        </button>

        <div class="tr-slider-wrap" id="tr-slider-wrap">
          <div class="tr-track" id="tr-track">

            @foreach ($testimonials as $i => $t)
            <div class="tr-item">

              {{-- Card - full Tailwind kecuali corner --}}
              <div class="tr-card group relative flex h-full flex-col gap-4
                          border border-[#A8D5B5] bg-[#FDFCFA] p-6
                          transition-colors duration-200 hover:border-gold-400">

                {{-- Quote mark --}}
                <div class="select-none font-cormorant text-5xl font-light leading-none text-brand-200"
                     aria-hidden="true">&ldquo;</div>

                {{-- Quote text --}}
                <p class="flex-1 text-sm font-light leading-relaxed text-brand-800 md:text-base">
                  {{ $t['quote'] }}
                </p>

                {{-- Divider --}}
                <div class="my-4 border-t border-brand-100"></div>

                {{-- Author --}}
                <div class="flex items-center gap-4">
                  <div class="flex h-10 w-10 shrink-0 items-center justify-center
                              bg-brand-800 text-sm font-medium text-gold-100">
                    {{ $t['initial'] }}
                  </div>
                  <div>
                    <p class="text-xs font-medium uppercase tracking-widest text-brand-900 md:text-sm">
                      {{ $t['name'] }}
                    </p>
                    <p class="text-xs font-light text-brand-600">
                      {{ $t['role'] }}
                    </p>
                  </div>
                </div>

              </div>
            </div>
            @endforeach

          </div>
        </div>

      </div>

      {{-- Dots --}}
      <div id="tr-dots" class="mt-6 flex items-center justify-center gap-2"></div>

    </div>


    {{-- â”€â”€ Trust Badges â”€â”€ --}}
    <div class="mt-16" data-aos="fade-up" data-aos-delay="100">

      <div class="mb-10 flex items-center gap-3">
        <div class="h-px flex-1 bg-brand-200"></div>
        <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
        <div class="h-px flex-1 bg-brand-200"></div>
      </div>

      <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">

        @foreach ([
          ['<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>',
           'Bahan Premium', 'Hanya bahan pilihan berkualitas tinggi'],
          ['<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>',
           'Pengiriman Aman', 'Dikemas khusus agar tiba sempurna'],
          ['<path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>',
           'Garansi Kepuasan', 'Tidak puas? Kami carikan solusinya'],
          ['<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>',
           'Konsultasi Gratis', 'Tim kami siap membantu setiap saat'],
        ] as [$icon, $title, $desc])

        <div class="group flex items-center gap-4 border border-brand-200 bg-cream p-4
                    transition-colors duration-200 hover:border-gold-400">
          <div class="flex h-10 w-10 shrink-0 items-center justify-center
                      border border-brand-200 bg-brand-50
                      transition-colors duration-200 group-hover:border-brand-800 group-hover:bg-brand-800">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                 stroke="#1A4A33" stroke-width="1.5"
                 class="transition-all duration-200 group-hover:stroke-gold-400"
                 style="display:block;">
              {!! $icon !!}
            </svg>
          </div>
          <div class="min-w-0">
            <p class="text-xs font-medium uppercase tracking-widest text-brand-900 md:text-sm">
              {{ $title }}
            </p>
            <p class="mt-1 text-xs font-light leading-relaxed text-brand-600 md:text-sm">
              {{ $desc }}
            </p>
          </div>
        </div>

        @endforeach

      </div>
    </div>

  </div>
</section>


@push('scripts')
<script>
(function () {

  const wrap    = document.getElementById('tr-slider-wrap');
  const track   = document.getElementById('tr-track');
  const btnPrev = document.getElementById('tr-prev');
  const btnNext = document.getElementById('tr-next');
  const dotsEl  = document.getElementById('tr-dots');
  const items   = track ? Array.from(track.querySelectorAll('.tr-item')) : [];
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
      d.className = 'tr-dot' + (i === getCurrentPage() ? ' active' : '');
      (function(idx) { d.addEventListener('click', function() { goToPage(idx); }); })(i);
      dotsEl.appendChild(d);
    }
  }

  function updateDots() {
    dotsEl.querySelectorAll('.tr-dot').forEach(function(d, i) {
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