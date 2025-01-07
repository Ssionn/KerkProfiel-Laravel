<x-app-layout>
    <h1 class="text-xl font-semibold">
        {{ __('Logged in as: ' . auth()->user()->username) }}
    </h1>

    @if (auth()->user()->password === null)
        {{ __('You don\'t have a password, please change it!') }}
    @endif

</x-app-layout>
