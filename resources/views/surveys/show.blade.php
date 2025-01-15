<x-app-layout>
    <h1 class="text-3xl font-bold mb-8">{{ $survey->name }}</h1>

    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8">
        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($currentPage / $totalPages) * 100 }}%">
        </div>
    </div>
    <div class="text-sm text-gray-600 mb-6">
        <span class="font-semibold">
            Question {{ $currentPage }} of {{ $totalPages }}
        </span>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-2 gap-8 mb-6">
            <div class="text-right">
                <p class="font-semibold">{{ $question->left_statement }}</p>
            </div>
            <div class="text-left">
                <p class="font-semibold">{{ $question->right_statement }}</p>
            </div>
        </div>

        <form action="{{ route('survey.answer', ['survey' => $survey]) }}" method="POST">
            @csrf
            <input type="hidden" name="question_id" value="{{ $question->id }}">

            <div class="space-y-4">
                <div class="flex justify-between items-center gap-4">
                    <div class="flex flex-row justify-center space-x-12 flex-1">
                        @foreach ($question->radioButtonValues() as $value)
                            <input type="radio" name="answer" value="{{ $value }}"
                                class="w-12 h-12 text-midnight-blue bg-gray-100 border-2 border-gray-300 focus:bg-midnight-blue focus:bg-midnight-blue">
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-8">
                @if ($currentPage < $totalPages)
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Next
                    </button>
                @else
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                        Finish Survey
                    </button>
                @endif
            </div>
        </form>
    </div>
</x-app-layout>
