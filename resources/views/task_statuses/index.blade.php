<x-app-layout>
    <div class="w-full px-6 py-8 bg-white text-black min-h-screen">
        <h2 class="text-xl font-normal tracking-tight mb-8 text-black">{{ __('Статусы') }}</h2>

        @auth
        <div class="mb-6">
            <a href="{{ route('task_statuses.create') }}" class="inline-block text-xs uppercase tracking-wider px-4 py-2 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium transition-colors">
                {{ __('Создать статус') }}
            </a>
        </div>
        @endauth

        <div class="w-full overflow-x-auto">
            <table class="w-full table-auto text-left text-sm border border-gray-300 border-collapse">
                <thead>
                    <tr class="bg-[#faf9f6] text-sm tracking-wide text-gray-700 border-b border-gray-300">
                        <th scope="col" class="px-4 py-3 font-medium border-r border-gray-300 text-left">{{ __('ID') }}</th>
                        <th scope="col" class="px-4 py-3 font-medium border-r border-gray-300 text-left">{{ __('Название') }}</th>
                        <th scope="col" class="px-4 py-3 font-medium text-left">{{ __('Действия') }}</th>
                    </tr>
                </thead>
                <tbody class="text-black divide-y divide-gray-300">
                    @foreach ($taskStatuses as $status)
                    <tr class="hover:bg-[#faf9f6]">
                        <td class="px-4 py-4 border-r border-gray-300 text-left">{{ $status->id }}</td>
                        <td class="px-4 py-4 border-r border-gray-300 text-left">{{ $status->name }}</td>
                        <td class="px-4 py-4 text-left">
                            <div class="flex items-center gap-2 justify-start">
                                @auth
                                <a href="{{ route('task_statuses.edit', $status) }}" class="inline-block text-xs uppercase tracking-wider px-3 py-1.5 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium transition-colors">{{ __('Изменить') }}</a>

                                <form action="{{ route('task_statuses.destroy', $status) }}" method="POST" class="inline-block m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('{{ __('Вы уверены?') }}')" class="inline-block text-xs uppercase tracking-wider px-3 py-1.5 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium cursor-pointer transition-colors align-baseline text-left border-none">
                                        {{ __('Удалить') }}
                                    </button>
                                </form>
                                @endauth
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>