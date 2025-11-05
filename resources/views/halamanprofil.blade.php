    <!DOCTYPE html>
    <html lang="id">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Profil</title>
    <style>
        body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f6f8;
        color: #333;
        }
        header {
        background-color: #4f46e5;
        color: white;
        text-align: center;
        padding: 20px 0;
        }
        .container {
        max-width: 800px;
        margin: 40px auto;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 30px;
        }
        .profile-header {
        display: flex;
        align-items: center;
        flex-direction: column;
        }
        .profile-header img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #4f46e5;
        }
        .profile-header h2 {
        margin-top: 15px;
        font-size: 22px;
        }
        .profile-header p {
        color: #777;
        font-size: 14px;
        }
        .info-section {
        margin-top: 30px;
        }
        .info-item {
        margin-bottom: 15px;
        }
        .info-item label {
        font-weight: bold;
        display: block;
        color: #555;
        margin-bottom: 5px;
        }
        .info-item span {
        color: #333;
        font-size: 15px;
        }
        .edit-btn {
        display: inline-block;
        background-color: #4f46e5;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        margin-top: 20px;
        }
        .edit-btn:hover {
        background-color: #3730a3;
        }
        .social-links {
        margin-top: 25px;
        text-align: center;
        }
        .social-links a {
        text-decoration: none;
        margin: 0 10px;
        color: #4f46e5;
        font-weight: bold;
        }
        .social-links a:hover {
        text-decoration: underline;
        }
    </style>
    </head>
    <body>
    <header>
        <h1>Profil Pengguna</h1>
    </header>

    <div class="container">
        <div class="profile-header">
        <img id="profile-image" src="https://via.placeholder.com/120" alt="Foto Profil" />
        <h2 id="profile-name">Alya Putri</h2>
        <p id="profile-role">Mahasiswa RPL</p>
        </div>

        <div class="info-section">
        <div class="info-item">
            <label>Email:</label>
            <span id="profile-email">alya.putri@example.com</span>
        </div>
        <div class="info-item">
            <label>No. Telepon:</label>
            <span id="profile-phone">0812-3456-7890</span>
        </div>
        <div class="info-item">
            <label>Alamat:</label>
            <span id="profile-address">Jl. Merpati No. 45, Bandung</span>
        </div>
        <div class="info-item">
            <label>Tentang Saya:</label>
            <span id="profile-about">Saya adalah mahasiswa yang antusias belajar tentang pengembangan web dan desain UI/UX.</span>
        </div>
        </div>

        <a href="{{ route ('editprofil') }}" class="edit-btn">Edit Profil</a>

        <div class="social-links">
        <a href="#">Instagram</a>
        <a href="#">LinkedIn</a>
        <a href="#">GitHub</a>
        </div>
    </div>


    </body>
    </html>