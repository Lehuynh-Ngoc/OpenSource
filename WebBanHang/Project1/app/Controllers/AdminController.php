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

    public function store() {
        if ($_POST) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $imageName = 'default.jpg'; // Ảnh mặc định

            // Xử lý Upload Ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $imageName = time() . '_' . $_FILES['image']['name'];
                $target = 'public/uploads/' . $imageName;
                
                // Di chuyển file vào thư mục đích
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    die("Lỗi: Không thể upload ảnh.");
                }
            }

            $this->model->add($name, $price, $imageName);
            header('Location: /Project1/admin/index');
        }
    }

    public function delete($id) {
        $this->model->delete($id);
        header('Location: /Project1/admin/index');
    }

    public function edit($id) {
        $product = $this->model->getById($id);
        require_once 'app/views/admin/edit.php';
    }

    public function update($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        
        $product = $this->model->getById($id);
        $image = $product['image']; 

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            // Sử dụng __DIR__ để xác định đường dẫn tuyệt đối từ thư mục hiện tại
            // Giả sử AdminController nằm trong app/Controllers, ta cần lùi ra 2 cấp để vào public/uploads
            $uploadDir = realpath(__DIR__ . '/../../public/uploads/') . DIRECTORY_SEPARATOR;
            
            // Kiểm tra nếu thư mục không tồn tại thì tạo mới
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Xóa ảnh cũ (nếu cần)
                if ($product['image'] !== 'default.jpg' && file_exists($uploadDir . $product['image'])) {
                    unlink($uploadDir . $product['image']);
                }
                $image = $fileName; 
            } else {
                die("Lỗi: Không thể di chuyển file vào thư mục $uploadDir. Hãy kiểm tra quyền ghi.");
            }
        }

        $this->model->update($id, $name, $price, $image);
        header('Location: /Project1/admin/index');
        exit;
    }
}
}