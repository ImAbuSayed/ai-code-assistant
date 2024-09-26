<x-layouts.dashboard>
    <h2 class="text-2xl font-bold mb-4 text-orange-500">Code Review History</h2>

    <div class="space-y-6">
        @forelse ($codeSnippets as $snippet)
            <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-white mb-2">{{ $snippet->language }} Code Snippet</h3>
                <pre class="bg-gray-700 p-4 rounded-md overflow-x-auto text-sm text-gray-300 mb-4"><code>{{ $snippet->code }}</code></pre>
                <h4 class="text-lg font-medium text-orange-500 mb-2">Analysis</h4>
                <p class="text-gray-400">{{ $snippet->analysis }}</p>
                <div class="mt-4 text-sm text-gray-500">Reviewed: {{ $snippet->created_at->diffForHumans() }}</div>
            </div>
        @empty
            <p class="text-gray-400">No code reviews found.</p>
        @endforelse
    </div>
</x-layouts.dashboard>
