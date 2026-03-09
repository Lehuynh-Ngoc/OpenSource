<?php
class Database {
    private $host = "localhost";
    private $db_name = "webbanhang";
    private $username = "root";
    private $password = ""; 
    protected $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->conn->exec("CREATE DATABASE IF NOT EXISTS " . $this->db_name . " CHARACTER SET utf8 COLLATE utf8_unicode_ci");
            $this->conn->exec("USE " . $this->db_name);
            
            // 1. Bảng Danh mục (MỚI)
            $this->conn->exec("CREATE TABLE IF NOT EXISTS categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            // Thêm dữ liệu mẫu cho danh mục nếu trống
            $checkCat = $this->conn->query("SELECT COUNT(*) FROM categories")->fetchColumn();
            if ($checkCat == 0) {
                $this->conn->exec("INSERT INTO categories (name) VALUES ('Áo HUTECH'), ('Balo & Túi'), ('Phụ kiện khác')");
            }

            // 2. Bảng sản phẩm (CẬP NHẬT thêm category_id, description, stock)
            $this->conn->exec("CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                price INT NOT NULL,
                image VARCHAR(255) DEFAULT 'default.jpg',
                description TEXT,
                stock INT DEFAULT 10,
                category_id INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
            )");

            // Kiểm tra và cập nhật các cột thiếu
            $cols = [
                'category_id' => "INT AFTER image",
                'description' => "TEXT AFTER image",
                'stock' => "INT DEFAULT 10 AFTER price"
            ];
            foreach($cols as $col => $attr) {
                try {
                    $this->conn->query("SELECT $col FROM products LIMIT 1");
                } catch (Exception $e) {
                    $this->conn->exec("ALTER TABLE products ADD COLUMN $col $attr");
                }
            }

            // 3. Bảng giỏ hàng
            $this->conn->exec("CREATE TABLE IF NOT EXISTS cart (
                id INT AUTO_INCREMENT PRIMARY KEY,
                session_id VARCHAR(255) NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL DEFAULT 1,
                is_selected TINYINT(1) DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            )");

            // Kiểm tra xem cột is_selected đã tồn tại chưa
            try {
                $this->conn->query("SELECT is_selected FROM cart LIMIT 1");
            } catch (Exception $e) {
                $this->conn->exec("ALTER TABLE cart ADD COLUMN is_selected TINYINT(1) DEFAULT 1 AFTER quantity");
            }

            // 4. Bảng Người dùng (MỚI)
            $this->conn->exec("CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin', 'user') DEFAULT 'user',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            // 5. Bảng Đơn hàng (MỚI)
            $this->conn->exec("CREATE TABLE IF NOT EXISTS orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                total_amount INT NOT NULL,
                payment_method ENUM('pay_later', 'checkout') DEFAULT 'pay_later',
                status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
            )");

            // 6. Bảng Chi tiết đơn hàng (MỚI)
            $this->conn->exec("CREATE TABLE IF NOT EXISTS order_items (
                id INT AUTO_INCREMENT PRIMARY KEY,
                order_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL,
                price INT NOT NULL,
                FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            )");

            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Lỗi kết nối Database: " . $exception->getMessage();
        }
        return $this->conn;
    }
}