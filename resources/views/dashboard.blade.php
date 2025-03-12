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

    <div class="grid grid-cols-3 gap-4 mt-4">
        <x-totalscore-diagram />

        <div class="col-span-1">
            <h2 class="text-lg font-semibold">
                {{ __('Surveys') }}
            </h2>

            @if ($surveys->count() > 0)
                <ul class="mt-4">
                    @foreach ($surveys as $survey)
                        <a href="{{ route('surveys.show', $survey) }}">
                            <li class="flex flex-row justify-between items-center bg-white rounded-md p-3">
                                <div class="flex flex-col items-start">
                                    <span class="font-semibold text-gray-900">{{ $survey->name }}</span>
                                </div>
                                <span class="px-4 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded-full">
                                    {{ $survey->status->value }}
                                </span>
                            </li>
                        </a>
                    @endforeach
                </ul>
            @else
                <p>{{ __('No surveys found.') }}</p>
            @endif
        </div>
    </div>
</x-app-layout>
