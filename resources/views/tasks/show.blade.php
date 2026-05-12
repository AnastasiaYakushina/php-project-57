<x-app-layout>
    <h2>{{ __('Просмотр задачи') }}: {{ $task->name }}</h2>

    <div>
        <p><strong>{{ __('Имя') }}:</strong> {{ $task->name }}</p>

        <p><strong>{{ __('Статус') }}:</strong> {{ $task->status->name }}</p>

        <p><strong>{{ __('Описание') }}:</strong> {{ $task->description ?? __('') }}</p>

        <p><strong>{{ __('Автор') }}:</strong> {{ $task->creator->name }}</p>

        <p><strong>{{ __('Исполнитель') }}:</strong> {{ $task->executor?->name ?? '-' }}</p>

        <p><strong>{{ __('Дата создания') }}:</strong> {{ $task->created_at->format('d.m.Y') }}</p>
    </div>

    <hr>

    <div>
        <a href="{{ route('tasks.index') }}">{{ __('Назад к списку') }}</a>
    </div>
</x-app-layout>