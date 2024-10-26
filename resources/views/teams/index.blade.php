<x-app-layout>
        <x-header title="Teams"/>

        <div class="p-2 mt-8">
            <div class="masonry">
                <div class="masonry-item break-inside">
                    @include('teams.partials.team-info')
                </div>

{{--                <div class="masonry-item break-inside">--}}
{{--                    @include('teams.partials.team-info')--}}
{{--                </div>--}}
            </div>
        </div>
</x-app-layout>
