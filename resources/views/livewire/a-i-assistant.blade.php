<div>
    <h2 class="text-2xl font-bold mb-4 text-orange-500">AI Programming Assistant</h2>

    <form wire:submit.prevent="askQuestion">
        <div class="mb-4">
            <label for="question" class="block text-sm font-medium text-gray-300">Ask a question</label>
            <textarea id="question" wire:model="question" rows="3" class="mt-1 block w-full py-2 px-3 border border-gray-600 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 text-white"></textarea>
        </div>

        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
            Ask AI
        </button>
    </form>

    @if($answer)
        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-300">AI Response</h3>
            <div class="mt-2 p-4 bg-gray-700 rounded-md">
                {!! nl2br(e($answer)) !!}
            </div>
        </div>
    @endif
</div>
