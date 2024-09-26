<x-layouts.dashboard>
    <h2 class="text-2xl font-bold mb-4 text-orange-500">Projects</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($projects as $project)
            <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-white mb-2">{{ $project->name }}</h3>
                <p class="text-gray-400 mb-4">{{ $project->description }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Created: {{ $project->created_at->diffForHumans() }}</span>
                    <a href="#" class="text-orange-500 hover:text-orange-600">View Details</a>
                </div>
            </div>
        @empty
            <p class="text-gray-400 col-span-3">No projects found.</p>
        @endforelse
    </div>
</x-layouts.dashboard>
