<x-app-layout>
    <h2>{{ __('Задачи') }}</h2>

    @auth
    <div>
        <a href="{{ route('tasks.create') }}">{{ __('Создать задачу') }}</a>
    </div>
    @endauth

    <form action="{{ route('tasks.index') }}" method="GET" style="margin-bottom: 20px; margin-top: 20px;">
        <div style="display: flex; gap: 10px;">
            <select name="filter[status_id]">
                <option value="">{{ __('Статус') }}</option>
                @foreach($taskStatuses as $status)
                <option value="{{ $status->id }}" {{ request('filter.status_id') == $status->id ? 'selected' : '' }}>
                    {{ $status->name }}
                </option>
                @endforeach
            </select>

            <select name="filter[created_by_id]">
                <option value="">{{ __('Автор') }}</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ request('filter.created_by_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>

            <select name="filter[assigned_to_id]">
                <option value="">{{ __('Исполнитель') }}</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ request('filter.assigned_to_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>

            <button type="submit">{{ __('Применить') }}</button>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Название') }}</th>
                <th>{{ __('Статус') }}</th>
                <th>{{ __('Исполнитель') }}</th>
                <th>{{ __('Автор') }}</th>
                <th>{{ __('Дата создания') }}</th>
                <th>{{ __('Действия') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>
                    <a href="{{ route('tasks.show', $task) }}">{{ $task->name }}</a>
                </td>
                <td>{{ $task->status->name }}</td>
                <td>{{ $task->executor?->name }}</td>
                <td>{{ $task->creator->name }}</td>
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