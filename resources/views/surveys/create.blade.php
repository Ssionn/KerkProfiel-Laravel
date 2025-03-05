<x-app-layout>
    <div class="flex flex-col justify-center items-center mt-12">
        <div class="bg-white rounded-lg shadow-sm p-4 w-full sm:w-1/2 md:w-2/3">
            <h1 class="text-start text-xl font-semibold text-gray-900">
                {{ __('Vragenlijst aanmaken') }}
            </h1>

            <div class="mt-4">
                <form action="{{ route('surveys.store') }}" method="POST" enctype="multipart/form-data"
                    class="p-2 space-y-2">
                    @csrf

                    <div class="flex flex-row items-center space-x-2">
                        <div class="w-full">
                            <label class="ml-1 text-xs font-semibold text-gray-600" for="survey_name">
                                {{ __('Vragenlijst naam') }}
                            </label>
                            <input type="text" name="survey_name" id="survey_name" required
                                class="w-full p-2 rounded text-xs placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-sky-blue" />
                        </div>
                        <div class="w-full">
                            <label class="ml-1 text-xs font-semibold text-gray-600" for="survey_status">
                                {{ __('Vragenlijst status') }}
                            </label>

                            <select name="survey_status" id="survey_status"
                                class="w-full p-2 rounded text-xs placeholder:text-gray-200 placeholder:text-sm border-[1px] focus:ring-sky-blue">
                                <option value="Concept">Concept</option>
                                <option value="Gepubliceerd">Gepubliceerd</option>
                                <option value="Gesloten">Gesloten</option>
                            </select>
                        </div>
                    </div>

                    <div x-data="{
                        fileName: null,
                        handleFile(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.fileName = file.name;
                            }
                        },
                        clearFile() {
                            this.fileName = null;
                            document.getElementById('dropzone-file').value = '';
                        }
                    }" class="flex flex-col items-center space-x-2">
                        <div class="w-full mt-2">
                            <div class="flex flex-col w-full">
                                <label for="dropzone-file" class="text-start ml-1 text-xs font-semibold text-gray-600">
                                    {{ __('Vragenlijst uploaden') }}
                                </label>

                                <div x-show="!fileName">
                                    <label for="dropzone-file"
                                        class="flex flex-col items-center justify-center w-full h-32 mt-1 border-2 border-gray-300 border-dashed rounded cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <x-bytesize-upload class="w-8 h-8 text-gray-500" />
                                            <p class="mb-2 text-sm text-gray-500"><span
                                                    class="font-semibold">{{ __('Klik om te uploaden') }}</span></p>
                                            <p class="text-xs text-gray-500">{{ __('.xlsx bestanden') }}</p>
                                        </div>
                                    </label>
                                </div>

                                <div x-show="fileName">
                                    <div
                                        class="flex flex-col items-center justify-center w-full h-32 mt-1 border-2 border-green-300 rounded bg-green-50">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <x-entypo-check class="w-8 h-8 text-green-500" />
                                            <p class="mb-2 text-sm text-green-600 font-semibold" x-text="fileName"></p>
                                            <button @click.prevent="clearFile" type="button"
                                                class="text-xs text-red-500 hover:text-red-700">
                                                {{ __('Verwijderen') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <input id="dropzone-file" name="excel_file" type="file" accept=".xlsx" class="hidden"
                                    @change="handleFile($event)" />

                                @error('excel_file')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="w-full mt-2">
                        <button type="submit"
                            class="w-full py-2 mt-2 text-sm font-semibold text-center text-white rounded-lg bg-midnight-blue">
                            {{ __('Aanmaken') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-8 w-full sm:w-1/2 md:w-2/3">
            <div class="flex flex-col items-center w-full space-y-2">
                @foreach ($surveys as $survey)
                    <div class="flex justify-between items-center bg-white rounded-lg shadow-sm p-4 w-full">
                        <div class="">
                            <a href="{{ route('surveys.show', ['survey' => $survey]) }}" class="text-blue-600 hover:text-blue-800">
                                {{ $survey->name }}
                            </a>
                        </div>
                        <div class="flex items-center gap-4">
                            @if ($survey->status->name === 'DRAFT')
                                <span class="px-4 py-1 text-xs font-semibold text-gray-600 bg-gray-200 rounded-full">
                                    {{ __('Concept') }}
                                </span>
                            @elseif ($survey->status->name === 'PUBLISHED')
                                <span class="px-4 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded-full">
                                    {{ __('Gepubliceerd') }}
                                </span>
                            @else
                                <span class="px-4 py-1 text-xs font-semibold text-green-600 bg-green-100 rounded-full">
                                    {{ __('Gesloten') }}
                                </span>
                            @endif

                            <form action="{{ route('surveys.destroy', $survey) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Weet je zeker dat je deze vragenlijst wilt verwijderen?')"
                                    class="text-red-600 hover:text-red-800">
                                    <x-heroicon-s-trash class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
