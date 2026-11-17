<section class="welcome-row">
    <div>
        <div class="eyebrow"><span class="eyebrow-line"></span> SENIN YANG CERAH, SI PECINTA TANAMAN!</div>
        <h1>Semua tumbuh<br><em>dengan indah.</em></h1>
        <p class="page-lead">Atur koleksi tanaman favoritmu di satu tempat yang nyaman.</p>
    </div>
    <div class="sunny-plant" aria-hidden="true"><span class="sunny-sun"></span><span class="sunny-pot">🪴</span><span class="sparkle sparkle-one">✦</span><span class="sparkle sparkle-two">✧</span></div>
</section>

<section class="stats-grid" aria-label="Ringkasan inventaris">
    <article class="stat-card stat-pink"><span class="stat-icon">🌱</span><span class="stat-label">JENIS TANAMAN</span><strong><?= e($summary['products']) ?></strong><span class="stat-foot">koleksi aktif</span><span class="stat-watermark">✿</span></article>
    <article class="stat-card stat-cream"><span class="stat-icon">🧺</span><span class="stat-label">TOTAL STOK</span><strong><?= e($summary['stock']) ?></strong><span class="stat-foot">siap menemani rumahmu</span><span class="stat-watermark">〰</span></article>
    <article class="stat-card stat-lilac"><span class="stat-icon">🪴</span><span class="stat-label">KATEGORI</span><strong><?= e($summary['categories']) ?></strong><span class="stat-foot">sudut untuk setiap suasana</span><span class="stat-watermark">❀</span></article>
</section>

<section class="collection-section">
    <div class="section-heading">
        <div><div class="eyebrow small-eyebrow">PILIHAN HARI INI <span>✧</span></div><h2>Koleksi tanaman</h2><p>Setiap tanaman punya cerita kecilnya sendiri.</p></div>
        <a href="index.php?action=create" class="button button-primary"><span>＋</span> Tambah koleksi</a>
    </div>
    <form class="filter-bar" action="index.php" method="get">
        <label class="search-box"><span>⌕</span><input type="search" name="q" value="<?= e($search) ?>" placeholder="Cari nama tanaman..." aria-label="Cari nama tanaman"></label>
        <label class="category-select"><span class="sr-only">Pilih kategori</span><select name="category"><option value="">Semua kategori</option><?php foreach ($categories as $category): ?><option value="<?= e($category) ?>" <?= $selectedCategory === $category ? 'selected' : '' ?>><?= e($category) ?></option><?php endforeach; ?></select><span class="select-chevron">⌄</span></label>
        <button class="button button-filter" type="submit">Terapkan</button>
        <?php if ($search !== '' || $selectedCategory !== ''): ?><a class="clear-filter" href="index.php">Reset</a><?php endif; ?>
    </form>

    <?php if ($products === []): ?>
        <div class="empty-state"><span>🌷</span><h3>Belum ada yang cocok</h3><p>Coba kata kunci lain atau tambahkan tanaman baru ke koleksimu.</p><a class="button button-primary" href="index.php?action=create">Tambah tanaman</a></div>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($products as $index => $product): ?>
                <article class="product-card">
                    <a class="product-art art-<?= $index % 5 ?>" href="index.php?action=show&id=<?= e($product['id']) ?>" aria-label="Lihat <?= e($product['name']) ?>">
                        <span class="art-label"><?= e($product['category']) ?></span><span class="art-plant"><?= e($product['emoji']) ?></span>
                        <span class="art-spark art-spark-a">✦</span><span class="art-spark art-spark-b">✧</span><span class="art-leaf">⌁</span>
                    </a>
                    <div class="product-info">
                        <div class="product-title-line"><h3><?= e($product['name']) ?></h3><span class="stock-pill <?= (int) $product['stock'] < 5 ? 'stock-low' : '' ?>"><?= e($product['stock']) ?> stok</span></div>
                        <p><?= e($product['category']) ?></p>
                        <div class="product-bottom"><strong><?= rupiah($product['price']) ?></strong><a class="text-link" href="index.php?action=show&id=<?= e($product['id']) ?>">Detail <span>→</span></a></div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="collection-count">Menampilkan <strong><?= count($products) ?></strong> tanaman <span>·</span> semoga tumbuh subur!</div>
    <?php endif; ?>
</section>
