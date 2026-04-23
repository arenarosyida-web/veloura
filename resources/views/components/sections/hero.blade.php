<section class="relative overflow-hidden bg-cream font-jost
               min-h-[calc(100vh-80px)] md:min-h-[calc(100vh-96px)]
               flex items-center">
  {{-- Decorative Background Blob --}}
  <div class="absolute -left-32 -top-32 h-[600px] w-[600px] rounded-full bg-brand-50/60 blur-3xl mix-blend-multiply"></div>
  <div class="absolute -right-32 bottom-0 h-[500px] w-[500px] rounded-full bg-gold-50/50 blur-3xl mix-blend-multiply"></div>

  <div class="relative z-10 mx-auto grid w-full max-w-7xl items-center gap-10 px-4 py-12
       sm:px-6 lg:px-8
       md:grid-cols-2 md:gap-12 md:py-16">


    {{-- ─── LEFT COLUMN - typography + CTA ─── --}}
    <div class="flex flex-col items-start order-2 md:order-1">

      {{-- Eyebrow tag --}}
      <div data-aos="fade-up" data-aos-delay="100"
           class="mb-6 flex items-center gap-4 md:mb-8">
        <div class="h-px w-12 bg-gold-500"></div>
        <span class="text-xs font-light uppercase tracking-widest text-gold-500 md:text-sm">
          Koleksi 1989
        </span>
      </div>

      {{-- Main heading --}}
      <h1 data-aos="fade-up" data-aos-delay="150"
          class="font-cormorant text-5xl font-normal leading-[1.05] text-brand-900
                 md:text-6xl lg:text-7xl">
        Cakes Made<br>
        <em class="italic text-brand-700">With <span class="text-gold-500">Love</span></em>
      </h1>

      {{-- Diamond divider --}}
      <div data-aos="fade-up" data-aos-delay="200"
           class="my-6 flex items-center gap-4 md:my-8">
        <div class="h-px w-12 bg-brand-200"></div>
        <div class="h-2 w-2 rotate-45 bg-gold-400"></div>
        <div class="h-px w-12 bg-brand-200"></div>
      </div>

      {{-- Body copy --}}
      <p data-aos="fade-up" data-aos-delay="200"
         class="mb-10 text-base font-light leading-relaxed text-brand-700 sm:text-lg md:max-w-xl lg:text-xl">
        Dari pernikahan intim hingga acara besar, p&acirc;tissier kami merancang
        kreasi khusus yang disesuaikan dengan momen Anda.
      </p>

      {{-- CTA buttons --}}
      <div data-aos="fade-up" data-aos-delay="250"
           class="flex flex-wrap items-center gap-4 md:gap-6">

        {{-- Primary --}}
        <a href="{{ route('shop.index') }}"
           class="inline-flex items-center gap-3 bg-brand-800 px-8 py-4
                  text-xs font-normal uppercase tracking-widest text-gold-100
                  transition-colors hover:bg-brand-900 md:text-sm">
          Koleksi
          <svg width="16" height="11" viewBox="0 0 14 9"
               fill="none" stroke="#E8C97A" stroke-width="1.5">
            <line x1="0" y1="4.5" x2="12" y2="4.5"/>
            <polyline points="8,1 12,4.5 8,8"/>
          </svg>
        </a>

        {{-- Secondary --}}
        <a href="#custom"
           class="inline-flex items-center gap-2 border border-brand-400 bg-transparent
                  px-8 py-4 text-xs font-normal uppercase tracking-widest text-brand-800
                  transition-colors hover:border-gold-400 hover:text-gold-500 md:text-sm">
          Custom Order
        </a>

      </div>
    </div>


{{-- ─── RIGHT COLUMN - image frame ─── --}}
<div data-aos="fade-up" data-aos-delay="50"
     class="relative flex items-center justify-center md:justify-end order-1 md:order-2">

  <div class="relative p-2 pb-6 pr-6 md:p-4 md:pb-8 md:pr-8">

    {{-- Frame container --}}
    <div class="relative h-[320px] w-[270px] md:h-[500px] md:w-[400px] lg:h-[540px] lg:w-[440px]">

      {{-- Offset shadow rect --}}
      <div class="absolute -bottom-6 -right-6 left-6 top-6 border border-brand-200 bg-brand-100
                  md:-bottom-8 md:-right-8 md:left-8 md:top-8"></div>

      {{-- Gold corner accents --}}
      <div class="absolute -left-3 -top-3 z-30 h-8 w-8 border-l-2 border-t-2 border-gold-400
                  md:-left-5 md:-top-5 md:h-12 md:w-12"></div>
      <div class="absolute -bottom-3 -right-3 z-30 h-8 w-8 border-b-2 border-r-2 border-gold-400
                  md:-bottom-5 md:-right-5 md:h-12 md:w-12"></div>

      {{-- Main image --}}
      <div class="absolute inset-0 z-10 overflow-hidden border border-brand-200 bg-cream-2">
        <img src="{{ asset('images/hero-cake.jpg') }}"
             alt="Signature Cake Veloura"
             class="h-full w-full object-cover">
      </div>

    </div>
  </div>

</div>

  </div>
</section>