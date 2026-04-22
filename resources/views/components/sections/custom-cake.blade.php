<section id="custom"
         class="relative overflow-hidden bg-[#EDE8DF] py-16 font-jost md:py-24">
         

  <div class="relative z-10 mx-auto max-w-7xl px-6">
    <div class="grid items-center gap-12 md:grid-cols-2 md:gap-16">


{{-- ═══════════════════════════════════════
     LEFT — Image frame
═══════════════════════════════════════ --}}
<div data-aos="fade-up" data-aos-delay="50"
     class="flex items-center justify-center pb-8 md:pb-0">

  <div class="relative p-2 pb-6 pl-6 md:p-3 md:pb-9 md:pl-9">

    {{-- Frame container --}}
    <div class="relative h-[260px] w-[240px] md:h-[440px] md:w-[380px]">

      {{-- Offset shadow rect — dibalik ke bottom-left --}}
      <div class="absolute -bottom-4 -left-4 right-4 top-4 border border-emerald-200 bg-emerald-100
                  md:-bottom-6 md:-left-6 md:right-6 md:top-6"></div>

      {{-- Gold corner accents — dibalik ke kiri atas & kanan bawah --}}
      <div class="absolute -right-2 -top-2 z-30 h-6 w-6 border-r border-t border-gold-400
            md:-right-3 md:-top-3 md:h-8 md:w-8"></div>
      <div class="absolute -bottom-2 -left-2 z-30 h-6 w-6 border-b border-l border-gold-400
            md:-bottom-3 md:-left-3 md:h-8 md:w-8"></div>

      {{-- Main image --}}
      <div class="absolute inset-0 z-10 overflow-hidden border border-emerald-200 bg-[#EDE8DF]">
        <img src="{{ asset('images/hero-cake.jpg') }}"
             alt="Custom Cake Veloura"
             class="h-full w-full object-cover"
             onerror="this.style.display='none'">
      </div>

    </div>
  </div>

</div>


      {{-- ═══════════════════════════════════════
           RIGHT — Content
      ═══════════════════════════════════════ --}}
      <div class="flex flex-col">

        {{-- Eyebrow --}}
        <div data-aos="fade-up" data-aos-delay="100"
             class="mb-4 flex items-center gap-3">
          <div class="h-px w-8 bg-gold-500"></div>
          <span class="text-[10px] font-light uppercase tracking-[4px] text-gold-500">
            Custom Order
          </span>
        </div>

        {{-- Heading --}}
        <h2 data-aos="fade-up" data-aos-delay="150"
            class="font-cormorant text-4xl font-normal leading-[1.15] text-emerald-900 md:text-5xl">
          Wujudkan Kue<br>
          <em class="font-light italic text-gold-500">Impian Anda</em>
        </h2>

        {{-- Diamond divider --}}
        <div data-aos="fade-up" data-aos-delay="150"
             class="mt-5 flex items-center gap-3">
          <div class="h-px w-10 bg-emerald-200"></div>
          <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
          <div class="h-px w-10 bg-emerald-200"></div>
        </div>

        {{-- Description --}}
        <p data-aos="fade-up" data-aos-delay="200"
           class="mt-5 pr-4 text-[13px] font-light leading-[1.85] text-emerald-700 md:max-w-md md:pr-0">
          Dari pernikahan intim hingga acara besar, pâtissier kami merancang kreasi
          khusus yang disesuaikan dengan momen Anda. Setiap detail, setiap rasa —
          dirancang tepat untuk Anda.
        </p>

        {{-- Feature list --}}
        <ul data-aos="fade-up" data-aos-delay="250"
            class="mt-7 flex flex-col gap-2">
          @foreach ([
            [
              'Pilih Flavor & Isian',
              'Vanilla klasik hingga matcha eksotis — lebih dari 50 kombinasi rasa.',
              '<path stroke-linecap="round" stroke-linejoin="round" d="M4.098 19.902a3.75 3.75 0 005.304 0l6.401-6.402M6.75 21A3.75 3.75 0 013 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 003.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008z"/>',
            ],
            [
              'Desain & Dekorasi Bebas',
              'Fondant hand-painted, bunga edible, figurin sculptur — tanpa batas kreasi.',
              '<path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/>',
            ],
            [
              'Untuk Semua Momen',
              'Ulang tahun, pernikahan, wisuda, anniversary — kami rayakan bersama Anda.',
              '<path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>',
            ],
          ] as [$title, $desc, $iconPath])

          {{-- group untuk hover child --}}
          <li class="group flex cursor-default items-start gap-3.5 border border-[#A8D5B5] bg-[#FDFCFA]
                     p-4 transition-colors duration-200 hover:border-gold-400 hover:bg-[#FAF3DC]">

            {{-- Icon box --}}
            <div class="flex h-9 w-9 shrink-0 items-center justify-center border border-[#A8D5B5]
                        bg-[#EDF7EF] transition-colors duration-200
                        group-hover:border-emerald-900 group-hover:bg-emerald-900">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                   stroke="#256B47" stroke-width="1.5"
                   class="transition-all duration-200 group-hover:stroke-gold-400"
                   style="display:block;">
                {!! $iconPath !!}
              </svg>
            </div>

            {{-- Text --}}
            <div class="min-w-0 flex-1">
              <p class="mb-0.5 text-[12px] font-medium uppercase tracking-[2px] text-emerald-900">
                {{ $title }}
              </p>
              <p class="text-[12px] font-light leading-relaxed text-emerald-700">
                {{ $desc }}
              </p>
            </div>

          </li>
          @endforeach
        </ul>

        {{-- CTA --}}
        <div data-aos="fade-up" data-aos-delay="300"
             class="mt-8 flex flex-wrap items-center gap-4">
          <a href="https://wa.me/62882007694588?text=Halo,%20saya%20ingin%20memesan%20custom%20cake.%20Apakah%20bisa%20dibantu?"<a href="https://wa.me/62882007694588"
             target="_blank"
             rel="noopener noreferrer"
             class="inline-flex min-h-[44px] items-center gap-3 bg-emerald-800 px-7 py-3
                    text-[11px] font-normal uppercase tracking-[3px] text-[#F3E2AF]
                    transition-colors duration-200 hover:bg-emerald-900">
            Konsultasi
            <svg width="14" height="9" viewBox="0 0 14 9" fill="none"
                 stroke="#E8C97A" stroke-width="1.5">
              <line x1="0" y1="4.5" x2="12" y2="4.5"/>
              <polyline points="8,1 12,4.5 8,8"/>
            </svg>
          </a>
        </div>

      </div>{{-- /right --}}
    </div>{{-- /grid --}}
  </div>
</section>