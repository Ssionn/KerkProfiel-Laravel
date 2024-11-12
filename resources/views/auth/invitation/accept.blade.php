<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen">
        <div class="flex flex-col w-full p-2 bg-white rounded-lg shadow-lg md:p-0 sm:w-3/4 md:w-2/4 xl:w-1/3">
            <div>
                <h1 class="text-md font-medium text-center mt-5">
                    {{ __('Je bent uitgenodigd om lid te worden!') }}
                </h1>
            </div>
            <div class="px-2">
                <form action="{{ route('teams.acceptPost', $invitation->token) }}" method="POST" class="p-2 space-y-2"
                    name="invitation-form">
                    @csrf
                    <div class="flex flex-col items-start space-y-2">
                        <label class="ml-1 text-xs font-semibold text-gray-600" for="username">
                            {{ __('Gebruikersnaam') }}
                        </label>
                        <input type="text" name="username" id="username" required
                            class="w-full p-2 rounded-lg text-xs placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-sky-blue" />
                    </div>

                    <div class="flex flex-col items-start space-y-2">
                        <label class="ml-1 text-xs font-semibold text-gray-600" for="email">
                            {{ __('Email') }}
                        </label>
                        <input type="text" name="email" id="email" value="{{ $invitation->email }}" required
                            class="w-full p-2 rounded-lg text-xs placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-sky-blue" />
                    </div>

                    <div class="flex flex-col items-start space-y-2">
                        <label class="ml-1 text-xs font-semibold text-gray-600" for="password">
                            {{ __('Wachtwoord') }}
                        </label>
                        <input type="password" name="password" id="password" required
                            class="w-full p-2 rounded-lg text-xs placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-sky-blue" />
                    </div>

                    <div class="flex flex-col items-start space-y-2">
                        <label class="ml-1 text-xs font-semibold text-gray-600" for="password_confirmation">
                            {{ __('Wachtwoord bevestigen') }}
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full p-2 rounded-lg text-xs placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-sky-blue" />
                        <span class="text-red-500 text-xs italic">{{ $errors->first('password_confirmation') }}</span>
                    </div>

                    <div class="mt-2 mb-2">
                        <button type="submit"
                            class="w-full py-1 text-sm font-semibold text-center text-white rounded-lg bg-midnight-blue">
                            {{ __('Aanmelden') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
