<x-app-layout>
    <h2>{{ __('Создать метку') }}</h2>

    <form action="{{ route('labels.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">{{ __('Название') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">

            @error('name')
            <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description">{{ __('Описание') }}</label>
            <textarea name="description" id="description">{{ old('description') }}</textarea>

            @error('description')
            <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit">{{ __('Создать') }}</button>
        </div>
    </form>
</x-app-layout>