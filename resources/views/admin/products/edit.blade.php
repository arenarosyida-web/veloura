<x-layouts.admin title="Edit Produk">

<div class="max-w-2xl font-jost space-y-5">

  {{-- ── Header ── --}}
  <div data-aos="fade-down" data-aos-duration="400">
    <a href="{{ route('products.index') }}"
       class="mb-4 inline-flex items-center gap-2 text-[10px] font-medium uppercase
              tracking-[2px] text-brand-700 transition-colors hover:text-brand-900">
      <svg width="12" height="8" viewBox="0 0 12 8" fill="none" stroke="currentColor" stroke-width="1.5">
        <line x1="12" y1="4" x2="2" y2="4"/><polyline points="5,1 2,4 5,7"/>
      </svg>
      Kembali ke Produk
    </a>
    <p class="text-[10px] font-medium uppercase tracking-[3px] text-gold-500 mb-1 mt-4">Admin</p>
    <h1 class="font-cormorant text-3xl font-normal text-brand-900">Edit Produk</h1>
    <div class="mt-3 flex items-center gap-3">
      <div class="h-px w-12 bg-brand-200"></div>
      <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
      <div class="h-px w-6 bg-brand-200"></div>
    </div>
  </div>

  {{-- ── Form card ── --}}
  <div class="border border-brand-200 bg-cream p-6"
       data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">

    <form method="POST" action="{{ route('products.update', $product->product_id) }}"
          enctype="multipart/form-data" class="flex flex-col gap-5">
      @csrf
      @method('PATCH')

      {{-- Nama --}}
      <div class="flex flex-col gap-1.5">
        <label class="text-[11px] font-medium uppercase tracking-[2px] text-brand-900">
          Nama Produk <span class="text-red-600 font-semibold">*</span>
        </label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
               class="w-full border px-4 py-2.5 text-[13px] font-medium text-brand-900
                      bg-cream focus:outline-none transition-colors
                      {{ $errors->has('name') ? 'border-red-300' : 'border-brand-200 focus:border-gold-400' }}">
        @error('name')
          <p class="text-[11px] font-light text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- Harga + Stok --}}
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-1.5">
          <label class="text-[11px] font-medium uppercase tracking-[2px] text-brand-900">
            Harga (Rp) <span class="text-red-600 font-semibold">*</span>
          </label>
          <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                 class="w-full border px-4 py-2.5 text-[13px] font-medium text-brand-900
                        bg-cream focus:outline-none transition-colors
                        {{ $errors->has('price') ? 'border-red-300' : 'border-brand-200 focus:border-gold-400' }}">
          @error('price')
            <p class="text-[11px] font-light text-red-500">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="text-[11px] font-medium uppercase tracking-[2px] text-brand-900">
            Stok <span class="text-red-600 font-semibold">*</span>
          </label>
          <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                 class="w-full border px-4 py-2.5 text-[13px] font-medium text-brand-900
                        bg-cream focus:outline-none transition-colors
                        {{ $errors->has('stock') ? 'border-red-300' : 'border-brand-200 focus:border-gold-400' }}">
          @error('stock')
            <p class="text-[11px] font-light text-red-500">{{ $message }}</p>
          @enderror
        </div>
      </div>

      {{-- Kategori --}}
      <div class="flex flex-col gap-1.5">
        <label class="text-[11px] font-medium uppercase tracking-[2px] text-brand-900">
          Kategori
        </label>
        <select name="category_id"
                class="w-full border border-brand-200 bg-cream px-4 py-2.5 text-[13px] font-medium text-brand-900 focus:border-gold-400 focus:outline-none transition-colors">
          <option value="">- Tanpa Kategori -</option>
          @foreach($categories as $category)
            <option value="{{ $category->category_id }}"
                    {{ $product->category_id == $category->category_id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Deskripsi --}}
      <div class="flex flex-col gap-1.5">
        <label class="text-[11px] font-medium uppercase tracking-[2px] text-brand-900">
          Deskripsi
        </label>
        <textarea name="description" rows="3"
                  class="w-full resize-none border border-brand-200 bg-cream px-4 py-2.5
                         text-[13px] font-medium text-brand-900
                         focus:border-gold-400 focus:outline-none transition-colors">{{ old('description', $product->description) }}</textarea>
      </div>

    {{-- Gambar --}}
    <div class="flex flex-col gap-2">
      <label class="text-[11px] font-medium uppercase tracking-[2px] text-brand-900">
        Gambar Produk
      </label>

      {{-- Preview gambar saat ini --}}
      @if($product->image)
      <div class="mb-2 h-16 w-16 overflow-hidden border border-brand-200">
        <img src="{{ asset('storage/' . $product->image) }}"
            class="h-full w-full object-cover" alt="{{ $product->name }}">
      </div>
      @endif

      <input type="file" name="image" accept="image/jpg,image/png,image/jpeg"
            class="w-full border border-brand-200 bg-cream px-4 py-2.5 text-[13px] font-medium text-brand-800 transition-colors
                    file:mr-3 file:border-0 file:bg-brand-800 file:px-3 file:py-1
                    file:text-[10px] file:font-light file:uppercase file:tracking-widest
                    file:text-gold-100 hover:file:bg-brand-900
                    focus:border-gold-400 focus:outline-none">
      @error('image')
        <p class="text-[11px] font-light text-red-500">{{ $message }}</p>
      @enderror
    </div>

      {{-- Divider --}}
      <div class="flex items-center gap-3">
        <div class="h-px flex-1 bg-brand-200"></div>
        <div class="h-1 w-1 rotate-45 bg-gold-400"></div>
      </div>

      {{-- Actions --}}
      <div class="flex items-center gap-3">
        <button type="submit"
                class="bg-brand-800 px-6 py-2.5 text-[11px] font-medium uppercase
                       tracking-[2px] text-gold-100 transition-colors hover:bg-brand-900">
          Perbarui Produk
        </button>
        <a href="{{ route('products.index') }}"
           class="border border-brand-200 px-6 py-2.5 text-[11px] font-medium uppercase
                  tracking-[2px] text-brand-700 transition-colors
                  hover:border-brand-800 hover:text-brand-900">
          Batal
        </a>
      </div>

    </form>
  </div>

</div>

</x-layouts.admin>