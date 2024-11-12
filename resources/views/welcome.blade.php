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
</x-app-layout>
