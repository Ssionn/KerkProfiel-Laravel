<x-app-layout>
    <!-- Teamleden -->
    <div class="mt-8 bg-white rounded-lg shadow-sm px-4 py-2 max-w-full md:max-w-3xl lg:max-w-4xl mx-auto">
        <!-- Header met filter -->
        <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0">
            <h2 class="text-lg font-medium text-gray-900">{{ __('teams/team.team_members_table.table_header') }}</h2>
            <form action="{{ route('teams') }}" method="GET" name="team-members-filter-form" class="w-full sm:w-auto">
                <x-select-filter name="role_type" :options="['Alle', 'Teamleader', 'Member']" label="Role Selection" />
            </form>
        </div>

        <!-- Lijst met gebruikers -->
        @if ($users->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                @foreach ($users as $user)
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row items-start md:justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- Avatar -->
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                    <img src="{{ $user->defaultUserAvatar() }}" alt="{{ $user->username }}"
                                        class="w-12 h-12 rounded-xl object-cover">
                                </div>
                                <!-- Details -->
                                <div>
                                    <h3 class="text-md md:text-lg font-medium text-gray-900">{{ $user->username }}</h3>
                                    <!-- Email met wrapping -->
                                    <p class="text-xs md:text-sm text-gray-500 break-words">{{ $user->email }}</p>
                                </div>
                            </div>
                            <!-- Status -->
                            <div class="mt-2 md:mt-0">
                                @if ($user->is_active)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ __('teams/team.team_members_table.table_user_activity.active') }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        {{ __('teams/team.team_members_table.table_user_activity.inactive') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- Actie -->
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-sm text-gray-500">{{ ucfirst($user->role->name) }}</span>
                            @can('remove people')
                                @if ($user->role->name !== 'teamleader')
                                    <button class="text-gray-400 hover:text-red-500"
                                        data-modal-toggle="remove-user-{{ $user->id }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    <x-modal modalId="remove-user-{{ $user->id }}" method="DELETE"
                                        modalHeader="{{ __('teams/team.team_members_table.table_dropdown.remove_user') }}"
                                        modalButton="{{ __('teams/team.team_members_table.table_dropdown.remove_user_button') }}"
                                        formAction="{{ route('team.members.destroy', $user->id) }}">
                                        <p>{{ __('teams/team.team_members_table.table_dropdown.remove_user_confirm') }}</p>
                                    </x-modal>
                                @endif
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Paginering -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
