<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        @-webkit-keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        .fadeIn {
            -webkit-animation-name: fadeIn;
            animation-name: fadeIn;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/tukanasta.js') }}"></script>

    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div id="content" class="hidden min-h-screen bg-white">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <div class="px-4 mx-auto -mt-1 max-w-7xl sm:px-8">
                <header class="bg-white rounded-b-lg shadow ">
                    <div class="px-4 py-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            </div>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @livewire('livewire-ui-modal')
        @livewire('footer-menu')

        <button id="btnUp" type="button" class="fadeIn fixed flex items-center justify-center w-12 h-12 text-white bg-green-700 border-2 border-gray-100 rounded-full shadow-md bottom-6 right-3">
            <svg width="16" he0ght="16" fill="white" class="text-white bi bi-chevron-double-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708l6-6z" />
                <path fill-rule="evenodd" d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
            </svg>
        </button>
    </div>

    <div id="loadding" class="grid h-screen place-items-center">
        <div class="flex items-center">
            <svg fill="green" width="48" class="mr-2 animate-spin" height="48" viewBox="0 0 24 24">
                <g>
                    <circle cx="3" cy="12" r="2" />
                    <circle cx="21" cy="12" r="2" />
                    <circle cx="12" cy="21" r="2" />
                    <circle cx="12" cy="3" r="2" />
                    <circle cx="5.64" cy="5.64" r="2" />
                    <circle cx="18.36" cy="18.36" r="2" />
                    <circle cx="5.64" cy="18.36" r="2" />
                    <circle cx="18.36" cy="5.64" r="2" />
                    <animateTransform attributeName="transform" type="rotate" dur="2s" values="0 12 12;360 12 12" repeatCount="indefinite" />
                </g>
            </svg>
            <div class="font-bold text-green-700 uppercase text-md">{{ __('Loadding') }}...</div>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
    @yield('scripts')
</body>

</html>
