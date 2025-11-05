    <!DOCTYPE html>
    <html lang="id">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Pelaporan</title>
    <style>
        body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f5f6fa;
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
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
        font-weight: bold;
        color: #555;
        margin-top: 10px;
        }
        input, select, textarea {
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-top: 5px;
        font-size: 14px;
        }
        textarea {
        resize: none;
        height: 100px;
        }
        button {
        background-color: #4f46e5;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 12px;
        font-size: 14px;
        margin-top: 20px;
        cursor: pointer;
        }
        button:hover {
        background-color: #3730a3;
        }
        .report-list {
        margin-top: 40px;
        }
        .report-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #fafafa;
        }
        .report-card h4 {
        margin: 0 0 5px;
        color: #4f46e5;
        }
        .report-card p {
        margin: 5px 0;
        }
        .no-data {
        text-align: center;
        color: #999;
        margin-top: 20px;
        }
    </style>
    </head>
    <body>
    <header>
        <h1>Halaman Pelaporan</h1>
    </header>

    <div class="container">
        <h2>Formulir Pelaporan</h2>
        <form id="reportForm">
        <label for="reportTitle">Judul Laporan</label>
        <input type="text" id="reportTitle" placeholder="Masukkan judul laporan" required>

        <label for="reportCategory">Kategori</label>
        <select id="reportCategory">
            <option value="Umum">Umum</option>
            <option value="Keuangan">Keuangan</option>
            <option value="Kegiatan">Kegiatan</option>
            <option value="Lainnya">Lainnya</option>
        </select>

        <label for="reportContent">Isi Laporan</label>
        <textarea id="reportContent" placeholder="Tuliskan laporan Anda di sini" required></textarea>

        <button type="submit">Kirim Laporan</button>
        </form>

        <div class="report-list" id="reportList">
        <h2>Daftar Laporan</h2>
        <div class="no-data" id="noDataMsg">Belum ada laporan.</div>
        </div>
    </div>

    <script>
        const form = document.getElementById('reportForm');
        const reportList = document.getElementById('reportList');
        const noDataMsg = document.getElementById('noDataMsg');

        let reports = JSON.parse(localStorage.getItem('reports')) || [];

        function displayReports() {
        const listContainer = document.createElement('div');
        listContainer.innerHTML = '';
        reportList.innerHTML = '<h2>Daftar Laporan</h2>';

        if (reports.length === 0) {
            noDataMsg.style.display = 'block';
            return;
        }
        noDataMsg.style.display = 'none';

        reports.forEach((report, index) => {
            const card = document.createElement('div');
            card.className = 'report-card';
            card.innerHTML = `
            <h4>${report.title}</h4>
            <p><strong>Kategori:</strong> ${report.category}</p>
            <p>${report.content}</p>
            <button onclick="deleteReport(${index})">Hapus</button>
            `;
            reportList.appendChild(card);
        });
        }

        form.addEventListener('submit', (e) => {
        e.preventDefault();
        const title = document.getElementById('reportTitle').value.trim();
        const category = document.getElementById('reportCategory').value;
        const content = document.getElementById('reportContent').value.trim();

        if (!title || !content) {
            alert('Judul dan isi laporan wajib diisi.');
            return;
        }

        const newReport = { title, category, content, date: new Date().toLocaleString() };
        reports.push(newReport);
        localStorage.setItem('reports', JSON.stringify(reports));

        form.reset();
        displayReports();
        });

        function deleteReport(index) {
        if (confirm('Yakin ingin menghapus laporan ini?')) {
            reports.splice(index, 1);
            localStorage.setItem('reports', JSON.stringify(reports));
            displayReports();
        }
        }

        displayReports();
    </script>
    </body>
    </html>