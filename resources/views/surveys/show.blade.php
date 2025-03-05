<x-app-layout>
    <!-- Background with gradient -->
    <div class="min-h-screen" style="background: linear-gradient(82deg, #eaeafd 0%, #c3c2c6 100%);">
        <div class="max-w-6xl mx-auto px-4 py-4 sm:py-8">
            <!-- Survey Header -->
            <div class="mb-8 sm:mb-16 text-center space-y-4 sm:space-y-6">
                <h1 class="text-2xl sm:text-4xl font-bold text-gray-900">{{ $survey->name }}</h1>
                <div class="flex items-center justify-center gap-2 sm:gap-4 text-sm sm:text-base text-gray-600">
                    <span class="font-medium">Vraag {{ $currentPage }}</span>
                    <span>van</span>
                    <span class="font-medium">{{ $totalPages }}</span>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="relative pt-1 mb-8 sm:mb-16">
                <div class="flex mb-2 sm:mb-4 items-center justify-between">
                    <div class="text-xs sm:text-sm font-semibold inline-block py-1 sm:py-2 px-2 sm:px-4 uppercase rounded-full text-blue-600 bg-blue-200">
                        Voortgang
                    </div>
                    <div class="text-xs sm:text-sm font-semibold inline-block text-blue-600">
                        {{ round(($currentPage / $totalPages) * 100) }}%
                    </div>
                </div>
                <div class="overflow-hidden h-2 sm:h-3 mb-4 text-xs flex rounded bg-blue-100">
                    <div style="width: {{ ($currentPage / $totalPages) * 100 }}%"
                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600 transition-all duration-500">
                    </div>
                </div>
            </div>

            <!-- Question Container -->
            <div class="bg-white/30 backdrop-blur-md border border-white/50 rounded-xl shadow-lg p-4 sm:p-12 mb-8">
                <div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2 md:gap-8 lg:gap-12 mb-8 sm:mb-12 md:mb-16">
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center p-4 sm:p-6 bg-white/60 backdrop-blur-sm rounded-lg border border-white/60 min-h-[80px] sm:min-h-[100px] md:min-h-[120px] hover:bg-white/70 transition-all duration-300 w-full">
                            <p class="font-bold text-base sm:text-lg md:text-xl text-gray-900 text-center">{{ $question->left_statement }}</p>
                        </div>
                        <div class="flex items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span class="text-xs sm:text-sm font-bold text-gray-700 ml-1">L</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center p-4 sm:p-6 bg-white/60 backdrop-blur-sm rounded-lg border border-white/60 min-h-[80px] sm:min-h-[100px] md:min-h-[120px] hover:bg-white/70 transition-all duration-300 w-full">
                            <p class="font-bold text-base sm:text-lg md:text-xl text-gray-900 text-center">{{ $question->right_statement }}</p>
                        </div>
                        <div class="flex items-center mt-2">
                            <span class="text-xs sm:text-sm font-bold text-gray-700 mr-1">R</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </div>
                    </div>
                </div>

                <form action="{{ route('survey.answer', ['survey' => $survey]) }}" method="POST" id="survey-form">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <input type="hidden" name="page" value="{{ $currentPage }}">

                    <!-- Radio Button Group (Desktop) -->
                    <div class="hidden sm:flex justify-center items-center gap-4 mb-8 sm:mb-16">
                        <div class="grid grid-cols-7 gap-4 sm:gap-8 w-full max-w-4xl mx-auto px-2 sm:px-0">
                            @foreach ($question->radioButtonValues() as $key => $value)
                                @php
                                    $colors = [
                                        ['bg' => 'bg-emerald-600', 'border' => 'border-emerald-600'],
                                        ['bg' => 'bg-emerald-400', 'border' => 'border-emerald-400'],
                                        ['bg' => 'bg-teal-400', 'border' => 'border-teal-400'],
                                        ['bg' => 'bg-white', 'border' => 'border-gray-200'],
                                        ['bg' => 'bg-sky-400', 'border' => 'border-sky-400'],
                                        ['bg' => 'bg-blue-400', 'border' => 'border-blue-400'],
                                        ['bg' => 'bg-emerald-600', 'border' => 'border-emerald-600']
                                    ];
                                    $index = is_string($key) ? ($key === 'left' ? 0 : 6) : $value+3;
                                @endphp
                                <div class="flex flex-col items-center">
                                    <label class="relative">
                                        <input type="radio" name="answer" value="{{ $value }}"
                                            {{ isset($existingAnswer) && $existingAnswer->answer == $value ? 'checked' : '' }}
                                            class="desktop-radio peer sr-only">
                                        <div class="relative w-10 h-10 sm:w-14 sm:h-14 rounded-full border-2 {{ $colors[$index]['bg'] . ' ' . $colors[$index]['border'] }} cursor-pointer transition-all duration-200">
                                            <!-- White dot indicator -->
                                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-4 h-4 sm:w-6 sm:h-6 rounded-full bg-white shadow-md opacity-0 peer-checked:opacity-100 transition-all duration-200"></div>
                                        </div>
                                        <!-- Hover/Selected ring effect -->
                                        <div class="absolute -inset-2 -z-10 rounded-full opacity-0 peer-hover:opacity-100 peer-checked:opacity-100 transition-opacity duration-200 bg-gray-400/40"></div>
                                        @if (is_string($key))
                                            <span class="absolute -bottom-6 sm:-bottom-8 left-1/2 transform -translate-x-1/2 text-xs sm:text-sm font-bold text-gray-700">
                                                {{ ucfirst($key) }}
                                            </span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Desktop Score Explainer -->
                    <div class="hidden sm:flex justify-center mb-8">
                        <div id="desktop-score-explainer" class="text-sm font-semibold text-blue-600 bg-blue-100 px-3 py-1.5 rounded-md hidden"></div>
                    </div>

                    <!-- Slider (Mobile) -->
                    <div class="sm:hidden flex flex-col justify-center items-center gap-4 mb-8">
                        <div class="w-full max-w-4xl mx-auto px-4">
                            <!-- Slider Container -->
                            <div class="relative py-6">
                                <!-- Color Background Track -->
                                <div class="absolute top-1/2 left-0 right-0 h-4 rounded-full overflow-hidden -translate-y-1/2">
                                    <div class="w-full h-full flex">
                                        <div class="bg-emerald-600 flex-1"></div>
                                        <div class="bg-emerald-400 flex-1"></div>
                                        <div class="bg-teal-400 flex-1"></div>
                                        <div class="bg-white flex-1"></div>
                                        <div class="bg-sky-400 flex-1"></div>
                                        <div class="bg-blue-400 flex-1"></div>
                                        <div class="bg-emerald-600 flex-1"></div>
                                    </div>
                                </div>

                                <!-- Tick Marks -->
                                <div class="absolute top-1/2 left-0 right-0 -translate-y-1/2 px-1 flex justify-between pointer-events-none">
                                    @for ($i = 0; $i < 7; $i++)
                                        <div class="w-0.5 h-6 bg-white/40 rounded-full"></div>
                                    @endfor
                                </div>

                                <!-- Slider Input -->
                                <input type="range" name="mobile_answer" min="-3" max="3" step="1" value="{{ isset($existingAnswer) ? $existingAnswer->answer : 0 }}"
                                    class="w-full appearance-none bg-transparent cursor-pointer focus:outline-none h-12"
                                    id="mobile-slider">

                                <!-- Slider Thumb Styling -->
                                <style>
                                    /* Hide default track */
                                    input[type=range] {
                                        -webkit-appearance: none;
                                        margin: 0;
                                    }

                                    input[type=range]:focus {
                                        outline: none;
                                    }

                                    input[type=range]::-webkit-slider-runnable-track {
                                        width: 100%;
                                        height: 4px;
                                        cursor: pointer;
                                        background: transparent;
                                    }

                                    input[type=range]::-moz-range-track {
                                        width: 100%;
                                        height: 4px;
                                        cursor: pointer;
                                        background: transparent;
                                    }

                                    input[type=range]::-webkit-slider-thumb {
                                        -webkit-appearance: none;
                                        appearance: none;
                                        width: 32px;
                                        height: 32px;
                                        border-radius: 50%;
                                        background: white;
                                        border: 2px solid #9ca3af;
                                        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                                        cursor: pointer;
                                        position: relative;
                                        z-index: 10;
                                        margin-top: -14px;
                                    }

                                    input[type=range]::-moz-range-thumb {
                                        width: 32px;
                                        height: 32px;
                                        border-radius: 50%;
                                        background: white;
                                        border: 2px solid #9ca3af;
                                        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                                        cursor: pointer;
                                        position: relative;
                                        z-index: 10;
                                    }

                                    /* Active state */
                                    input[type=range]:active::-webkit-slider-thumb {
                                        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
                                        border-color: #3b82f6;
                                    }

                                    input[type=range]:active::-moz-range-thumb {
                                        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
                                        border-color: #3b82f6;
                                    }
                                </style>

                                <!-- Value Labels -->
                                <div class="flex justify-between mt-6 px-1">
                                    <span class="text-xs font-bold text-gray-700">L</span>
                                    <span id="mobile-slider-value" class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-md"></span>
                                    <span class="text-xs font-bold text-gray-700">R</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Score Explainer (Both Desktop and Mobile) -->
                    <div class="sm:flex justify-center mb-8 hidden">
                        <div id="score-explainer" class="text-sm font-semibold text-blue-600 bg-blue-100 px-3 py-1.5 rounded-md hidden"></div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-end gap-2 sm:gap-4">
                        @if ($currentPage > 1)
                            <a href="{{ route('surveys.show', ['survey' => $survey, 'page' => $currentPage - 1]) }}"
                                class="px-4 sm:px-6 py-2 text-sm sm:text-base bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                Vorige
                            </a>
                        @endif

                        @if ($currentPage < $totalPages)
                            <button type="submit"
                                class="px-4 sm:px-6 py-2 text-sm sm:text-base bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Volgende
                            </button>
                        @else
                            <button type="submit"
                                class="px-4 sm:px-6 py-2 text-sm sm:text-base bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
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
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('survey-form');
                const mobileSlider = document.getElementById('mobile-slider');
                const desktopRadios = document.querySelectorAll('.desktop-radio');
                const mobileSliderValue = document.getElementById('mobile-slider-value');
                const scoreExplainer = document.getElementById('score-explainer');

                // Map values to descriptive text
                const valueDescriptions = {
                    '-3': 'Helemaal links',
                    '-2': 'Grotendeels links',
                    '-1': 'Enigszins links',
                    '0': 'Neutraal',
                    '1': 'Enigszins rechts',
                    '2': 'Grotendeels rechts',
                    '3': 'Helemaal rechts'
                };

                // Sync desktop radios with mobile slider
                mobileSlider.addEventListener('input', function() {
                    const value = this.value;
                    updateValueDisplay(value);
                    syncDesktopRadios(value);

                    // Add haptic feedback for mobile if supported
                    if (window.navigator && window.navigator.vibrate) {
                        window.navigator.vibrate(5);
                    }
                });

                // Sync mobile slider with desktop radios
                desktopRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const value = this.value;
                        mobileSlider.value = value;
                        updateValueDisplay(value);
                    });
                });

                // Initialize the value display with any existing answer
                if (mobileSlider.value) {
                    updateValueDisplay(mobileSlider.value);
                    syncDesktopRadios(mobileSlider.value);
                }

                // Update the value display
                function updateValueDisplay(value) {
                    const description = valueDescriptions[value] || '';

                    // Update mobile slider value display - for mobile only
                    if (window.innerWidth < 640) {
                        mobileSliderValue.textContent = description;
                    }

                    // Update the desktop score explainer - for desktop only
                    if (window.innerWidth >= 640 && description) {
                        scoreExplainer.textContent = description;
                        scoreExplainer.classList.remove('hidden');
                    } else if (window.innerWidth >= 640) {
                        scoreExplainer.classList.add('hidden');
                    }
                }

                // Find and check the correct desktop radio based on value
                function syncDesktopRadios(value) {
                    desktopRadios.forEach(radio => {
                        if (radio.value === value) {
                            radio.checked = true;
                        }
                    });
                }

                // Form validation
                form.addEventListener('submit', function(e) {
                    // Add hidden input with the current value before submitting
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'answer';
                    hiddenInput.value = mobileSlider.value;

                    // Only add if we're on mobile (slider visible)
                    if (window.innerWidth < 640) {
                        form.appendChild(hiddenInput);
                    }

                    // Check if any option is selected
                    let answered = false;

                    if (window.innerWidth < 640) {
                        // Mobile: check slider value
                        answered = true; // Slider always has a value
                    } else {
                        // Desktop: check radio buttons
                        desktopRadios.forEach(radio => {
                            if (radio.checked) {
                                answered = true;
                            }
                        });
                    }

                    if (!answered) {
                        e.preventDefault();
                        window.Toast.show('Selecteer eerst een antwoord voordat je verder gaat.', 'error');
                    }
                });
            });
        </script>
    </div>
</x-app-layout>
