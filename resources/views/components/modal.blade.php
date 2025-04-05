@props(['modalId', 'modalHeader', 'modalButton', 'formAction', 'method', 'modalButtonColor' => 'bg-midnight-blue'])

<div data-modal-target="{{ $modalId }}" id="{{ $modalId }}" tabindex="-1"
    class="fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-screen max-h-full hidden">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity duration-300 ease-out opacity-0"
        data-modal-backdrop="{{ $modalId }}"></div>
    <div class="relative py-2 px-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow transform transition-all duration-300 ease-out opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            data-modal-content="{{ $modalId }}">
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

            <form action="{{ $formAction }}" method="POST" name="remove-user-form">
                @csrf
                @method($method)
                <div class="p-2">
                    {{ $slot }}
                </div>
                <div class="flex items-center p-2 rounded-b dark:border-gray-600">
                    <button data-modal-hide="{{ $modalId }}" type="submit"
                        class="w-full text-sm py-2 px-2 font-medium focus:outline-none text-white rounded-lg border border-midnight-blue focus:z-10 focus:ring-4 focus:ring-gray-100 {{ $modalButtonColor }}">
                        {{ $modalButton }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showModalButtons = document.querySelectorAll('[data-modal-toggle]');
        showModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                const backdrop = modal.querySelector(`[data-modal-backdrop="${modalId}"]`);
                const content = modal.querySelector(`[data-modal-content="${modalId}"]`);

                modal.classList.remove('hidden');
                modal.classList.add('flex');

                requestAnimationFrame(() => {
                    backdrop.classList.remove('opacity-0');
                    content.classList.remove('opacity-0', 'translate-y-4',
                        'sm:translate-y-0', 'sm:scale-95');
                    content.classList.add('opacity-100', 'translate-y-0',
                        'sm:scale-100');
                });
            });
        });

        const hideModalButtons = document.querySelectorAll('[data-modal-hide]');
        hideModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal-hide');
                const modal = document.getElementById(modalId);
                const backdrop = modal.querySelector(`[data-modal-backdrop="${modalId}"]`);
                const content = modal.querySelector(`[data-modal-content="${modalId}"]`);

                backdrop.classList.add('opacity-0');
                content.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
                content.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0',
                    'sm:scale-95');

                setTimeout(() => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }, 300);
            });
        });
    });
</script>
