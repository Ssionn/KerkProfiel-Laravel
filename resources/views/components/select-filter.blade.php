@props(['name', 'options' => [], 'label' => ''])

<select name="{{ $name }}" onchange="this.form.submit()"
    class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-1.5 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 hover:border-gray-300 transition-colors cursor-pointer appearance-none"
    aria-label="{{ $label }}">
    @foreach ($options as $option)
        @if ($option === 'Alle')
            <option value="" selected>{{ $option }}</option>
        @else
            <option value="{{ $option }}" {{ request($name) === $option ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endif
    @endforeach
</select>
