<?php
// setup_db.php - File tự động tạo Database cho người dùng

$host = "localhost";
$username = "root";
$password = ""; // Mặc định của Laragon/XAMPP là để trống

try {
    // 1. Kết nối đến MySQL (chưa chọn database)
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Tạo Database
    $sql = "CREATE DATABASE IF NOT EXISTS webbanhang CHARACTER SET utf8 COLLATE utf8_unicode_ci";
    $conn->exec($sql);
    echo "1. Đã tạo Database 'webbanhang' thành công!<br>";

    // 3. Chọn Database vừa tạo
    $conn->exec("USE webbanhang");

    // 4. Tạo bảng products
    $sqlTable = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        price INT NOT NULL,
        image VARCHAR(255) DEFAULT 'default.jpg',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($sqlTable);
    echo "2. Đã tạo bảng 'products' thành công!<br>";

    // 5. Thêm dữ liệu mẫu (nếu bảng trống)
    $checkEmpty = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
    if ($checkEmpty == 0) {
        $sqlInsert = "INSERT INTO products (name, price, image) VALUES 
            ('Áo Thun HUTECH', 150000, 'default.jpg'),
            ('Balo HUTECH', 300000, 'default.jpg'),
            ('Mũ Bảo Hiểm HUTECH', 250000, 'default.jpg')";
        $conn->exec($sqlInsert);
        echo "3. Đã thêm dữ liệu mẫu thành công!<br>";
    }

    echo "<br><b style='color:green;'>TẤT CẢ ĐÃ SẴN SÀNG!</b><br>";
    echo "<a href='product/index'>Click vào đây để xem trang sản phẩm</a>";

} catch(PDOException $e) {
    echo "<b style='color:red;'>LỖI THIẾT LẬP:</b> " . $e->getMessage();
}
?>