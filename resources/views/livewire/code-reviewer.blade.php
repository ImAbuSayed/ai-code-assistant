<div>
    <h2 class="text-2xl font-bold mb-4 text-orange-500">AI Code Reviewer</h2>

    <form wire:submit.prevent="analyzeCode">
        <div class="mb-4">
            <label for="language" class="block text-sm font-medium text-gray-300">Programming Language</label>
            <select id="language" wire:model="language"
                class="mt-1 block w-full py-2 px-3 border border-gray-600 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 text-white">
                <option value="">Select a language</option>
                <option value="php">PHP</option>
                <option value="javascript">JavaScript</option>
                <option value="python">Python</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="code" class="block text-sm font-medium text-gray-300">Code</label>
            <textarea id="code" wire:model="code" rows="10"
                class="mt-1 block w-full py-2 px-3 border border-gray-600 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 text-white"></textarea>
        </div>

        <button type="submit"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
            Analyze Code
        </button>
    </form>

    @if ($analysis)
        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-300 mb-2">Analysis Result</h3>
            <div x-data="{ copySuccess: false }" class="relative">
                <button
                    @click="copyToClipboard($refs.analysisText.innerText); copySuccess = true; setTimeout(() => copySuccess = false, 2000)"
                    class="absolute top-2 right-2 text-gray-400 hover:text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </button>
                <div x-show="copySuccess" class="absolute top-2 right-10 text-green-500">Copied!</div>
                <div x-ref="analysisText" class="mt-2 p-4 bg-gray-800 rounded-md overflow-x-auto text-sm text-gray-300">
                    {!! $analysis !!}
                </div>
            </div>
        </div>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('pre code').forEach((el) => {
                hljs.highlightElement(el);
            });
        });

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text);
        }
    </script>
</div>
