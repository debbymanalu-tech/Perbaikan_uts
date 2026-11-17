# Debby — Little Plant Studio

Dashboard inventaris toko tanaman hias dengan tampilan lembut bernuansa pink. Aplikasi dibuat mandiri menggunakan PHP, pola MVC sederhana, dan SQLite—tanpa framework atau template dari repositori pihak lain.

## Fitur

- CRUD produk: tambah, lihat detail, ubah, dan hapus.
- Pencarian produk dan filter berdasarkan kategori.
- Ringkasan jumlah produk, stok, dan kategori.
- Validasi input, prepared statement, dan token CSRF untuk form.
- Data contoh otomatis dimasukkan saat database lokal pertama kali dibuat.
- Tampilan responsif untuk desktop dan ponsel.

## Teknologi

- PHP 8.1 atau lebih baru
- PDO SQLite (`pdo_sqlite`)
- HTML, CSS, dan JavaScript tanpa dependensi frontend

## Struktur folder

```text
rona-rimbun/
├── app/
│   ├── Controllers/
│   │   └── ProductController.php
│   ├── Core/
│   │   └── Database.php
│   ├── Models/
│   │   └── Product.php
│   └── Views/
│       ├── errors/
│       ├── products/
│       └── layout.php
├── database/
│   └── schema.sql
├── public/
│   ├── assets/
│   │   ├── css/style.css
│   │   └── js/app.js
│   └── index.php
└── README.md
```

Database SQLite `database/rona-rimbun.sqlite` dibuat otomatis saat aplikasi pertama kali dijalankan. File database tersebut tidak perlu dibuat atau diunduh terpisah.

## Cara menjalankan

Pastikan PHP memiliki ekstensi `pdo_sqlite`, lalu dari folder proyek jalankan:

```bash
php -S localhost:8000 -t public
```

Buka [http://localhost:8000](http://localhost:8000). Jika menggunakan XAMPP, arahkan document root Apache ke folder `public` proyek ini.

## Skema database

Skema tersedia di [`database/schema.sql`](database/schema.sql). Untuk membuat database kosong menggunakan SQLite CLI:

```bash
sqlite3 database/rona-rimbun.sqlite < database/schema.sql
```

Seed produk dimasukkan otomatis oleh aplikasi hanya jika tabel produk masih kosong.

## Identitas pembuat

- Nama: **Debby Manalu**
- Kelas: **KA A**
- Mata kuliah: **Pemrograman Web**
- NIM/NIS: **25210026**
- Tautan publik (opsional): **Belum tersedia**

> Setelah aplikasi di-deploy ke hosting milik sendiri, tambahkan URL publiknya di bagian identitas. Aplikasi ini tidak terhubung ke atau menggunakan repositori GitHub pihak lain.
