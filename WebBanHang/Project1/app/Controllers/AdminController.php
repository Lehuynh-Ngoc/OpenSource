<?php
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';
require_once 'app/models/UserModel.php';

class AdminController {
    private $model;
    private $categoryModel;
    private $userModel;

    public function __construct() { 
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Ép quyền Admin nếu tên đăng nhập là admin để tránh lỗi phiên làm việc
        if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
            $_SESSION['role'] = 'admin';
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /Project1/auth/login');
            exit;
        }
        $this->model = new ProductModel(); 
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
    }

    public function index() {
        $products = $this->model->getAll();
        require_once 'app/views/admin/list.php';
    }

    public function create() { 
        $categories = $this->categoryModel->getAll();
        require_once 'app/views/admin/create.php'; 
    }

    private function uploadImage($file) {
        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0777, true);
        }
        $fileName = time() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $fileName;
        }
        return false;
    }

    // --- QUẢN LÝ NGƯỜI DÙNG ---
    public function users() {
        $users = $this->userModel->getAll();
        require_once 'app/views/admin/user_list.php';
    }

    public function update_user_role($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $_POST['role'] ?? 'user';
            $this->userModel->updateRole($id, $role);
            header('Location: /Project1/admin/users');
            exit;
        }
    }

    public function delete_user($id) {
        $this->userModel->delete($id);
        header('Location: /Project1/admin/users');
        exit;
    }

    // --- QUẢN LÝ DANH MỤC ---
    public function categories() {
        $categories = $this->categoryModel->getAll();
        require_once 'app/views/admin/category_list.php';
    }

    public function category_create() {
        require_once 'app/views/admin/category_create.php';
    }

    public function category_store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            if (!empty($name)) {
                $this->categoryModel->add($name);
                header('Location: /Project1/admin/categories');
                exit;
            }
        }
    }

    public function category_edit($id) {
        $category = $this->categoryModel->getById($id);
        if ($category) {
            require_once 'app/views/admin/category_edit.php';
        }
    }

    public function category_update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            if (!empty($name)) {
                $this->categoryModel->update($id, $name);
                header('Location: /Project1/admin/categories');
                exit;
            }
        }
    }

    public function category_delete($id) {
        $this->categoryModel->delete($id);
        header('Location: /Project1/admin/categories');
        exit;
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $categoryId = $_POST['category_id'] ?? null;
            $description = $_POST['description'] ?? '';
            $stock = $_POST['stock'] ?? 10;
            if ($categoryId === '') $categoryId = null; // Convert empty string to null
            $imageName = 'default.jpg'; 

            if (empty($name) || empty($price)) {
                die("Lỗi: Vui lòng nhập đầy đủ Tên và Giá sản phẩm.");
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploaded = $this->uploadImage($_FILES['image']);
                if ($uploaded) {
                    $imageName = $uploaded;
                }
            }

            if ($this->model->add($name, $price, $imageName, $categoryId, $description, $stock)) {
                header('Location: /Project1/admin/index');
                exit;
            } else {
                die("Lỗi Database: Không thể thực hiện lệnh INSERT.");
            }
        }
    }

    public function delete($id) {
        $this->model->delete($id);
        header('Location: /Project1/admin/index');
        exit;
    }

    public function edit($id) {
        $product = $this->model->getById($id);
        $categories = $this->categoryModel->getAll();
        if (!$product) {
            die('Sản phẩm không tồn tại');
        }
        require_once 'app/views/admin/edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $categoryId = $_POST['category_id'] ?? null;
            $description = $_POST['description'] ?? '';
            $stock = $_POST['stock'] ?? 10;
            if ($categoryId === '') $categoryId = null;
            
            $product = $this->model->getById($id);
            if (!$product) {
                 die('Sản phẩm không tồn tại');
            }
            
            $image = $product['image']; 

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploaded = $this->uploadImage($_FILES['image']);
                if ($uploaded) {
                    $uploadDir = __DIR__ . '/../../public/uploads/';
                    if ($product['image'] !== 'default.jpg' && file_exists($uploadDir . $product['image'])) {
                        @unlink($uploadDir . $product['image']);
                    }
                    $image = $uploaded;
                }
            }

            if ($this->model->update($id, $name, $price, $image, $categoryId, $description, $stock)) {
                header('Location: /Project1/admin/index');
                exit;
            } else {
                die("Lỗi: Không thể cập nhật sản phẩm.");
            }
        }
    }
}