<x-guest-layout>
    <div class="max-w-md mx-auto px-6 py-8 bg-white text-black min-h-screen sm:min-h-0 sm:mt-16 border border-gray-300">
        <h2 class="text-xl font-normal tracking-tight mb-6 text-black border-b border-gray-200 pb-3">
            {{ __('Восстановление пароля') }}
        </h2>

        <div class="mb-6 text-sm text-gray-400 leading-relaxed">
            {{ __('Забыли пароль? Укажите адрес электронной почты, и мы отправим вам письмо со ссылкой для сброса пароля, чтобы вы могли установить новый.') }}
        </div>

        <x-auth-session-status class="mb-4 text-sm text-emerald-800" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="email" class="text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                <input id="email" class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-none focus:outline-none focus:border-emerald-800 focus:ring-0 text-black" type="email" name="email" value="{{ old('email') }}" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="text-xs text-red-600 mt-1" />
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="inline-block text-xs px-4 py-2 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium cursor-pointer transition-colors border-none text-center">
                    {{ __('Отправить ссылку для сброса пароля на email') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>