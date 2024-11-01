<x-app-layout>
    {{-- Team header --}}
    <div class="bg-white rounded-lg shadow-sm p-4 max-w-lg">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <x-team-avatar :team="$team" />
            </div>

            <div class="flex-1">
                <h1 class="text-xl font-bold text-gray-900">{{ $team->name }}</h1>
                @if ($team->description)
                    <p class="text-sm text-gray-500">{{ $team->description }}</p>
                @endif
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-200">
            <h2 class="text-base font-medium text-gray-900">Team Leader</h2>
            <x-team-leader :team="$team" />
        </div>
    </div>

    {{-- Team members table --}}
    <div class="mt-8 bg-white rounded-lg shadow-sm px-4 py-2">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">Team Leden</h2>
            <div class="flex items-center space-x-2">
                @can('edit team')
                    <button type="button" class="inline-flex items-center px-2 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-midnight-blue">
                        Team Bewerken
                    </button>
                @endcan
                <button type="button" class="inline-flex items-center px-2 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-midnight-blue">
                    Uitnodigen
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
