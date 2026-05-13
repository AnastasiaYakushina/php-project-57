<x-app-layout>
    <div class="max-w-2xl mx-auto px-6 py-8 bg-white text-black min-h-screen">
        <h2 class="text-xl font-normal tracking-tight mb-8 text-black">{{ __('Создать статус') }}</h2>

        {{ html()->form('POST', route('task_statuses.store'))->class('space-y-6')->open() }}

        <div class="flex flex-col gap-2">
            {{ html()->label(__('Имя'), 'name')->class('text-sm font-medium text-gray-700') }}
            {{ html()->text('name')->value(old('name'))->class('w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-none focus:outline-none focus:border-emerald-800 focus:ring-0 text-black') }}

            @error('name')
            <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="pt-4">
            {{ html()->submit(__('Создать'))->class('inline-block text-xs px-4 py-2 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium cursor-pointer transition-colors border-none text-center') }}
        </div>

        {{ html()->form()->close() }}
    </div>
</x-app-layout>