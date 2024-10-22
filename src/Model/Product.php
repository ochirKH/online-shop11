<?php

namespace Model;
class Product extends Model
{
    private int $id;
    private string $name;
    private float $price;
    private string $images;
    private string $category;
    private string $description;

    public function getProductById(int $productId): Product|null // / Проверяем есть ли такой товар в магазине
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :product');
        $stmt->execute(['product' => $productId]);
        $data = $stmt->fetch();

        if (empty($data)) {
            return null;
        }
        return $this->hydrate($data);
    }

    public function getAll(): array
    {
        $exec = $this->pdo->query('SELECT * FROM products');
        $products = $exec->fetchAll();

        $main = [];
        foreach ($products as $product) {
            $main[] = $this->hydrate($product);
        }
        return $main;
    }


    private function hydrate($data): Product
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->price = $data['price'];
        $obj->images = $data['images'];
        $obj->category = $data['category'];
        $obj->description = $data['description'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImages(): string
    {
        return $this->images;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

