<nav x-data="{ open: false }" class="w-full bg-emerald-800 text-white shadow-none">
    <div class="w-full px-6">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('tasks.index') }}" class="text-xl font-medium tracking-tight hover:text-gray-200 transition-colors">
                        {{ __('Менеджер задач') }}
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex items-center h-full ml-12 mr-auto">
                <a href="{{ route('tasks.index') }}" class="inline-flex items-center text-lg font-normal text-white border-b-2 {{ request()->routeIs('tasks.*') ? 'border-white' : 'border-transparent' }} pb-1.5 px-6 h-fit hover:text-gray-200 transition-colors">
                    {{ __('Задачи') }}
                </a>
                <a href="{{ route('task_statuses.index') }}" class="inline-flex items-center text-lg font-normal text-white border-b-2 {{ request()->routeIs('task_statuses.*') ? 'border-white' : 'border-transparent' }} pb-1.5 px-6 h-fit hover:text-gray-200 transition-colors">
                    {{ __('Статусы') }}
                </a>
                <a href="{{ route('labels.index') }}" class="inline-flex items-center text-lg font-normal text-white border-b-2 {{ request()->routeIs('labels.*') ? 'border-white' : 'border-transparent' }} pb-1.5 px-6 h-fit hover:text-gray-200 transition-colors">
                    {{ __('Метки') }}
                </a>
            </div>

            <div class="hidden sm:flex sm:items-center gap-8">
                @auth
                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center text-lg font-normal text-white hover:text-gray-200 transition-colors cursor-pointer bg-transparent border-none p-0">
                        {{ __('Выход') }}
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="inline-flex items-center text-lg font-normal text-white hover:text-gray-200 transition-colors">
                    {{ __('Войти') }}
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center text-lg font-normal text-white hover:text-gray-200 transition-colors">
                    {{ __('Зарегистрироваться') }}
                </a>
                @endauth
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-white hover:text-gray-200 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden border-t border-emerald-900 bg-emerald-800">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('tasks.index') }}" class="block pl-4 py-2 text-lg font-normal text-white {{ request()->routeIs('tasks.*') ? 'bg-emerald-900 border-l-4 border-white' : '' }}">
                {{ __('Задачи') }}
            </a>
            <a href="{{ route('task_statuses.index') }}" class="block pl-4 py-2 text-lg font-normal text-white {{ request()->routeIs('task_statuses.*') ? 'bg-emerald-900 border-l-4 border-white' : '' }}">
                {{ __('Статусы') }}
            </a>
            <a href="{{ route('labels.index') }}" class="block pl-4 py-2 text-lg font-normal text-white {{ request()->routeIs('labels.*') ? 'bg-emerald-900 border-l-4 border-white' : '' }}">
                {{ __('Метки') }}
            </a>
        </div>
    </div>
</nav>