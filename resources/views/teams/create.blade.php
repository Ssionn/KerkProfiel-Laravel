<x-app-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <div class="flex flex-col w-full bg-white rounded-lg shadow-lg p-2 md:p-4 sm:w-11/12 md:w-3/4 lg:w-2/4 xl:w-1/3">
            <div class="p-2">
                <h1 class="text-lg font-semibold md:text-xl">{{ __('teams/create.form.header') }}</h1>
            </div>

            <div>
                <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data"
                    class="p-2 space-y-4">
                    @csrf

                    <div class="flex flex-col space-y-1">
                        <label for="team_name" class="ml-1 text-sm font-medium text-gray-700">
                            {{ __('teams/create.form.fields.name') }}
                        </label>
                        <input type="text" name="team_name" id="team_name" required
                            placeholder="{{ __('teams/create.form.fields.placeholder_name') }}"
                            class="w-full p-2 border rounded-lg shadow-sm text-sm placeholder-gray-400 focus:ring focus:ring-blue-300" />
                    </div>

                    <div class="flex flex-col space-y-1">
                        <label for="team_description" class="ml-1 text-sm font-medium text-gray-700">
                            {{ __('teams/create.form.fields.description') }}
                        </label>
                        <input type="text" name="team_description" id="team_description" required
                            placeholder="{{ __('teams/create.form.fields.placeholder_omschrijving') }}"
                            class="w-full p-2 border rounded-lg shadow-sm text-sm placeholder-gray-400 focus:ring focus:ring-blue-300" />
                    </div>

                    <div class="flex flex-col space-y-1">
                        <label for="team_avatar" class="ml-1 text-sm font-medium text-gray-700">
                            {{ __('teams/create.form.fields.avatar') }}
                        </label>
                        <input type="file" name="team_avatar" id="team_avatar" class="filepond" />
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full py-2 text-sm font-semibold text-white bg-midnight-blue rounded-lg shadow">
                            {{ __('teams/create.form.fields.create_button') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
