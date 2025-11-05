    <!DOCTYPE html>
    <html lang="id">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profil</title>
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
        max-width: 600px;
        margin: 40px auto;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 30px;
        }
        h2 {
        text-align: center;
        margin-bottom: 20px;
        }
        form {
        display: flex;
        flex-direction: column;
        }
        label {
        margin-top: 10px;
        font-weight: bold;
        color: #555;
        }
        input, textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-top: 5px;
        font-size: 14px;
        }
        textarea {
        resize: none;
        height: 80px;
        }
        .preview-img {
        display: block;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #4f46e5;
        margin: 10px auto;
        }
        .btn {
        margin-top: 20px;
        padding: 10px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        }
        .btn-save {
        background-color: #4f46e5;
        color: white;
        }
        .btn-save:hover {
        background-color: #3730a3;
        }
        .btn-cancel {
        background-color: #ccc;
        color: #333;
        margin-top: 10px;
        }
        .btn-cancel:hover {
        background-color: #aaa;
        }
    </style>
    </head>
    <body>
    <header>
        <h1>Edit Profil</h1>
    </header>

    <div class="container">
        <h2>Formulir Edit Profil</h2>
        <form id="editProfileForm">
        <img id="previewImage" src="https://via.placeholder.com/120" alt="Preview Foto" class="preview-img">
        <label for="profileImage">Ganti Foto Profil</label>
        <input type="file" id="profileImage" accept="image/*">

        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" value="Alya Putri">

        <label for="email">Email</label>
        <input type="email" id="email" value="alya.putri@example.com">

        <label for="phone">No. Telepon</label>
        <input type="text" id="phone" value="0812-3456-7890">

        <label for="address">Alamat</label>
        <input type="text" id="address" value="Jl. Merpati No. 45, Bandung">

        <label for="about">Tentang Saya</label>
        <textarea id="about">Saya adalah mahasiswa yang antusias belajar tentang pengembangan web dan desain UI/UX.</textarea>

        <button type="button" class="btn btn-save" onclick="saveProfile()">Simpan Perubahan</button>
        <button type="button" class="btn btn-cancel" onclick="cancelEdit()">Batal</button>
        </form>
    </div>

    <script>
        const profileImage = document.getElementById('profileImage');
        const previewImage = document.getElementById('previewImage');

        profileImage.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
            previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        });

        function saveProfile() {
        alert('Data profil berhasil disimpan! (simulasi, tidak ada backend)');
        }

        function cancelEdit() {
        if (confirm('Batalkan perubahan?')) {
            window.location.href = 'profil.html'; // arahkan kembali ke halaman profil
        }
        }
    </script>
    </body>
    </html>
