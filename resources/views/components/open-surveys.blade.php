<div class="flex flex-col w-full p-1.5 sm:w-3/4 md:w-2/5 xl:w-2/6">
    <div class="p-1.5">
        <h1 class="text-xl font-semibold">{{ __('Open surveys') }}</h1>
    </div>
    <div class="px-1.5 space-y-2">
        <div class="flex flex-row justify-between bg-white border border-gray-200 rounded-lg shadow-sm p-3">
            <div class="flex flex-col items-start space-y-1">
                <div class="flex flex-col items-start">
                    <span class="font-semibold">
                        {{ __('Survey name') }}
                    </span>
                    <div class="flex flex-row items-center space-x-2">
                        <div class="h-2 w-6 rounded-sm bg-sky-blue"></div>
                        <div class="h-2 w-6 rounded-sm bg-sky-blue"></div>
                        <div class="h-2 w-6 rounded-sm bg-sky-blue"></div>
                        <div class="h-2 w-6 rounded-sm bg-sky-blue"></div>
                        <div class="h-2 w-6 rounded-sm bg-sky-blue"></div>
                        <span class="text-sm font-semibold text-gray-500">
                            100%
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center">
                <button class="bg-sky-blue text-white py-2 px-2 text-sm font-semibold text-center rounded-lg">
                    {{ __('Take survey') }}
                </button>
            </div>
        </div>
    </div>
</div>
