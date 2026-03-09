<?php
require_once 'Database.php';

class ProductModel extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->getConnection();
    }

    // Lấy tất cả hoặc lọc theo category_id và tìm kiếm
    public function getAll($categoryId = null, $search = null, $sort = null) {
        if (!$this->db) return [];
        
        $query = "SELECT p.*, c.name as category_name 
                  FROM products p 
                  LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
        
        $params = [];

        if ($categoryId) {
            $query .= " AND p.category_id = :cat_id";
            $params[':cat_id'] = $categoryId;
        }

        if ($search) {
            $query .= " AND p.name LIKE :search";
            $params[':search'] = "%$search%";
        }

        // Sắp xếp
        if ($sort == 'price_asc') {
            $query .= " ORDER BY p.price ASC";
        } elseif ($sort == 'price_desc') {
            $query .= " ORDER BY p.price DESC";
        } else {
            $query .= " ORDER BY p.id DESC";
        }
        
        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
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

    public function add($name, $price, $image = 'default.jpg', $categoryId = null, $description = '', $stock = 10) {
        $query = "INSERT INTO products (name, price, image, category_id, description, stock) VALUES (:name, :price, :image, :category_id, :description, :stock)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':stock', $stock);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function update($id, $name, $price, $image, $categoryId = null, $description = '', $stock = 10) {
        $query = "UPDATE products SET name = :name, price = :price, image = :image, category_id = :category_id, description = :description, stock = :stock WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':stock', $stock);
        return $stmt->execute();
    }
}