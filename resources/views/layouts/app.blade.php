<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-base-200 text-base-content" data-theme="corporate">
        <div class="max-w-6xl mx-auto px-6 py-8">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                <div>
                    <p class="text-sm opacity-70">Cloudflare R2 Helper</p>
                    <h1 class="text-2xl font-semibold">@yield('heading', 'Connessioni R2')</h1>
                </div>
                <div class="text-sm opacity-70">
                    @yield('subheading')
                </div>
            </div>

            @if (session('status'))
                <div class="alert alert-success mb-6">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error mb-6">
                    <div>
                        <p class="font-medium">Controlla i dati inseriti:</p>
                        <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </body>
</html>
