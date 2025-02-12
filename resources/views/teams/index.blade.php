<x-app-layout>
    <div class="bg-white rounded-lg shadow-sm p-4 max-w-full md:max-w-4xl lg:max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-3">
            <div class="">
                <img src="{{ $team->defaultTeamAvatar() }}" alt="{{ $team->name }}"
                    class="h-12 w-12 rounded-lg object-cover border border-gray-200" />
            </div>

            <div class="flex-1">
                @if (auth()->user()->getTeamEditPermission())
                    <a href="{{ route('teams.edit', $team) }}" class="inline-flex items-center text-xl font-bold text-gray-900 hover:underline hover:scale-110 transition ease-in-out duration-300">
                        {{ $team->name }}
                        <x-feathericon-edit class="w-4 h-4 ml-1"/>
                    </a>
                @else
                    <h1 class="text-xl font-bold text-gray-900">{{ $team->name }}</h1>
                @endif
                <p class="text-sm text-gray-500">{{ $team->description ?? '' }}</p>
            </div>

            <div class="flex flex-col sm:flex-row space-y-2 sm:space-x-2 sm:space-y-0 w-full sm:w-auto">
                @can('add people')
                    <button type="button" data-modal-toggle="uitnodigen-modal"
                        class="bg-midnight-blue text-white rounded-full px-4 py-1 font-medium">
                        {{ __('teams/index.team_members_table.table_dropdown.invite_members') }}
                    </button>
                @endcan

                @can('create existing survey')
                    <button type="button" data-modal-toggle="create-survey-modal"
                        class="bg-emerald-600 text-white rounded-full px-4 py-1 font-medium">
                        {{ __('teams/index.team_members_table.table_dropdown.create_survey') }}
                    </button>
                @endcan

                @can('leave team')
                    <button type="button" data-modal-toggle="leave-team-modal"
                        class="bg-red-600 text-white rounded-full px-4 py-1 font-medium">
                        {{ __('teams/index.team_members_table.table_dropdown.leave_team') }}
                    </button>
                @endcan
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-200">
            <h2 class="text-base font-medium text-gray-900">{{ __('teams/index.team_info.role_position') }}</h2>
            <x-team-leader :team="$team" />
        </div>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow-sm px-4 py-2 max-w-full md:max-w-4xl lg:max-w-5xl mx-auto">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-2 sm:space-y-0">
            <h2 class="text-lg font-medium text-gray-900">{{ __('teams/index.team_members_table.table_header') }}</h2>
            <form action="{{ route('teams') }}" method="GET" name="team-members-filter-form" class="w-full sm:w-auto">
                <x-select-filter name="role_type" :options="['Alle', 'Teamleader', 'Member']" label="Role Selection" />
            </form>
        </div>

        <x-modal modalId="uitnodigen-modal" method="POST"
            modalHeader="{{ __('teams/team.team_members_table.table_dropdown.invite_members') }}"
            modalButton="{{ __('teams/team.team_members_table.table_dropdown.invite_fields.invite_button') }}"
            modalButtonColor="bg-midnight-blue"
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                @foreach ($users as $user)
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-100 px-4 py-2 hover:shadow-md transition-shadow w-full">
                        <div class="flex items-center justify-between w-full">
                            <div class="flex flex-row items-center space-x-2 w-full">
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                    <img src="{{ $user->defaultUserAvatar() }}" alt="{{ $user->username }}"
                                        class="w-12 h-12 rounded-xl object-cover">
                                </div>
                                <div class="flex flex-col items-start">
                                    <h3 class="text-md font-medium text-gray-900">{{ $user->username }}</h3>
                                    <p class="text-xs md:text-sm text-gray-500">{{ $user->email }}</p>
                                    <p class="text-xs md:text-sm text-gray-500">
                                        {{ $user->role->capitalizedNameAttribute() }}</p>
                                </div>
                                <div class="flex">
                                    <span
                                        class="inline-flex items-start px-2 py-[2px] rounded-full text-xs font-medium
                                    {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->is_active
                                            ? __('teams/index.team_members_table.table_user_activity.active')
                                            : __('teams/index.team_members_table.table_user_activity.inactive') }}
                                    </span>
                                </div>
                            </div>

                            <x-modal modalId="uitnodigen-modal" method="POST"
                                modalHeader="{{ __('teams/index.team_members_table.table_dropdown.invite_members') }}"
                                modalButton="{{ __('teams/index.team_members_table.table_dropdown.invite_fields.invite_button') }}"
                                formAction="{{ route('teams.invite') }}">
                                <div class="flex flex-col items-start space-y-2">
                                    <label class="ml-1 text-sm font-semibold text-gray-600" for="invite_email">
                                        {{ __('teams/index.team_members_table.table_dropdown.invite_fields.email') }}
                                    </label>
                                    <input type="text" name="invite_email" id="invite_email" required
                                        class="w-full p-2 rounded-lg text-sm placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-sky-blue" />
                                </div>
                            </x-modal>

                            <x-modal modalId="remove-user-{{ $user->id }}" method="DELETE"
                                modalHeader="{{ __('teams/index.team_members_table.table_dropdown.remove_user') }}"
                                modalButton="{{ __('teams/index.team_members_table.table_dropdown.remove_user_button') }}"
                                formAction="{{ route('team.members.destroy', $user->id) }}">
                                <div class="flex flex-col items-start space-y-2">
                                    <label class="ml-1 text-sm font-semibold text-gray-600" for="remove_user_confirm">
                                        {{ __('teams/index.team_members_table.table_dropdown.remove_user_confirm') }}
                                    </label>
                                </div>
                            </x-modal>

                            <x-modal modalId="leave-team-modal" method="POST"
                                modalHeader="{{ __('teams/index.team_members_table.table_dropdown.leave_team') }}"
                                modalButton="{{ __('teams/index.team_members_table.table_dropdown.leave_team_button') }}"
                                formAction="{{ route('teams.leave', auth()->user()->id) }}">
                                <div class="flex flex-col items-start space-y-2">
                                    <label class="ml-1 text-sm font-semibold text-gray-600" for="leave_team_confirm">
                                        {{ __('teams/index.team_members_table.table_dropdown.leave_team_confirm') }}
                                    </label>
                                </div>
                            </x-modal>

                            <x-modal modalId="create-survey-modal" method="POST"
                                modalHeader="{{ __('teams/index.team_members_table.table_dropdown.create_survey_header') }}"
                                modalButton="{{ __('teams/index.team_members_table.table_dropdown.create_survey_button') }}"
                                formAction="{{ route('teams.create.survey') }}">
                                <div class="flex flex-col items-start space-y-2">
                                    <label class="ml-1 text-sm font-semibold text-gray-600" for="">
                                        {{ __('teams/index.team_members_table.table_dropdown.create_survey_description') }}
                                    </label>

                                    @if ($surveys->count() > 0)
                                        <select name="survey_id" id="survey_id"
                                            class="w-full rounded-md border-gray-300">
                                            @foreach ($surveys as $survey)
                                                <option value="{{ $survey->id }}">{{ $survey->name }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <p class="text-sm text-gray-500">
                                            {{ __('teams/index.team_members_table.table_dropdown.create_survey_no_surveys') }}
                                        </p>
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

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
