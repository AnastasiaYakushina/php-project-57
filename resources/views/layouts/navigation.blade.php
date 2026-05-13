<nav x-data="{ open: false }" class="w-full bg-emerald-800 text-white shadow-md">
    <div class="w-full px-6">
        <div class="flex justify-between h-16">

            <div class="flex items-center space-x-10">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('tasks.index') }}" class="text-xl font-semibold tracking-tight hover:text-emerald-200 transition-colors whitespace-nowrap">
                        {{ __('Менеджер задач') }}
                    </a>
                </div>

                <div class="hidden sm:flex space-x-4 h-full">
                    <a href="{{ route('tasks.index') }}" class="inline-flex items-center text-base font-medium px-1 border-b-2 {{ request()->routeIs('tasks.*') ? 'border-white text-white' : 'border-transparent text-emerald-100 hover:text-white hover:border-emerald-300' }} transition-colors h-full">
                        {{ __('Задачи') }}
                    </a>
                    <a href="{{ route('task_statuses.index') }}" class="inline-flex items-center text-base font-medium px-1 border-b-2 {{ request()->routeIs('task_statuses.*') ? 'border-white text-white' : 'border-transparent text-emerald-100 hover:text-white hover:border-emerald-300' }} transition-colors h-full">
                        {{ __('Статусы') }}
                    </a>
                    <a href="{{ route('labels.index') }}" class="inline-flex items-center text-base font-medium px-1 border-b-2 {{ request()->routeIs('labels.*') ? 'border-white text-white' : 'border-transparent text-emerald-100 hover:text-white hover:border-emerald-300' }} transition-colors h-full">
                        {{ __('Метки') }}
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center space-x-4">
                @auth
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form-global-desktop').submit();"
                    class="text-base font-medium text-emerald-100 hover:text-white transition-colors cursor-pointer">
                    {{ __('Выход') }}
                </a>
                @else
                <a href="{{ route('login') }}" class="text-base font-medium text-emerald-100 hover:text-white transition-colors">
                    {{ __('Войти') }}
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-base font-medium text-emerald-800 bg-white hover:bg-emerald-50 rounded-md transition-colors">
                    {{ __('Зарегистрироваться') }}
                </a>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-emerald-200 hover:text-white hover:bg-emerald-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-emerald-900 bg-emerald-800">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('tasks.index') }}" class="block pl-4 py-2 text-base font-medium {{ request()->routeIs('tasks.*') ? 'bg-emerald-900 border-l-4 border-white text-white' : 'text-emerald-100 hover:bg-emerald-700' }}">
                {{ __('Задачи') }}
            </a>
            <a href="{{ route('task_statuses.index') }}" class="block pl-4 py-2 text-base font-medium {{ request()->routeIs('task_statuses.*') ? 'bg-emerald-900 border-l-4 border-white text-white' : 'text-emerald-100 hover:bg-emerald-700' }}">
                {{ __('Статусы') }}
            </a>
            <a href="{{ route('labels.index') }}" class="block pl-4 py-2 text-base font-medium {{ request()->routeIs('labels.*') ? 'bg-emerald-900 border-l-4 border-white text-white' : 'text-emerald-100 hover:bg-emerald-700' }}">
                {{ __('Метки') }}
            </a>
        </div>

        <div class="pt-4 pb-1 border-t border-emerald-900">
            @auth
            <div class="space-y-1">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form-global-mobile').submit();"
                    class="block pl-4 py-2 text-base font-medium text-emerald-100 hover:bg-emerald-700">
                    {{ __('Выход') }}
                </a>
            </div>
            @else
            <div class="space-y-1 py-2">
                <a href="{{ route('login') }}" class="block pl-4 py-2 text-base font-medium text-emerald-100 hover:bg-emerald-700">
                    {{ __('Войти') }}
                </a>
                <a href="{{ route('register') }}" class="block pl-4 py-2 text-base font-medium text-emerald-100 hover:bg-emerald-700">
                    {{ __('Зарегистрироваться') }}
                </a>
            </div>
            @endauth
        </div>
    </div>
</nav>

<form id="logout-form-global-desktop" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<form id="logout-form-global-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>