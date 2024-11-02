<x-app-layout>
    <div class="flex flex-col items-center justify-center">
        <div class="flex flex-col w-full p-2 bg-white rounded-lg shadow-lg md:p-0 sm:w-3/4 md:w-2/4 xl:w-2/4">
            <div class="p-2 md:p-3">
                <h1 class="text-xl font-medium">{{ __('Team aanmaken') }}</h1>
            </div>
            <div class="px-2">
                <form action="{{ route('teams.store') }}" method="POST" class="p-2 space-y-2">
                    @csrf

                    <div class="flex flex-col items-start space-y-2">
                        <label class="ml-1 text-xs font-semibold text-gray-600" for="team_name">
                            {{ __('Team naam') }}
                        </label>
                        <input type="text" name="team_name" id="team_name" required
                            class="w-full p-2 rounded-lg text-xs placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-sky-blue" />
                    </div>

                    <div class="flex flex-col items-start space-y-2">
                        <label class="ml-1 text-xs font-semibold text-gray-600" for="team_description">
                            {{ __('Team beschrijving') }}
                        </label>
                        <input type="text" name="team_description" id="team_description" required
                            class="w-full p-2 rounded-lg text-xs placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-sky-blue" />
                    </div>

                    <div class="flex flex-col items-start space-y-2 py-4">
                        <label class="ml-1 text-xs font-semibold text-gray-600" for="team_avatar">
                            {{ __('Team avatar') }}
                        </label>
                        <input type="file" name="team_avatar" id="team_avatar" class="w-full filepond" />
                    </div>

                    <div class="mt-2 mb-2">
                        <button type="submit"
                            class="w-full py-1 text-sm font-semibold text-center text-white rounded-lg bg-midnight-blue">
                            {{ __('Aanmaken') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
