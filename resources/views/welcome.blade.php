<x-app-layout>
    <h1 class="text-xl font-semibold">
        {{ __('welcome.auth.logged_in_as', ['username' => auth()->user()->username]) }}
    </h1>

    @if (auth()->user()->password === null)
        {{ __('welcome.auth.no_password_warning') }}
    @endif

    @if (auth()->user())
        <form action="{{ route('logout') }}" method="POST" name="logout-form">
            @csrf

            <button type="submit" class="px-6 py-1 font-semibold text-white rounded bg-midnight-blue">
                {{ __('welcome.auth.logout') }}
            </button>
        </form>
    @endif
</x-app-layout>
