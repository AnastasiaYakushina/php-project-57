<x-app-layout>
    <h2>{{ __('Изменить метку') }}</h2>

    <form action="{{ route('labels.update', $label) }}" method="POST">
        @csrf

        @method('PATCH')

        <div>
            <label for="name">{{ __('Название') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name', $label->name) }}">

            @error('name')
            <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description">{{ __('Описание') }}</label>
            <textarea name="description" id="description">{{ old('description', $label->description) }}</textarea>

            @error('description')
            <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit">{{ __('Обновить') }}</button>
        </div>
    </form>
</x-app-layout>