@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-xs text-red-600 space-y-1 mt-1']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center gap-1">
                <i class="fas fa-exclamation-circle text-[10px]"></i>
                {{ $message }}
            </li>
        @endforeach
    </ul>
@endif