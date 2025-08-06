<?php
require_once __DIR__ . '/database copy.php';

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllProducts()
    {
        $sql = "SELECT * FROM `products`";
        return $this->db->getAll($sql);
    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM `products` WHERE id = :id";
        return $this->db->getOne($sql, ['id' => $id]);
    }

    public function getProductsByCategoryId($categoryId, $limit = 10)
    {
        $sql = "SELECT * FROM `products` WHERE `MaDM` = :categoryId ORDER BY `created_at` DESC LIMIT :limit";
        return $this->db->getAll($sql, ['categoryId' => $categoryId, 'limit' => $limit]);
    }

    public function updateProduct($id, $name, $description, $image, $price, $sale_price, $quantity)
    {
        $sql = "UPDATE `products` 
        SET `name` = :name, `description` = :description, `image` = :image, `price` = :price, `sale_price` = :sale_price, `quantity` = :quantity 
        WHERE `id` = :id";
        
        return $this->db->execute($sql, [
            'id' => $id, 
            'name' => $name, 
            'description' => $description, 
            'image' => $image, 
            'price' => $price, 
            'sale_price' => $sale_price, 
            'quantity' => $quantity
        ]);
    }

    public function insertProduct($name, $category_id, $description, $image, $price, $sale_price, $quantity)
    {
        $sql = "INSERT INTO `products` (name, category_id, description, image, price, sale_price, quantity)
                VALUES (:name, :category_id, :description, :image, :price, :sale_price, :quantity)";
        
        return $this->db->execute($sql, [
            'name' => $name, 
            'category_id' => $category_id, 
            'description' => $description, 
            'image' => $image, 
            'price' => $price, 
            'sale_price' => $sale_price, 
            'quantity' => $quantity
        ]);
    }
}