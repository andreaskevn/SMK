<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-gray-100 font-sans">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        @include('components.sidebar')

        <div class="flex flex-col flex-1 w-full md:ml-0 h-screen overflow-hidden p-4">

            <header class="md:hidden bg-white shadow p-4 flex items-center justify-between">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-700 text-2xl">
                    <i data-feather="menu"></i>
                </button>
                <h1 class="text-lg font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
            </header>

            <x-headbar :user="Auth::user()" />

            <main class="flex-1 overflow-y-auto bg-white p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>

</html>
