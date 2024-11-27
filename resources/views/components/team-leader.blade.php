@props(['team'])

@if ($team->owner)
    <div class="mt-2 flex items-center space-x-1">
        <div class="flex flex-row items-center">
            <img src="{{ $team->owner->defaultUserAvatar() }}" alt="{{ $team->owner->username }}"
                class="h-8 w-8 rounded-lg object-cover" />
        </div>
        <div>
            <p class="text-sm font-medium text-gray-900">{{ $team->owner->username }}</p>
            <p class="text-xs text-gray-500">{{ $team->owner->email }}</p>
        </div>
    </div>
@else
    <p class="mt-2 text-sm text-gray-500">No team leader assigned</p>
@endif
