<?php
require_once 'app/models/ProductModel.php';

class CartController {
    private $productModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->productModel = new ProductModel();
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    }

    // Hiển thị giỏ hàng
    public function index() {
        $cart = $_SESSION['cart'];
        require_once 'app/views/cart.php';
    }

    // Thêm sản phẩm vào giỏ (ĐÃ CẬP NHẬT ĐỂ NHẬN SỐ LƯỢNG)
    public function add($id) {
        // Lấy thông tin sản phẩm từ Model
        $product = $this->productModel->getById($id);
        
        // Lấy số lượng từ form gửi lên qua phương thức POST
        // Nếu không có hoặc giá trị không hợp lệ, mặc định là 1
        $quantityToAdd = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        if ($quantityToAdd < 1) $quantityToAdd = 1;

        if ($product) {
            if (isset($_SESSION['cart'][$id])) {
                // Nếu sản phẩm đã có trong giỏ, cộng dồn số lượng mới vào
                $_SESSION['cart'][$id]['quantity'] += $quantityToAdd;
            } else {
                // Nếu sản phẩm chưa có, thêm mới với số lượng tương ứng
                $_SESSION['cart'][$id] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => isset($product['image']) ? $product['image'] : 'default.jpg',
                    'quantity' => $quantityToAdd
                ];
            }
        }
        // Sau khi thêm, chuyển hướng về trang giỏ hàng để xem kết quả
        header('Location: /Project1/cart/index');
        exit;
    }

    // Xóa sản phẩm khỏi giỏ
    public function remove($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /Project1/cart/index');
        exit;
    }

    // Xóa sạch giỏ hàng
    public function clear() {
        $_SESSION['cart'] = [];
        header('Location: /Project1/cart/index');
        exit;
    }
}