<section id="custom"
         class="relative overflow-hidden bg-[#EDE8DF] py-16 font-jost md:py-24">
         

  <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid items-center gap-10 md:grid-cols-2 md:gap-12">


{{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
     LEFT - Image frame
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
<div data-aos="fade-up" data-aos-delay="50"
     class="flex items-center justify-center md:justify-start pb-8 md:pb-0">

  <div class="relative p-2 pb-6 pl-6 md:p-3 md:pb-9 md:pl-9">

    {{-- Frame container --}}
    <div class="relative h-[320px] w-[270px] md:h-[500px] md:w-[400px] lg:h-[540px] lg:w-[440px]">

      {{-- Offset shadow rect --}}
      <div class="absolute -bottom-5 -left-5 right-5 top-5 border border-brand-200 bg-brand-100
                  md:-bottom-7 md:-left-7 md:right-7 md:top-7"></div>

      {{-- Gold corner accents --}}
      <div class="absolute -right-3 -top-3 z-30 h-8 w-8 border-r-2 border-t-2 border-gold-400
            md:-right-4 md:-top-4 md:h-10 md:w-10"></div>
      <div class="absolute -bottom-3 -left-3 z-30 h-8 w-8 border-b-2 border-l-2 border-gold-400
            md:-bottom-4 md:-left-4 md:h-10 md:w-10"></div>

      {{-- Main image parallax --}}
      <div class="absolute inset-0 z-10 overflow-hidden border border-brand-200 bg-[#EDE8DF]">
        <img src="{{ asset('images/hero-cake.jpg') }}"
             alt="Custom Cake Veloura"
             class="h-full w-full object-cover"
             onerror="this.style.display='none'">
      </div>

    </div>
  </div>

</div>


      {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
           RIGHT - Content
      â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
      <div class="flex flex-col">

        {{-- Eyebrow --}}
        <div data-aos="fade-up" data-aos-delay="100"
             class="mb-6 flex items-center gap-4">
          <div class="h-px w-12 bg-gold-500"></div>
          <span class="text-xs font-light uppercase tracking-widest text-gold-500 md:text-sm">
            Custom Order
          </span>
        </div>

        {{-- Heading --}}
        <h2 data-aos="fade-up" data-aos-delay="150"
            class="font-cormorant text-4xl font-normal leading-[1.15] text-brand-900 md:text-5xl lg:text-6xl">
          Wujudkan Kue<br>
          <em class="font-light italic text-gold-500">Impian Anda</em>
        </h2>

        {{-- Diamond divider --}}
        <div data-aos="fade-up" data-aos-delay="150"
             class="mt-6 flex items-center gap-4">
          <div class="h-px w-12 bg-brand-200"></div>
          <div class="h-2 w-2 rotate-45 bg-gold-400"></div>
          <div class="h-px w-12 bg-brand-200"></div>
        </div>

        {{-- Description --}}
        <p data-aos="fade-up" data-aos-delay="200"
           class="mt-6 text-base font-light leading-relaxed text-brand-700 sm:text-lg md:max-w-lg">
          Dari pernikahan intim hingga acara besar, p&acirc;tissier kami merancang kreasi
          khusus yang disesuaikan dengan momen Anda. Setiap detail, setiap rasa &mdash;
          dirancang tepat untuk Anda.
        </p>

        {{-- Feature list --}}
        <ul data-aos="fade-up" data-aos-delay="250"
            class="mt-7 flex flex-col gap-2">
          @foreach ([
            [
              'Pilih Flavor & Isian',
              'Vanilla klasik hingga matcha eksotis - lebih dari 50 kombinasi rasa.',
              '<path stroke-linecap="round" stroke-linejoin="round" d="M4.098 19.902a3.75 3.75 0 005.304 0l6.401-6.402M6.75 21A3.75 3.75 0 013 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 003.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008z"/>',
            ],
            [
              'Desain & Dekorasi Bebas',
              'Fondant hand-painted, bunga edible, figurin sculptur - tanpa batas kreasi.',
              '<path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/>',
            ],
            [
              'Untuk Semua Momen',
              'Ulang tahun, pernikahan, wisuda, anniversary - kami rayakan bersama Anda.',
              '<path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>',
            ],
          ] as [$title, $desc, $iconPath])

          {{-- group untuk hover child --}}
          <li class="group flex cursor-default items-start gap-3.5 border border-[#A8D5B5] bg-[#FDFCFA]
                     p-4 transition-colors duration-200 hover:border-gold-400 hover:bg-[#FAF3DC]">

            {{-- Icon box --}}
            <div class="flex h-9 w-9 shrink-0 items-center justify-center border border-[#A8D5B5]
                        bg-[#EDF7EF] transition-colors duration-200
                        group-hover:border-brand-900 group-hover:bg-brand-900">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                   stroke="#256B47" stroke-width="1.5"
                   class="transition-all duration-200 group-hover:stroke-gold-400"
                   style="display:block;">
                {!! $iconPath !!}
              </svg>
            </div>

            {{-- Text --}}
            <div class="min-w-0 flex-1">
              <p class="mb-1 text-sm font-medium uppercase tracking-widest text-brand-900">
                {{ $title }}
              </p>
              <p class="text-sm font-light leading-relaxed text-brand-700">
                {{ $desc }}
              </p>
            </div>

          </li>
          @endforeach
        </ul>

        {{-- CTA --}}
        <div data-aos="fade-up" data-aos-delay="300"
             class="mt-10 flex flex-wrap items-center gap-4">
          <a href="https://wa.me/6282135854733?text=Halo%20saya%20ingin%20custom%20cake%20%F0%9F%8E%82%0A%0ASaya%20punya%20request%20seperti%20berikut:%0A%0A(Boleh%20ceritakan%20tema%2C%20acara%2C%20atau%20inspirasi%20yang%20diinginkan)%0A%0AJika%20perlu%2C%20ini%20detail%20tambahan:%0A-%20Tanggal:%0A-%20Ukuran:%0A-%20Budget:%0A%0ATerima%20kasih%20%F0%9F%99%8F"
             target="_blank"
             rel="noopener noreferrer"
             class="inline-flex items-center gap-3 bg-brand-800 px-8 py-4
                    text-xs font-normal uppercase tracking-widest text-gold-100
                    transition-colors duration-200 hover:bg-brand-900 md:text-sm">
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