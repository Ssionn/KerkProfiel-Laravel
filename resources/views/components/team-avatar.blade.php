@props(['team'])
<img src="{{ $team->defaultTeamAvatar() }}" alt="{{ $team->name }}"
    class="h-12 w-12 rounded-lg object-cover border border-gray-200" />
