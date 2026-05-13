<x-app-layout>
    <h2>{{ __('Метки') }}</h2>

    @auth
    <div>
        <a href="{{ route('labels.create') }}">{{ __('Создать метку') }}</a>
    </div>
    @endauth

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('Название') }}</th>
                <th>{{ __('Действия') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($labels as $label)
            <tr>
                <td>{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>
                    @auth
                    <a href="{{ route('labels.edit', $label) }}">{{ __('Изменить') }}</a>

                    <form action="{{ route('labels.destroy', $label) }}" method="POST">
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