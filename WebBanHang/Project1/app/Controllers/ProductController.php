<?php
// Nạp Model vào để sử dụng
require_once 'app/models/ProductModel.php';
require_once 'app/models/CartModel.php';
require_once 'app/models/CategoryModel.php';

class ProductController {
    private $model;
    private $cartModel;
    private $categoryModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->model = new ProductModel();
        $this->cartModel = new CartModel();
        $this->categoryModel = new CategoryModel();
    }

    // Trang danh sách sản phẩm (Trang chủ người dùng)
    public function index($categoryId = null) {
        // Lấy danh sách sản phẩm (có thể lọc theo category)
        $products = $this->model->getAll($categoryId);
        
        // Lấy danh sách danh mục để hiện menu
        $categories = $this->categoryModel->getAll();
        
        // Lấy số lượng giỏ hàng
        $cartCount = $this->cartModel->countItems(session_id());
        
        // Truyền dữ liệu sang View
        require_once 'app/views/products.php';
    }

    public function detail($id) {
        $product = $this->model->getById($id);
        if ($product) {
            echo "<h1>Chi tiết: " . $product['name'] . "</h1>";
        } else {
            echo "Sản phẩm không tồn tại!";
        }
    }
}