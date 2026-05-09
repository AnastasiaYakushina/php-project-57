<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Проект на Хекслете</title>
    <!-- Подключаем стили, которые генерирует Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-slate-50">
    <div class="relative min-h-screen flex flex-col items-center justify-center">

        <!-- Навигация в углу -->
        @if (Route::has('login'))
            <div class="absolute top-0 right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Панель управления</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Вход</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition shadow-md shadow-indigo-200">Регистрация</a>
                    @endif
                @endauth
            </div>
        @endif

        <!-- Основная карточка -->
        <div class="max-w-md w-full px-6">
            <div class="bg-white p-8 rounded-2xl shadow-xl shadow-slate-200 text-center border border-slate-100">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 text-3xl rounded-full mb-6">
                    🚀
                </div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Привет!</h1>
                <p class="text-slate-600 leading-relaxed">
                    Это мой финальный проект на <span class="font-semibold text-indigo-600">Хекслете</span>.
                </p>

                <div class="mt-8 pt-6 border-t border-slate-50 text-xs text-slate-400 uppercase tracking-widest">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
