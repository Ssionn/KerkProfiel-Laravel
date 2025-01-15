<x-app-layout>
    <body class="bg-gray-50 flex items-center justify-center min-h-screen">
        <div class="max-w-3xl mx-auto p-6">
            <h1 class="text-4xl font-bold text-center mb-8">{{ __('faq/faq.page.title') }}</h1>

            <div id="accordion-collapse" data-accordion="collapse">
                @foreach ($faqs as $index => $faq)
                    <h2 id="accordion-collapse-heading-{{ $index }}">
                        <button
                            type="button"
                            class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-b-0 border-gray-200 {{ $loop->first ? 'rounded-t-xl' : '' }} focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                            data-accordion-target="#accordion-collapse-body-{{ $index }}"
                            aria-expanded="{{ __('faq/faq.accordion.expand_button.aria_expanded') }}"
                            aria-controls="{{ __('faq/faq.accordion.expand_button.aria_controls') }}-{{ $index }}"
                        >
                            <span class="text-black dark:text-gray-400">{{ $faq->question }}</span>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                            </svg>
                        </button>
                    </h2>
                    <div
                        id="accordion-collapse-body-{{ $index }}"
                        class="{{ $loop->first ? '' : 'hidden' }}"
                        aria-labelledby="accordion-collapse-heading-{{ $index }}"
                    >
                        <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                            <p class="mb-2 text-black dark:text-gray-400">{{ $faq->answer }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <p class="mt-4 text-sm">
                    {{ __('faq/faq.contact.text') }}
                    <a href="mailto:{{ __('faq/faq.contact.email') }}" class="text-blue-600 underline">
                        {{ __('faq/faq.contact.email') }}
                    </a>
                    {{ __('faq/faq.contact.via') }}
                </p>
            </div>
        </div>
    </body>
</x-app-layout>
