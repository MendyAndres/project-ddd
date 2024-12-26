<?php

namespace Src\Commerce\Products\Infrastructure\Repositories;

use PDO;
use PDOException;
use Src\Commerce\Products\Domain\Models\Product;
use Src\Commerce\Products\Domain\Repositories\ProductRepositoryInterface;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductDescription;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductId;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductName;
use Src\Commerce\Products\Domain\ValueObjects\Products\ProductPrice;

final class PdoProductRepository implements ProductRepositoryInterface
{
    private PDO $pdoConnection;

    public function __construct(PDO $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }

    public function save(Product $product): void
    {
        $statement = $this->pdoConnection->prepare('INSERT INTO products (id, name, description, price) VALUES (:id, :name, :description, :price)');

        $statement->bindValue(':id',          $product->getId()->value());
        $statement->bindValue(':name',        $product->getName()->value());
        $statement->bindValue(':description', $product->getDescription()->value());
        $statement->bindValue(':price',       $product->getPrice()->value());

        $statement->execute();
    }

    public function findById(string $productId): ?Product
    {
        $statement = $this->pdoConnection->prepare('SELECT * FROM products WHERE id = :id');
        $statement->bindValue(':id', $productId);
        $statement->execute();

        $product = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$product) {
            return null;
        }

        return $this->mapRowToProduct($product);
    }

    public function findAll(): array
    {
        $statement = $this->pdoConnection->prepare('SELECT * FROM products');
        $statement->execute();

        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!$products) {
            return [];
        }

        return array_map(function (array $product) {
            return $this->mapRowToProduct($product);
        }, $products);
    }

    public function update(Product $product): void
    {
        $statement = $this->pdoConnection->prepare('UPDATE products SET name = :name, description = :description, price = :price WHERE id = :id');

        $statement->bindValue(':id',          $product->getId()->value());
        $statement->bindValue(':name',        $product->getName()->value());
        $statement->bindValue(':description', $product->getDescription()->value());
        $statement->bindValue(':price',       $product->getPrice()->value());

        $statement->execute();
    }

    public function delete(string $productId): void
    {
        $statement = $this->pdoConnection->prepare('DELETE FROM products WHERE id = :id');
        $statement->bindValue(':id', $productId);
        $statement->execute();
    }

    public function mapRowToProduct(array $product): Product
    {
        return new Product(
            new ProductId($product['id']),
            new ProductName($product['name']),
            new ProductDescription($product['description']),
            new ProductPrice((float)$product['price'])
        );
    }
}