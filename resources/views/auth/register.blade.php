<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Register</h2>
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700">Nama</label>
                <input type="text" name="users_name" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-400">
            </div>
            <div>
                <label class="block text-gray-700">Email</label>
                <input type="email" name="users_email" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-400">
            </div>
            <div>
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-400">
            </div>
            <div>
                <label class="block text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-400">
            </div>
            <button type="submit"
                class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition">Daftar</button>
        </form>
        <p class="mt-4 text-sm text-center">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
        </p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('already_logged_in'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Sudah login!',
                text: '{{ session('already_logged_in') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

</body>

</html>
