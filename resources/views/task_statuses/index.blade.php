<x-app-layout>
    <h2>{{ __('Статусы') }}</h2>
    
    @auth
        <div>
            <a href="{{ route('task_statuses.create') }}">{{ __('Создать статус') }}</a>
        </div>
    @endauth

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($taskStatuses as $status)
                <tr>
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->name }}</td>
                    <td>
                        @auth
                            <a href="{{ route('task_statuses.edit', $status) }}">{{ __('Изменить') }}</a>
                        
                            <form action="{{ route('task_statuses.destroy', $status) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('{{ __('Вы уверены?') }}')">
                                    {{ __('Удалить') }}
                             </button>
                            </form>
                        @endauth
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
