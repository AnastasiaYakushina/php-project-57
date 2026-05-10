<x-app-layout>
    <h2>{{ __('Создать статус') }}</h2>

    <form action="{{ route('task_statuses.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">{{ __('Имя') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
            
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit">{{ __('Создать') }}</button>
        </div>
    </form>
</x-app-layout>
