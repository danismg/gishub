<div>
    <x-filament::breadcrumbs :breadcrumbs="[
        '/admin/assets' => 'Assets',
        '' => 'List',
    ]" />
    <div class="flex justify-between mt-1">
        <div class="font-bold text-3xl">Assets</div>
        <div>
            {{ $data }}
        </div>
    </div>
    <div>
        <form wire:submit="save" class="w-full max-w-sm flex mt-2 flex-col h-full">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Berkas</label>
            <div class="flex items-center gap-2 w-full">
                <label for="fileInput"
                    class="cursor-pointer bg-gray-100 border border-gray-300 text-gray-700 py-2 px-12 rounded-lg flex items-center justify-center hover:bg-gray-200 w-full text-center">
                    Pilih File Excel
                </label>
                <input id="fileInput" type="file" wire:model="file" class="hidden">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Unggah
                </button>
            </div>

        </form>
    </div>
</div>
