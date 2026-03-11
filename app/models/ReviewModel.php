<?php
require_once 'Database.php';

class ReviewModel extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->getConnection();
    }

    public function add($productId, $userId, $orderId, $rating, $comment) {
        $query = "INSERT INTO reviews (product_id, user_id, order_id, rating, comment) 
                  VALUES (:product_id, :user_id, :order_id, :rating, :comment)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':product_id' => $productId,
            ':user_id' => $userId,
            ':order_id' => $orderId,
            ':rating' => $rating,
            ':comment' => $comment
        ]);
    }

    public function getReviewsByProduct($productId) {
        $query = "SELECT r.*, u.username 
                  FROM reviews r 
                  JOIN users u ON r.user_id = u.id 
                  WHERE r.product_id = :product_id 
                  ORDER BY r.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkUserReviewed($productId, $userId, $orderId) {
        $query = "SELECT COUNT(*) FROM reviews WHERE product_id = :p_id AND user_id = :u_id AND order_id = :o_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':p_id' => $productId, ':u_id' => $userId, ':o_id' => $orderId]);
        return $stmt->fetchColumn() > 0;
    }
}