<x-layouts.admin title="Edit Kategori">

<div class="max-w-2xl font-jost space-y-5">

  {{-- ── Header ── --}}
  <div data-aos="fade-down" data-aos-duration="400">
    <a href="{{ route('categories.index') }}"
       class="mb-4 inline-flex items-center gap-2 text-[10px] font-light uppercase
              tracking-[2px] text-emerald-500 transition-colors hover:text-emerald-900">
      <svg width="12" height="8" viewBox="0 0 12 8" fill="none" stroke="currentColor" stroke-width="1.5">
        <line x1="12" y1="4" x2="2" y2="4"/><polyline points="5,1 2,4 5,7"/>
      </svg>
      Kembali ke Kategori
    </a>
    <p class="text-[10px] font-light uppercase tracking-[4px] text-gold-500 mb-1 mt-4">Admin</p>
    <h1 class="font-cormorant text-3xl font-normal text-emerald-900">Edit Kategori</h1>
    <div class="mt-3 flex items-center gap-3">
      <div class="h-px w-12 bg-emerald-200"></div>
      <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
      <div class="h-px w-6 bg-emerald-200"></div>
    </div>
  </div>

  {{-- ── Form card ── --}}
  <div class="border border-emerald-200 bg-cream p-6"
       data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">

    <form method="POST" action="{{ route('categories.update', $category->category_id) }}"
          enctype="multipart/form-data" class="flex flex-col gap-5">
      @csrf
      @method('PATCH')

      {{-- Nama --}}
      <div class="flex flex-col gap-1.5">
        <label class="text-[10px] font-light uppercase tracking-[3px] text-emerald-700">
          Nama Kategori <span class="text-red-400">*</span>
        </label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required
               class="w-full border px-4 py-2.5 text-[13px] font-light text-emerald-900
                      bg-cream focus:outline-none transition-colors
                      {{ $errors->has('name') ? 'border-red-300' : 'border-emerald-200 focus:border-gold-400' }}">
        @error('name')
          <p class="text-[11px] font-light text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- Gambar --}}
      <div class="flex flex-col gap-2">
        <label class="text-[10px] font-light uppercase tracking-[3px] text-emerald-700">
          Gambar Kategori
        </label>

        {{-- Preview gambar saat ini --}}
        @if($category->image)
        <div class="flex items-center gap-4 border border-emerald-200 bg-emerald-50/40 p-3">
          <div class="h-16 w-16 shrink-0 overflow-hidden border border-emerald-200">
            <img src="{{ asset('storage/' . $category->image) }}"
                 class="h-full w-full object-cover" alt="{{ $category->name }}">
          </div>
          <div>
            <p class="text-[11px] font-light text-emerald-700">Gambar saat ini</p>
            <p class="text-[10px] font-light uppercase tracking-[2px] text-emerald-500">
              Upload baru untuk mengganti
            </p>
          </div>
        </div>
        @endif

        <input type="file" name="image" accept="image/*" id="image-input"
               class="w-full border border-emerald-200 bg-cream px-4 py-2.5 text-[12px]
                      font-light text-emerald-700 transition-colors
                      file:mr-3 file:border-0 file:bg-emerald-800 file:px-3 file:py-1
                      file:text-[10px] file:font-light file:uppercase file:tracking-widest
                      file:text-gold-100 hover:file:bg-emerald-900
                      focus:border-gold-400 focus:outline-none">
        @error('image')
          <p class="text-[11px] font-light text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- Preview gambar baru --}}
      <div id="preview-container" class="hidden flex flex-col gap-1.5">
        <p class="text-[10px] font-light uppercase tracking-[3px] text-emerald-700">Preview Baru</p>
        <div class="flex items-center gap-4 border border-emerald-200 bg-emerald-50/40 p-3">
          <div class="h-16 w-16 shrink-0 overflow-hidden border border-emerald-200">
            <img id="preview-image" class="h-full w-full object-cover" alt="Preview">
          </div>
          <p class="text-[10px] font-light uppercase tracking-[2px] text-emerald-500">
            Gambar baru akan mengganti yang lama
          </p>
        </div>
      </div>

      {{-- Divider --}}
      <div class="flex items-center gap-3">
        <div class="h-px flex-1 bg-emerald-200"></div>
        <div class="h-1 w-1 rotate-45 bg-gold-400"></div>
      </div>

      {{-- Actions --}}
      <div class="flex items-center gap-3">
        <button type="submit"
                class="bg-emerald-800 px-6 py-2.5 text-[11px] font-light uppercase
                       tracking-[2px] text-gold-100 transition-colors hover:bg-emerald-900">
          Perbarui Kategori
        </button>
        <a href="{{ route('categories.index') }}"
           class="border border-emerald-200 px-6 py-2.5 text-[11px] font-light uppercase
                  tracking-[2px] text-emerald-700 transition-colors
                  hover:border-emerald-800 hover:text-emerald-900">
          Batal
        </a>
      </div>

    </form>
  </div>

</div>

<script>
document.getElementById('image-input').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    document.getElementById('preview-image').src = URL.createObjectURL(file);
    document.getElementById('preview-container').classList.remove('hidden');
  }
});
</script>

</x-layouts.admin>