<x-guest-layout>
    <div class="max-w-md mx-auto px-6 py-8 bg-white text-black min-h-screen sm:min-h-0 sm:mt-16 border border-gray-300">
        <h2 class="text-xl font-normal tracking-tight mb-8 text-black border-b border-gray-200 pb-3">
            {{ __('Регистрация') }}
        </h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="name" class="text-sm font-medium text-gray-700">{{ __('Имя') }}</label>
                <input id="name" class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-none focus:outline-none focus:border-emerald-800 focus:ring-0 text-black" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="text-xs text-red-600 mt-1" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="email" class="text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                <input id="email" class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-none focus:outline-none focus:border-emerald-800 focus:ring-0 text-black" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="text-xs text-red-600 mt-1" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="password" class="text-sm font-medium text-gray-700">{{ __('Пароль') }}</label>
                <input id="password" class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-none focus:outline-none focus:border-emerald-800 focus:ring-0 text-black" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="text-xs text-red-600 mt-1" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="password_confirmation" class="text-sm font-medium text-gray-700">{{ __('Подтверждение пароля') }}</label>
                <input id="password_confirmation" class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-none focus:outline-none focus:border-emerald-800 focus:ring-0 text-black" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="text-xs text-red-600 mt-1" />
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <a class="text-xs text-gray-400 hover:text-black hover:underline transition-colors" href="{{ route('login') }}">
                    {{ __('Уже зарегистрированы?') }}
                </a>

                <button type="submit" class="inline-block text-xs px-4 py-2 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium cursor-pointer transition-colors border-none text-center">
                    {{ __('Зарегистрировать') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>