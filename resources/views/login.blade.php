    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-400 to-sky-500">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm">
        <!-- Judul -->
        <h2 class="text-center text-2xl font-bold text-white bg-gradient-to-r from-blue-600 to-sky-400 py-3 rounded-md mb-6">
        LOGIN
        </h2>

        <!-- Form -->
        <form action="#" method="POST" class="space-y-4">
        @csrf
        <!-- Username -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">User Name</label>
            <input type="text" name="username" placeholder="Masukkan username"
            class="w-full border border-blue-400 rounded-full px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <!-- Password -->
        <div>
            <label class="block mb-1 text-gray-700 font-medium">Password</label>
            <div class="relative">
            <input type="password" id="password" name="password" placeholder="Masukkan password"
                class="w-full border border-blue-400 rounded-full px-4 py-2 pr-10 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            <button type="button" onclick="togglePassword()" 
                class="absolute inset-y-0 right-3 flex items-center text-blue-500 hover:text-blue-700">
                👁️
            </button>
            </div>
        </div>

        <!-- Tombol Login -->
        <button type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md py-2 transition">
            Login
        </button>
        </form>

        <!-- Link Register -->
        <p class="text-center text-sm text-gray-600 mt-6">
        Belum punya akun?
        <a href="/register" class="text-blue-600 font-semibold hover:underline">
            Register di sini
        </a>
        </p>
    </div>

    <!-- Script show/hide password -->
    <script>
        function togglePassword() {
        const pwd = document.getElementById("password");
        pwd.type = pwd.type === "password" ? "text" : "password";
        }
    </script>
    </body>
    </html>
