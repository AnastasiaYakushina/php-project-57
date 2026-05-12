<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Проект на Хекслете</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div>

        @if (Route::has('login'))
        <div>
            @auth
            <a href="{{ url('/dashboard') }}">Панель управления</a>
            @else
            <a href="{{ route('login') }}">Вход</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Регистрация</a>
            @endif
            @endauth
        </div>
        @endif

        <div>
        </div>
</body>

</html>