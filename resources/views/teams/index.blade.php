<x-app-layout>
    <div class="bg-white rounded-lg shadow-sm p-4 max-w-full md:max-w-4xl lg:max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-3">
            <div class="flex-shrink-0">
                <x-team-avatar :team="$team" />
            </div>

            <div class="flex-1">
                <h1 class="text-xl font-bold text-gray-900">{{ $team->name }}</h1>
                <p class="text-sm text-gray-500 break-words">
                    {{ $team->description ?? '' }}
                </p>
            </div>

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

        <div class="mt-4 pt-4 border-t border-gray-200">
            <h2 class="text-base font-medium text-gray-900">{{ __('teams/team.team_info.role_position') }}</h2>
            <x-team-leader :team="$team" />
        </div>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow-sm px-4 py-2 max-w-full md:max-w-4xl lg:max-w-5xl mx-auto">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-2 sm:space-y-0">
            <h2 class="text-lg font-medium text-gray-900">{{ __('teams/team.team_members_table.table_header') }}</h2>
            <form action="{{ route('teams') }}" method="GET" name="team-members-filter-form" class="w-full sm:w-auto">
                <x-select-filter name="role_type" :options="['Alle', 'Teamleader', 'Member']" label="Role Selection" />
            </form>
        </div>

        @if ($users->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                @foreach ($users as $user)
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                    <img src="{{ $user->defaultUserAvatar() }}" alt="{{ $user->username }}"
                                        class="w-12 h-12 rounded-xl object-cover">
                                </div>
                                <div>
                                    <h3 class="text-md font-medium text-gray-900">{{ $user->username }}</h3>
                                    <p class="text-xs md:text-sm text-gray-500">{{ $user->email }}</p>
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

                            <x-modal modalId="remove-user-{{ $user->id }}" method="DELETE"
                                modalHeader="{{ __('teams/team.team_members_table.table_dropdown.remove_user') }}"
                                modalButton="{{ __('teams/team.team_members_table.table_dropdown.remove_user_button') }}"
                                formAction="{{ route('team.members.destroy', $user->id) }}">
                                <div class="flex flex-col items-start space-y-2">
                                    <label class="ml-1 text-sm font-semibold text-gray-600" for="remove_user_confirm">
                                        {{ __('teams/team.team_members_table.table_dropdown.remove_user_confirm') }}
                                    </label>
                                </div>
                            </x-modal>


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

                            <div class="flex items-center justify-center pb-2">
                                <span
                                    class="inline-flex items-center px-[0.25rem] py-0.5 rounded-full text-xs font-medium mt-[2px] ml-[-20px]
                                    {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
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

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
