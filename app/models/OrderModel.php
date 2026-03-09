<?php
require_once 'Database.php';

class OrderModel extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->getConnection();
    }

    public function createOrder($userId, $totalAmount, $paymentMethod, $items) {
        try {
            $this->db->beginTransaction();

            // 1. Tạo đơn hàng
            $query = "INSERT INTO orders (user_id, total_amount, payment_method) VALUES (:user_id, :total, :method)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':user_id' => $userId,
                ':total' => $totalAmount,
                ':method' => $paymentMethod
            ]);
            $orderId = $this->db->lastInsertId();

            // 2. Lưu chi tiết đơn hàng
            $itemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
            $itemStmt = $this->db->prepare($itemQuery);

            foreach ($items as $item) {
                $itemStmt->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $item['id'],
                    ':quantity' => $item['quantity'],
                    ':price' => $item['price']
                ]);
            }

            // 3. Xóa các sản phẩm đã mua khỏi giỏ hàng
            $deleteQuery = "DELETE FROM cart WHERE session_id = :session_id AND is_selected = 1";
            $deleteStmt = $this->db->prepare($deleteQuery);
            $deleteStmt->execute([':session_id' => session_id()]);

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}