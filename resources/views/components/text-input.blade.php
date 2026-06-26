@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full border-2 border-gray-200 rounded-xl shadow-sm focus:border-[#d4af37] focus:ring-[#d4af37] focus:ring-2 focus:ring-offset-0 py-3 px-4 text-gray-800 placeholder-gray-400 transition-all duration-300']) }}>