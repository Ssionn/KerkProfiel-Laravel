@props(['icon', 'href', 'active' => false, 'title' => ''])

@php
    $classes =
        $active ?? false
            ? 'flex flex-row items-center space-x-1 rounded bg-sky-blue p-2 text-white'
            : 'flex flex-row items-center transition ease-in-out duration-150 space-x-1 rounded hover:bg-sky-blue p-2 hover:text-white';
@endphp

<li>
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        <x-icon name="{{ $icon }}" class="w-5 h-5" />
        <span x-show="open" class="text-sm semibold">{{ $title }}</span>
    </a>
</li>
