@props(['team'])

@if ($team->owner)
    <div class="mt-2 flex items-center space-x-3">
        <div class="flex-shrink-0">
            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                <span class="text-xs font-medium text-gray-600">
                    {{ Str::upper(Str::substr($team->owner->username, 0, 2)) }}
                </span>
            </div>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-900">{{ $team->owner->username }}</p>
            <p class="text-xs text-gray-500">{{ $team->owner->email }}</p>
        </div>
    </div>
@else
    <p class="mt-2 text-sm text-gray-500">No team leader assigned</p>
@endif
