<x-app-layout>
    <div class="bg-white rounded-lg shadow-sm p-4 max-w-2xl mx-auto relative">
        <div class="relative">
            @if (session('status'))
                <div id="flash-message" class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md shadow-md z-50" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <div class="flex items-center space-x-3 mb-4 mt-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">Team instellingen</h1>
                </div>
            </div>

            <div id="team-details-section" class="mt-4 pt-4 border-t border-gray-200">
                <h2 class="text-xl font-medium text-gray-900 mb-4">Team informatie</h2>
                <form action="{{ route('teams.team.update', $team) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Teamnaam</label>
                        <input type="text" name="name" id="name" value="{{ $team->name }}" class="mt-1 block w-full p-2 rounded-lg text-sm border border-gray-300 focus:ring-sky-blue">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Beschrijving</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full p-2 rounded-lg text-sm border border-gray-300 focus:ring-sky-blue">{{ $team->description }}</textarea>
                    </div>
                    <div>
                        <label for="avatar" class="block text-sm font-medium text-gray-700">Team Avatar</label>
                        <input type="file" name="avatar" id="avatar" class="filepond">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-midnight-blue text-white rounded-full px-4 py-1 font-medium">
                            Team Bijwerken
                        </button>
                    </div>
                </form>
            </div>

            @can('delete team')
                <div id="delete-team-section" class="mt-8 pt-4 border-t border-gray-200">
                    <h2 class="text-xl font-medium text-gray-900 mb-4">Team Verwijderen</h2>
                    <form id="delete-team-form" action="{{ route('teams.team.delete', $team) }}" method="POST" class="space-y-4">
                        @csrf
                        <p class="text-red-600">Weet je zeker dat je het team wilt verwijderen? Deze actie kan niet ongedaan gemaakt worden.</p>
                        <div class="flex justify-end">
                            <button type="button" data-modal-toggle="delete-team"
                                class="bg-red-500 text-white rounded-full px-4 py-1 font-medium">
                                {{ __('settings/team.delete.delete_button') }}
                            </button>
                        </div>
                    </form>
                </div>
            @endcan
        </div>
    </div>

    <x-modal modalId="delete-team" method="POST"
            modalHeader="{{ __('settings/team.delete.delete_button') }}"
            modalButton="{{ __('settings/team.delete.delete_confirmation') }}"
            modalButtonColor="bg-red-500"
            formAction="{{ route('teams.team.delete', $team) }}">
            <div class="flex flex-col items-start space-y-2">
                <span class="font-semibold text-sm ">{{ __('settings/team.delete.delete_description') }}</span>
            </div>
    </x-modal>
</x-app-layout>
