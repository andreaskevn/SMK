@props(['user'])

<div class="bg-white shadow-md p-4 flex justify-between items-center">
    <div class="text-xl font-bold text-blue-600">
        Kursus Pemrograman Mengoding
    </div>
    <div class="text-sm text-gray-700">
        👤 {{ $user->users_name ?? 'Guest' }}
    </div>
</div>
