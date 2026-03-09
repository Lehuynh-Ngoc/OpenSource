<?php
require_once 'app/models/OrderModel.php';
require_once 'app/models/CartModel.php';
require_once 'app/models/UserModel.php';

class OrderController {
    private $orderModel;
    private $cartModel;
    private $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->orderModel = new OrderModel();
        $this->cartModel = new CartModel();
        $this->userModel = new UserModel();
    }

    public function checkout() {
        if (!isset($_SESSION['username'])) {
            header('Location: /Project1/auth/login');
            exit;
        }

        $paymentMethod = $_POST['payment_method'] ?? 'pay_later';
        $sessionId = session_id();
        $cartItems = $this->cartModel->getCartItems($sessionId);

        // Chỉ lấy những sản phẩm được chọn
        $selectedItems = array_filter($cartItems, function($item) {
            return $item['is_selected'] == 1;
        });

        if (empty($selectedItems)) {
            die("Vui lòng chọn ít nhất một sản phẩm để thanh toán.");
        }

        // Tính tổng tiền
        $totalAmount = 0;
        foreach ($selectedItems as $item) {
            $totalAmount += (int)$item['price'] * (int)$item['quantity'];
        }

        // Lấy User ID từ session
        $user = $this->userModel->getUserByUsername($_SESSION['username']);
        $userId = $user['id'];

        // Tạo đơn hàng
        $orderId = $this->orderModel->createOrder($userId, $totalAmount, $paymentMethod, $selectedItems);

        if ($orderId) {
            // Chuyển hướng đến trang thành công
            echo "<script>alert('Đặt hàng thành công! Mã đơn hàng của bạn là: #$orderId'); window.location.href='/Project1/product/index';</script>";
        } else {
            die("Có lỗi xảy ra trong quá trình đặt hàng.");
        }
    }
}