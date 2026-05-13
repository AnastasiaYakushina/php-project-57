<x-app-layout>
    <div class="max-w-4xl mx-auto px-8 bg-white text-black min-h-screen">
        <h2 class="text-3xl font-normal tracking-tight mb-16 text-black border-b border-gray-200 pb-4">
            {{ __('Просмотр задачи') }}: {{ $task->name }}
        </h2>

        <div class="w-full overflow-x-auto mb-24">
            <table class="w-full table-auto text-left text-base border border-gray-300 border-collapse">
                <tbody class="text-black divide-y divide-gray-300">
                    <tr class="hover:bg-[#faf9f6]">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-600 bg-[#faf9f6] border-r border-gray-300 w-48">{{ __('Имя') }}</th>
                        <td class="px-6 py-4">{{ $task->name }}</td>
                    </tr>
                    <tr class="hover:bg-[#faf9f6]">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-600 bg-[#faf9f6] border-r border-gray-300">{{ __('Статус') }}</th>
                        <td class="px-6 py-4">{{ $task->status->name }}</td>
                    </tr>
                    <tr class="hover:bg-[#faf9f6]">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-600 bg-[#faf9f6] border-r border-gray-300">{{ __('Описание') }}</th>
                        <td class="px-6 py-4 whitespace-pre-line">{{ $task->description ?? '—' }}</td>
                    </tr>
                    <tr class="hover:bg-[#faf9f6]">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-600 bg-[#faf9f6] border-r border-gray-300">{{ __('Автор') }}</th>
                        <td class="px-6 py-4">{{ $task->creator->name }}</td>
                    </tr>
                    <tr class="hover:bg-[#faf9f6]">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-600 bg-[#faf9f6] border-r border-gray-300">{{ __('Исполнитель') }}</th>
                        <td class="px-6 py-4">{{ $task->executor?->name ?? '—' }}</td>
                    </tr>
                    <tr class="hover:bg-[#faf9f6]">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-600 bg-[#faf9f6] border-r border-gray-300">{{ __('Метки') }}</th>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @if($task->labels->isEmpty())
                                <span>—</span>
                                @else
                                @foreach($task->labels as $label)
                                <span>{{ $label->name }}</span>{{ !$loop->last ? ',' : '' }}
                                @endforeach
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-[#faf9f6]">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-600 bg-[#faf9f6] border-r border-gray-300">{{ __('Дата создания') }}</th>
                        <td class="px-6 py-4 font-mono text-sm">{{ $task->created_at->format('d.m.Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pt-4">
            <a href="{{ route('tasks.index') }}" class="inline-block text-sm px-6 py-4 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium transition-colors">
                {{ __('Назад к списку') }}
            </a>
        </div>
    </div>
</x-app-layout>