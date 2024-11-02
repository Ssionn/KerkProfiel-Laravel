@props(['modalId', 'modalHeader', 'modalButton', 'formAction'])

<div id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative py-2 px-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-2 rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ $modalHeader }}
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="{{ $modalId }}">
                    <x-css-close />
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form action="{{ $formAction }}" method="POST">
                @csrf
                <div class="p-2">
                    {{ $slot }}
                </div>
                <div class="flex items-center p-2 rounded-b dark:border-gray-600">
                    <button data-modal-hide="{{ $modalId }}" type="button"
                        class="w-full text-sm py-2 px-2 font-medium focus:outline-none bg-midnight-blue text-white rounded-lg border border-indigo-500 focus:z-10 focus:ring-4 focus:ring-gray-100">
                        {{ $modalButton }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
