<div x-data="{ open: true }" x-show="open"
    class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
    <div class="fixed inset-0 bg-black opacity-50" @click="open = false"></div>

    <div class="relative w-auto my-6 mx-auto max-w-sm sm:max-w-md z-50 {{ isset($modalClass) ? $modalClass : '' }}">
        <div
            class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
            <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">{{ $title }}</h3>
                <button
                    class="p-1 ml-auto bg-transparent border-0 text-gray-400 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                    @click="open = false">&times;</button>
            </div>
            <div class="relative p-6 flex-auto">
                <p class="my-4 text-slate-500 text-sm leading-relaxed">{!! $body !!}</p>
            </div>
            <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                <button
                    class="bg-gray-500 text-white active:bg-gray-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                    type="button" @click="open = false">Close</button>
            </div>
        </div>
    </div>
</div>
