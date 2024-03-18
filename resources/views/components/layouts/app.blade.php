<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100 dark:bg-gray-900">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        @stack('customer-scripts')
    </head>
    <body class="min-h-screen">
        <div x-data="{ menuVisibility: false }">
            <x-side-bar></x-side-bar>

            <div class="flex flex-col md:pl-64">
                <x-navigation/>

                @if(session()->has('impersonate'))
                <div class="flex items-center justify-center w-full gap-x-6 bg-indigo-600 px-6 py-2.5 sm:px-3.5 ">
                    <span class="text-sm leading-6 text-white">You are impersonatine <strong>{{ auth()->user()->name }}</strong></span>
                    <a href="{{ route('impersonate.leave') }}" class="text-sm leading-6 text-white underline"><span>Leave Impersonating</span></a>
                </div>
                @endif

                <main class="flex-1">
                    <div class="py-6">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        @livewireScriptConfig
    </body>
</html>
