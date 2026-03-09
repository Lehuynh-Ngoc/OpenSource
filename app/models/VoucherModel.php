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
                  AND (expiry_date IS NULL OR expiry_date >= CURDATE()) 
                  AND (usage_limit > used_count) LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($code, $discount_type, $discount_value, $min_order_value, $usage_limit, $expiry_date) {
        $query = "INSERT INTO vouchers (code, discount_type, discount_value, min_order_value, usage_limit, expiry_date) 
                  VALUES (:code, :discount_type, :discount_value, :min_order_value, :usage_limit, :expiry_date)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':discount_type', $discount_type);
        $stmt->bindParam(':discount_value', $discount_value);
        $stmt->bindParam(':min_order_value', $min_order_value);
        $stmt->bindParam(':usage_limit', $usage_limit);
        $stmt->bindParam(':expiry_date', $expiry_date);
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
}