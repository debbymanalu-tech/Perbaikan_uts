<?php
declare(strict_types=1);

final class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        $databasePath = dirname(__DIR__, 2) . '/database/rona-rimbun.sqlite';
        $directory = dirname($databasePath);
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new RuntimeException('Folder database tidak dapat dibuat.');
        }

        $pdo = new PDO('sqlite:' . $databasePath, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $pdo->exec('PRAGMA foreign_keys = ON');
        $pdo->exec('PRAGMA journal_mode = WAL');
        $pdo->exec('CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            category TEXT NOT NULL,
            price INTEGER NOT NULL CHECK (price > 0),
            stock INTEGER NOT NULL DEFAULT 0 CHECK (stock >= 0),
            emoji TEXT NOT NULL DEFAULT "🪴",
            description TEXT NOT NULL DEFAULT "",
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
        )');

        $count = (int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
        if ($count === 0) {
            $seed = $pdo->prepare(
                'INSERT INTO products (name, category, price, stock, emoji, description)
                 VALUES (:name, :category, :price, :stock, :emoji, :description)'
            );
            $products = [
                ['Monstera Deliciosa', 'Tanaman Indoor', 185000, 12, '🌿', 'Si daun ikonik dengan belahan cantik. Cocok untuk sudut ruang yang terang tanpa sinar matahari langsung.'],
                ['Calathea Orbifolia', 'Tanaman Indoor', 145000, 8, '🍃', 'Daun bundar bergaris perak yang menenangkan. Suka kelembapan dan cahaya tidak langsung.'],
                ['Kaktus Mini Senja', 'Sukulen & Kaktus', 38000, 24, '🌵', 'Kaktus mungil pilihan untuk meja kerja. Perawatannya mudah dan cukup disiram sesekali.'],
                ['Peperomia Rosso', 'Tanaman Indoor', 72000, 15, '🪴', 'Perpaduan hijau dan merah marun di bagian bawah daun. Cantik dalam pot kecil dekat jendela.'],
                ['Paket Pot Terakota', 'Pot & Aksesori', 55000, 18, '🏺', 'Pot terakota berpori dengan lubang drainase, pas untuk tanaman yang tidak suka media terlalu basah.'],
                ['Lidah Mertua Mini', 'Tanaman Indoor', 49000, 21, '🌱', 'Tanaman tangguh yang tetap menawan di ruang mungil. Tumbuh baik dengan perawatan sederhana.'],
                ['Haworthia Zebra', 'Sukulen & Kaktus', 42000, 10, '🌵', 'Sukulen mungil dengan gurat putih khas. Hadiah manis untuk teman yang baru mulai berkebun.'],
                ['Spray Mister Pastel', 'Pot & Aksesori', 32000, 7, '💧', 'Botol semprot warna pastel untuk membantu menjaga kelembapan daun dan tanaman tropis.'],
                ['lavender', 'Pot & Aksesori', 30000, 7, '💧', 'untuk membantu menjaga kelembapan daun dan tanaman tropis.'],
            ];
            foreach ($products as [$name, $category, $price, $stock, $emoji, $description]) {
                $seed->execute(compact('name', 'category', 'price', 'stock', 'emoji', 'description'));
            }
        }

        self::$connection = $pdo;
        return self::$connection;
    }
}
