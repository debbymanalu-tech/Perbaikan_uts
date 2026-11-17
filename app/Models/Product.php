<?php
declare(strict_types=1);

final class Product
{
    public function __construct(private PDO $db)
    {
    }

    public function all(string $search = '', string $category = ''): array
    {
        $sql = 'SELECT * FROM products WHERE 1 = 1';
        $params = [];
        if ($search !== '') {
            $sql .= ' AND (name LIKE :search OR description LIKE :search OR category LIKE :search)';
            $params['search'] = '%' . $search . '%';
        }
        if ($category !== '') {
            $sql .= ' AND category = :category';
            $params['category'] = $category;
        }
        $sql .= ' ORDER BY id DESC';
        $statement = $this->db->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll();
    }

    public function find(int $id): ?array
    {
        $statement = $this->db->prepare('SELECT * FROM products WHERE id = :id');
        $statement->execute(['id' => $id]);
        $product = $statement->fetch();
        return $product ?: null;
    }

    public function categories(): array
    {
        return $this->db->query('SELECT DISTINCT category FROM products ORDER BY category')->fetchAll(PDO::FETCH_COLUMN);
    }

    public function create(array $data): void
    {
        $statement = $this->db->prepare(
            'INSERT INTO products (name, category, price, stock, emoji, description)
             VALUES (:name, :category, :price, :stock, :emoji, :description)'
        );
        $statement->execute($data);
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $statement = $this->db->prepare(
            'UPDATE products SET name = :name, category = :category, price = :price,
             stock = :stock, emoji = :emoji, description = :description,
             updated_at = CURRENT_TIMESTAMP WHERE id = :id'
        );
        $statement->execute($data);
    }

    public function delete(int $id): void
    {
        $statement = $this->db->prepare('DELETE FROM products WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    public function summary(): array
    {
        return $this->db->query(
            'SELECT COUNT(*) AS products, COALESCE(SUM(stock), 0) AS stock,
             COUNT(DISTINCT category) AS categories FROM products'
        )->fetch();
    }
}
