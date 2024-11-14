<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen p-4 sm:p-0">
        <div>
            <h1 class="text-xl font-medium">{{ __('U bent uitgenodigd om lid te worden!') }}</h1>
        </div>
        <div class="flex flex-col w-full p-2 mt-4 bg-white rounded-lg shadow-lg md:p-0 sm:w-3/4 md:w-2/4 xl:w-1/4">
            <div class="px-4 py-2">
                <h1 class="text-xl font-medium">{{ __('Log in op uw account') }}</h1>
            </div>
            <div class="px-2">
                <div class="flex justify-center">
                    @error('email')
                        <p class="text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <form action="{{ route('teams.acceptPostLogin', $invitation->token) }}" method="POST" class="px-2 space-y-2" name="login-form">
                    @csrf

                    <div class="flex flex-col items-start space-y-2">
                        <label class="ml-1 text-xs font-semibold text-gray-600" for="email">
                            {{ __('Email') }}
                        </label>
                        <input type="email" name="email" id="email" value="{{ $invitation->email }}"
                            class="w-full p-2 rounded-lg text-xs placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-lavender-purple" />
                    </div>
                    <div class="flex flex-col items-start space-y-2">
                        <label class="ml-1 text-xs font-semibold text-gray-600" for="password">
                            {{ __('Password') }}
                        </label>
                        <input type="password" name="password" id="password"
                            class="w-full p-2 rounded-lg text-xs placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-lavender-purple" />
                    </div>
                    <div class="mt-2">
                        <button type="submit"
                            class="w-full py-1 text-sm font-semibold text-center text-white rounded-lg bg-midnight-blue">
                            {{ __('Inloggen') }}
                        </button>
                    </div>
                </form>
                <div class="flex justify-end px-2 mt-2">
                    <a href="{{ route('teams.accept', $invitation->token) }}" class="text-[10px] font-light underline">
                        {{ __('Geen account?') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
