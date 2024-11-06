<x-app-layout>
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

    <div class="mt-8 bg-white rounded-lg shadow-sm px-4 py-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-medium text-gray-900">Team Leden</h2>
            <div class="flex items-center space-x-2">
                @can('edit team')
                    <form method="GET" action="{{ request()->url() }}">
                        @if (request()->has('edit'))
                            <button type="submit" x-cloak
                                class="inline-flex items-center px-2 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-sky-blue">
                                Klaar
                            </button>
                        @else
                            <input type="hidden" name="edit" value="true">

                            <button type="submit" x-cloak
                                class="inline-flex items-center px-2 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-midnight-blue">
                                Team Bewerken
                            </button>
                        @endif
                    </form>
                @endcan
                @can('add people')
                    <button type="button" data-modal-toggle="uitnodigen-modal"
                        class="inline-flex items-center px-2 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-midnight-blue">
                        Uitnodigen
                    </button>
                @endcan
            </div>
        </div>

        <x-modal modalId="uitnodigen-modal" modalHeader="Uitnodigen" modalButton="Uitnodigen"
            formAction="{{ route('teams.invite') }}">
            <div class="flex flex-col items-start space-y-2">
                <label class="ml-1 text-sm font-semibold text-gray-600" for="invite_email">
                    {{ __('Email') }}
                </label>
                <input type="text" name="invite_email" id="invite_email" required
                    class="w-full p-2 rounded-lg text-sm placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-sky-blue" />
            </div>
        </x-modal>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Naam
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rol
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        @if (request()->has('edit'))
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Verwijderen
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->username }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ ucfirst($user->role->name) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($user->is_active)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Actief
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactief
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-3">
                                    @if (request()->has('edit'))
                                        @can('remove people')
                                            <form method="POST" action="{{ route('team.members.destroy', $user->id) }}"
                                                onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')"
                                                class="flex items-center">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                                    Verwijder
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
