<x-app-layout>
    <h2>{{ __('Изменить задачу') }}</h2>

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PATCH')

        <div>
            <label for="name">{{ __('Название') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name', $task->name) }}">

            @error('name')
            <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description">{{ __('Описание') }}</label>
            <textarea name="description" id="description">{{ old('description', $task->description) }}</textarea>

            @error('description')
            <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="status_id">{{ __('Статус') }}</label>
            <select name="status_id" id="status_id">
                <option value="">-- {{ __('Выберите статус') }} --</option>
                @foreach($taskStatuses as $status)
                <option value="{{ $status->id }}" {{ old('status_id', $task->status_id) == $status->id ? 'selected' : '' }}>
                    {{ $status->name }}
                </option>
                @endforeach
            </select>

            @error('status_id')
            <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="assigned_to_id">{{ __('Исполнитель') }}</label>
            <select name="assigned_to_id" id="assigned_to_id">
                <option value="">-- {{ __('Выберите исполнителя') }} --</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('assigned_to_id', $task->assigned_to_id) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>

            @error('assigned_to_id')
            <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit">{{ __('Обновить') }}</button>
        </div>
    </form>
</x-app-layout>