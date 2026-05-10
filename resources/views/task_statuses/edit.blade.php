<x-app-layout>
    <h2>{{ __('Изменить статус') }}</h2>

    <form action="{{ route('task_statuses.update', $taskStatus) }}" method="POST">
        @csrf

        @method('PATCH')

        <div>
            <label for="name">{{ __('Имя') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name', $taskStatus->name) }}">
            
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit">{{ __('Обновить') }}</button>
        </div>
    </form>
</x-app-layout>
