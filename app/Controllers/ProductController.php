<?php
declare(strict_types=1);

final class ProductController
{
    private Product $products;

    public function __construct()
    {
        $this->products = new Product(Database::connection());
    }

    public function index(): void
    {
        $search = trim((string) ($_GET['q'] ?? ''));
        $category = trim((string) ($_GET['category'] ?? ''));
        $this->render('products/index', [
            'title' => 'Koleksi tanaman',
            'products' => $this->products->all($search, $category),
            'categories' => $this->products->categories(),
            'summary' => $this->products->summary(),
            'search' => $search,
            'selectedCategory' => $category,
        ]);
    }

    public function create(): void
    {
        $this->form('create', null);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        [$data, $errors] = $this->validatedInput();
        if ($errors !== []) {
            $this->form('create', $data, $errors);
            return;
        }
        $this->products->create($data);
        $_SESSION['flash'] = 'Produk baru berhasil ditambahkan ke kebun.';
        $this->redirect();
    }

    public function show(int $id): void
    {
        $product = $this->products->find($id);
        if ($product === null) {
            $this->notFound();
            return;
        }
        $this->render('products/show', ['title' => $product['name'], 'product' => $product]);
    }

    public function edit(int $id): void
    {
        $product = $this->products->find($id);
        if ($product === null) {
            $this->notFound();
            return;
        }
        $this->form('edit', $product);
    }

    public function update(int $id): void
    {
        $this->verifyCsrf();
        if ($this->products->find($id) === null) {
            $this->notFound();
            return;
        }
        [$data, $errors] = $this->validatedInput();
        if ($errors !== []) {
            $data['id'] = $id;
            $this->form('edit', $data, $errors);
            return;
        }
        $this->products->update($id, $data);
        $_SESSION['flash'] = 'Detail tanaman berhasil diperbarui.';
        $this->redirect();
    }

    public function destroy(int $id): void
    {
        $this->verifyCsrf();
        $this->products->delete($id);
        $_SESSION['flash'] = 'Produk berhasil dihapus dari koleksi.';
        $this->redirect();
    }

    private function validatedInput(): array
    {
        $data = [
            'name' => trim((string) ($_POST['name'] ?? '')),
            'category' => trim((string) ($_POST['category'] ?? '')),
            'price' => filter_var($_POST['price'] ?? null, FILTER_VALIDATE_INT),
            'stock' => filter_var($_POST['stock'] ?? null, FILTER_VALIDATE_INT),
            'emoji' => trim((string) ($_POST['emoji'] ?? '')),
            'description' => trim((string) ($_POST['description'] ?? '')),
        ];
        $errors = [];
        if ($data['name'] === '' || mb_strlen($data['name']) > 100) {
            $errors[] = 'Nama wajib diisi dan maksimal 100 karakter.';
        }
        if ($data['category'] === '' || mb_strlen($data['category']) > 60) {
            $errors[] = 'Kategori wajib diisi dan maksimal 60 karakter.';
        }
        if ($data['price'] === false || $data['price'] < 1) {
            $errors[] = 'Harga harus berupa angka minimal Rp1.';
        }
        if ($data['stock'] === false || $data['stock'] < 0) {
            $errors[] = 'Stok harus berupa bilangan bulat nol atau lebih.';
        }
        if ($data['emoji'] === '') {
            $data['emoji'] = '🪴';
        } elseif (mb_strlen($data['emoji']) > 8) {
            $errors[] = 'Ikon terlalu panjang.';
        }
        if (mb_strlen($data['description']) > 1000) {
            $errors[] = 'Deskripsi maksimal 1000 karakter.';
        }
        return [$data, $errors];
    }

    private function form(string $mode, ?array $product, array $errors = []): void
    {
        $this->render('products/form', [
            'title' => $mode === 'create' ? 'Tambah tanaman' : 'Edit tanaman',
            'mode' => $mode,
            'product' => $product ?? ['name' => '', 'category' => '', 'price' => '', 'stock' => '', 'emoji' => '🪴', 'description' => ''],
            'errors' => $errors,
        ]);
    }

    private function render(string $view, array $data): void
    {
        extract($data, EXTR_SKIP);
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        $viewFile = dirname(__DIR__) . '/Views/' . $view . '.php';
        require dirname(__DIR__) . '/Views/layout.php';
    }

    private function verifyCsrf(): void
    {
        $submitted = (string) ($_POST['csrf_token'] ?? '');
        if (!hash_equals($_SESSION['csrf_token'], $submitted)) {
            http_response_code(403);
            exit('Permintaan tidak dapat diverifikasi. Muat ulang halaman lalu coba lagi.');
        }
    }

    private function notFound(): void
    {
        http_response_code(404);
        $this->render('errors/404', ['title' => 'Tanaman tidak ditemukan']);
    }

    private function redirect(): never
    {
        header('Location: index.php');
        exit;
    }
}
