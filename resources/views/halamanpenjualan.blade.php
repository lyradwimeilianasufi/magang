    <!DOCTYPE html>
    <html lang="id">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Halaman Penjualan</title>
    <style>
        :root{--primary:#0f172a;--accent:#4f46e5;--muted:#6b7280;--card:#fff}
        *{box-sizing:border-box}
        body{margin:0;font-family:Inter,Arial,Helvetica,sans-serif;background:#f3f4f6;color:#0b1220}
        header{background:var(--accent);color:white;padding:18px 20px}
        .wrap{max-width:1100px;margin:22px auto;padding:0 16px;display:grid;grid-template-columns:1fr 320px;gap:18px}
        h1{margin:0;font-size:18px}
        .controls{display:flex;gap:10px;align-items:center;margin:14px 0}
        input[type=search]{flex:1;padding:10px;border-radius:8px;border:1px solid #e6e9ef}
        select{padding:10px;border-radius:8px;border:1px solid #e6e9ef}

        .products{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:14px}
        .product{background:var(--card);padding:12px;border-radius:10px;box-shadow:0 2px 8px rgba(2,6,23,0.06);display:flex;flex-direction:column}
        .product img{width:100%;height:140px;object-fit:cover;border-radius:8px}
        .product h3{font-size:16px;margin:8px 0 6px}
        .product p{font-size:13px;color:var(--muted);margin:0 0 8px}
        .price-row{display:flex;justify-content:space-between;align-items:center;margin-top:auto}
        .price{font-weight:700}
        .btn{padding:8px 10px;border-radius:8px;border:0;cursor:pointer}
        .btn-add{background:var(--accent);color:white}

        /* cart */
        .cart{position:sticky;top:22px;background:var(--card);padding:12px;border-radius:10px;box-shadow:0 2px 8px rgba(2,6,23,0.06);height:max-content}
        .cart h2{margin:0 0 8px}
        .cart-items{max-height:360px;overflow:auto;margin-top:8px}
        .cart-item{display:flex;gap:8px;align-items:center;padding:8px;border-bottom:1px dashed #eee}
        .cart-item img{width:48px;height:48px;object-fit:cover;border-radius:6px}
        .cart-item .meta{flex:1}
        .qty{display:flex;align-items:center;gap:6px}
        .qty button{padding:6px 8px;border-radius:6px;border:1px solid #e6e9ef;background:white;cursor:pointer}
        .total-row{display:flex;justify-content:space-between;align-items:center;margin-top:10px;font-weight:700}
        .checkout{margin-top:10px;padding:10px;border-radius:8px;background:var(--accent);color:white;border:0;cursor:pointer;width:100%}
        .empty{color:var(--muted);text-align:center;padding:20px}

        footer{max-width:1100px;margin:18px auto;text-align:center;color:var(--muted);font-size:13px}

        @media(max-width:900px){
        .wrap{grid-template-columns:1fr;}
        .cart{position:static}
        }
    </style>
    </head>
    <body>
    <header>
        <h1>Simple Shop — Halaman Penjualan</h1>
    </header>

    <div class="wrap">
        <main>
        <div class="controls">
            <input id="search" type="search" placeholder="Cari produk..." />
            <select id="categoryFilter">
            <option value="all">Semua Kategori</option>
            </select>
        </div>

        <section id="products" class="products"></section>
        </main>

        <aside class="cart card">
        <h2>Keranjang</h2>
        <div id="cartItems" class="cart-items"></div>
        <div id="cartEmpty" class="empty" style="display:none">Keranjang kosong</div>
        <div class="total-row">
            <span>Total</span>
            <span id="cartTotal">Rp 0</span>
        </div>
        <button id="checkoutBtn" class="checkout">Proses Checkout</button>
        <button id="clearCart" class="btn" style="margin-top:8px;background:#f3f4f6;border:1px solid #e6e9ef;width:100%">Bersihkan Keranjang</button>
        </aside>
    </div>

    <footer>Demo penjualan — tampilan depan saja (tanpa backend). Data sementara disimpan di localStorage.</footer>

    <script>
        // contoh produk statis
        const PRODUCTS = [
        { id:'p1', name:'Kaos Bandung', price:75000, category:'Pakaian', image:'https://picsum.photos/seed/p1/400/300?grayscale' },
        { id:'p2', name:'Notebook A5', price:25000, category:'Alat Tulis', image:'https://picsum.photos/seed/p2/400/300' },
        { id:'p3', name:'Botol Minum', price:45000, category:'Aksesoris', image:'https://picsum.photos/seed/p3/400/300' },
        { id:'p4', name:'Headset', price:150000, category:'Elektronik', image:'https://picsum.photos/seed/p4/400/300' },
        { id:'p5', name:'Jaket Hoodie', price:180000, category:'Pakaian', image:'https://picsum.photos/seed/p5/400/300' },
        { id:'p6', name:'Pulpen Gel', price:8000, category:'Alat Tulis', image:'https://picsum.photos/seed/p6/400/300' }
        ];

        // state cart
        const CART_KEY = 'simple_shop_cart_v1';
        let cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');

        // elements
        const productsEl = document.getElementById('products');
        const cartItemsEl = document.getElementById('cartItems');
        const cartTotalEl = document.getElementById('cartTotal');
        const cartEmptyEl = document.getElementById('cartEmpty');
        const searchEl = document.getElementById('search');
        const categoryFilterEl = document.getElementById('categoryFilter');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const clearCartBtn = document.getElementById('clearCart');

        function formatRupiah(val){
        return 'Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function renderProducts(list){
        productsEl.innerHTML = '';
        list.forEach(p => {
            const el = document.createElement('div');
            el.className = 'product card';
            el.innerHTML = `
            <img src="${p.image}" alt="${p.name}">
            <h3>${p.name}</h3>
            <p>${p.category}</p>
            <div class="price-row">
                <div class="price">${formatRupiah(p.price)}</div>
                <button class="btn btn-add" onclick="addToCart('${p.id}')">Tambah</button>
            </div>
            `;
            productsEl.appendChild(el);
        });
        }

        function renderCart(){
        cartItemsEl.innerHTML = '';
        if(cart.length === 0){
            cartEmptyEl.style.display = 'block';
            cartItemsEl.style.display = 'none';
            cartTotalEl.textContent = formatRupiah(0);
            return;
        }
        cartEmptyEl.style.display = 'none';
        cartItemsEl.style.display = 'block';

        let total = 0;
        cart.forEach(item => {
            const p = PRODUCTS.find(x=>x.id===item.productId);
            if(!p) return;
            total += p.price * item.qty;
            const itemEl = document.createElement('div');
            itemEl.className = 'cart-item';
            itemEl.innerHTML = `
            <img src="${p.image}" alt="${p.name}">
            <div class="meta">
                <div style="font-weight:600">${p.name}</div>
                <div style="font-size:13px;color:${'--muted'}">${formatRupiah(p.price)} x ${item.qty}</div>
            </div>
            <div class="qty">
                <button onclick="changeQty('${item.productId}', -1)">-</button>
                <div>${item.qty}</div>
                <button onclick="changeQty('${item.productId}', 1)">+</button>
                <button style="margin-left:8px;background:transparent;border:none;color:#ef4444;cursor:pointer" onclick="removeFromCart('${item.productId}')">Hapus</button>
            </div>
            `;
            cartItemsEl.appendChild(itemEl);
        });
        cartTotalEl.textContent = formatRupiah(total);
        }

        function saveCart(){
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        renderCart();
        }

        function addToCart(productId){
        const idx = cart.findIndex(c => c.productId === productId);
        if(idx === -1) cart.push({productId, qty:1});
        else cart[idx].qty += 1;
        saveCart();
        alert('Produk ditambahkan ke keranjang (simulasi).');
        }

        function changeQty(productId, delta){
        const idx = cart.findIndex(c => c.productId === productId);
        if(idx === -1) return;
        cart[idx].qty += delta;
        if(cart[idx].qty <= 0) cart.splice(idx,1);
        saveCart();
        }

        function removeFromCart(productId){
        cart = cart.filter(c=>c.productId !== productId);
        saveCart();
        }

        function clearCart(){
        if(!confirm('Bersihkan keranjang?')) return;
        cart = [];
        saveCart();
        }

        function checkout(){
        if(cart.length === 0){ alert('Keranjang kosong.'); return; }
        // simulasi checkout: tampilkan ringkasan lalu bersihkan keranjang
        let summary = 'Ringkasan Pesanan:\n';
        let total = 0;
        cart.forEach(item=>{
            const p = PRODUCTS.find(x=>x.id===item.productId);
            summary += `${p.name} x ${item.qty} = ${formatRupiah(p.price * item.qty)}\n`;
            total += p.price * item.qty;
        });
        summary += `Total: ${formatRupiah(total)}\n\nLanjutkan checkout? (simulasi)`;
        if(confirm(summary)){
            alert('Pembayaran berhasil (simulasi). Terima kasih!');
            cart = [];
            saveCart();
        }
        }

        // filters & search
        function setupCategoryOptions(){
        const cats = ['all', ...new Set(PRODUCTS.map(p=>p.category))];
        categoryFilterEl.innerHTML = '';
        cats.forEach(c=>{
            const opt = document.createElement('option');
            opt.value = c;
            opt.textContent = c === 'all' ? 'Semua Kategori' : c;
            categoryFilterEl.appendChild(opt);
        });
        }

        function applyFilters(){
        const q = searchEl.value.trim().toLowerCase();
        const cat = categoryFilterEl.value;
        let filtered = PRODUCTS.filter(p=>{
            const matchesQ = !q || (p.name + ' ' + p.category).toLowerCase().includes(q);
            const matchesCat = cat === 'all' || p.category === cat;
            return matchesQ && matchesCat;
        });
        renderProducts(filtered);
        }

        // initial
        setupCategoryOptions();
        applyFilters();
        renderCart();

        // events
        searchEl.addEventListener('input', applyFilters);
        categoryFilterEl.addEventListener('change', applyFilters);
        checkoutBtn.addEventListener('click', checkout);
        clearCartBtn.addEventListener('click', clearCart);
    </script>
    </body>
    </html>