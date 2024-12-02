<x-app-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <div class="flex flex-col w-full p-4 bg-white rounded-lg shadow-lg md:p-6 sm:w-11/12 md:w-3/4 lg:w-2/4 xl:w-1/3">
            <div class="p-2 md:p-4">
                <h1 class="text-lg font-semibold md:text-xl">{{ __('Team aanmaken') }}</h1>
            </div>

            <div class="px-2">
                <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data" class="p-2 space-y-4">
                    @csrf

                    <div class="flex flex-col space-y-1">
                        <label for="team_name" class="ml-1 text-sm font-medium text-gray-700">
                            {{ __('Team naam') }}
                        </label>
                        <input 
                            type="text" 
                            name="team_name" 
                            id="team_name" 
                            required 
                            placeholder="{{ __('Voer een teamnaam in') }}"
                            class="w-full p-3 border rounded-lg shadow-sm text-sm placeholder-gray-400 focus:ring focus:ring-blue-300"
                        />
                    </div>

                    <div class="flex flex-col space-y-1">
                        <label for="team_description" class="ml-1 text-sm font-medium text-gray-700">
                            {{ __('Team beschrijving') }}
                        </label>
                        <input 
                            type="text" 
                            name="team_description" 
                            id="team_description" 
                            required 
                            placeholder="{{ __('Beschrijf het team') }}"
                            class="w-full p-3 border rounded-lg shadow-sm text-sm placeholder-gray-400 focus:ring focus:ring-blue-300"
                        />
                    </div>

                    <div class="flex flex-col space-y-1">
                        <label for="team_avatar" class="ml-1 text-sm font-medium text-gray-700">
                            {{ __('Team avatar') }}
                        </label>
                        <input 
                            type="file" 
                            name="team_avatar" 
                            id="team_avatar" 
                            class="w-full p-2 border rounded-lg file:bg-blue-500 file:text-white file:rounded-lg file:border-none file:px-4 file:py-2"
                        />
                    </div>

                    <div class="pt-2">
                        <button 
                            type="submit" 
                            class="w-full py-3 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 focus:ring focus:ring-blue-300">
                            {{ __('Aanmaken') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
