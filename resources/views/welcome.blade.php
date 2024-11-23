<x-app-layout>
    <h1 class="text-xl font-semibold">
        {{ __('Logged in as: ' . auth()->user()->username) }}
    </h1>

    @if (auth()->user()->password === null)
        {{ __('You don\'t have a password, please change it!') }}
    @endif

    @if (auth()->user())
        <form action="{{ route('logout') }}" method="POST" name="logout-form">
            @csrf

            <button type="submit" class="px-6 py-1 font-semibold text-white rounded bg-midnight-blue">
                {{ __('Uitloggen') }}
            </button>
        </form>
    @endif

    <div class="flex sm:flex-row flex-col items-start sm:space-x-4 space-x-0 space-y-4 sm:space-y-0 mt-2">
        <x-open-surveys />
        <x-completed-surveys />
    </div>
</x-app-layout>
