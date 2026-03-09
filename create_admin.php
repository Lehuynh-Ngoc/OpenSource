<?php
require_once 'app/models/Database.php';

class UltimateFix extends Database {
    public function run() {
        $db = $this->getConnection();
        
        echo "<h1>DANG TIEN HANH SUA LOI TRIET DE...</h1>";
        
        // 1. Xóa bảng users cũ (nếu có) để làm mới hoàn toàn
        $db->exec("DROP TABLE IF EXISTS cart"); // Xóa cart trước vì có khóa ngoại
        $db->exec("DROP TABLE IF EXISTS users");
        echo "- Da xoa bang cu de lam moi.<br>";
        
        // 2. Tạo lại bảng users với cấu trúc CHUẨN
        $db->exec("CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'user') DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        echo "- Da tao lai bang users moi.<br>";

        // 3. Tạo lại bảng cart (vì vừa xóa ở bước 1)
        $db->exec("CREATE TABLE cart (
            id INT AUTO_INCREMENT PRIMARY KEY,
            session_id VARCHAR(255) NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        )");
        echo "- Da tao lai bang cart.<br>";
        
        // 4. Tạo tài khoản admin duy nhất
        $username = 'admin';
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $role = 'admin';
        
        $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (:u, :p, :r)");
        $stmt->execute([':u' => $username, ':p' => $password, ':r' => $role]);
        
        // 5. Kiểm tra kết quả trong Database
        $check = $db->prepare("SELECT role FROM users WHERE username = 'admin'");
        $check->execute();
        $realRole = $check->fetchColumn();
        
        echo "<h2>KET QUA:</h2>";
        echo "Quyen cua admin trong DB: <b style='color:green;'>" . $realRole . "</b> (Phai la admin moi dung)<br>";
        
        // 6. Xóa session
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        
        echo "<br><b style='color:red;'>LUU Y: He thong da lam moi hoan toan.</b><br>";
        echo "<br><a href='/Project1/auth/login' style='font-size:20px; font-weight:bold; color:blue;'>NHAN VAO DAY DE DANG NHAP LAI</a>";
    }
}

$fixer = new UltimateFix();
$fixer->run();
