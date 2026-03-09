<?php
require_once 'Database.php';

class PromotionModel extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->getConnection();
    }

    public function getAll() {
        $query = "SELECT p.*, 
                  CASE 
                    WHEN p.type = 'product' THEN (SELECT name FROM products WHERE id = p.target_id)
                    WHEN p.type = 'category' THEN (SELECT name FROM categories WHERE id = p.target_id)
                  END as target_name
                  FROM promotions p ORDER BY p.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($name, $type, $target_id, $discount_type, $discount_value, $start_date, $end_date) {
        $query = "INSERT INTO promotions (name, type, target_id, discount_type, discount_value, start_date, end_date) 
                  VALUES (:name, :type, :target_id, :discount_type, :discount_value, :start_date, :end_date)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':target_id', $target_id);
        $stmt->bindParam(':discount_type', $discount_type);
        $stmt->bindParam(':discount_value', $discount_value);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM promotions WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Lấy khuyến mãi đang hoạt động cho một sản phẩm cụ thể (có kiểm tra thời gian)
    public function getActivePromotionForProduct($productId, $categoryId) {
        // Ưu tiên khuyến mãi theo sản phẩm, sau đó mới đến danh mục
        // Chỉ lấy khuyến mãi nếu thời gian hiện tại nằm trong khoảng start_date và end_date
        $query = "SELECT * FROM promotions WHERE status = 1 
                  AND (start_date IS NULL OR start_date <= NOW())
                  AND (end_date IS NULL OR end_date >= NOW())
                  AND ((type = 'product' AND target_id = :p_id) 
                  OR (type = 'category' AND target_id = :c_id))
                  ORDER BY type ASC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':p_id', $productId);
        $stmt->bindParam(':c_id', $categoryId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}