<section class="detail-page">
    <a href="index.php" class="back-link">← Kembali ke koleksi</a>
    <div class="detail-layout">
        <div class="detail-art art-2"><span class="art-label"><?= e($product['category']) ?></span><span class="detail-emoji"><?= e($product['emoji']) ?></span><span class="art-spark art-spark-a">✦</span><span class="art-spark art-spark-b">✧</span></div>
        <div class="detail-copy">
            <div class="eyebrow"><span class="eyebrow-line"></span> CERITA DARI KEBUN KECIL</div>
            <h1><?= e($product['name']) ?></h1>
            <span class="detail-category"><?= e($product['category']) ?></span>
            <p class="detail-description"><?= e($product['description'] ?: 'Tanaman pilihan Debby Manalu, siap membawa suasana segar ke rumahmu.') ?></p>
            <div class="detail-price"><?= rupiah($product['price']) ?></div>
            <div class="detail-stock"><span class="online-dot"></span> <?= e($product['stock']) ?> tersedia di kebun</div>
            <div class="detail-actions"><a class="button button-primary" href="index.php?action=edit&id=<?= e($product['id']) ?>">✎ Edit tanaman</a>
                <form method="post" action="index.php?action=delete&id=<?= e($product['id']) ?>" data-confirm="Hapus <?= e($product['name']) ?> dari koleksi?">
                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>"><button class="button button-delete" type="submit">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    <div class="detail-footnote">Dirawat sepenuh hati, tumbuh bersama. <span>♡</span></div>
</section>
