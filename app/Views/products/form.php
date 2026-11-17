<?php $isEdit = $mode === 'edit'; ?>
<section class="form-page">
    <div class="form-heading">
        <a href="index.php" class="back-link">← Kembali ke koleksi</a>
        <div class="eyebrow"><span class="eyebrow-line"></span> <?= $isEdit ? 'PERBARUI DETAIL TANAMAN' : 'TANAMAN BARU, CERITA BARU' ?></div>
        <h1><?= $isEdit ? 'Rawat detailnya<br><em>agar terus tumbuh.</em>' : 'Tambahkan teman<br><em>hijau yang baru.</em>' ?></h1>
        <p class="page-lead">Lengkapi detailnya, biar semua tanaman punya tempat di kebunmu.</p>
    </div>
    <div class="form-layout">
        <form class="product-form" method="post" action="index.php?action=<?= $isEdit ? 'update&id=' . e($product['id']) : 'store' ?>">
            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
            <?php if ($errors !== []): ?><div class="form-errors" role="alert"><strong>Yuk, cek lagi:</strong><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
            <div class="form-field"><label for="name">Nama tanaman <span>*</span></label><input id="name" name="name" maxlength="100" required value="<?= e($product['name']) ?>" placeholder="Contoh: Monstera Deliciosa"></div>
            <div class="form-row">
                <div class="form-field"><label for="category">Kategori <span>*</span></label><input id="category" name="category" maxlength="60" required value="<?= e($product['category']) ?>" placeholder="Contoh: Tanaman Indoor"></div>
                <div class="form-field"><label for="emoji">Ikon tanaman</label><input id="emoji" name="emoji" maxlength="8" value="<?= e($product['emoji']) ?>" placeholder="🌿"><small>Emoji yang mewakili produkmu</small></div>
            </div>
            <div class="form-row">
                <div class="form-field"><label for="price">Harga jual <span>*</span></label><div class="input-prefix"><span>Rp</span><input id="price" type="number" name="price" min="1" step="1" required value="<?= e($product['price']) ?>" placeholder="85000"></div></div>
                <div class="form-field"><label for="stock">Jumlah stok <span>*</span></label><input id="stock" type="number" name="stock" min="0" step="1" required value="<?= e($product['stock']) ?>" placeholder="10"></div>
            </div>
            <div class="form-field"><label for="description">Cerita kecil tentang tanaman <span class="optional">(opsional)</span></label><textarea id="description" name="description" rows="4" maxlength="1000" placeholder="Ceritakan karakter dan cara merawatnya..."><?= e($product['description']) ?></textarea><small>Maksimal 1.000 karakter.</small></div>
            <div class="form-actions"><a href="index.php" class="button button-quiet">Batal</a><button type="submit" class="button button-primary"><?= $isEdit ? 'Simpan perubahan' : 'Simpan tanaman' ?> <span>→</span></button></div>
        </form>
        <aside class="form-aside"><div class="aside-flower">🌸</div><span class="aside-kicker">CATATAN KECIL</span><h3>Setiap tanaman<br>punya tempatnya.</h3><p>Informasi yang lengkap membantu kamu mengenali koleksi dan menjaga stok tetap teratur.</p><div class="aside-doodle">✿ &nbsp; ✧ &nbsp; ❀</div></aside>
    </div>
</section>
