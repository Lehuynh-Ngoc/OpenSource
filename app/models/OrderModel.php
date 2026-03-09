<?php
require_once 'Database.php';

class OrderModel extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->getConnection();
    }

    public function createOrder($userId, $customerData, $totalBefore, $discount, $totalAfter, $voucherCode, $paymentMethod, $items) {
        try {
            $this->db->beginTransaction();

            // 1. Tạo đơn hàng (Bao gồm thông tin người mua và giảm giá)
            $query = "INSERT INTO orders (user_id, customer_name, customer_phone, customer_address, 
                                        total_before_discount, discount_amount, total_amount, 
                                        voucher_code, payment_method) 
                      VALUES (:user_id, :name, :phone, :address, :total_before, :discount, :total_after, :v_code, :method)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':user_id' => $userId,
                ':name' => $customerData['name'],
                ':phone' => $customerData['phone'],
                ':address' => $customerData['address'],
                ':total_before' => $totalBefore,
                ':discount' => $discount,
                ':total_after' => $totalAfter,
                ':v_code' => $voucherCode,
                ':method' => $paymentMethod
            ]);
            $orderId = $this->db->lastInsertId();

            // 2. Lưu chi tiết đơn hàng và TRỪ KHO
            $itemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                          VALUES (:order_id, :product_id, :quantity, :price)";
            $itemStmt = $this->db->prepare($itemQuery);

            $stockQuery = "UPDATE products SET stock = stock - :qty WHERE id = :p_id AND stock >= :qty";
            $stockStmt = $this->db->prepare($stockQuery);

            foreach ($items as $item) {
                // Lưu chi tiết
                $itemStmt->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $item['id'],
                    ':quantity' => $item['quantity'],
                    ':price' => $item['discounted_price'] // Lưu giá đã giảm sau khuyến mãi SP
                ]);

                // Trừ kho
                $stockStmt->execute([
                    ':qty' => $item['quantity'],
                    ':p_id' => $item['id']
                ]);
                
                if ($stockStmt->rowCount() == 0) {
                    throw new Exception("Sản phẩm " . $item['name'] . " đã hết hàng hoặc không đủ số lượng.");
                }
            }

            // 3. Cập nhật số lượt dùng Voucher nếu có
            if ($voucherCode) {
                $vQuery = "UPDATE vouchers SET used_count = used_count + 1 WHERE code = :code";
                $vStmt = $this->db->prepare($vQuery);
                $vStmt->execute([':code' => $voucherCode]);
            }

            // 4. Xóa các sản phẩm đã mua khỏi giỏ hàng
            $deleteQuery = "DELETE FROM cart WHERE session_id = :session_id AND is_selected = 1";
            $deleteStmt = $this->db->prepare($deleteQuery);
            $deleteStmt->execute([':session_id' => session_id()]);

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return $e->getMessage();
        }
    }
}