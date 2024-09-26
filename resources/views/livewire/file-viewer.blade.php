<div>
    <h3 class="text-lg font-medium text-orange-500 mb-4">File Content</h3>
    @if($selectedFile)
        <div class="flex justify-end mb-2">
            @if(!$isEditing)
                <button wire:click="editFile" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Edit File
                </button>
            @else
                <button wire:click="saveFile" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 mr-2">
                    Save
                </button>
                <button wire:click="cancelEdit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Cancel
                </button>
            @endif
        </div>
        @if(!$isEditing)
            <div class="bg-gray-700 rounded-md p-4 overflow-x-auto">
                <pre class="text-sm text-green-400 font-mono"><code>{{ $fileContent }}</code></pre>
            </div>
        @else
            <textarea wire:model="editedContent" rows="20" class="w-full p-2 border border-gray-600 bg-gray-700 rounded text-white"></textarea>
        @endif
    @else
        <p class="text-gray-400">Select a file to view its content</p>
    @endif
</div>
