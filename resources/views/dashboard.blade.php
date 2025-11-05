    <!DOCTYPE html>
    <html lang="id">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* ======= Gaya Umum ======= */
        body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f6f8;
        color: #333;
        }

        header {
        background-color: #4f46e5;
        color: white;
        padding: 15px 0;
        text-align: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        nav {
        display: flex;
        justify-content: center;
        background-color: #ffffff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        padding: 10px 0;
        }

        nav a {
        color: #4f46e5;
        text-decoration: none;
        margin: 0 10px;
        font-weight: bold;
        padding: 8px 15px;
        border-radius: 6px;
        transition: background-color 0.3s;
        }

        nav a:hover {
        background-color: #e0e7ff;
        }

        nav a.active {
        background-color: #4f46e5;
        color: white;
        }

        .container {
        max-width: 1000px;
        margin: 30px auto;
        padding: 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h1 {
        text-align: center;
        color: #4f46e5;
        }

        p {
        text-align: center;
        color: #555;
        }
    </style>
    </head>
    <body>

    <header>
        <h1>Dashboard</h1>
    </header>

    <nav>
        <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
        <a href="{{ route('halamanprofil') }}">Profil</a>
        <a href="{{ route('halamanpencatatan') }}">Pencatatan</a>
        <a href="{{ route('halamanlaporan') }}">Pelaporan</a>
        <a href="{{ route('halamanpenjualan') }}">Penjualan</a>
        <a href="{{ route('laporanpenjualan') }}">Laporan Penjualan</a>
    </nav>

    <div class="container">
        <h1>Selamat Datang di Dashboard!</h1>
        <p>Pilih halaman dari menu di atas untuk mulai menjelajahi sistem Anda.</p>
    </div>

    <script>
        // Tambahkan efek aktif di navbar sesuai halaman yang dibuka
        const links = document.querySelectorAll("nav a");
        links.forEach(link => {
        if (link.href === window.location.href) {
            link.classList.add("active");
        }
        });
    </script>

    </body>
    </html>
