<?php
require_once 'app/models/CategoryModel.php';

class CategoryController {
    private $model;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->model = new CategoryModel();
    }

    // Hiển thị danh sách danh mục (Admin)
    public function index() {
        $categories = $this->model->getAll();
        require_once 'app/views/admin/category_list.php';
    }

    // Hiển thị form thêm mới
    public function create() {
        require_once 'app/views/admin/category_create.php';
    }

    // Lưu danh mục mới vào Database
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            if (empty($name)) {
                die("Lỗi: Tên danh mục không được để trống.");
            }

            if ($this->model->add($name)) {
                header('Location: /Project1/category/index');
                exit;
            } else {
                die("Lỗi: Không thể lưu danh mục vào cơ sở dữ liệu.");
            }
        }
    }

    // Hiển thị form sửa danh mục
    public function edit($id) {
        $category = $this->model->getById($id);
        if (!$category) {
            die('Danh mục không tồn tại');
        }
        require_once 'app/views/admin/category_edit.php';
    }

    // Cập nhật danh mục
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            if (empty($name)) {
                die("Lỗi: Tên danh mục không được để trống.");
            }

            if ($this->model->update($id, $name)) {
                header('Location: /Project1/category/index');
                exit;
            } else {
                die("Lỗi: Không thể cập nhật danh mục.");
            }
        }
    }

    // Xóa danh mục
    public function delete($id) {
        if ($this->model->delete($id)) {
            header('Location: /Project1/category/index');
            exit;
        } else {
            die("Lỗi: Không thể xóa danh mục.");
        }
    }
}