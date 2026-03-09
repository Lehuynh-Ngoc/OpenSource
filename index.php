<?php
// 1. Khởi tạo Session để dùng cho giỏ hàng
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Thiết lập hiển thị lỗi (Bật để xem lỗi cụ thể)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. Nạp Database và Model trước để Controller có cái mà dùng
require_once __DIR__ . '/app/models/Database.php';
require_once __DIR__ . '/app/models/ProductModel.php';

// 3. Lấy URL từ biến $_GET['url'] (do .htaccess cung cấp)
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// 4. Xử lý trường hợp URL bắt đầu bằng 'Project1' (nếu .htaccess ở root đẩy sang)
if (isset($url[0]) && $url[0] === 'Project1') {
    array_shift($url);
}

// 5. Xác định tên Controller (Viết hoa chữ cái đầu)
$controllerName = (isset($url[0]) && $url[0] != '') ? ucfirst($url[0]) . 'Controller' : 'DefaultController';

// 6. Xác định Action
$action = (isset($url[1]) && $url[1] != '') ? $url[1] : 'index';

// 7. Xác định đường dẫn file Controller
$controllerFile = __DIR__ . '/app/Controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    echo "DEBUG: Đang tìm Controller: $controllerName<br>";
    echo "DEBUG: Đường dẫn file dự kiến: $controllerFile<br>";
    echo "DEBUG: Thư mục hiện tại: " . __DIR__ . "<br>";
    
    // Nếu không tìm thấy controller cụ thể, thử dùng DefaultController
    $controllerName = 'DefaultController';
    $controllerFile = __DIR__ . '/app/Controllers/' . $controllerName . '.php';
    if (!file_exists($controllerFile)) {
        die("Fatal Error: Không tìm thấy cả Controller yêu cầu lẫn DefaultController!");
    }
}

// 8. Nạp file và khởi tạo class
require_once $controllerFile;

if (!class_exists($controllerName)) {
    die("Class $controllerName không tồn tại trong file $controllerFile");
}

$controller = new $controllerName();

// 9. Kiểm tra hàm (Action) và thực thi
if (!method_exists($controller, $action)) {
    // Nếu không tìm thấy action, thử gọi action mặc định 'index'
    $action = 'index';
    if (!method_exists($controller, $action)) {
        die("Action not found trong $controllerName");
    }
}

// Gọi hàm và truyền các tham số còn lại
call_user_func_array([$controller, $action], array_slice($url, 2));