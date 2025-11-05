    <!DOCTYPE html>
    <html lang="id">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Halaman Pencatatan</title>
    <style>
        :root{
        --primary:#4f46e5;
        --muted:#6b7280;
        --bg:#f4f6f8;
        --card:#ffffff;
        }
        *{box-sizing:border-box}
        body{margin:0;font-family:Inter,Segoe UI,Arial;background:var(--bg);color:#111}
        header{background:var(--primary);color:#fff;padding:18px 20px}
        header h1{margin:0;font-size:20px}
        .wrap{max-width:980px;margin:24px auto;padding:0 16px}

        .toolbar{display:flex;gap:12px;align-items:center;flex-wrap:wrap;margin-bottom:18px}
        .card{background:var(--card);border-radius:10px;padding:16px;box-shadow:0 2px 8px rgba(15,23,42,0.06)}

        .note-form{display:grid;grid-template-columns:1fr auto;gap:12px}
        .note-form .fields{display:grid;gap:8px}
        input[type=text],textarea,select{width:100%;padding:10px;border:1px solid #e6e9ef;border-radius:8px;font-size:14px}
        textarea{min-height:92px;resize:vertical}

        .btn{border:0;padding:10px 12px;border-radius:8px;cursor:pointer;font-weight:600}
        .btn-primary{background:var(--primary);color:#fff}
        .btn-ghost{background:transparent;border:1px solid #e6e9ef;color:var(--muted)}

        .controls{display:flex;gap:8px;margin-left:auto}
        .search{flex:1;min-width:180px}

        .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px;margin-top:16px}
        .note{padding:12px;border-radius:10px;background:linear-gradient(180deg,#fff,#fbfdff);position:relative}
        .note h3{margin:0 0 6px;font-size:16px}
        .note p{margin:0 0 8px;color:var(--muted);white-space:pre-wrap}
        .note small{display:block;color:#9ca3af}

        .note .meta{display:flex;gap:8px;align-items:center;margin-top:10px}
        .note .meta button{padding:6px 8px;font-size:13px}

        .empty{padding:30px;text-align:center;color:var(--muted)}

        /* responsive */
        @media (max-width:600px){
        .note-form{grid-template-columns:1fr}
        .controls{width:100%}
        }
    </style>
    </head>
    <body>
    <header>
        <h1>Halaman Pencatatan — Catatan Harian</h1>
    </header>

    <div class="wrap">
        <div class="card toolbar">
        <form id="noteForm" class="note-form" onsubmit="return false">
            <div class="fields">
            <input id="title" type="text" placeholder="Judul catatan (contoh: Belanja)" />
            <textarea id="content" placeholder="Tulis detail catatan di sini..."></textarea>
            <select id="tag">
                <option value="Umum">Umum</option>
                <option value="Kerja">Kerja</option>
                <option value="Pribadi">Pribadi</option>
                <option value="Belanja">Belanja</option>
            </select>
            </div>

            <div style="display:flex;flex-direction:column;gap:8px;align-items:flex-end">
            <div style="display:flex;gap:8px">
                <button id="saveBtn" class="btn btn-primary">Tambah / Simpan</button>
                <button id="clearForm" class="btn btn-ghost" type="button">Bersihkan</button>
            </div>
            <small style="color:var(--muted)">Catatan disimpan di browser (localStorage).</small>
            </div>
        </form>

        <div class="controls">
            <input id="search" class="search" type="text" placeholder="Cari catatan..." />
            <button id="exportBtn" class="btn btn-ghost">Ekspor (JSON)</button>
            <input id="importFile" type="file" accept="application/json" style="display:none" />
            <button id="importBtn" class="btn btn-ghost">Impor</button>
            <button id="clearAll" class="btn btn-ghost">Hapus Semua</button>
        </div>
        </div>

        <div id="notesArea" class="grid"></div>
        <div id="emptyState" class="empty" style="display:none">Belum ada catatan. Tambahkan catatan baru di atas.</div>
    </div>

    <script>
        // Simple front-end note app using localStorage (no backend)
        const STORAGE_KEY = 'simple_notes_v1';
        let notes = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
        let editId = null;

        const noteForm = document.getElementById('noteForm');
        const titleEl = document.getElementById('title');
        const contentEl = document.getElementById('content');
        const tagEl = document.getElementById('tag');
        const saveBtn = document.getElementById('saveBtn');
        const clearFormBtn = document.getElementById('clearForm');
        const notesArea = document.getElementById('notesArea');
        const emptyState = document.getElementById('emptyState');
        const searchEl = document.getElementById('search');
        const exportBtn = document.getElementById('exportBtn');
        const importBtn = document.getElementById('importBtn');
        const importFile = document.getElementById('importFile');
        const clearAllBtn = document.getElementById('clearAll');

        function saveNotes() { localStorage.setItem(STORAGE_KEY, JSON.stringify(notes)); }

        function renderNotes(filter = ''){
        notesArea.innerHTML = '';
        const filtered = notes.filter(n => {
            const q = filter.trim().toLowerCase();
            if(!q) return true;
            return (n.title + ' ' + n.content + ' ' + n.tag).toLowerCase().includes(q);
        });

        if(filtered.length === 0){
            emptyState.style.display = 'block';
            notesArea.style.display = 'none';
            return;
        }
        emptyState.style.display = 'none';
        notesArea.style.display = 'grid';

        filtered.sort((a,b)=>b.updatedAt - a.updatedAt);

        filtered.forEach(n => {
            const el = document.createElement('div');
            el.className = 'note card';
            const time = new Date(n.updatedAt).toLocaleString();
            el.innerHTML = `
            <h3>${escapeHtml(n.title || '(Tanpa judul)')}</h3>
            <p>${escapeHtml(n.content)}</p>
            <small>${escapeHtml(n.tag)} • ${time}</small>
            <div class="meta">
                <button class="btn btn-ghost" onclick="startEdit('${n.id}')">Edit</button>
                <button class="btn btn-ghost" onclick="deleteNote('${n.id}')">Hapus</button>
            </div>
            `;
            notesArea.appendChild(el);
        });
        }

        function escapeHtml(str){
        if(!str) return '';
        return str.replace(/[&<>\"']/g, function(m){
            return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]);
        });
        }

        function uid(){ return Date.now().toString(36) + Math.random().toString(36).slice(2,7); }

        function addOrUpdateNote(){
        const t = titleEl.value.trim();
        const c = contentEl.value.trim();
        const tag = tagEl.value;
        if(!t && !c){
            alert('Judul atau konten harus diisi.');
            return;
        }

        if(editId){
            const idx = notes.findIndex(x=>x.id===editId);
            if(idx>-1){
            notes[idx].title = t;
            notes[idx].content = c;
            notes[idx].tag = tag;
            notes[idx].updatedAt = Date.now();
            alert('Perubahan disimpan (simulasi - lokal).');
            }
            editId = null;
        } else {
            notes.push({id:uid(),title:t,content:c,tag,createdAt:Date.now(),updatedAt:Date.now()});
            alert('Catatan ditambahkan.');
        }

        saveNotes();
        clearForm();
        renderNotes(searchEl.value);
        }

        function startEdit(id){
        const n = notes.find(x=>x.id===id);
        if(!n) return;
        editId = id;
        titleEl.value = n.title;
        contentEl.value = n.content;
        tagEl.value = n.tag;
        window.scrollTo({top:0,behavior:'smooth'});
        saveBtn.textContent = 'Simpan Perubahan';
        }

        function deleteNote(id){
        if(!confirm('Hapus catatan ini?')) return;
        notes = notes.filter(x=>x.id!==id);
        saveNotes();
        renderNotes(searchEl.value);
        }

        function clearForm(){
        editId = null;
        titleEl.value = '';
        contentEl.value = '';
        tagEl.value = 'Umum';
        saveBtn.textContent = 'Tambah / Simpan';
        }

        function exportNotes(){
        const data = JSON.stringify(notes, null, 2);
        const blob = new Blob([data],{type:'application/json'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url; a.download = 'catatan.json'; a.click();
        URL.revokeObjectURL(url);
        }

        function importNotes(file){
        const reader = new FileReader();
        reader.onload = function(e){
            try{
            const imported = JSON.parse(e.target.result);
            if(!Array.isArray(imported)) throw new Error('Format tidak valid');
            // merge but ensure unique ids
            const existingIds = new Set(notes.map(n=>n.id));
            imported.forEach(it => {
                if(!it.id) it.id = uid();
                if(existingIds.has(it.id)) it.id = uid();
                notes.push(it);
            });
            saveNotes();
            renderNotes(searchEl.value);
            alert('Impor selesai.');
            }catch(err){
            alert('Gagal mengimpor: ' + err.message);
            }
        };
        reader.readAsText(file);
        }

        // events
        saveBtn.addEventListener('click', addOrUpdateNote);
        clearFormBtn.addEventListener('click', clearForm);
        searchEl.addEventListener('input', ()=>renderNotes(searchEl.value));
        exportBtn.addEventListener('click', exportNotes);
        importBtn.addEventListener('click', ()=>importFile.click());
        importFile.addEventListener('change', ()=>{
        const f = importFile.files[0]; if(f) importNotes(f); importFile.value='';
        });
        clearAllBtn.addEventListener('click', ()=>{
        if(!confirm('Hapus semua catatan?')) return; notes=[]; saveNotes(); renderNotes();
        });

        // initial render
        renderNotes();
    </script>
    </body>
    </html>