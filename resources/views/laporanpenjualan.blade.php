    <!DOCTYPE html>
    <html lang="id">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Laporan Penjualan</title>
    <style>
        :root{--accent:#4f46e5;--muted:#6b7280;--bg:#f7f8fb}
        *{box-sizing:border-box}
        body{margin:0;font-family:Inter,Arial,Helvetica,sans-serif;background:var(--bg);color:#0b1220}
        header{background:var(--accent);color:white;padding:18px 20px;text-align:center}
        .wrap{max-width:1100px;margin:22px auto;padding:16px}
        .card{background:white;border-radius:10px;padding:14px;box-shadow:0 2px 8px rgba(2,6,23,0.06)}
        .row{display:flex;gap:12px;align-items:center}
        .controls{display:flex;gap:12px;align-items:center;margin-bottom:12px;flex-wrap:wrap}
        input[type=date],input[type=number],select,input[type=text]{padding:8px;border-radius:8px;border:1px solid #e6e9ef}
        button{padding:8px 12px;border-radius:8px;border:0;background:var(--accent);color:white;cursor:pointer}
        button.ghost{background:transparent;color:var(--muted);border:1px solid #e6e9ef}
        .summary{display:flex;gap:12px;margin-top:12px}
        .summary .item{flex:1;background:linear-gradient(180deg,#fff,#fbfdff);padding:12px;border-radius:8px;text-align:center}
        .grid{display:grid;grid-template-columns:1fr 380px;gap:14px;margin-top:14px}
        canvas{width:100%;height:240px}
        table{width:100%;border-collapse:collapse;margin-top:10px}
        th,td{padding:8px;border-bottom:1px solid #f1f1f4;text-align:left}
        th{background:#fafafa;color:var(--muted)}
        .list{max-height:420px;overflow:auto}
        .form-inline{display:flex;gap:8px;align-items:center}
        @media(max-width:960px){.grid{grid-template-columns:1fr} .summary{flex-direction:column}}
    </style>
    </head>
    <body>
    <header>
        <h1>Laporan Penjualan — Dashboard</h1>
        <p style="margin:6px 0 0;opacity:.9">Hanya tampilan (HTML/CSS/JS). Data disimpan di browser.</p>
    </header>

    <div class="wrap">
        <div class="card">
        <div class="controls">
            <div class="form-inline">
            <label for="fromDate">Dari&nbsp;</label>
            <input id="fromDate" type="date">
            </div>
            <div class="form-inline">
            <label for="toDate">Sampai&nbsp;</label>
            <input id="toDate" type="date">
            </div>
            <select id="groupBy">
            <option value="day">Per Hari</option>
            <option value="month">Per Bulan</option>
            </select>

            <button id="applyBtn">Terapkan Filter</button>
            <button id="resetBtn" class="ghost">Reset</button>

            <div style="margin-left:auto;display:flex;gap:8px">
            <button id="exportCsv" class="ghost">Ekspor CSV</button>
            <button id="addSample" class="ghost">Tambah Data Contoh</button>
            <button id="clearData" class="ghost">Hapus Semua Data</button>
            </div>
        </div>

        <div class="summary" id="summary">
            <div class="item">
            <div style="font-size:13px;color:var(--muted)">Total Penjualan</div>
            <div id="totalSales" style="font-weight:700;font-size:18px">Rp 0</div>
            </div>
            <div class="item">
            <div style="font-size:13px;color:var(--muted)">Jumlah Transaksi</div>
            <div id="countSales" style="font-weight:700;font-size:18px">0</div>
            </div>
            <div class="item">
            <div style="font-size:13px;color:var(--muted)">Rata-rata / Transaksi</div>
            <div id="avgSales" style="font-weight:700;font-size:18px">Rp 0</div>
            </div>
        </div>

        <div class="grid">
            <div>
            <canvas id="salesChart"></canvas>

            <div class="card list" style="margin-top:12px">
                <table id="salesTable">
                <thead>
                    <tr><th>Tgl</th><th>Invoice</th><th>Pelanggan</th><th>Items</th><th>Jumlah</th></tr>
                </thead>
                <tbody></tbody>
                </table>
            </div>
            </div>

            <aside>
            <div class="card">
                <h3>Tambah Penjualan (simulasi)</h3>
                <div style="margin-top:8px;display:flex;flex-direction:column;gap:8px">
                <input id="saleDate" type="date">
                <input id="invoice" type="text" placeholder="Invoice (mis. INV-001)">
                <input id="customer" type="text" placeholder="Nama pelanggan">
                <input id="items" type="text" placeholder="Deskripsi item (pisah koma)">
                <input id="amount" type="number" placeholder="Jumlah (Rp)" min="0">
                <button id="addSaleBtn">Tambah Penjualan</button>
                </div>
            </div>

            <div class="card" style="margin-top:12px">
                <h3>Ringkasan Kategori</h3>
                <div id="categorySummary" style="margin-top:8px"></div>
            </div>
            </aside>
        </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Storage key
        const KEY = 'sales_report_data_v1';

        // DOM
        const fromDateEl = document.getElementById('fromDate');
        const toDateEl = document.getElementById('toDate');
        const applyBtn = document.getElementById('applyBtn');
        const resetBtn = document.getElementById('resetBtn');
        const exportCsvBtn = document.getElementById('exportCsv');
        const addSampleBtn = document.getElementById('addSample');
        const clearDataBtn = document.getElementById('clearData');
        const groupByEl = document.getElementById('groupBy');

        const totalSalesEl = document.getElementById('totalSales');
        const countSalesEl = document.getElementById('countSales');
        const avgSalesEl = document.getElementById('avgSales');
        const salesTableBody = document.querySelector('#salesTable tbody');
        const salesChartCtx = document.getElementById('salesChart').getContext('2d');
        const addSaleBtn = document.getElementById('addSaleBtn');

        const saleDateEl = document.getElementById('saleDate');
        const invoiceEl = document.getElementById('invoice');
        const customerEl = document.getElementById('customer');
        const itemsEl = document.getElementById('items');
        const amountEl = document.getElementById('amount');

        // load or init
        let sales = JSON.parse(localStorage.getItem(KEY) || '[]');

        function save(){ localStorage.setItem(KEY, JSON.stringify(sales)); }

        // sample data generator
        function addSampleData(){
        const samples = [];
        const now = new Date();
        for(let i=0;i<20;i++){
            const d = new Date(now.getFullYear(), now.getMonth(), now.getDate() - Math.floor(Math.random()*30));
            samples.push({
            id: 'S' + Date.now().toString(36) + Math.random().toString(36).slice(2,6),
            date: d.toISOString().slice(0,10),
            invoice: 'INV-' + (1000 + Math.floor(Math.random()*9000)),
            customer: ['Alya','Budi','Citra','Dewi','Eka'][Math.floor(Math.random()*5)],
            items: ['Produk A','Produk B','Produk C'].slice(0,1+Math.floor(Math.random()*3)).join(', '),
            amount: Math.floor(20000 + Math.random()*500000)
            });
        }
        sales = sales.concat(samples);
        save();
        render();
        }

        // helpers
        function formatRupiah(n){ return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g,'.'); }

        function renderTable(list){
        salesTableBody.innerHTML = '';
        list.slice().sort((a,b)=>b.date.localeCompare(a.date)).forEach(s => {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${s.date}</td><td>${s.invoice}</td><td>${escapeHtml(s.customer)}</td><td>${escapeHtml(s.items)}</td><td style="text-align:right">${formatRupiah(s.amount)}</td>`;
            salesTableBody.appendChild(tr);
        });
        }

        function escapeHtml(s){ return (s||'').toString().replace(/[&<>\"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }

        // aggregate by day or month
        function aggregate(list, groupBy){
        const map = new Map();
        list.forEach(s => {
            let key = s.date;
            if(groupBy === 'month') key = s.date.slice(0,7);
            if(!map.has(key)) map.set(key, 0);
            map.set(key, map.get(key) + s.amount);
        });
        const entries = Array.from(map.entries()).sort((a,b)=>a[0].localeCompare(b[0]));
        return {labels: entries.map(e=>e[0]), values: entries.map(e=>e[1])};
        }

        // chart
        let chart = null;
        function renderChart(labels, values){
        if(chart) chart.destroy();
        chart = new Chart(salesChartCtx, {
            type: 'line',
            data: { labels, datasets: [{ label: 'Pendapatan', data: values, fill:true, tension:0.3, borderColor:'#4f46e5', backgroundColor:'rgba(79,70,229,0.08)'}] },
            options: { responsive:true, scales:{ y:{ beginAtZero:true } } }
        });
        }

        function calcSummary(list){
        const total = list.reduce((s,x)=>s + Number(x.amount || 0),0);
        const count = list.length;
        const avg = count ? Math.round(total / count) : 0;
        totalSalesEl.textContent = formatRupiah(total);
        countSalesEl.textContent = count;
        avgSalesEl.textContent = formatRupiah(avg);
        }

        function renderCategorySummary(list){
        const map = {};
        list.forEach(s => {
            // infer category from items simple heuristic (first word)
            const cat = (s.items || 'Lainnya').split(',')[0].trim().split(' ')[0] || 'Lainnya';
            map[cat] = (map[cat] || 0) + Number(s.amount || 0);
        });
        const container = document.getElementById('categorySummary');
        container.innerHTML = '';
        Object.keys(map).sort((a,b)=>map[b]-map[a]).forEach(k=>{
            const el = document.createElement('div');
            el.style.display='flex';el.style.justifyContent='space-between';el.style.padding='6px 0';
            el.innerHTML = `<div>${escapeHtml(k)}</div><div style="font-weight:700">${formatRupiah(map[k])}</div>`;
            container.appendChild(el);
        });
        if(Object.keys(map).length===0) container.innerHTML = '<div class="no-data">Tidak ada data</div>';
        }

        // filter
        function applyFilter(){
        let list = sales.slice();
        const from = fromDateEl.value;
        const to = toDateEl.value;
        if(from) list = list.filter(s=>s.date >= from);
        if(to) list = list.filter(s=>s.date <= to);
        calcSummary(list);
        renderTable(list);
        renderCategorySummary(list);

        const agg = aggregate(list, groupByEl.value);
        renderChart(agg.labels, agg.values);
        }

        // export CSV
        function exportCSV(list){
        if(!list || list.length===0){ alert('Tidak ada data untuk diekspor'); return; }
        const headers = ['date','invoice','customer','items','amount'];
        const rows = list.map(r => headers.map(h => '"' + String(r[h]||'').replace(/"/g,'""') + '"').join(','));
        const csv = [headers.join(','), ...rows].join('\n');
        const blob = new Blob([csv],{type:'text/csv'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a'); a.href = url; a.download = 'laporan_penjualan.csv'; a.click(); URL.revokeObjectURL(url);
        }

        // add sale
        function addSale(){
        const d = saleDateEl.value || new Date().toISOString().slice(0,10);
        const invoice = invoiceEl.value.trim() || ('INV-' + Math.floor(Math.random()*9000+1000));
        const customer = customerEl.value.trim() || 'Pelanggan';
        const items = itemsEl.value.trim() || 'Produk';
        const amount = Number(amountEl.value) || 0;
        if(amount <= 0){ alert('Jumlah harus lebih dari 0'); return; }
        sales.push({ id: 'S' + Date.now().toString(36), date: d, invoice, customer, items, amount });
        save();
        saleDateEl.value = ''; invoiceEl.value=''; customerEl.value=''; itemsEl.value=''; amountEl.value='';
        applyFilter();
        }

        // events
        applyBtn.addEventListener('click', applyFilter);
        resetBtn.addEventListener('click', ()=>{ fromDateEl.value=''; toDateEl.value=''; groupByEl.value='day'; applyFilter(); });
        exportCsvBtn.addEventListener('click', ()=>{ applyFilter(); const visible = filterVisible(); exportCSV(visible); });
        addSampleBtn.addEventListener('click', addSampleData);
        clearDataBtn.addEventListener('click', ()=>{ if(confirm('Hapus semua data penjualan?')){ sales=[]; save(); applyFilter(); } });
        addSaleBtn.addEventListener('click', addSale);

        function filterVisible(){
        let list = sales.slice();
        const from = fromDateEl.value; const to = toDateEl.value;
        if(from) list = list.filter(s=>s.date >= from);
        if(to) list = list.filter(s=>s.date <= to);
        return list;
        }

        // initial render
        if(sales.length===0){
        // set default date range last 30 days
        const today = new Date();
        const past = new Date(); past.setDate(today.getDate()-30);
        fromDateEl.value = past.toISOString().slice(0,10);
        toDateEl.value = today.toISOString().slice(0,10);
        }
        applyFilter();
    </script>
    </body>
    </html>
