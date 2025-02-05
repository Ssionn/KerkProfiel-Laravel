<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Email Notification' }}</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="bg-gray-100 min-h-screen py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            @if (isset($thumbnail))
                <img src="{{ $thumbnail }}" alt="Team" class="w-32 h-32 object-cover object-center">
            @endif

            <div class="bg-primary-600 px-6 py-4">
                <h1 class="text-xl font-semibold">
                    {{ $subject ?? 'Email Notification' }}
                </h1>
            </div>

            <div class="px-6 py-8">
                <div class="mb-6">
                    <p class="text-lg">
                        Je bent uitgenodigd om lid te worden van het team <strong>{{ $team->name }}</strong>!
                    </p>
                </div>

                @if (isset($acceptUrl))
                    <div class="max-w-none break-words">
                        Als de knop hieronder niet werkt, kopieer en plak dan de volgende URL in je browser:
                        <a href="{{ $acceptUrl }}" class="text-blue-500 hover:underline">
                            {{ $acceptUrl }}
                        </a>
                    </div>


                    <div class="mt-8">
                        <a href="{{ $acceptUrl }}"
                            class="flex flex-row justify-center items-center px-6 py-3 bg-midnight-blue text-white font-semibold rounded-lg">
                            Accepteer uitnodiging
                        </a>
                    </div>
                @endif
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t">
                <p class="text-sm">
                    Met vriendelijke groet,<br>
                    {{ config('app.name') }}
                </p>
            </div>
        </div>
    </div>
</body>

</html>
