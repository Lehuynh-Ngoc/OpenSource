<?php
require_once 'Database.php';

class ProductModel extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->getConnection();
    }

    // Lấy tất cả hoặc lọc theo category_id
    public function getAll($categoryId = null) {
        if (!$this->db) return [];
        
        $query = "SELECT p.*, c.name as category_name 
                  FROM products p 
                  LEFT JOIN categories c ON p.category_id = c.id";
        
        if ($categoryId) {
            $query .= " WHERE p.category_id = :cat_id";
        }
        
        $query .= " ORDER BY p.id DESC";
        
        $stmt = $this->db->prepare($query);
        if ($categoryId) {
            $stmt->bindParam(':cat_id', $categoryId);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($name, $price, $image = 'default.jpg', $categoryId = null) {
        $query = "INSERT INTO products (name, price, image, category_id) VALUES (:name, :price, :image, :category_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $categoryId);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function update($id, $name, $price, $image, $categoryId = null) {
        $query = "UPDATE products SET name = :name, price = :price, image = :image, category_id = :category_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $categoryId);
        return $stmt->execute();
    }
}