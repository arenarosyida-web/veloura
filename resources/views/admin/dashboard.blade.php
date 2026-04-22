<x-layouts.admin title="Dashboard">

{{-- ============================================================
     Veloura - Admin Dashboard
     Revisi:
     - Menghapus section "Aksi Cepat" (duplikat dengan sidebar)
     - Menambahkan grafik barang masuk & keluar (Chart.js)
     - Menambahkan stat card barang masuk & keluar
     ============================================================ --}}

@push('styles')
<style>
  .adm-stat {
    background: #FDFCFA;
    border: 1px solid #E0CDBD;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    padding: 18px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    transition: border-color .2s, box-shadow .2s;
  }
  .adm-stat:hover { border-color: #C9960F; box-shadow: 0 4px 6px rgba(201,150,15,0.05); }
  .adm-stat-icon {
    width: 40px; height: 40px;
    flex-shrink: 0;
    border: 1px solid #E0CDBD;
    background: #FDF8F5;
    display: flex; align-items: center; justify-content: center;
  }

  /* ── Card base ── */
  .adm-card {
    background: #FDFCFA;
    border: 1px solid #E0CDBD;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    padding: 20px 22px;
  }

  /* ── Table row ── */
  .adm-tr { border-bottom: 1px solid #FDF8F5; }
  .adm-tr:last-child { border-bottom: none; }
</style>
@endpush


<div class="space-y-5 font-jost">

  {{-- ── Page header ── --}}
  <div class="flex items-end justify-between">
    <div>
      <p class="text-[10px] font-medium uppercase tracking-[3px] text-gold-500 mb-1">
        Overview
      </p>
      <h1 class="font-cormorant text-3xl font-normal text-brand-900">
        Dashboard
      </h1>
    </div>
    <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-600">
      {{ now()->format('d M Y') }}
    </p>
  </div>

  {{-- ── Divider ── --}}
  <div class="flex items-center gap-3">
    <div class="h-px flex-1 bg-brand-200"></div>
    <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
    <div class="h-px w-8 bg-brand-200"></div>
  </div>


  {{-- ═══════════════════════════════════════════════════════
       STAT CARDS (6 cards: 4 original + 2 stock movement)
  ═══════════════════════════════════════════════════════ --}}
  <div class="grid grid-cols-2 gap-3 lg:grid-cols-3">

    {{-- Total Products --}}
    <div class="adm-stat">
      <div>
        <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-800 mb-1">
          Products
        </p>
        <p class="font-cormorant text-3xl font-semibold text-brand-900">
          {{ $totalProducts ?? 0 }}
        </p>
      </div>
      <div class="adm-stat-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="#4A2A18" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
      </div>
    </div>

    {{-- Categories --}}
    <div class="adm-stat">
      <div>
        <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-800 mb-1">
          Categories
        </p>
        <p class="font-cormorant text-3xl font-semibold text-brand-900">
          {{ $totalCategories ?? 0 }}
        </p>
      </div>
      <div class="adm-stat-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="#4A2A18" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
        </svg>
      </div>
    </div>

    {{-- Total Orders --}}
    <div class="adm-stat">
      <div>
        <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-800 mb-1">
          Orders
        </p>
        <p class="font-cormorant text-3xl font-semibold text-brand-900">
          {{ $totalOrders ?? 0 }}
        </p>
      </div>
      <div class="adm-stat-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="#4A2A18" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
        </svg>
      </div>
    </div>

    {{-- Total Customers --}}
    <div class="adm-stat">
      <div>
        <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-800 mb-1">
          Customers
        </p>
        <p class="font-cormorant text-3xl font-semibold text-brand-900">
          {{ $totalCustomers ?? 0 }}
        </p>
      </div>
      <div class="adm-stat-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="#4A2A18" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
        </svg>
      </div>
    </div>

    {{-- Barang Masuk --}}
    <div class="adm-stat">
      <div>
        <p class="text-[10px] font-medium uppercase tracking-[2px] text-green-700 mb-1">
          Barang Masuk
        </p>
        <p class="font-cormorant text-3xl font-semibold text-green-600">
          {{ $totalStockIn ?? 0 }}
        </p>
      </div>
      <div class="adm-stat-icon" style="border-color:#bbf7d0;background:#f0fdf4">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="#16a34a" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12M12 16.5V3"/>
        </svg>
      </div>
    </div>

    {{-- Barang Keluar --}}
    <div class="adm-stat">
      <div>
        <p class="text-[10px] font-medium uppercase tracking-[2px] text-red-700 mb-1">
          Barang Keluar
        </p>
        <p class="font-cormorant text-3xl font-semibold text-red-600">
          {{ $totalStockOut ?? 0 }}
        </p>
      </div>
      <div class="adm-stat-icon" style="border-color:#fecaca;background:#fef2f2">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="#dc2626" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
        </svg>
      </div>
    </div>

  </div>


  {{-- ═══════════════════════════════════════════════════════
       GRAFIK BARANG MASUK & KELUAR (Chart.js)
  ═══════════════════════════════════════════════════════ --}}
  <div class="adm-card">
    <div class="mb-4 flex items-center justify-between">
      <p class="text-[11px] font-medium uppercase tracking-[3px] text-brand-900">
        Grafik Barang Masuk & Keluar
      </p>
      <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-600">
        6 Bulan Terakhir
      </p>
    </div>
    <div class="relative" style="height: 280px">
      <canvas id="stockChart"></canvas>
    </div>
  </div>


  {{-- ═══════════════════════════════════════════════════════
       PRODUK TERBARU (tanpa Aksi Cepat — sudah di sidebar)
  ═══════════════════════════════════════════════════════ --}}
  <div class="adm-card">

    <div class="mb-4 flex items-center justify-between">
      <p class="text-[11px] font-medium uppercase tracking-[3px] text-brand-900">
        Produk Terbaru
      </p>
      <a href="{{ route('products.index') }}"
         class="text-[10px] font-medium uppercase tracking-[2px] text-gold-500
                border-b border-gold-400 pb-0.5 transition-colors hover:text-gold-600">
        Lihat Semua
      </a>
    </div>

    <div class="flex flex-col">
      @forelse($recentProducts ?? [] as $product)
      <div class="adm-tr flex items-center gap-3 py-3">

        {{-- Thumbnail --}}
        <div class="h-10 w-10 shrink-0 overflow-hidden border border-brand-200 bg-brand-50">
          @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}"
                 class="h-full w-full object-cover" alt="{{ $product->name }}">
          @else
            <div class="flex h-full w-full items-center justify-center">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                   stroke="#E0CDBD" stroke-width="1">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
              </svg>
            </div>
          @endif
        </div>

        <div class="min-w-0 flex-1">
          <p class="truncate text-[13px] font-medium text-brand-900">
            {{ $product->name }}
          </p>
          <p class="text-[12px] font-medium text-brand-700 mt-0.5">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </p>
        </div>

        <span class="shrink-0 text-[10px] font-semibold uppercase tracking-[1px]
                     {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
          {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
        </span>

      </div>
      @empty
      <p class="py-4 text-[11px] font-medium text-brand-600">
        Belum ada produk.
      </p>
      @endforelse
    </div>

  </div>

</div>

{{-- ── Chart.js CDN ── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const ctx = document.getElementById('stockChart').getContext('2d');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: @json($chartLabels ?? []),
      datasets: [
        {
          label: 'Barang Masuk',
          data: @json($chartDataIn ?? []),
          backgroundColor: 'rgba(22, 163, 74, 0.7)',
          borderColor: 'rgba(22, 163, 74, 1)',
          borderWidth: 1,
          borderRadius: 4,
          barPercentage: 0.6,
          categoryPercentage: 0.7,
        },
        {
          label: 'Barang Keluar',
          data: @json($chartDataOut ?? []),
          backgroundColor: 'rgba(220, 38, 38, 0.7)',
          borderColor: 'rgba(220, 38, 38, 1)',
          borderWidth: 1,
          borderRadius: 4,
          barPercentage: 0.6,
          categoryPercentage: 0.7,
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 20,
            usePointStyle: true,
            pointStyle: 'rectRounded',
            font: { family: 'Jost', size: 11, weight: '500' },
            color: '#5C3A21',
          }
        },
        tooltip: {
          backgroundColor: '#2E1503',
          titleFont: { family: 'Jost', size: 11 },
          bodyFont: { family: 'Jost', size: 12 },
          padding: 12,
          cornerRadius: 2,
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: {
            font: { family: 'Jost', size: 10, weight: '500' },
            color: '#A67D5D',
          },
          border: { color: '#E0CDBD' },
        },
        y: {
          beginAtZero: true,
          grid: { color: 'rgba(224,205,189,0.3)' },
          ticks: {
            font: { family: 'Jost', size: 10, weight: '500' },
            color: '#A67D5D',
            precision: 0,
          },
          border: { display: false },
        }
      }
    }
  });
});
</script>

</x-layouts.admin>