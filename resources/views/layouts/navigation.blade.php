<aside :class="open ? 'w-60' : 'w-16'"
    class="fixed h-screen p-2 text-black bg-white rounded-tr-lg rounded-br-lg shadow-md transition-all duration-300">

    <div class="flex items-center justify-between relative p-2">
        <div class="flex items-center">
            <img x-show="open" src="{{ asset('/storage/images/logos/kp-logo.jpeg') }}" alt="Logo" class="w-auto h-8">
        </div>

        <div class="flex items-center ml-auto" x-cloak :class="open ? 'justify-end' : 'justify-center w-full'">
            <button @click="open = !open" class="text-black" aria-label="Toggle sidebar">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div class="flex items-center" :class="open ? '' : 'justify-center'">
        <ul class="space-y-2" :class="open ? 'w-full' : ''">
            <x-sidebar-tab href="{{ route('dashboard') }}" active="{{ request()->routeIs('dashboard') }}"
                title="Dashboard" icon="heroicon-s-home" class="flex items-center w-full" aria-label="Dashboard" />

            @can('view teams')
                <x-sidebar-tab href="{{ route('teams') }}" active="{{ request()->routeIs('teams') }}" title="Teams"
                    icon="heroicon-s-users" class="flex items-center w-full" aria-label="Teams" />
            @endcan

            @can('create survey')
                <x-sidebar-tab href="{{ route('surveys') }}" active="{{ request()->routeIs('surveys') }}"
                    title="Vragenlijsten" icon="heroicon-s-question-mark-circle" class="flex items-center w-full"
                    aria-label="Vragenlijsten" />
            @endcan
        </ul>
    </div>

    <div class="absolute bottom-4 left-4" :class="open ? 'w-52' : 'justify-center hover:text-white'">
        <ul :class="open ? 'w-full' : ''">
            <x-sidebar-tab href="" title="Settings" icon="heroicon-s-cog-6-tooth"
                class="flex items-center w-full" aria-label="Settings" />
        </ul>
    </div>
</aside>
