<x-app-layout>
    <div class="w-full px-6 py-8 bg-white text-black min-h-screen">
        <h2 class="text-xl font-normal tracking-tight mb-8 text-black">{{ __('Задачи') }}</h2>

        @auth
        <div class="mb-6">
            <a href="{{ route('tasks.create') }}" class="inline-block text-xs uppercase tracking-wider px-4 py-2 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium transition-colors">
                {{ __('Создать задачу') }}
            </a>
        </div>
        @endauth

        {{ html()->form('GET', route('tasks.index'))->class('w-full')->open() }}
        <div class="flex flex-wrap items-center gap-6 mb-8 pb-6 border-b border-gray-100 w-full">
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">{{ __('Статус') }}:</span>
                {{ html()->select('filter[status_id]', $taskStatuses->pluck('name', 'id'))
                        ->placeholder(__('Все'))
                        ->value(request('filter.status_id'))
                        ->class('text-sm bg-transparent border-none p-0 pr-6 focus:ring-0 text-black cursor-pointer') }}
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">{{ __('Автор') }}:</span>
                {{ html()->select('filter[created_by_id]', $users->pluck('name', 'id'))
                        ->placeholder(__('Все'))
                        ->value(request('filter.created_by_id'))
                        ->class('text-sm bg-transparent border-none p-0 pr-6 focus:ring-0 text-black cursor-pointer') }}
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">{{ __('Исполнитель') }}:</span>
                {{ html()->select('filter[assigned_to_id]', $users->pluck('name', 'id'))
                        ->placeholder(__('Все'))
                        ->value(request('filter.assigned_to_id'))
                        ->class('text-sm bg-transparent border-none p-0 pr-6 focus:ring-0 text-black cursor-pointer') }}
            </div>

            <button type="submit" class="text-xs uppercase tracking-wider px-4 py-2 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium cursor-pointer transition-colors">
                {{ __('Применить') }}
            </button>
        </div>
        {{ html()->form()->close() }}

        <div class="w-full overflow-x-auto">
            <table class="w-full table-auto text-left text-sm border border-gray-300 border-collapse">
                <thead>
                    <tr class="bg-[#faf9f6] text-sm tracking-wide text-gray-700 border-b border-gray-300">
                        <th scope="col" class="px-4 py-3 font-medium border-r border-gray-300 text-left">{{ __('ID') }}</th>
                        <th scope="col" class="px-4 py-3 font-medium border-r border-gray-300 text-left">{{ __('Название') }}</th>
                        <th scope="col" class="px-4 py-3 font-medium border-r border-gray-300 text-left">{{ __('Статус') }}</th>
                        <th scope="col" class="px-4 py-3 font-medium border-r border-gray-300 text-left">{{ __('Исполнитель') }}</th>
                        <th scope="col" class="px-4 py-3 font-medium border-r border-gray-300 text-left">{{ __('Автор') }}</th>
                        <th scope="col" class="px-4 py-3 font-medium border-r border-gray-300 text-left">{{ __('Дата создания') }}</th>
                        <th scope="col" class="px-4 py-3 font-medium text-left">{{ __('Действия') }}</th>
                    </tr>
                </thead>
                <tbody class="text-black divide-y divide-gray-300">
                    @foreach ($tasks as $task)
                    <tr class="hover:bg-[#faf9f6]">
                        <td class="px-4 py-4 border-r border-gray-300 text-left">{{ $task->id }}</td>
                        <td class="px-4 py-4 border-r border-gray-300 text-left">
                            <a href="{{ route('tasks.show', $task) }}" class="hover:underline">{{ $task->name }}</a>
                        </td>
                        <td class="px-4 py-4 border-r border-gray-300 text-left">{{ $task->status->name }}</td>
                        <td class="px-4 py-4 border-r border-gray-300 text-left">{{ $task->executor?->name ?? '—' }}</td>
                        <td class="px-4 py-4 border-r border-gray-300 text-left">{{ $task->creator->name }}</td>
                        <td class="px-4 py-4 border-r border-gray-300 text-left">{{ $task->created_at->format('d.m.Y') }}</td>

                        <td class="px-4 py-4 text-left">
                            <div class="flex items-center gap-2 justify-start">
                                @auth
                                <a href="{{ route('tasks.edit', $task) }}" class="inline-block text-xs uppercase tracking-wider px-3 py-1.5 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium transition-colors">{{ __('Изменить') }}</a>

                                @can('delete', $task)
                                <form id="delete-task-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <a href="{{ route('tasks.destroy', $task) }}"
                                    onclick="event.preventDefault(); if(confirm('{{ __('Вы уверены?') }}')) { document.getElementById('delete-task-form-{{ $task->id }}').submit(); }"
                                    class="inline-block text-xs uppercase tracking-wider px-3 py-1.5 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium cursor-pointer transition-colors">
                                    {{ __('Удалить') }}
                                </a>
                                @endcan
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