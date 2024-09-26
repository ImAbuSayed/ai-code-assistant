<x-layouts.dashboard>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-800 p-6 rounded-lg shadow-md">
            <livewire:project-generator />
        </div>
        <div class="bg-gray-800 p-6 rounded-lg shadow-md">
            <livewire:file-viewer />
        </div>
        <div class="bg-gray-800 p-6 rounded-lg shadow-md md:col-span-2">
            <livewire:code-reviewer />
        </div>
        <div class="bg-gray-800 p-6 rounded-lg shadow-md md:col-span-2">
            <livewire:a-i-assistant />
        </div>
    </div>
</x-layouts.dashboard>
