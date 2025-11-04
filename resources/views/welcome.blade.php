    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Landing Page Sederhana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full top-0 left-0">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-indigo-600">MyLanding</h1>
        <div class="space-x-6">
            <a href="#home" class="hover:text-indigo-600">Home</a>
            <a href="#about" class="hover:text-indigo-600">Tentang</a>
            <a href="#contact" class="hover:text-indigo-600">Kontak</a>
        </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-32 pb-20 text-center bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
        <h2 class="text-4xl font-bold mb-4">Selamat Datang di Website Kami 🎉</h2>
        <p class="text-lg mb-6">Tempat terbaik untuk belajar dan berkembang bersama teknologi modern.</p>
        <a href="#about" class="bg-white text-indigo-600 font-semibold px-6 py-3 rounded-full shadow hover:bg-indigo-100 transition">Pelajari Lebih Lanjut</a>
    </section>

    <!-- About Section -->
    <section id="about" class="max-w-5xl mx-auto px-6 py-20 text-center">
        <h3 class="text-3xl font-bold mb-6 text-indigo-600">Tentang Kami</h3>
        <p class="text-gray-700 leading-relaxed">
        Kami adalah tim pengembang muda yang bersemangat menciptakan solusi digital inovatif. 
        Fokus kami pada kesederhanaan, kecepatan, dan kemudahan penggunaan.
        </p>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="bg-gray-100 py-20 text-center">
        <h3 class="text-3xl font-bold mb-6 text-indigo-600">Hubungi Kami</h3>
        <p class="mb-4">Ingin bekerja sama? Kirim pesan kepada kami!</p>
        <a href="mailto:info@example.com" class="bg-indigo-600 text-white px-6 py-3 rounded-full shadow hover:bg-indigo-700 transition">Kirim Email</a>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-6 text-center shadow-inner">
        <p class="text-sm text-gray-500">&copy; 2025 MyLanding. All rights reserved.</p>
    </footer>
    </body>
    </html>
