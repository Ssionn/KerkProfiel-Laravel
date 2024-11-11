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
            <h2 class="text-base font-medium text-gray-900">{{ __('teams/team.team_info.role_position') }}</h2>
            <x-team-leader :team="$team" />
        </div>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow-sm px-4 py-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-medium text-gray-900">{{ __('teams/team.team_members_table.table_header') }}</h2>
            <div class="flex items-center space-x-2">
                <form action="{{ route('teams') }}" method="GET" class="mr-8">
                    <select name="role_type" onchange="this.form.submit()" class="py-1 px-4 rounded-lg">
                        <option value="">
                            {{ __('teams/team.team_members_table.table_filter.all') }}
                        </option>
                        <option value="teamleader" {{ request('role_type') === 'teamleader' ? 'selected' : '' }}>
                            {{ __('teams/team.team_members_table.table_filter.teamleaders') }}
                        </option>
                        <option value="member" {{ request('role_type') === 'member' ? 'selected' : '' }}>
                            {{ __('teams/team.team_members_table.table_filter.members') }}
                        </option>
                    </select>
                </form>

                @can('edit team')
                    <button id="dropdownTeamFeaturesButton" data-dropdown-toggle="dropdownTeamFeatures">
                        <x-tabler-dots />
                    </button>

                    <div id="dropdownTeamFeatures"
                        class="hidden z-10 mt-2 w-36 rounded-md bg-white shadow-lg divide-y divide-gray-100 ring-1 ring-black ring-opacity-5">
                        <div class="py-1">
                            <form method="GET" action="{{ request()->url() }}" class="w-full">
                                @if (request()->has('edit'))
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        {{ __('teams/team.team_members_table.table_dropdown.edit_team_save') }}
                                    </button>
                                @else
                                    <input type="hidden" name="edit" value="true">
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        {{ __('teams/team.team_members_table.table_dropdown.edit_team_button') }}
                                    </button>
                                @endif
                            </form>

                            @can('add people')
                                <button type="button" data-modal-toggle="uitnodigen-modal"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    {{ __('teams/team.team_members_table.table_dropdown.invite_members') }}
                                </button>
                            @endcan
                        </div>
                    </div>
                @endcan
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
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('teams/team.team_members_table.table_column_headings.name') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('teams/team.team_members_table.table_column_headings.email') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('teams/team.team_members_table.table_column_headings.role') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('teams/team.team_members_table.table_column_headings.status') }}
                            </th>
                            @if (request()->has('edit'))
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('teams/team.team_members_table.table_column_headings.remove') }}
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
                                            {{ __('teams/team.team_members_table.table_user_activity.active') }}
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ __('teams/team.team_members_table.table_user_activity.inactive') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        @if (request()->has('edit'))
                                            @can('remove people')
                                                @if ($user->role->name === 'teamleader')
                                                @else
                                                    <button type="button"
                                                        data-modal-toggle="remove-user-modal-{{ $user->id }}"
                                                        class="inline-flex items-center px-2 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                                                        {{ __('teams/team.team_members_table.table_dropdown.remove_user_button') }}
                                                    </button>
                                                @endif
                                            @endcan
                                        @endif

                                        <x-modal modalId="remove-user-modal-{{ $user->id }}" method="DELETE"
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
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
