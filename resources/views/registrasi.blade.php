    <!DOCTYPE html>
    <html lang="id">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col md:flex-row w-full max-w-5xl">
        
        <!-- BAGIAN KIRI: FORM REGISTRASI -->
        <div class="w-full md:w-1/2 p-8">
        <h2 class="text-3xl font-bold text-blue-600 text-center mb-6">REGISTER</h2>

        <form class="space-y-5">
            <div>
            <label class="block text-gray-700 text-sm font-semibold mb-1">Username</label>
            <input type="text" placeholder="Masukkan username"
                    class="w-full border border-blue-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
            <label class="block text-gray-700 text-sm font-semibold mb-1">Email</label>
            <input type="email" placeholder="Masukkan email"
                    class="w-full border border-blue-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
            <label class="block text-gray-700 text-sm font-semibold mb-1">Password</label>
            <div class="flex items-center border border-blue-300 rounded-lg overflow-hidden">
                <input type="password" placeholder="Masukkan password"
                    class="w-full py-2 px-3 focus:outline-none">
                <button type="button" class="px-3 text-blue-500 hover:text-blue-700">
                👁
                </button>
            </div>
            </div>

            <button type="button"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg transition">
            Register
            </button>
        </form>

        <p class="text-center text-gray-600 text-sm mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login di sini</a>
        </p>
        </div>

        <!-- BAGIAN KANAN: GAMBAR DOKTER -->
        <div class="hidden md:flex w-full md:w-1/2 items-center justify-center bg-gradient-to-r from-blue-500 to-blue-300">
        <img src="{{ asset('image/dokter.png') }}" alt="Gambar Dokter" class="max-w-sm w-full">
        </div>

    </div>

    </body>
    </html>
