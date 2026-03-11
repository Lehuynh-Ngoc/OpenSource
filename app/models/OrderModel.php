<?php
require_once 'Database.php';

class OrderModel extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->getConnection();
    }

    public function createOrder($userId, $customerData, $totalBefore, $discount, $shippingCost, $totalAfter, $voucherCode, $paymentMethod, $shippingMethod, $shippingRegion, $items) {
        try {
            $this->db->beginTransaction();

            // 1. Tạo đơn hàng (Bao gồm thông tin người mua và giảm giá + phí vận chuyển)
            $query = "INSERT INTO orders (user_id, customer_name, customer_phone, customer_address, 
                                        total_before_discount, discount_amount, shipping_cost, total_amount, 
                                        voucher_code, payment_method, shipping_method, shipping_region) 
                      VALUES (:user_id, :name, :phone, :address, :total_before, :discount, :shipping_cost, :total_after, :v_code, :method, :s_method, :s_region)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':user_id' => $userId,
                ':name' => $customerData['name'],
                ':phone' => $customerData['phone'],
                ':address' => $customerData['address'],
                ':total_before' => $totalBefore,
                ':discount' => $discount,
                ':shipping_cost' => $shippingCost,
                ':total_after' => $totalAfter,
                ':v_code' => $voucherCode,
                ':method' => $paymentMethod,
                ':s_method' => $shippingMethod,
                ':s_region' => $shippingRegion
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

    public function getOrdersByUserId($userId) {
        $query = "SELECT * FROM orders WHERE user_id = :user_id GROUP BY id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrders() {
        $query = "SELECT o.*, u.username 
                  FROM orders o 
                  LEFT JOIN users u ON o.user_id = u.id 
                  GROUP BY o.id 
                  ORDER BY o.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($orderId) {
        $query = "SELECT oi.*, p.name, p.image 
                  FROM order_items oi 
                  JOIN products p ON oi.product_id = p.id 
                  WHERE oi.order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($orderId, $status) {
        $query = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':status' => $status, ':id' => $orderId]);
    }

    public function getOrderById($orderId) {
        $query = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cancelOrder($orderId, $userId, $isAdmin = false) {
        try {
            $this->db->beginTransaction();

            // 1. Kiểm tra đơn hàng. Nếu là Admin thì bỏ qua bước kiểm tra chủ sở hữu
            $sql = "SELECT * FROM orders WHERE id = :id AND status IN ('pending', 'confirmed')";
            if (!$isAdmin) {
                $sql .= " AND user_id = :user_id";
            }
            
            $stmt = $this->db->prepare($sql);
            $params = [':id' => $orderId];
            if (!$isAdmin) $params[':user_id'] = $userId;
            
            $stmt->execute($params);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                throw new Exception("Không thể hủy đơn hàng này hoặc đơn đã được giao.");
            }

            // 2. Cập nhật trạng thái thành 'cancelled'
            $updateQuery = "UPDATE orders SET status = 'cancelled' WHERE id = :id";
            $this->db->prepare($updateQuery)->execute([':id' => $orderId]);

            // 3. HOÀN KHO: Lấy danh sách sản phẩm và cộng lại số lượng
            $items = $this->getOrderItems($orderId);
            $restockQuery = "UPDATE products SET stock = stock + :qty WHERE id = :p_id";
            $restockStmt = $this->db->prepare($restockQuery);

            foreach ($items as $item) {
                $restockStmt->execute([
                    ':qty' => $item['quantity'],
                    ':p_id' => $item['product_id']
                ]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return $e->getMessage();
        }
    }
}