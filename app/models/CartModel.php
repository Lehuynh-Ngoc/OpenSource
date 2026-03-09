<?php
require_once 'Database.php';

class CartModel extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->getConnection();
    }

    // Lấy toàn bộ sản phẩm trong giỏ hàng của session hiện tại
    public function getCartItems($sessionId) {
        $query = "SELECT c.id as cart_id, c.quantity, c.is_selected, p.* 
                  FROM cart c 
                  JOIN products p ON c.product_id = p.id 
                  WHERE c.session_id = :session_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':session_id', $sessionId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái chọn của sản phẩm trong giỏ
    public function updateSelection($cartId, $isSelected) {
        $query = "UPDATE cart SET is_selected = :is_selected WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':is_selected', $isSelected, PDO::PARAM_INT);
        $stmt->bindParam(':id', $cartId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Thêm sản phẩm vào giỏ hoặc cập nhật số lượng nếu đã có
    public function addToCart($sessionId, $productId, $quantity) {
        // Kiểm tra xem sản phẩm đã có trong giỏ chưa
        $checkQuery = "SELECT id, quantity FROM cart WHERE session_id = :session_id AND product_id = :product_id";
        $stmt = $this->db->prepare($checkQuery);
        $stmt->bindParam(':session_id', $sessionId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Nếu đã có, cộng dồn số lượng
            $newQuantity = $row['quantity'] + $quantity;
            $updateQuery = "UPDATE cart SET quantity = :quantity WHERE id = :id";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->bindParam(':quantity', $newQuantity);
            $updateStmt->bindParam(':id', $row['id']);
            return $updateStmt->execute();
        } else {
            // Nếu chưa có, thêm mới
            $insertQuery = "INSERT INTO cart (session_id, product_id, quantity) VALUES (:session_id, :product_id, :quantity)";
            $insertStmt = $this->db->prepare($insertQuery);
            $insertStmt->bindParam(':session_id', $sessionId);
            $insertStmt->bindParam(':product_id', $productId);
            $insertStmt->bindParam(':quantity', $quantity);
            return $insertStmt->execute();
        }
    }

    // Cập nhật số lượng của 1 sản phẩm trong giỏ
    public function updateQuantity($cartId, $quantity) {
        $query = "UPDATE cart SET quantity = :quantity WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $cartId);
        return $stmt->execute();
    }

    // Xóa 1 sản phẩm khỏi giỏ (dùng ID của dòng trong bảng cart)
    public function removeItem($cartId) {
        $query = "DELETE FROM cart WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $cartId);
        return $stmt->execute();
    }

    // Xóa sạch giỏ hàng của người dùng
    public function clearCart($sessionId) {
        $query = "DELETE FROM cart WHERE session_id = :session_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':session_id', $sessionId);
        return $stmt->execute();
    }

    // Đếm tổng số lượng sản phẩm để hiện icon giỏ hàng
    public function countItems($sessionId) {
        $query = "SELECT SUM(quantity) FROM cart WHERE session_id = :session_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':session_id', $sessionId);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}