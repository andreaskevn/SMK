<div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

    <!-- Overlay Backdrop (mobile only) -->
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"></div>

    <aside :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out md:translate-x-0 md:relative md:block p-4" >
        <div class="h-full overflow-y-auto p-4 flex flex-col">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-xl font-bold text-blue-600">My App</h1>
                <button @click="sidebarOpen = false" class="md:hidden text-2xl text-gray-700">&times;</button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1">
                <ul class="space-y-2">
                    <li>
                        <a href="/dashboard"
                            class="block py-2 px-4 rounded hover:bg-blue-100 {{ request()->is('dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/guru"
                            class="block py-2 px-4 rounded hover:bg-blue-100 {{ request()->is('guru*') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                            Guru
                        </a>
                    </li>
                    <li>
                        <a href="/kelas"
                            class="block py-2 px-4 rounded hover:bg-blue-100 {{ request()->is('kelas*') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                            Kelas
                        </a>
                    </li>
                    <li>
                        <a href="/siswa"
                            class="block py-2 px-4 rounded hover:bg-blue-100 {{ request()->is('siswa*') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                            Siswa
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="w-full py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>
    </aside>


</div>
