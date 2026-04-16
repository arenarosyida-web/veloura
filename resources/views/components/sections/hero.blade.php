<section class="relative overflow-hidden bg-cream font-jost">

  <div class="relative z-10 mx-auto grid max-w-7xl items-center gap-8 px-6 py-10
              md:grid-cols-2 md:gap-12 md:py-20">


    {{-- ─── LEFT COLUMN — typography + CTA ─── --}}
    <div class="flex flex-col items-start order-2 md:order-1">

      {{-- Eyebrow tag --}}
      <div data-aos="fade-up" data-aos-delay="100"
           class="mb-4 flex items-center gap-3 md:mb-6">
        <div class="h-px w-8 bg-gold-500"></div>
        <span class="text-[10px] font-light uppercase tracking-[4px] text-gold-500">
          Koleksi 1989
        </span>
      </div>

      {{-- Main heading --}}
      <h1 data-aos="fade-up" data-aos-delay="150"
          class="font-cormorant text-[34px] font-normal leading-[1.08] text-emerald-900 md:text-[62px]">
        Cakes Made<br>
        <em class="italic text-emerald-700">With <span class="text-gold-500">Love</span></em>
      </h1>

      {{-- Diamond divider --}}
      <div data-aos="fade-up" data-aos-delay="200"
           class="my-4 flex items-center gap-3 md:my-5">
        <div class="h-px w-8 bg-emerald-200"></div>
        <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
        <div class="h-px w-8 bg-emerald-200"></div>
      </div>

      {{-- Body copy --}}
      <p data-aos="fade-up" data-aos-delay="200"
         class="mb-7 pr-4 text-[13px] font-light leading-[1.85] text-emerald-700
                md:mb-9 md:max-w-xs md:pr-0">
        Dari pernikahan intim hingga acara besar, pâtissier kami merancang
        kreasi khusus yang disesuaikan dengan momen Anda.
      </p>

      {{-- CTA buttons --}}
      <div data-aos="fade-up" data-aos-delay="250"
           class="flex items-center gap-3 md:gap-4">

        {{-- Primary --}}
        <a href="#"
           class="inline-flex min-h-[44px] items-center gap-3 bg-emerald-800 px-6 py-3.5
                  text-[10px] font-normal uppercase tracking-[3px] text-gold-100
                  transition-colors hover:bg-emerald-900
                  md:min-h-0 md:px-7 md:text-[11px]">
          Koleksi
          <svg width="14" height="9" viewBox="0 0 14 9"
               fill="none" stroke="#E8C97A" stroke-width="1.5">
            <line x1="0" y1="4.5" x2="12" y2="4.5"/>
            <polyline points="8,1 12,4.5 8,8"/>
          </svg>
        </a>

        {{-- Secondary --}}
        <a href="#custom"
           class="inline-flex min-h-[44px] items-center gap-2 border border-emerald-400 bg-transparent
                  px-4 py-3.5 text-[10px] font-normal uppercase tracking-[3px] text-emerald-700
                  transition-colors hover:border-gold-400 hover:text-gold-500
                  md:min-h-0 md:px-5 md:text-[11px]">
          Custom Order
        </a>

      </div>
    </div>


{{-- ─── RIGHT COLUMN — image frame ─── --}}
<div data-aos="fade-up" data-aos-delay="50"
     class="relative flex items-center justify-center order-1 pb-8 md:order-2 md:pb-0">

  <div class="relative p-2 pb-6 pr-6 md:p-3 md:pb-9 md:pr-9">

    {{-- Frame container — TETAP di sini, ornamen yang menyesuaikan --}}
    <div class="relative h-[260px] w-[240px] md:h-[440px] md:w-[380px]">

      {{-- Offset shadow rect --}}
      <div class="absolute -bottom-4 -right-4 left-4 top-4 border border-emerald-200 bg-emerald-100
                  md:-bottom-6 md:-right-6 md:left-6 md:top-6"></div>

      {{-- Gold corner accents --}}
      <div class="absolute -left-2 -top-2 z-30 h-6 w-6 border-l border-t border-gold-400
                  md:-left-3 md:-top-3 md:h-8 md:w-8"></div>
      <div class="absolute -bottom-2 -right-2 z-30 h-6 w-6 border-b border-r border-gold-400
                  md:-bottom-3 md:-right-3 md:h-8 md:w-8"></div>

      {{-- Main image --}}
      <div class="absolute inset-0 z-10 overflow-hidden border border-emerald-200 bg-cream-2">
        <img src="{{ asset('images/hero-cake.jpg') }}"
             alt="Signature Cake Veloura"
             class="h-full w-full object-cover">
      </div>

    </div>
  </div>

</div>

  </div>
</section>