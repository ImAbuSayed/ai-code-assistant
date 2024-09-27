<x-layouts.dashboard>
    <h2 class="text-2xl font-bold mb-4 text-orange-500">Code Review History</h2>

    <div class="space-y-6">
        @forelse ($codeSnippets as $snippet)
            <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-white mb-2">{{ $snippet->language }} Code Snippet</h3>
                <pre class="bg-gray-700 p-4 rounded-md overflow-x-auto text-sm text-gray-300 mb-4"><code class="language-{{ $snippet->language }}">{{ $snippet->code }}</code></pre>
                <h4 class="text-lg font-medium text-orange-500 mb-2">Analysis</h4>
                <div x-data="{ copySuccess: false }" class="relative">
                    <button
                        @click="copyToClipboard($refs.analysisText{{ $snippet->id }}.innerText); copySuccess = true; setTimeout(() => copySuccess = false, 2000)"
                        class="absolute top-2 right-2 text-gray-400 hover:text-white focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                    <div x-show="copySuccess" class="absolute top-2 right-10 text-green-500">Copied!</div>
                    <div x-ref="analysisText{{ $snippet->id }}" class="mt-2 p-4 bg-gray-800 rounded-md overflow-x-auto text-sm text-gray-300">
                        {!! $snippet->analysis !!}
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-500">Reviewed: {{ $snippet->created_at->diffForHumans() }}</div>
            </div>
        @empty
            <p class="text-gray-400">No code reviews found.</p>
        @endforelse
    </div>

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
</x-layouts.dashboard>
