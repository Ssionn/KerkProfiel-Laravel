<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        @if (session('status'))
            <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
                <button onclick="this.parentElement.remove()" class="absolute top-0 right-0 px-4 py-3">
                    <span class="sr-only">Sluiten</span>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-6">Instellingen</h1>

        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Profielinformatie</h2>
            <form action="{{ route('settings.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Gebruikersnaam</label>
                    <input type="text" name="username" id="username" value="{{ auth()->user()->username }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Profiel bijwerken</button>
                </div>
            </form>
        </div>

        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Wachtwoord bijwerken</h2>
            <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Huidig wachtwoord</label>
                    <input type="password" name="current_password" id="current_password" placeholder="******" disabled class="mt-1 class=" bi bi-eye-slash mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Nieuw wachtwoord</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Bevestig wachtwoord</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <div>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Wachtwoord bijwerken</button>
                </div>
            </form>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-4">Account verwijderen</h2>
            <form action="{{ route('settings.account.delete') }}" method="POST" class="space-y-4">
                @csrf
                <p class="text-red-600">Weet u zeker dat u uw account wilt verwijderen? Deze actie kan niet ongedaan gemaakt worden.</p>
                <div>
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Account verwijderen</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        if (document.getElementById('flash-message')) {
            setTimeout(function() {
                document.getElementById('flash-message').remove();
            }, 3000);
        }
    </script>
</x-app-layout>
