<div class="w-full relative">
    <label class="ml-1 text-xs font-semibold text-gray-600" for="team_name_search">
        {{ __('Team zoeken') }}
    </label>
    <input type="text" name="team_name_search" id="team_name_search" wire:model.live="search" required
        class="w-full p-2 rounded text-xs border-[1px] focus:ring-sky-blue" />

    <div class="mt-2 space-y-2 z-50 absolute">
        @foreach ($teamSuggestions as $teamSuggestion)
            <div class="flex items-center space-x-2">
                <div class="flex-shrink-0">
                    <img src="{{ $teamSuggestion->image }}" alt="{{ $teamSuggestion->name }}"
                        class="w-8 h-8 rounded-full">
                </div>
                <div class="flex-1 space-y-1">
                    <div class="text-sm font-medium text-gray-900">{{ $teamSuggestion->name }}</div>
                    <div class="text-xs text-gray-500">{{ $teamSuggestion->description }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
