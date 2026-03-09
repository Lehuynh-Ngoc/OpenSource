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
        if (!isset($_SESSION['username'])) {
            header('Location: /Project1/auth/login');
            exit;
        }

        $search = isset($_GET['search']) ? $_GET['search'] : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : null;

        // Lấy danh sách sản phẩm (có thể lọc theo category, tìm kiếm, sắp xếp)
        $products = $this->model->getAll($categoryId, $search, $sort);
        
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
            // Lấy thêm tên danh mục để hiển thị
            $categories = $this->categoryModel->getAll();
            foreach($categories as $cat) {
                if ($cat['id'] == $product['category_id']) {
                    $product['category_name'] = $cat['name'];
                    break;
                }
            }
            require_once 'app/views/product_detail.php';
        } else {
            die("Sản phẩm không tồn tại!");
        }
    }
}