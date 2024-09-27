<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Code Assistant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="bg-gray-900 text-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-900">
        <!-- Sidebar -->
        <div class="flex-shrink-0 w-64 bg-gray-800 shadow-lg">
            <div class="flex items-center justify-center h-16 bg-orange-600">
                <span class="text-white text-2xl font-semibold">AI Code Assistant</span>
            </div>
            <nav class="mt-5">
                <a class="flex items-center px-6 py-2 mt-4 text-gray-300 hover:bg-gray-700 hover:text-white"
                    href="{{ route('dashboard') }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="mx-3">Dashboard</span>
                </a>
                <a class="flex items-center px-6 py-2 mt-4 text-gray-300 hover:bg-gray-700 hover:text-white"
                    href="{{ route('projects') }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <span class="mx-3">Projects</span>
                </a>
                <a class="flex items-center px-6 py-2 mt-4 text-gray-300 hover:bg-gray-700 hover:text-white"
                    href="{{ route('code-review') }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    <span class="mx-3">Code Review</span>
                </a>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto">
            <header class="flex items-center justify-between px-6 py-4 bg-gray-800 border-b border-gray-700">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-300 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div class="flex items-center">
                    <div class="relative">
                        <button
                            class="relative z-10 block h-8 w-8 rounded-full overflow-hidden border-2 border-gray-600 focus:outline-none focus:border-white">
                            <img class="h-full w-full object-cover"
                                src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIADgAOAMBIgACEQEDEQH/xAAbAAACAwEBAQAAAAAAAAAAAAAABQQGBwMCAf/EADAQAAEDAwIEBAUEAwAAAAAAAAECAwQABREGIRIxUWETQXGBFCIykbEHYnLhI0JU/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAH/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwDPiN69AZr1w5NdW26DvCiuKW2oNoKSdysgAVa4tylLAYaiRWVtDClhGQehA5Ck+n7E9qEymWFpb+HxhxWdiRyqVJ0LqRlkpafCkjbCVcxQTpmoWmmlNPKt61K5qVGSvPZQx+KqE6YwZR+RCEq3Bb+n27ele52lL/GIU9DcWOqd6XSmTHSG3UELHMK5g0ExSPtRRbCXoxB3KDj2ooOiWcmpjUfblUhmPk8qYsxCRyoH+jDAsUNz4ySG1ynPEC1pITjAAGeXWrsH2nGwpDiSkjIIOc0ij2KJPt0JbzSFONNp4SoZH2rhdbahm1x4EZ0thxzBKTg8PmBRE24u4StSd9qxTUanhcHfHbKSpRIPkR2rRl6Lea4Ph5DnAFFS1OuFW3QdPWq3rGI3xRo6cuEOb45kYJP4opVp6MTAcdP+68D0AopvY2fEiuuNApjHh8JBH07ZP5FFQMIsbJG1Oo8P5RtUcORoTYclOJbT35n0FLLlrBKWVNW1kpURgPOeXcCqL/AkpYt44jsj5TvjFJbwqS+4x4FyYIQMFC0gqH7hypR+ncx1USc444t0NOhb6d1KCVD6/Yg59Qaa3CfBkB1Tk+O9HChwJKR08+u9Azul0SICVNqCipPMVR49qev095xtaEojkZKxkEn+s1GvepUKCmIgBSnIBSMAVf8AR9oMDTkcOgeO+PHdP7lb49hge1QJ1W9uLHSyynCEDG/nRT6bG2O1FUY7JfUpRK1FR6k5qEXeJznsKKKCxaJu6rFqKLKJ/wAC1Bp4dUKO/wBtj7VpOvdBwbmwq5WxhDcojKkNDAe74HnRRQUeBpGRDZcn3RgsssJKktE5UtQ33HkNs96r+ndcXuxJDTTyZMX/AJ5GVBP8TzT+O1fKKDQLZ+oNjuraUy1Kt0g80vboz2WNseuKKKKD/9k="
                                alt="Abu Sayed">
                        </button>
                    </div>
                </div>
            </header>
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>

</html>
