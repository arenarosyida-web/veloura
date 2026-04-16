<x-layouts.app title="Home">

    <x-sections.hero />

    <x-sections.categories :categories="$categories" />

    <x-sections.featured-products :products="$products" />

    <x-sections.custom-cake />

    <x-sections.trust />

</x-layouts.app>