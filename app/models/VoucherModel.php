<?php
require_once 'Database.php';

class VoucherModel extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM vouchers ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCode($code) {
        $query = "SELECT * FROM vouchers WHERE code = :code AND status = 1 
                  AND (start_date IS NULL OR start_date <= NOW())
                  AND (end_date IS NULL OR end_date >= NOW()) 
                  AND (usage_limit > used_count) LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($code, $target_type, $discount_type, $discount_value, $min_order_value, $usage_limit, $start_date, $end_date) {
        $query = "INSERT INTO vouchers (code, target_type, discount_type, discount_value, min_order_value, usage_limit, start_date, end_date) 
                  VALUES (:code, :target_type, :discount_type, :discount_value, :min_order_value, :usage_limit, :start_date, :end_date)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':target_type', $target_type);
        $stmt->bindParam(':discount_type', $discount_type);
        $stmt->bindParam(':discount_value', $discount_value);
        $stmt->bindParam(':min_order_value', $min_order_value);
        $stmt->bindParam(':usage_limit', $usage_limit);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        return $stmt->execute();
    }

    public function updateUsedCount($code) {
        $query = "UPDATE vouchers SET used_count = used_count + 1 WHERE code = :code";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':code', $code);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM vouchers WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function update($id, $code, $target_type, $discount_type, $discount_value, $min_order_value, $usage_limit, $start_date, $end_date) {
        $query = "UPDATE vouchers SET code = :code, target_type = :target_type, discount_type = :discount_type, 
                  discount_value = :discount_value, min_order_value = :min_order_value, 
                  usage_limit = :usage_limit, start_date = :start_date, end_date = :end_date 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':target_type', $target_type);
        $stmt->bindParam(':discount_type', $discount_type);
        $stmt->bindParam(':discount_value', $discount_value);
        $stmt->bindParam(':min_order_value', $min_order_value);
        $stmt->bindParam(':usage_limit', $usage_limit);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        return $stmt->execute();
    }
}