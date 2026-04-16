<x-layouts.app title="Cek Resi">

<div class="min-h-screen bg-cream font-jost">
  <div class="mx-auto max-w-xl px-6 py-16">

    {{-- ── Header ── --}}
    <div class="mb-10"
         data-aos="fade-up" data-aos-duration="600">
      <div class="mb-3 flex items-center gap-3">
        <div class="h-px w-6 bg-gold-500"></div>
        <span class="text-[10px] font-light uppercase tracking-[4px] text-gold-500">
          Layanan Pengiriman
        </span>
      </div>
      <h1 class="font-cormorant text-5xl font-normal text-emerald-900">
        Cek Resi
      </h1>
      <div class="mt-4 flex items-center gap-3">
        <div class="h-px w-12 bg-emerald-200"></div>
        <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
        <div class="h-px w-6 bg-emerald-200"></div>
      </div>
    </div>


    {{-- ── Form ── --}}
    <div class="border border-emerald-200 bg-cream p-6"
         data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">

      {{-- Corner accents --}}
      <div class="pointer-events-none absolute -left-px -top-px h-4 w-4 border-l border-t border-gold-400"></div>
      <div class="pointer-events-none absolute -bottom-px -right-px h-4 w-4 border-b border-r border-gold-400"></div>

      <div class="relative">
        <form action="/cek-resi" method="POST" class="flex flex-col gap-5">
          @csrf

          {{-- Pilih Kurir --}}
          <div class="flex flex-col gap-1.5">
            <label class="text-[10px] font-light uppercase tracking-[3px] text-emerald-700">
              Pilih Kurir
            </label>
            <select name="courier"
                    class="w-full border border-emerald-200 bg-cream px-4 py-2.5 text-[13px]
                           font-light text-emerald-900 focus:border-gold-400 focus:outline-none
                           transition-colors">
              <option value="jne">JNE</option>
              <option value="jnt">J&amp;T</option>
              <option value="sicepat">SiCepat</option>
              <option value="tiki">TIKI</option>
              <option value="spx">SPX</option>
            </select>
          </div>

          {{-- Nomor Resi --}}
          <div class="flex flex-col gap-1.5">
            <label class="text-[10px] font-light uppercase tracking-[3px] text-emerald-700">
              Nomor Resi (AWB) <span class="text-red-400">*</span>
            </label>
            <input type="text" name="awb" required autocomplete="off"
                   placeholder="Masukkan nomor resi..."
                   class="w-full border border-emerald-200 bg-cream px-4 py-2.5 text-[13px]
                          font-light text-emerald-900 placeholder:text-emerald-300
                          focus:border-gold-400 focus:outline-none transition-colors">
          </div>

          {{-- No. HP --}}
          <div class="flex flex-col gap-1.5">
            <label class="text-[10px] font-light uppercase tracking-[3px] text-emerald-700">
              5 Digit Terakhir No. HP
              <span class="ml-1 normal-case text-[9px] tracking-normal text-emerald-500">(Opsional)</span>
            </label>
            <input type="text" name="phone"
                   placeholder="Contoh: 12345"
                   class="w-full border border-emerald-200 bg-cream px-4 py-2.5 text-[13px]
                          font-light text-emerald-900 placeholder:text-emerald-300
                          focus:border-gold-400 focus:outline-none transition-colors">
            <p class="text-[10px] font-light text-emerald-500">
              * Wajib untuk beberapa kurir seperti J&amp;T
            </p>
          </div>

          {{-- Submit --}}
          <button type="submit"
                  class="flex w-full items-center justify-center gap-3 bg-emerald-800 py-3.5
                         text-[11px] font-light uppercase tracking-[3px] text-gold-100
                         transition-colors hover:bg-emerald-900">
            Lacak Paket
            <svg width="14" height="9" viewBox="0 0 14 9" fill="none"
                 stroke="#E8C97A" stroke-width="1.5">
              <line x1="0" y1="4.5" x2="12" y2="4.5"/>
              <polyline points="8,1 12,4.5 8,8"/>
            </svg>
          </button>

        </form>
      </div>
    </div>


    {{-- ── Hasil Pelacakan ── --}}
    @php $result = session('result') ?? (isset($result) ? $result : null); @endphp

    @if(isset($result) && $result['status'] == 200)

    <div class="mt-6 border border-emerald-200 bg-cream"
         data-aos="fade-up" data-aos-duration="500">

      {{-- Result header --}}
      <div class="border-b border-emerald-200 bg-emerald-50/60 px-5 py-4">
        <div class="mb-1 flex items-center gap-3">
          <div class="h-px w-6 bg-gold-500"></div>
          <span class="text-[10px] font-light uppercase tracking-[4px] text-gold-500">
            Hasil Pelacakan
          </span>
        </div>
        <p class="font-cormorant text-2xl font-normal text-emerald-900">
          {{ $result['data']['summary']['awb'] }}
        </p>
        <div class="mt-2 flex items-center gap-2">
          <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
          <span class="text-[11px] font-light uppercase tracking-[2px] text-emerald-600">
            {{ $result['data']['summary']['status'] }}
          </span>
        </div>
      </div>

      {{-- Divider --}}
      <div class="flex items-center gap-3 px-5 py-3">
        <div class="h-px flex-1 bg-emerald-200"></div>
        <div class="h-1 w-1 rotate-45 bg-gold-400"></div>
        <div class="h-px w-8 bg-emerald-200"></div>
      </div>

      {{-- Header label riwayat --}}
      <div class="px-5 pb-2">
        <p class="text-[10px] font-light uppercase tracking-[3px] text-emerald-700">
          Riwayat Perjalanan
        </p>
      </div>

      {{-- Log list --}}
      <div class="flex flex-col px-5 pb-5">
        @foreach($result['data']['history'] as $i => $log)
        <div class="flex gap-4 {{ !$loop->last ? 'pb-4' : '' }}">

          {{-- Timeline indicator --}}
          <div class="flex flex-col items-center">
            <div class="h-2.5 w-2.5 shrink-0 border border-gold-400
                        {{ $loop->first ? 'bg-gold-400' : 'bg-cream' }}
                        mt-1.5"></div>
            @if(!$loop->last)
              <div class="mt-1 w-px flex-1 bg-emerald-200"></div>
            @endif
          </div>

          {{-- Content --}}
          <div class="min-w-0 pb-1">
            <p class="text-[10px] font-light uppercase tracking-[2px] text-emerald-500 mb-0.5">
              {{ $log['date'] }}
            </p>
            <p class="text-[12px] font-light leading-relaxed text-emerald-800">
              {{ $log['desc'] }}
            </p>
          </div>

        </div>
        @endforeach
      </div>

    </div>

    @elseif(isset($result))

    {{-- Error state --}}
    <div class="mt-6 border border-red-200 bg-red-50 px-5 py-4"
         data-aos="fade-up">
      <div class="flex items-center gap-2">
        <span class="h-1.5 w-1.5 rounded-full bg-red-400"></span>
        <p class="text-[11px] font-light uppercase tracking-[2px] text-red-500">
          Resi tidak ditemukan atau terjadi kesalahan.
        </p>
      </div>
    </div>

    @endif

  </div>
</div>

</x-layouts.app>