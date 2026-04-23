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

    {{-- Total Revenue --}}
    <div class="adm-stat" style="border-color:#C9960F; background:#FDFCF6;">
      <div>
        <p class="text-[10px] font-medium uppercase tracking-[2px] text-gold-600 mb-1">
          Pendapatan
        </p>
        <p class="font-cormorant text-2xl font-semibold text-brand-900">
          Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
        </p>
      </div>
      <div class="adm-stat-icon" style="background:#FDF8E7; border-color:#E8C56B;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="#C9960F" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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

    {{-- Perlu Dikirim --}}
    <div class="adm-stat cursor-pointer hover:opacity-90" style="border-color:#bfdbfe; background:#eff6ff;" onclick="window.location='{{ route('admin.orders.index') }}'">
      <div>
        <p class="text-[10px] font-medium uppercase tracking-[2px] text-blue-700 mb-1">
          Perlu Dikirim
        </p>
        <p class="font-cormorant text-3xl font-semibold text-blue-800">
          {{ $ordersToShip ?? 0 }}
        </p>
      </div>
      <div class="adm-stat-icon" style="background:#dbeafe; border-color:#93c5fd;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="#1d4ed8" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
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
       PESANAN TERBARU
  ═══════════════════════════════════════════════════════ --}}
  <div class="adm-card">

    <div class="mb-4 flex items-center justify-between">
      <p class="text-[11px] font-medium uppercase tracking-[3px] text-brand-900">
        Pesanan Terbaru
      </p>
      <a href="{{ route('admin.orders.index') }}"
         class="text-[10px] font-medium uppercase tracking-[2px] text-gold-500
                border-b border-gold-400 pb-0.5 transition-colors hover:text-gold-600">
        Lihat Semua
      </a>
    </div>

    <div class="flex flex-col">
      @forelse($recentOrders ?? [] as $order)
      <div class="adm-tr flex items-center gap-3 py-3 px-2 cursor-pointer hover:bg-brand-50 transition-colors" onclick="window.location='{{ route('admin.orders.show', $order->order_id) }}'">

        <div class="h-10 w-10 shrink-0 border border-brand-200 bg-cream flex items-center justify-center">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#A67D5D" stroke-width="1.5">
             <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
          </svg>
        </div>

        <div class="min-w-0 flex-1">
          <p class="truncate text-[13px] font-medium text-brand-900">
            Order #{{ $order->order_id }} - {{ $order->receiver_name }}
          </p>
          <p class="text-[12px] font-medium text-brand-700 mt-0.5">
            Rp {{ number_format($order->total_price, 0, ',', '.') }}
          </p>
        </div>

        @php
            $badgeColor = match($order->status) {
                'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                'paid' => 'bg-blue-50 text-blue-700 border-blue-200',
                'shipped' => 'bg-purple-50 text-purple-700 border-purple-200',
                'completed' => 'bg-green-50 text-green-700 border-green-200',
                'canceled' => 'bg-red-50 text-red-700 border-red-200',
                default => 'bg-gray-50 text-gray-700 border-gray-200',
            };
        @endphp

        <span class="shrink-0 text-[10px] font-medium uppercase tracking-[1px] px-2 py-1 border {{ $badgeColor }}">
          {{ $order->status }}
        </span>

      </div>
      @empty
      <p class="py-4 text-[11px] font-medium text-brand-600">
        Belum ada pesanan terbaru.
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