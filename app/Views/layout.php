<?php
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
function rupiah(int|string $amount): string
{
    return 'Rp' . number_format((int) $amount, 0, ',', '.');
}
$currentPage = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fff7f9">
    <title><?= e($title) ?> — Debby Manalu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="page-shell">
    <aside class="sidebar">
        <a class="brand" href="index.php" aria-label="Debby Manalu, beranda">
            <span class="brand-mark">d<span>✿</span></span>
            <span class="brand-copy"><strong>debby manalu</strong><small>Princess plant studio</small></span>
        </a>
        <div class="sidebar-caption">WORKSPACE</div>
        <nav class="side-nav" aria-label="Navigasi utama">
            <a class="nav-link <?= $currentPage === 'index.php' && !isset($_GET['action']) ? 'active' : '' ?>" href="index.php">
                <span class="nav-icon">⌂</span> Ringkasan <span class="nav-dot"></span>
            </a>
            <a class="nav-link <?= ($_GET['action'] ?? '') === 'create' ? 'active' : '' ?>" href="index.php?action=create">
                <span class="nav-icon">✿</span> Tambah tanaman
            </a>
        </nav>
        <div class="sidebar-note">
            <div class="note-illustration">🌷</div>
            <strong>Rawat dengan hati</strong>
            <p>Tanaman kecil, bahagia besar. Yuk, tumbuh bersama.</p>
        </div>
        <div class="sidebar-bottom">
            <span class="online-dot"></span>
            <span>Kebunmu siap tumbuh</span>
        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div class="breadcrumb"><span>Debby Manalu</span><span class="crumb-slash">/</span><strong><?= e($title) ?></strong></div>
            <div class="topbar-profile"><span class="profile-avatar">🌼</span><span><strong>Plant keeper</strong><small>Admin kebun</small></span><span class="profile-chevron">⌄</span></div>
        </header>
        <div class="content-wrap">
            <?php if ($flash): ?>
                <div class="flash-message" role="status"><span>✦</span> <?= e($flash) ?><button type="button" aria-label="Tutup notifikasi" onclick="this.parentElement.remove()">×</button></div>
            <?php endif; ?>
            <?php require $viewFile; ?>
        </div>
        <footer class="footer">Dirawat sepenuh hati <span>♡</span> oleh Debby Manalu <span class="footer-year">· 2026</span></footer>
    </main>
</div>
<script src="assets/js/app.js"></script>
</body>
</html>
