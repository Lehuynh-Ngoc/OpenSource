<?php
// Nạp Model vào để sử dụng
require_once 'app/models/ProductModel.php';
require_once 'app/models/CartModel.php';

class ProductController {
    private $model;
    private $cartModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->model = new ProductModel();
        $this->cartModel = new CartModel();
    }

    // Trang danh sách sản phẩm (Trang chủ người dùng)
    public function index() {
        $products = $this->model->getAll();
        
        // Lấy số lượng giỏ hàng thực tế từ Database
        $cartCount = $this->cartModel->countItems(session_id());
        
        // Truyền dữ liệu sang View hiển thị cho khách hàng
        require_once 'app/views/products.php';
    }

    // Trang chi tiết sản phẩm
    public function detail($id) {
        $product = $this->model->getById($id);
        
        if ($product) {
            // Bạn có thể tạo thêm file view chi tiết, ở đây tôi demo hiển thị nhanh
            echo "<h1>Chi tiết: " . $product['name'] . "</h1>";
            echo "Giá: " . number_format($product['price']) . "đ";
        } else {
            echo "Sản phẩm không tồn tại!";
        }
    }
}