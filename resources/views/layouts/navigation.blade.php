<nav x-data="{ open: false }" class="w-full bg-emerald-800 text-white shadow-none">
    <div class="w-full px-6">
        <div class="flex items-center justify-between h-16 relative">

            <div class="flex items-center min-w-[200px] z-10">
                <a href="{{ route('tasks.index') }}" class="text-xl font-medium tracking-tight hover:text-gray-200 transition-colors whitespace-nowrap">
                    {{ __('Менеджер задач') }}
                </a>
            </div>

            <div class="hidden sm:flex items-center justify-center absolute inset-x-0 mx-auto w-fit h-full z-0">
                <div class="flex items-center h-full space-x-2">
                    <a href="{{ route('tasks.index') }}" class="inline-flex items-center text-lg font-normal text-white border-b-2 {{ request()->routeIs('tasks.*') ? 'border-white' : 'border-transparent' }} pb-1.5 px-4 h-fit hover:text-gray-200 transition-colors mb-[-17px]">
                        {{ __('Задачи') }}
                    </a>
                    <a href="{{ route('task_statuses.index') }}" class="inline-flex items-center text-lg font-normal text-white border-b-2 {{ request()->routeIs('task_statuses.*') ? 'border-white' : 'border-transparent' }} pb-1.5 px-4 h-fit hover:text-gray-200 transition-colors mb-[-17px]">
                        {{ __('Статусы') }}
                    </a>
                    <a href="{{ route('labels.index') }}" class="inline-flex items-center text-lg font-normal text-white border-b-2 {{ request()->routeIs('labels.*') ? 'border-white' : 'border-transparent' }} pb-1.5 px-4 h-fit hover:text-gray-200 transition-colors mb-[-17px]">
                        {{ __('Метки') }}
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex items-center justify-end min-w-[200px] gap-8 z-10">
                @auth
                <!-- Дропдаун для авторизованного пользователя -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-base font-medium rounded-md text-white bg-emerald-700 hover:bg-emerald-600 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="w3.org" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Отдельная чистая форма аутентификации -->
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop">
                            @csrf
                        </form>

                        <!-- Чистая ссылка для клика Dusk -->
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                            {{ __('Выход') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
                @else
                <a href="{{ route('login') }}" class="inline-flex items-center text-lg font-normal text-white hover:text-gray-200 transition-colors whitespace-nowrap">
                    {{ __('Войти') }}
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center text-lg font-normal text-white hover:text-gray-200 transition-colors whitespace-nowrap">
                    {{ __('Зарегистрироваться') }}
                </a>
                @endauth
            </div>

            <div class="flex items-center sm:hidden z-10">
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