@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2']) }}>
        <i class="fas fa-check-circle text-green-500"></i>
        {{ $status }}
    </div>
@endif