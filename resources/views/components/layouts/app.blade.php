<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Veloura' }} — Cake Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=EB+Garamond:ital,wght@0,400;1,400&family=Raleway:wght@400;500&display=swap" rel="stylesheet">
    {{-- AOS CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>

    @include('components.navbar')

    <main>
        {{ $slot }}
    </main>

    @include('components.footer')

    {{-- AOS JS --}}
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
        duration: 750,
        easing: 'ease-out-quart',
        once: true,
        offset: 80,
        });
    </script>

    @stack('scripts')
</body>
</html>