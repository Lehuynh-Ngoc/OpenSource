<?php
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';

class AdminController {
    private $model;
    private $categoryModel;

    public function __construct() { 
        $this->model = new ProductModel(); 
        $this->categoryModel = new CategoryModel();
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

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $categoryId = $_POST['category_id'] ?? null;
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

            if ($this->model->add($name, $price, $imageName, $categoryId)) {
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

            if ($this->model->update($id, $name, $price, $image, $categoryId)) {
                header('Location: /Project1/admin/index');
                exit;
            } else {
                die("Lỗi: Không thể cập nhật sản phẩm.");
            }
        }
    }
}