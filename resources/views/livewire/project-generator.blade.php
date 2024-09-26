<div class="bg-gray-800 shadow-xl rounded-lg p-6">
    <h2 class="text-3xl font-bold mb-6 text-orange-500">AI Project Generator</h2>

    @if ($currentStep == 'init')
        <form wire:submit.prevent="generateProject">
            <div class="mb-6">
                <label for="projectName" class="block text-sm font-medium text-gray-300">Project Name</label>
                <input type="text" id="projectName" wire:model="projectName"
                    class="mt-1 block w-full py-2 px-3 border border-gray-600 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 text-white"
                    placeholder="Enter project name">
            </div>

            <div class="mb-6">
                <label for="projectDescription" class="block text-sm font-medium text-gray-300">Project Description</label>
                <textarea id="projectDescription" wire:model="projectDescription" rows="3"
                    class="mt-1 block w-full py-2 px-3 border border-gray-600 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 text-white"
                    placeholder="Describe your project"></textarea>
            </div>

            <div class="mb-6">
                <h4 class="text-lg font-medium text-gray-300 mb-2">Project Options</h4>
                <div class="space-y-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox text-orange-600" wire:model="projectOptions.auth">
                        <span class="ml-2 text-gray-300">Authentication</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox text-orange-600" wire:model="projectOptions.api">
                        <span class="ml-2 text-gray-300">API</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox text-orange-600" wire:model="projectOptions.admin">
                        <span class="ml-2 text-gray-300">Admin Panel</span>
                    </label>
                </div>
            </div>

            <button type="submit"
                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Generate Project
            </button>
        </form>
        @else
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-300">Project: {{ $projectName }}</h3>
            <p class="text-sm text-gray-400">{{ $projectDescription }}</p>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-300">Current Step: {{ ucfirst($currentStep) }}</h3>
            <div class="mt-2 relative pt-1">
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-700">
                    <div style="width:{{ $progress }}%"
                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-orange-500 transition-all duration-500">
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-sm font-semibold inline-block text-orange-500">
                        {{ $progress }}%
                    </span>
                </div>
            </div>
        </div>

        @if ($currentFile)
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-300">Currently Generating: {{ $currentFile['path'] }}</h3>
                <div class="mt-2 p-4 bg-gray-700 rounded-md overflow-x-auto">
                    <pre class="text-sm font-mono"><code>{!! $currentFile['content'] !!}</code></pre>
                </div>
            </div>
        @endif

        @if ($downloadLink)
            <div class="mt-6">
                <a href="{{ $downloadLink }}"
                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Project
                </a>
            </div>
        @endif
    @endif
</div>
