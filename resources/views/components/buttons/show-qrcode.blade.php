<div x-data="{ open: false }" x-cloak>
    <button @click="open = true"
        class="transition w-full duration-100 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        QR-CODE
    </button>
    <div x-show="open" @click.away="open = false" class="fixed z-10 inset-0 overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen">
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <img src="{{ asset('qrcodes/'.$flexible->id.'.png') }}" alt="QR Code for {{ $flexible->title }}"
                        class="w-full rounded-lg shadow-md">
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="open = false">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>