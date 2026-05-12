<x-app-layout>
    <h2>{{ __('Задачи') }}</h2>

    @auth
    <div>
        <a href="{{ route('tasks.create') }}">{{ __('Создать задачу') }}</a>
    </div>
    @endauth

    <table>
        <thead>
            <tr>
                <th>{{ __('Название') }}</th>
                <th>{{ __('Статус') }}</th>
                <th>{{ __('Исполнитель') }}</th>
                <th>{{ __('Дата создания') }}</th>
                <th>{{ __('Действия') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>
                    <a href="{{ route('tasks.show', $task) }}">{{ $task->name }}</a>
                </td>
                <td>{{ $task->status->name }}</td>
                <td>{{ $task->executor?->name }}</td>
                <td>{{ $task->created_at->format('d.m.Y') }}</td>
                <td>
                    @auth
                    <a href="{{ route('tasks.edit', $task) }}">{{ __('Изменить') }}</a>

                    @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('{{ __('Вы уверены?') }}')">
                            {{ __('Удалить') }}
                        </button>
                    </form>
                    @endcan

                    @endauth
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>