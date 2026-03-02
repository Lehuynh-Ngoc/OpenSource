<?php
require_once 'app/models/ProductModel.php';

class AdminController {
    private $model;
    public function __construct() { $this->model = new ProductModel(); }

    public function index() {
        $products = $this->model->getAll();
        require_once 'app/views/admin/list.php';
    }

    public function create() { require_once 'app/views/admin/create.php'; }

    // Helper function to handle image upload
    private function uploadImage($file) {
        // Define upload directory relative to this controller file
        // app/Controllers/../../public/uploads/ => public/uploads/
        $uploadDir = __DIR__ . '/../../public/uploads/';
        
        // Create directory if it doesn't exist
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
            $imageName = 'default.jpg'; 

            // Kiểm tra dữ liệu đầu vào
            if (empty($name) || empty($price)) {
                die("Lỗi: Vui lòng nhập đầy đủ Tên và Giá sản phẩm.");
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploaded = $this->uploadImage($_FILES['image']);
                if ($uploaded) {
                    $imageName = $uploaded;
                }
            }

            if ($this->model->add($name, $price, $imageName)) {
                // Sau khi lưu thành công, quay về danh sách
                header('Location: /Project1/admin/index');
                exit;
            } else {
                die("Lỗi Database: Không thể thực hiện lệnh INSERT vào bảng products.");
            }
        } else {
            die("Lỗi: Phương thức yêu cầu không hợp lệ (Phải là POST).");
        }
    }

    public function delete($id) {
        $this->model->delete($id);
        header('Location: /Project1/admin/index');
        exit;
    }

    public function edit($id) {
        $product = $this->model->getById($id);
        if (!$product) {
            die('Sản phẩm không tồn tại');
        }
        require_once 'app/views/admin/edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            
            $product = $this->model->getById($id);
            if (!$product) {
                 die('Sản phẩm không tồn tại');
            }
            
            $image = $product['image']; 

            // Nếu có upload ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploaded = $this->uploadImage($_FILES['image']);
                if ($uploaded) {
                    // Xóa ảnh cũ nếu không phải default
                    $uploadDir = __DIR__ . '/../../public/uploads/';
                    if ($product['image'] !== 'default.jpg' && file_exists($uploadDir . $product['image'])) {
                        @unlink($uploadDir . $product['image']);
                    }
                    $image = $uploaded;
                }
            }

            if ($this->model->update($id, $name, $price, $image)) {
                header('Location: /Project1/admin/index');
                exit;
            } else {
                die("Lỗi: Không thể cập nhật sản phẩm.");
            }
        }
    }
}
