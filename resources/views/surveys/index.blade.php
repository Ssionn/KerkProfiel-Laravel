<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">Beschikbare vragenlijsten</h1>
                <p class="mt-4 text-lg text-gray-600">Kies een vragenlijst om te beginnen</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($surveys as $survey)
                    <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-semibold text-gray-900">{{ $survey->name }}</h2>
                                <span class="px-4 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded-full">
                                    {{ $survey->status->value }}
                                </span>
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    {{ $survey->amount_of_questions }} vragen
                                </div>

                                @php
                                    $userAnswers = $survey->answers()->where('user_id', Auth::id())->count();
                                    $progress = $survey->amount_of_questions > 0
                                        ? round(($userAnswers / $survey->amount_of_questions) * 100)
                                        : 0;
                                @endphp

                                <div class="text-sm text-gray-600">
                                    {{ $progress }}% voltooid
                                </div>
                            </div>

                            <!-- Progress bar -->
                            <div class="mt-4">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-500"
                                        style="width: {{ $progress }}%">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('surveys.show', $survey) }}"
                                    class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    {{ $progress > 0 ? 'Doorgaan' : 'Beginnen' }}
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <h3 class="text-lg font-medium text-gray-900">Geen vragenlijsten beschikbaar</h3>
                        <p class="mt-2 text-gray-600">Er zijn momenteel geen vragenlijsten beschikbaar om in te vullen.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
