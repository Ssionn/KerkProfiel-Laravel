@props(['active' => false])

@php
    $classes =
        $active ?? false
            ? 'bg-sky-blue text-white block px-4 py-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-blue focus-visible:ring-opacity-75 rounded-lg'
            : 'hover:bg-sky-blue hover:text-white block px-4 py-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-blue focus-visible:ring-opacity-75 rounded-lg';
@endphp

<button id="userDropdown" data-dropdown-toggle="toggleUserDropdown" data-dropdown-placement="top"
    class="flex flex-row items-center p-2 w-full rounded-lg border-gray-200 hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-blue focus-visible:ring-opacity-75">
    <img src="{{ auth()->user()->defaultUserAvatar() }}" alt="{{ auth()->user()->username }}"
        class="w-8 h-8 rounded-full object-cover">
    <div class="flex flex-col items-center" :class="open ? 'ml-2' : ''">
        <span x-show="open" class="text-sm font-medium">{{ auth()->user()->username }}</span>
        <span x-show="open" class="text-xs text-gray-500">{{ auth()->user()->team->name }}</span>
    </div>
</button>

<div id="toggleUserDropdown"
    class="z-10 hidden bg-white border border-gray-200 divide-y divide-gray-100 rounded-lg shadow w-56">
    <ul class="py-[2px] px-[2px] text-sm text-gray-700" aria-labelledby="userDropdownList">
        <li>
            <a href="{{ route('settings') }}" {{ $attributes->merge(['class' => $classes]) }}>
                {{ __('Settings') }}
            </a>
        </li>
    </ul>
</div>
