<?php
// Nạp Model vào để sử dụng
require_once 'app/models/ProductModel.php';

class ProductController {
    private $model;

    public function __construct() {
        // Khởi tạo Model để dùng chung cho các hàm bên dưới
        $this->model = new ProductModel();
    }

    // Trang danh sách sản phẩm (Trang chủ người dùng)
    public function index() {
        // Lấy dữ liệu thực tế từ Model (dữ liệu mà Admin đã thêm/xóa/sửa)
        $products = $this->model->getAll();
        
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