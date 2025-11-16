<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>App Vulnerável</title>

        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Classe customizada para a cor vermelha do Laravel */
            .laravel-red {
                color: #EF3B2D;
            }

            /* Adicionando classes de Sombra e Transição */
            .shadow-lg{--tw-shadow:0 10px 15px -3px rgb(0 0 0 / .1), 0 4px 6px -4px rgb(0 0 0 / .1);--tw-shadow-colored:0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow)}
            .transition-transform{transition-property:transform;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:.15s}
            .transform{transform:translateY(0) rotate(0) skewX(0) skewY(0) scaleX(1) scaleY(1)}
            .hover\:scale-105:hover{--tw-scale-x:1.05;--tw-scale-y:1.05;transform:translateY(0) rotate(0) skewX(0) skewY(0) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 text-center">
                
                <div class="flex justify-center pt-8 sm:pt-0">
                    <h1 class="text-5xl sm:text-6xl font-bold laravel-red">
                        OpenAccess Shop
                    </h1>
                </div>

                <div class="mt-8 flex justify-center space-x-10">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-block px-10 py-4 bg-gray-900 text-white dark:bg-gray-200 dark:text-gray-900 rounded-xl text-lg font-semibold hover:bg-gray-700 dark:hover:bg-white transition-transform transform hover:scale-105 shadow-lg">
                                Produtos
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-block px-10 py-4 bg-gray-900 text-white dark:bg-gray-200 dark:text-gray-900 rounded-xl text-lg font-semibold hover:bg-gray-700 dark:hover:bg-white transition-transform transform hover:scale-105 shadow-lg">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-block px-10 py-4 bg-gray-900 text-white dark:bg-gray-200 dark:text-gray-900 rounded-xl text-lg font-semibold hover:bg-gray-700 dark:hover:bg-white transition-transform transform hover:scale-105 shadow-lg">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

            </div>
        </div>
    </body>
</html>