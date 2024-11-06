@props(['icon', 'href', 'active' => false, 'title' => ''])

@php
    $classes =
        $active ?? false
            ? 'flex flex-row items-center space-x-1 rounded bg-sky-blue p-2 text-white'
            : 'flex flex-row items-center transition ease-in-out duration-150 space-x-1 rounded scale-105 hover:bg-sky-blue p-2';
@endphp

<li>
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        <x-icon name="{{ $icon }}" class="w-5 h-5 hover:text-white" />
        <span x-show="open" class="text-sm semibold">{{ $title }}</span>
    </a>
</li>
