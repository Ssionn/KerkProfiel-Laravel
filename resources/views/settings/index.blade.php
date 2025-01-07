<x-app-layout>
    <div class="bg-white rounded-lg shadow-sm p-4 max-w-2xl mx-auto relative">
        <div class="relative">
            @if (session('status'))
                <div id="flash-message" class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md shadow-md z-50" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <div class="flex items-center space-x-3 mb-4 mt-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">Instellingen</h1>
                </div>
            </div>

            <div id="profile-section" class="mt-4 pt-4 border-t border-gray-200">
                <h2 class="text-xl font-medium text-gray-900 mb-4">Profielinformatie</h2>
                <form action="{{ route('settings.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Gebruikersnaam</label>
                        <input type="text" name="username" id="username" value="{{ auth()->user()->username }}" class="mt-1 block w-full p-2 rounded-lg text-sm border-[1px] focus:ring-sky-blue">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                        <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="mt-1 block w-full p-2 rounded-lg text-sm border-[1px] focus:ring-sky-blue">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-midnight-blue text-white rounded-full px-4 py-1 font-medium">
                            Profiel bijwerken
                        </button>
                    </div>
                </form>
            </div>

            <div id="password-section" class="mt-8 pt-4 border-t border-gray-200">
                <h2 class="text-xl font-medium text-gray-900 mb-4">Wachtwoord bijwerken</h2>
                <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Huidig wachtwoord</label>
                        <input type="password" name="current_password" id="current_password" placeholder="******" class="mt-1 block w-full p-2 rounded-lg text-sm border-[1px] focus:ring-sky-blue">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Nieuw wachtwoord</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full p-2 rounded-lg text-sm border-[1px] focus:ring-sky-blue">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Bevestig wachtwoord</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full p-2 rounded-lg text-sm border-[1px] focus:ring-sky-blue">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-500 text-white rounded-full px-4 py-1 font-medium">
                            Wachtwoord bijwerken
                        </button>
                    </div>
                </form>
            </div>

            <div id="delete-account-section" class="mt-8 pt-4 border-t border-gray-200">
                <h2 class="text-xl font-medium text-gray-900 mb-4">Account verwijderen</h2>
                <form id="delete-account-form" action="{{ route('settings.account.delete') }}" method="POST" class="space-y-4">
                    @csrf
                    <p class="text-red-600">Weet u zeker dat u uw account wilt verwijderen? Deze actie kan niet ongedaan gemaakt worden.</p>
                    <div class="flex justify-end">
                        <button type="button" data-modal-toggle="delete-account"
                            class="bg-red-500 text-white rounded-full px-4 py-1 font-medium">
                            {{ __('settings/user-setting.delete.delete_button') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-modal modalId="delete-account" method="POST"
            modalHeader="{{ __('settings/user-setting.delete.delete_button') }}"
            modalButton="{{ __('settings/user-setting.delete.delete_confirmation') }}"
            modalButtonColor="bg-red-500"
            formAction="{{ route('settings.account.delete') }}">
            <div class="flex flex-col items-start space-y-2">
                <span class="font-semibold text-sm ">{{ __('settings/user-setting.delete.delete_description') }}</span>
            </div>
    </x-modal>
</x-app-layout>
