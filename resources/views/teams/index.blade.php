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

            @can('add people')
                <div class="flex justify-end items-center">
                    <button type="button" data-modal-toggle="uitnodigen-modal"
                        class="bg-midnight-blue text-white rounded-full px-4 py-1 font-medium">
                        {{ __('teams/team.team_members_table.table_dropdown.invite_members') }}
                    </button>
                </div>
            @endcan

            @can('leave team')
                <div class="flex justify-end items-center">
                    <button type="button" data-modal-toggle="leave-team-modal"
                        class="bg-red-600 text-white rounded-full px-4 py-1 font-medium">
                        {{ __('teams/team.team_members_table.table_dropdown.leave_team') }}
                    </button>
                </div>
            @endcan
        </div>

        <div class="mt-4 pt-4 border-t border-gray-200">
            <h2 class="text-base font-medium text-gray-900">{{ __('teams/team.team_info.role_position') }}</h2>
            <x-team-leader :team="$team" />
        </div>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow-sm px-4 py-2">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">{{ __('teams/team.team_members_table.table_header') }}</h2>
            <div class="flex flex-col items-center space-x-2">
                <form action="{{ route('teams') }}" method="GET" name="team-members-filter-form">
                    <x-select-filter name="role_type" :options="['Alle', 'Teamleader', 'Member']" label="Role Selection" />
                </form>
            </div>
        </div>

        <x-modal modalId="uitnodigen-modal" method="POST"
            modalHeader="{{ __('teams/team.team_members_table.table_dropdown.invite_members') }}"
            modalButton="{{ __('teams/team.team_members_table.table_dropdown.invite_fields.invite_button') }}"
            formAction="{{ route('teams.invite') }}">
            <div class="flex flex-col items-start space-y-2">
                <label class="ml-1 text-sm font-semibold text-gray-600" for="invite_email">
                    {{ __('teams/team.team_members_table.table_dropdown.invite_fields.email') }}
                </label>
                <input type="text" name="invite_email" id="invite_email" required
                    class="w-full p-2 rounded-lg text-sm placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-sky-blue" />
            </div>
        </x-modal>

        @if (request()->has('role_type'))
            @if ($users->count() === 0)
                <div class="flex items-center justify-center w-full h-full">
                    <div class="flex flex-row space-x-1">
                        <p class="text-md font-semibold">
                            {{ __('teams/team.team_members_table.table_filter.no_users') }}</p>
                        <p class="text-md font-semibold underline">{{ ucfirst(request('role_type')) }}</p>
                    </div>
                </div>
            @endif
        @endif

        @if ($users->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-2">
                @foreach ($users as $user)
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row items-start md:justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                    <img src="{{ $user->defaultUserAvatar() }}" alt="{{ $user->username }}"
                                        class="w-12 h-12 rounded-xl object-cover">
                                </div>

                                <div class="flex-1">
                                    <h3 class="text-md md:text-lg font-medium text-gray-900">{{ $user->username }}</h3>
                                    <p class="text-xs md:text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="mt-1 md:mt-0">
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

                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">{{ ucfirst($user->role->name) }}</span>
                            </div>

                            <div class="flex items-center space-x-2">
                                @can('remove people')
                                    @if ($user->role->name === 'teamleader')
                                    @else
                                        <button class="text-gray-400 hover:text-red-500"
                                            data-modal-toggle="remove-user-{{ $user->id }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @endif

                                    <x-modal modalId="remove-user-{{ $user->id }}" method="DELETE"
                                        modalHeader="{{ __('teams/team.team_members_table.table_dropdown.remove_user') }}"
                                        modalButton="{{ __('teams/team.team_members_table.table_dropdown.remove_user_button') }}"
                                        formAction="{{ route('team.members.destroy', $user->id) }}">
                                        <div class="flex flex-col items-start space-y-2">
                                            <label class="ml-1 text-sm font-semibold text-gray-600"
                                                for="remove_user_confirm">
                                                {{ __('teams/team.team_members_table.table_dropdown.remove_user_confirm') }}
                                            </label>
                                        </div>
                                    </x-modal>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <x-modal modalId="leave-team-modal" method="POST"
                        modalHeader="{{ __('teams/team.team_members_table.table_dropdown.leave_team') }}"
                        modalButton="{{ __('teams/team.team_members_table.table_dropdown.leave_team_button') }}"
                        formAction="{{ route('teams.leave', auth()->user()->id) }}">
                        <div class="flex flex-col items-start space-y-2">
                            <label class="ml-1 text-sm font-semibold text-gray-600" for="remove_user_confirm">
                                {{ __('teams/team.team_members_table.table_dropdown.leave_team_confirm') }}
                            </label>
                        </div>
                    </x-modal>
                @endforeach
            </div>
        @endif

        <div>
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
