@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'block w-full ps-3 pe-4 py-3 border-l-4 border-[#d4af37] text-start text-base font-medium text-[#d4af37] bg-[#d4af37]/5 focus:outline-none focus:text-[#b5952f] focus:bg-[#d4af37]/10 focus:border-[#b5952f] transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>