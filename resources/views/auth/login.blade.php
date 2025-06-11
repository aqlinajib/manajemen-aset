<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT. Putu Abadi Sentosa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex font-sans">

    <!-- KIRI: Background Gambar dari class CSS -->
    <div class="hidden lg:flex w-1/2 login-left items-center justify-center text-white px-10">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">PT. PUTU ABADI SENTOSA</h1>
            <p class="text-xl">WAREHOUSE MANAGEMENT SYSTEM</p>
        </div>
    </div>

    <!-- KANAN: FORM LOGIN -->
    <div class="w-full lg:w-1/2 flex items-center justify-center bg-white">
        <div class="w-full max-w-md px-8">
            <!-- Avatar dan Judul -->
            <div class="flex items-center justify-center mb-6">
                <img src="https://cdn-icons-png.flaticon.com/512/5231/5231019.png" alt="Avatar"
                     class="w-16 h-16 rounded-full mr-4">
                <h2 class="text-2xl font-semibold">Hello Again!</h2>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border border-gray-300 rounded-full px-4 py-2 text-sm focus:ring focus:outline-none"
                           placeholder="User123" />
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full border border-gray-300 rounded-full px-4 py-2 text-sm focus:ring focus:outline-none"
                           placeholder="••••••" />
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-300 hover:bg-blue-400 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
