<x-guest-layout>
    <div class="max-w-md mx-auto px-6 py-8 bg-white text-black min-h-screen sm:min-h-0 sm:mt-16 border border-gray-300">
        <h2 class="text-xl font-normal tracking-tight mb-8 text-black border-b border-gray-200 pb-3">
            {{ __('Вход') }}
        </h2>

        <x-auth-session-status class="mb-4 text-sm text-emerald-800" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="email" class="text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                <input id="email" class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-none focus:outline-none focus:border-emerald-800 focus:ring-0 text-black" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="text-xs text-red-600 mt-1" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="password" class="text-sm font-medium text-gray-700">{{ __('Пароль') }}</label>
                <input id="password" class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-none focus:outline-none focus:border-emerald-800 focus:ring-0 text-black" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="text-xs text-red-600 mt-1" />
            </div>

            <div class="block">
                <label for="remember_me" class="inline-flex items-center text-sm cursor-pointer select-none">
                    <input id="remember_me" type="checkbox" class="w-4 h-4 text-emerald-800 border-gray-300 rounded-none focus:ring-0 focus:ring-offset-0 cursor-pointer" name="remember">
                    <span class="ml-2 text-black">{{ __('Запомнить меня') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                @if (Route::has('password.request'))
                <a class="text-xs text-gray-400 hover:text-black hover:underline transition-colors" href="{{ route('password.request') }}">
                    {{ __('Забыли пароль?') }}
                </a>
                @else
                <div></div>
                @endif

                <button type="submit" class="inline-block text-xs px-4 py-2 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium cursor-pointer transition-colors border-none text-center">
                    {{ __('Войти') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>