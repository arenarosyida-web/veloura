<x-layouts.admin title="Dashboard">

{{-- ============================================================
     Veloura — Admin Dashboard
     Style : Flat, square, emerald & gold — konsisten dengan sidebar
     Fix   : Tambahkan pada sidebar: sticky top-0 h-screen overflow-y-auto
     ============================================================ --}}

@push('styles')
<style>
  /* ── Stat card ── */
  .adm-stat {
    background: #FDFCFA;
    border: 0.5px solid #A8D5B5;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    transition: border-color .2s;
  }
  .adm-stat:hover { border-color: #C9960F; }
  .adm-stat-icon {
    width: 40px; height: 40px;
    flex-shrink: 0;
    border: 0.5px solid #A8D5B5;
    background: #EDF7EF;
    display: flex; align-items: center; justify-content: center;
  }

  /* ── Card base ── */
  .adm-card {
    background: #FDFCFA;
    border: 0.5px solid #A8D5B5;
    padding: 20px 22px;
  }

  /* ── Table row ── */
  .adm-tr { border-bottom: 0.5px solid #EDF7EF; }
  .adm-tr:last-child { border-bottom: none; }

  /* ── Quick action ── */
  .adm-action {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 16px 12px;
    border: 0.5px solid #A8D5B5;
    background: #FDFCFA;
    text-align: center;
    transition: border-color .2s, background .2s;
    text-decoration: none;
  }
  .adm-action:hover { border-color: #C9960F; background: #FAF3DC; }
  .adm-action-label {
    font-size: 10px;
    font-weight: 400;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #256B47;
  }
  .adm-action:hover .adm-action-label { color: #B8860B; }
</style>
@endpush


{{-- ══════════════════════════════════════════════════════════════
     CATATAN SIDEBAR FIX:
     Agar sidebar tidak memanjang mengikuti konten, ubah class
     pada <aside> di sidebar.blade.php menjadi:
     class="... sticky top-0 h-screen overflow-y-auto"
     dan hapus min-h-screen
══════════════════════════════════════════════════════════════ --}}


<div class="space-y-5 font-jost">

  {{-- ── Page header ── --}}
  <div class="flex items-end justify-between">
    <div>
      <p class="text-[10px] font-light uppercase tracking-[4px] text-gold-500 mb-1">
        Overview
      </p>
      <h1 class="font-cormorant text-3xl font-normal text-emerald-900">
        Dashboard
      </h1>
    </div>
    <p class="text-[10px] font-light uppercase tracking-[2px] text-emerald-600">
      {{ now()->format('d M Y') }}
    </p>
  </div>

  {{-- ── Divider ── --}}
  <div class="flex items-center gap-3">
    <div class="h-px flex-1 bg-emerald-200"></div>
    <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
    <div class="h-px w-8 bg-emerald-200"></div>
  </div>


  {{-- ══════════════════════════════════════════════════
       STAT CARDS
  ══════════════════════════════════════════════════ --}}
  <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">

    {{-- Total Products --}}
    <div class="adm-stat">
      <div>
        <p class="text-[9px] font-light uppercase tracking-[2px] text-emerald-600 mb-1">
          Products
        </p>
        <p class="font-cormorant text-3xl font-normal text-emerald-900">
          {{ $totalProducts ?? 0 }}
        </p>
      </div>
      <div class="adm-stat-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="#1A4A33" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
      </div>
    </div>

    {{-- Categories --}}
    <div class="adm-stat">
      <div>
        <p class="text-[9px] font-light uppercase tracking-[2px] text-emerald-600 mb-1">
          Categories
        </p>
        <p class="font-cormorant text-3xl font-normal text-emerald-900">
          {{ $totalCategories ?? 0 }}
        </p>
      </div>
      <div class="adm-stat-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="#1A4A33" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
        </svg>
      </div>
    </div>

    {{-- Total Orders --}}
    <div class="adm-stat">
      <div>
        <p class="text-[9px] font-light uppercase tracking-[2px] text-emerald-600 mb-1">
          Orders
        </p>
        <p class="font-cormorant text-3xl font-normal text-emerald-900">
          {{ $totalOrders ?? 0 }}
        </p>
      </div>
      <div class="adm-stat-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="#1A4A33" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
        </svg>
      </div>
    </div>

    {{-- Total Customers --}}
    <div class="adm-stat">
      <div>
        <p class="text-[9px] font-light uppercase tracking-[2px] text-emerald-600 mb-1">
          Customers
        </p>
        <p class="font-cormorant text-3xl font-normal text-emerald-900">
          {{ $totalCustomers ?? 0 }}
        </p>
      </div>
      <div class="adm-stat-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="#1A4A33" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
        </svg>
      </div>
    </div>

  </div>


  {{-- ══════════════════════════════════════════════════
       CONTENT ROW
  ══════════════════════════════════════════════════ --}}
  <div class="grid gap-4 md:grid-cols-2">

    {{-- ── Recent Products ── --}}
    <div class="adm-card">

      <div class="mb-4 flex items-center justify-between">
        <p class="text-[10px] font-light uppercase tracking-[3px] text-emerald-700">
          Produk Terbaru
        </p>
        <a href="{{ route('products.index') }}"
           class="text-[9px] font-light uppercase tracking-[2px] text-gold-500
                  border-b border-gold-400 pb-0.5 transition-colors hover:text-gold-600">
          Lihat Semua
        </a>
      </div>

      <div class="flex flex-col">
        @forelse($recentProducts ?? [] as $product)
        <div class="adm-tr flex items-center gap-3 py-3">

          {{-- Thumbnail --}}
          <div class="h-10 w-10 shrink-0 overflow-hidden border border-emerald-200 bg-emerald-50">
            @if($product->image)
              <img src="{{ asset('storage/'.$product->image) }}"
                   class="h-full w-full object-cover" alt="{{ $product->name }}">
            @else
              <div class="flex h-full w-full items-center justify-center">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="#A8D5B5" stroke-width="1">
                  <circle cx="12" cy="8" r="4"/>
                  <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
              </div>
            @endif
          </div>

          <div class="min-w-0 flex-1">
            <p class="truncate text-[12px] font-light text-emerald-900">
              {{ $product->name }}
            </p>
            <p class="text-[11px] font-light text-gold-500">
              Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>
          </div>

          <span class="shrink-0 text-[9px] font-light uppercase tracking-[1px]
                       {{ $product->stock > 0 ? 'text-emerald-500' : 'text-red-400' }}">
            {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
          </span>

        </div>
        @empty
        <p class="py-4 text-[11px] font-light text-emerald-400">
          Belum ada produk.
        </p>
        @endforelse
      </div>

    </div>


    {{-- ── Quick Actions ── --}}
    <div class="adm-card">

      <p class="mb-4 text-[10px] font-light uppercase tracking-[3px] text-emerald-700">
        Aksi Cepat
      </p>

      <div class="grid grid-cols-2 gap-3">

        <a href="{{ route('products.create') }}" class="adm-action">
          <div class="flex h-9 w-9 items-center justify-center border border-emerald-200 bg-emerald-50">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="#1A4A33" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
          </div>
          <span class="adm-action-label">Tambah Produk</span>
        </a>

        <a href="{{ route('categories.create') }}" class="adm-action">
          <div class="flex h-9 w-9 items-center justify-center border border-emerald-200 bg-emerald-50">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="#1A4A33" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
            </svg>
          </div>
          <span class="adm-action-label">Tambah Kategori</span>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="adm-action">
          <div class="flex h-9 w-9 items-center justify-center border border-emerald-200 bg-emerald-50">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="#1A4A33" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
            </svg>
          </div>
          <span class="adm-action-label">Semua Order</span>
        </a>

        <a href="{{ route('admin.payments.index') }}" class="adm-action">
          <div class="flex h-9 w-9 items-center justify-center border border-emerald-200 bg-emerald-50">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="#1A4A33" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
            </svg>
          </div>
          <span class="adm-action-label">Payments</span>
        </a>
        
        <a href="{{ route('admin.users.index') }}" class="adm-action">
          <div class="flex h-9 w-9 items-center justify-center border border-emerald-200 bg-emerald-50">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="#1A4A33" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
            </svg>
          </div>
          <span class="adm-action-label">Customer</span>
        </a>

    </div>
    </div>

  </div>

</div>

</x-layouts.admin>