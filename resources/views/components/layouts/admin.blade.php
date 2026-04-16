<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title ?? 'Admin' }} — Veloura</title>

  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=jost:300,400,500|cormorant-garamond:300,400,500,600" rel="stylesheet"/>

  {{-- AOS --}}
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css"/>

  {{-- Vite / Tailwind --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  @stack('styles')
</head>

<body class="bg-stone-50 font-jost antialiased">

  {{-- ═══════════════════════════════════════════════════════
       LAYOUT: sidebar kiri + konten kanan
  ═══════════════════════════════════════════════════════ --}}
  <div class="flex min-h-screen">

    {{-- ── Sidebar (komponen) ── --}}
    @include('components.admin-sidebar')

    {{-- ── Kolom kanan: topbar mobile + konten ── --}}
    <div class="flex min-w-0 flex-1 flex-col">

      {{-- ════════════════════════════════════════════════
           MOBILE TOPBAR  — hanya muncul di bawah lg
      ════════════════════════════════════════════════ --}}
      <header class="sticky top-0 z-20 flex items-center justify-between
               border-b border-emerald-800 bg-emerald-900 px-4 py-3 lg:hidden">

        {{-- Hamburger — pindah ke KIRI --}}
  <button onclick="openSidebar()"
          aria-label="Buka menu"
          class="flex h-9 w-9 items-center justify-center text-emerald-300
                 transition-colors hover:text-gold-300 active:scale-95">
    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
         stroke="currentColor" stroke-width="1.5">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
    </svg>
  </button>

  {{-- Spacer kanan — agar logo tetap terpusat --}}
  <div class="h-9 w-9"></div>


      </header>
      {{-- END MOBILE TOPBAR --}}

      {{-- ── Konten halaman ── --}}
      <main class="flex-1 p-4 lg:p-6">
        {{ $slot }}
      </main>

    </div>
    {{-- END kolom kanan --}}

  </div>

  {{-- AOS --}}
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>AOS.init({ once: true });</script>

  @stack('scripts')
</body>
</html>