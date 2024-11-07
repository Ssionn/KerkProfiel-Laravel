<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen p-4 sm:p-0">
        <div class="flex flex-col w-full p-2 bg-white rounded-lg shadow-lg md:p-0 sm:w-3/4 md:w-2/4 xl:w-1/4">
            <div class="p-3 md:p-4">
                <h1 class="text-xl font-medium">{{ __('Log in op uw account') }}</h1>
            </div>
            <div class="p-2">
                <div class="inline-flex items-center justify-center w-full space-x-2">
                    <a href="/auth/google/redirect" class="w-full">
                        <button
                            class="inline-flex justify-center items-center bg-white border-[1px] border-gray-200 px-1 w-full py-1 rounded-full shadow-sm">
                            <img src="{{ asset('storage/images/socialite-icons/google.svg') }}"
                                class="w-5 h-5 mr-1 align-middle" />
                            <span class="hidden text-sm font-semibold sm:block">
                                {{ __('Inloggen met Google') }}
                            </span>
                        </button>
                    </a>
                </div>

                <div class="flex justify-center mt-2">
                    @error('email')
                        <p class="text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <form action="{{ route('login.authenticate') }}" method="POST" class="px-2 mt-2 space-y-2">
                    @csrf

                    <div class="flex flex-col items-start space-y-2">
                        <label class="ml-1 text-xs font-semibold text-gray-600" for="email">
                            {{ __('Email') }}
                        </label>
                        <input type="email" name="email" id="email"
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
                    <a href="{{ route('register') }}" class="text-[10px] font-light underline">
                        {{ __('Geen account?') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
