<?php
require_once 'app/models/OrderModel.php';
require_once 'app/models/CartModel.php';
require_once 'app/models/UserModel.php';
require_once 'app/models/PromotionModel.php';
require_once 'app/models/VoucherModel.php';

class OrderController {
    private $orderModel;
    private $cartModel;
    private $userModel;
    private $promotionModel;
    private $voucherModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Ép quyền Admin nếu tên đăng nhập là admin
        if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
            $_SESSION['role'] = 'admin';
        }

        $this->orderModel = new OrderModel();
        $this->cartModel = new CartModel();
        $this->userModel = new UserModel();
        $this->promotionModel = new PromotionModel();
        $this->voucherModel = new VoucherModel();
    }

    public function checkout() {
        if (!isset($_SESSION['username'])) {
            header('Location: /Project1/auth/login');
            exit;
        }

        $sessionId = session_id();
        $cartItems = $this->cartModel->getCartItems($sessionId);

        // Chỉ lấy những sản phẩm được chọn
        $selectedItems = array_filter($cartItems, function($item) {
            return $item['is_selected'] == 1;
        });

        if (empty($selectedItems)) {
            die("<script>alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán!'); window.location.href='/Project1/cart/index';</script>");
        }

        // Tính toán khuyến mãi sản phẩm cho trang hiển thị
        $totalBefore = 0;
        $totalPromoDiscount = 0;
        foreach ($selectedItems as &$item) {
            $totalBefore += (int)$item['price'] * (int)$item['quantity'];
            $promo = $this->promotionModel->getActivePromotionForProduct($item['id'], $item['category_id']);
            $item['promotion'] = $promo;
            $item['discounted_price'] = $item['price'];
            if ($promo) {
                if ($promo['discount_type'] === 'percent') {
                    $item['discounted_price'] = $item['price'] * (1 - $promo['discount_value'] / 100);
                } else {
                    $item['discounted_price'] = max(0, $item['price'] - $promo['discount_value']);
                }
            }
            $totalPromoDiscount += ($item['price'] - $item['discounted_price']) * $item['quantity'];
        }

        // Voucher
        $voucher = null;
        if (isset($_SESSION['voucher_code'])) {
            $voucher = $this->voucherModel->getByCode($_SESSION['voucher_code']);
        }

        require_once 'app/views/checkout.php';
    }

    public function process() {
        if (!isset($_SESSION['username'])) {
            header('Location: /Project1/auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Project1/cart/index');
            exit;
        }

        // Thông tin người mua
        $customerData = [
            'name' => $_POST['customer_name'] ?? '',
            'phone' => $_POST['customer_phone'] ?? '',
            'address' => $_POST['customer_address'] ?? ''
        ];

        if (empty($customerData['name']) || empty($customerData['phone']) || empty($customerData['address'])) {
            die("<script>alert('Vui lòng nhập đầy đủ thông tin người nhận!'); history.back();</script>");
        }

        $paymentMethod = $_POST['payment_method'] ?? 'pay_later';
        $shippingMethod = $_POST['shipping_method'] ?? 'standard';
        $shippingRegion = $_POST['shipping_region'] ?? 'tphcm';

        // Tính phí vận chuyển
        $baseShipping = 0;
        switch ($shippingMethod) {
            case 'express': $baseShipping = 50000; break; // Hỏa tốc
            case 'standard': $baseShipping = 20000; break; // Trực tiếp/Tiêu chuẩn
            case 'locker': $baseShipping = 10000; break; // Tủ hàng
            default: $baseShipping = 20000;
        }

        $regionExtra = 0;
        switch ($shippingRegion) {
            case 'tphcm': $regionExtra = 0; break;
            case 'nearby': $regionExtra = 15000; break;
            case 'far': $regionExtra = 35000; break;
            default: $regionExtra = 0;
        }

        $shippingCost = $baseShipping + $regionExtra;

        $sessionId = session_id();
        $cartItems = $this->cartModel->getCartItems($sessionId);

        $selectedItems = array_filter($cartItems, function($item) {
            return $item['is_selected'] == 1;
        });

        if (empty($selectedItems)) {
            die("Vui lòng chọn ít nhất một sản phẩm để thanh toán.");
        }

        $totalBeforeDiscount = 0;
        $totalPromotionDiscount = 0;
        foreach ($selectedItems as &$item) {
            $totalBeforeDiscount += (int)$item['price'] * (int)$item['quantity'];
            $promo = $this->promotionModel->getActivePromotionForProduct($item['id'], $item['category_id']);
            $item['discounted_price'] = $item['price'];
            if ($promo) {
                if ($promo['discount_type'] === 'percent') {
                    $item['discounted_price'] = $item['price'] * (1 - $promo['discount_value'] / 100);
                } else {
                    $item['discounted_price'] = max(0, $item['price'] - $promo['discount_value']);
                }
            }
            $totalPromotionDiscount += ($item['price'] - $item['discounted_price']) * $item['quantity'];
        }

        $totalAfterPromotion = $totalBeforeDiscount - $totalPromotionDiscount;

        $voucherCode = $_SESSION['voucher_code'] ?? null;
        $voucherDiscount = 0;
        if ($voucherCode) {
            $voucher = $this->voucherModel->getByCode($voucherCode);
            if ($voucher && $totalAfterPromotion >= $voucher['min_order_value']) {
                if ($voucher['discount_type'] === 'percent') {
                    $voucherDiscount = $totalAfterPromotion * ($voucher['discount_value'] / 100);
                } else {
                    $voucherDiscount = min($totalAfterPromotion, $voucher['discount_value']);
                }
            } else {
                $voucherCode = null;
            }
        }

        $totalFinal = max(0, $totalAfterPromotion - $voucherDiscount) + $shippingCost;
        $totalTotalDiscount = $totalPromotionDiscount + $voucherDiscount;

        $user = $this->userModel->getUserByUsername($_SESSION['username']);
        $userId = $user['id'];

        $result = $this->orderModel->createOrder(
            $userId, $customerData, $totalBeforeDiscount, $totalTotalDiscount, $shippingCost, $totalFinal, $voucherCode, $paymentMethod, $shippingMethod, $shippingRegion, $selectedItems
        );

        if (is_numeric($result)) {
            unset($_SESSION['voucher_code']);
            echo "<script>alert('Đặt hàng thành công! Mã đơn của bạn là: #$result'); window.location.href='/Project1/product/index';</script>";
        } else {
            die("<script>alert('Lỗi: $result'); history.back();</script>");
        }
    }

    public function update_status() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            die("Access denied");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'];
            $status = $_POST['status'];
            $this->orderModel->updateStatus($orderId, $status);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    public function confirm_received() {
        if (!isset($_SESSION['username'])) exit;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'];
            $order = $this->orderModel->getOrderById($orderId);
            
            if ($order && $order['user_id'] == $_SESSION['user_id']) {
                $this->orderModel->updateStatus($orderId, 'received');
            }
            header('Location: /Project1/auth/profile');
            exit;
        }
    }

    public function cancel() {
        if (!isset($_SESSION['username'])) exit;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'];
            $userId = $_SESSION['user_id'];
            $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
            
            $result = $this->orderModel->cancelOrder($orderId, $userId, $isAdmin);
            if ($result === true) {
                echo "<script>alert('Hủy đơn hàng thành công! Sản phẩm đã được hoàn lại kho.'); window.location.href='/Project1/auth/profile';</script>";
            } else {
                echo "<script>alert('Lỗi: $result'); window.location.href='/Project1/auth/profile';</script>";
            }
            exit;
        }
    }
}