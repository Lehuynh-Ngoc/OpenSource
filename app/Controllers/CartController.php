<?php
require_once 'app/models/CartModel.php';
require_once 'app/models/PromotionModel.php';
require_once 'app/models/VoucherModel.php';

class CartController {
    private $cartModel;
    private $promotionModel;
    private $voucherModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->cartModel = new CartModel();
        $this->promotionModel = new PromotionModel();
        $this->voucherModel = new VoucherModel();
    }

    // Hiển thị giỏ hàng từ Database
    public function index() {
        if (!isset($_SESSION['username'])) {
            header('Location: /Project1/auth/login');
            exit;
        }
        $sessionId = session_id();
        $cart = $this->cartModel->getCartItems($sessionId);
        
        // Gắn thông tin khuyến mãi cho từng SP
        foreach ($cart as &$item) {
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
        }

        // Kiểm tra Voucher nếu có
        $voucher = null;
        if (isset($_SESSION['voucher_code'])) {
            $voucher = $this->voucherModel->getByCode($_SESSION['voucher_code']);
            if (!$voucher) unset($_SESSION['voucher_code']);
        }

        require_once 'app/views/cart.php';
    }

    public function apply_voucher() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['voucher_code'] ?? '';
            $redirect = $_POST['redirect'] ?? 'cart/index';
            $voucher = $this->voucherModel->getByCode($code);
            if ($voucher) {
                $_SESSION['voucher_code'] = $code;
                $_SESSION['voucher_success'] = "Đã áp dụng mã giảm giá thành công!";
            } else {
                $_SESSION['voucher_error'] = "Mã giảm giá không hợp lệ hoặc đã hết hạn.";
            }
            header('Location: /Project1/' . $redirect);
            exit;
        }
    }

    public function remove_voucher() {
        $redirect = $_GET['redirect'] ?? 'cart/index';
        unset($_SESSION['voucher_code']);
        header('Location: /Project1/' . $redirect);
        exit;
    }

    // Thêm sản phẩm vào giỏ hàng trong Database
    public function add($id) {
        $sessionId = session_id();
        $quantityToAdd = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        if ($quantityToAdd < 1) $quantityToAdd = 1;

        if ($this->cartModel->addToCart($sessionId, $id, $quantityToAdd)) {
            header('Location: /Project1/cart/index');
            exit;
        } else {
            die("Lỗi: Không thể thêm sản phẩm vào giỏ hàng.");
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
            if ($quantity < 1) {
                // Nếu số lượng nhỏ hơn 1, có thể xóa luôn sản phẩm hoặc để tối thiểu là 1
                $this->cartModel->removeItem($id);
            } else {
                $this->cartModel->updateQuantity($id, $quantity);
            }
            header('Location: /Project1/cart/index');
            exit;
        }
    }

    // Thay đổi trạng thái chọn của sản phẩm
    public function toggle($id) {
        $isSelected = isset($_POST['selected']) ? (int)$_POST['selected'] : 0;
        $this->cartModel->updateSelection($id, $isSelected);
        header('Location: /Project1/cart/index');
        exit;
    }

    // Xóa sản phẩm khỏi giỏ trong Database
    // $id ở đây là ID của dòng trong bảng cart (cart_id)
    public function remove($id) {
        if ($this->cartModel->removeItem($id)) {
            header('Location: /Project1/cart/index');
            exit;
        } else {
            die("Lỗi: Không thể xóa sản phẩm.");
        }
    }

    // Xóa sạch giỏ hàng trong Database
    public function clear() {
        $sessionId = session_id();
        if ($this->cartModel->clearCart($sessionId)) {
            header('Location: /Project1/cart/index');
            exit;
        } else {
            die("Lỗi: Không thể xóa sạch giỏ hàng.");
        }
    }
}