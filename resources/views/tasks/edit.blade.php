<x-app-layout>
    <div class="max-w-2xl mx-auto px-6 py-8 bg-white text-black min-h-screen">
        <h2 class="text-xl font-normal tracking-tight mb-8 text-black">{{ __('Изменить задачу') }}</h2>

        {{ html()->modelForm($task, 'PATCH', route('tasks.update', $task))->class('space-y-6')->open() }}

        <div class="flex flex-col gap-2">
            {{ html()->label(__('Название'), 'name')->class('text-sm font-medium text-gray-700') }}
            {{ html()->text('name')->class('w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-none focus:outline-none focus:border-emerald-800 focus:ring-0 text-black') }}

            @error('name')
            <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-2">
            {{ html()->label(__('Описание'), 'description')->class('text-sm font-medium text-gray-700') }}
            {{ html()->textarea('description')->class('w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-none focus:outline-none focus:border-emerald-800 focus:ring-0 text-black min-h-[100px]') }}

            @error('description')
            <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-2">
            {{ html()->label(__('Статус'), 'status_id')->class('text-sm font-medium text-gray-700') }}
            {{ html()->select('status_id', $taskStatuses->pluck('name', 'id'))
                    ->placeholder('-- ' . __('Выберите статус') . ' --')
                    ->class('w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-none focus:outline-none focus:border-emerald-800 focus:ring-0 text-black cursor-pointer') }}

            @error('status_id')
            <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-2">
            {{ html()->label(__('Исполнитель'), 'assigned_to_id')->class('text-sm font-medium text-gray-700') }}
            {{ html()->select('assigned_to_id', $users->pluck('name', 'id'))
                    ->placeholder('-- ' . __('Выберите исполнителя') . ' --')
                    ->class('w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-none focus:outline-none focus:border-emerald-800 focus:ring-0 text-black cursor-pointer') }}

            @error('assigned_to_id')
            <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700">{{ __('Метки') }}</span>
            <div class="grid grid-cols-2 gap-3 pt-1">
                @foreach($labels as $label)
                <label class="inline-flex items-center text-sm cursor-pointer select-none">
                    {{ html()->checkbox('labels[]', in_array($label->id, old('labels', $task->labels->pluck('id')->all())), $label->id)
                        ->class('w-4 h-4 text-emerald-800 border-gray-300 rounded-none focus:ring-0 focus:ring-offset-0 cursor-pointer') }}
                    <span class="ml-2 text-black">{{ $label->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="pt-4">
            {{ html()->submit(__('Обновить'))->class('inline-block text-xs px-4 py-2 text-white bg-emerald-800 hover:bg-emerald-900 rounded-none font-medium cursor-pointer transition-colors border-none text-center') }}
        </div>

        {{ html()->closeModelForm() }}
    </div>
</x-app-layout>