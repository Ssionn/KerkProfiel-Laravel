<x-app-layout>
    @if(auth()->user())
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="px-6 py-1 font-semibold text-white rounded bg-midnight-blue">
                {{ __('Uitloggen') }}
            </button>
        </form>
    @endif
</x-app-layout>
