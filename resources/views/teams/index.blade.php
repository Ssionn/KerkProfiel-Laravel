<x-app-layout>
    <!-- Team Informatie -->
    <div class="bg-white rounded-lg shadow-sm p-4 max-w-full md:max-w-3xl lg:max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-3">
            <!-- Team Avatar -->
            <div class="flex-shrink-0">
                <x-team-avatar :team="$team" />
            </div>

            <!-- Team Details -->
            <div class="flex-1">
                <h1 class="text-xl font-bold text-gray-900">{{ $team->name }}</h1>
                <p class="text-sm text-gray-500 break-words">
                    {{ $team->description ?? __('Geen beschrijving beschikbaar.') }}
                </p>
            </div>

            <!-- Actieknoppen -->
            <div class="flex space-x-2">
                @can('add people')
                    <button type="button" data-modal-toggle="uitnodigen-modal"
                        class="bg-midnight-blue text-white rounded-full px-4 py-1 font-medium">
                        {{ __('teams/team.team_members_table.table_dropdown.invite_members') }}
                    </button>
                @endcan

                @can('leave team')
                    <button type="button" data-modal-toggle="leave-team-modal"
                        class="bg-red-600 text-white rounded-full px-4 py-1 font-medium">
                        {{ __('teams/team.team_members_table.table_dropdown.leave_team') }}
                    </button>
                @endcan
            </div>
        </div>

        <!-- Teamleider -->
        <div class="mt-4 pt-4 border-t border-gray-200">
            <h2 class="text-base font-medium text-gray-900">{{ __('teams/team.team_info.role_position') }}</h2>
            <x-team-leader :team="$team" />
        </div>
    </div>

    <!-- Teamleden -->
    <div class="mt-8 bg-white rounded-lg shadow-sm px-4 py-2 max-w-full md:max-w-3xl lg:max-w-4xl mx-auto">
        <!-- Header met filter -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-2 sm:space-y-0">
            <h2 class="text-lg font-medium text-gray-900">{{ __('teams/team.team_members_table.table_header') }}</h2>
            <form action="{{ route('teams') }}" method="GET" name="team-members-filter-form" class="w-full sm:w-auto">
                <x-select-filter name="role_type" :options="['Alle', 'Teamleader', 'Member']" label="Role Selection" />
            </form>
        </div>

        <!-- Geen Gebruikers -->
        @if (request()->has('role_type') && $users->count() === 0)
            <div class="flex items-center justify-center w-full h-full mt-4">
                <p class="text-md font-semibold">
                    {{ __('teams/team.team_members_table.table_filter.no_users') }}: 
                    <span class="underline">{{ ucfirst(request('role_type')) }}</span>
                </p>
            </div>
        @endif

        <!-- Lijst met gebruikers -->
        @if ($users->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                @foreach ($users as $user)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <!-- Gebruikersinformatie -->
                            <div class="flex items-center space-x-3">
                                <!-- Avatar -->
                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                    <img src="{{ $user->defaultUserAvatar() }}" alt="{{ $user->username }}"
                                        class="w-12 h-12 rounded-xl object-cover">
                                </div>
                                <!-- Details -->
                                <div>
                                    <h3 class="text-md md:text-lg font-medium text-gray-900">{{ $user->username }}</h3>
                                    <p class="text-xs md:text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="flex items-center justify-center" style="padding-bottom: 0.6rem;">
                                <span
                                    class="inline-flex items-center px-1 py-0.5 rounded-full text-xs font-medium
                                    {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                    style="margin-top: -2px; margin-left: -10px; padding-left: 0.25rem; padding-right: 0.25rem;">
                                    {{ $user->is_active
                                        ? __('teams/team.team_members_table.table_user_activity.active')
                                        : __('teams/team.team_members_table.table_user_activity.inactive') }}
                                </span>
                            </div>
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
