<?php
require_once 'app/models/CartModel.php';

class CartController {
    private $cartModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->cartModel = new CartModel();
    }

    // Hiển thị giỏ hàng từ Database
    public function index() {
        $sessionId = session_id();
        $cart = $this->cartModel->getCartItems($sessionId);
        require_once 'app/views/cart.php';
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