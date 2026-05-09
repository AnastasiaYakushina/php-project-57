@foreach (session('flash_notification', []) as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title' => $message['title'],
            'body' => $message['message'],
        ])
    @else
        <div x-data="{ show: true }" x-show="show"
            class="mb-4 p-4 rounded-md border flex items-center justify-between shadow-sm transition-all duration-300
                    {{ $message['level'] === 'success' ? 'bg-green-50 border-green-200 text-green-800' : '' }}
                    {{ $message['level'] === 'danger' ? 'bg-red-50 border-red-200 text-red-800' : '' }}
                    {{ $message['level'] === 'warning' ? 'bg-yellow-50 border-yellow-200 text-yellow-800' : '' }}
                    {{ $message['level'] === 'info' ? 'bg-blue-50 border-blue-200 text-blue-800' : '' }}"
            role="alert">
            <div class="flex-1 text-sm font-medium">
                {!! $message['message'] !!}
            </div>

            @if ($message['important'])
                <button type="button"
                    class="ml-3 text-current opacity-60 hover:opacity-100 transition-opacity font-bold text-lg leading-none"
                    @click="show = false" aria-label="Close">&times;</button>
            @endif
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
