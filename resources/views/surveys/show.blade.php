<x-app-layout>
    <!-- Background with gradient -->
    <div class="min-h-screen" style="background: linear-gradient(82deg, #eaeafd 0%, #c3c2c6 100%);">
        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Survey Header -->
            <div class="mb-12 text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $survey->name }}</h1>
                <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
                    <span class="font-medium">Vraag {{ $currentPage }}</span>
                    <span>van</span>
                    <span class="font-medium">{{ $totalPages }}</span>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="relative pt-1 mb-12">
                <div class="flex mb-2 items-center justify-between">
                    <div class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200">
                        Voortgang
                    </div>
                    <div class="text-xs font-semibold inline-block text-blue-600">
                        {{ round(($currentPage / $totalPages) * 100) }}%
                    </div>
                </div>
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-100">
                    <div style="width: {{ ($currentPage / $totalPages) * 100 }}%"
                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600 transition-all duration-500">
                    </div>
                </div>
            </div>

            <!-- Question Container -->
            <div class="bg-white/30 backdrop-blur-md border border-white/50 rounded-xl shadow-lg p-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    <div class="flex items-center justify-center p-6 bg-white/60 backdrop-blur-sm rounded-lg border border-white/60 min-h-[120px] hover:bg-white/70 transition-all duration-300">
                        <p class="font-bold text-xl text-gray-900 text-center">{{ $question->left_statement }}</p>
                    </div>
                    <div class="flex items-center justify-center p-6 bg-white/60 backdrop-blur-sm rounded-lg border border-white/60 min-h-[120px] hover:bg-white/70 transition-all duration-300">
                        <p class="font-bold text-xl text-gray-900 text-center">{{ $question->right_statement }}</p>
                    </div>
                </div>

                <form action="{{ route('survey.answer', ['survey' => $survey]) }}" method="POST" id="survey-form">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <input type="hidden" name="page" value="{{ $currentPage }}">

                    <!-- Radio Button Group -->
                    <div class="flex justify-center items-center gap-4 mb-8">
                        <div class="grid grid-cols-9 gap-4 w-full max-w-3xl mx-auto">
                            @foreach ($question->radioButtonValues() as $key => $value)
                                <div class="flex flex-col items-center">
                                    <label class="relative">
                                        <input type="radio" name="answer" value="{{ $value }}"
                                            class="sr-only peer">
                                        <div class="w-12 h-12 rounded-full border-4 border-gray-300 bg-white peer-checked:bg-blue-600 peer-checked:border-blue-600 cursor-pointer transition-all duration-200 hover:border-blue-400">
                                        </div>
                                        @if (is_string($key))
                                            <span class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 text-xs font-bold text-gray-600">
                                                {{ ucfirst($key) }}
                                            </span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-end gap-4">
                        @if ($currentPage > 1)
                            <a href="{{ route('surveys.show', ['survey' => $survey, 'page' => $currentPage - 1]) }}"
                                class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                Vorige
                            </a>
                        @endif

                        @if ($currentPage < $totalPages)
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Volgende
                            </button>
                        @else
                            <button type="submit"
                                class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                Afronden
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Toast Container -->
        <div id="toast-container" class="fixed bottom-4 right-4 z-50"></div>

        <script>
            document.getElementById('survey-form').addEventListener('submit', function(e) {
                const radioButtons = this.querySelectorAll('input[type="radio"]');
                let answered = false;

                radioButtons.forEach(radio => {
                    if (radio.checked) {
                        answered = true;
                    }
                });

                if (!answered) {
                    e.preventDefault();
                    window.Toast.show('Selecteer eerst een antwoord voordat je verder gaat.', 'error');
                }
            });
        </script>
    </div>
</x-app-layout>
