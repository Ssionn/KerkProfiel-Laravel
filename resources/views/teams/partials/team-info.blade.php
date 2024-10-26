<div class="bg-white rounded-lg shadow-md">
    <div class="p-2">
        <h1 class="font-semibold text-xl">{{ __('Team Info') }}</h1>
        <div class="flex flex-row items-center space-x-4 p-2">
            <img src="{{ $team->avatar ?? '' }}" class="h-16 w-16 object-cover rounded-full border-2"/>

            <div class="flex flex-col space-y-1">
                <span class="font-semibold text-xl">{{ $team->name }}</span>
                <span class="font-medium italic text-sm">{{ $team->description }}</span>
            </div>
        </div>
    </div>
</div>
