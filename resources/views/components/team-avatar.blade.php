@props(['team'])

<img src="{{ $team->getFirstMediaUrl('avatars') }}" alt="{{ $team->name }}"
    class="h-12 w-12 rounded-full object-cover" />
