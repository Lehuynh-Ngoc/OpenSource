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

            // 2. Bảng sản phẩm (CẬP NHẬT thêm category_id)
            $this->conn->exec("CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                price INT NOT NULL,
                image VARCHAR(255) DEFAULT 'default.jpg',
                category_id INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
            )");

            // Kiểm tra xem cột category_id đã tồn tại chưa (phòng trường hợp bảng products đã có từ trước)
            try {
                $this->conn->query("SELECT category_id FROM products LIMIT 1");
            } catch (Exception $e) {
                $this->conn->exec("ALTER TABLE products ADD COLUMN category_id INT AFTER image");
                $this->conn->exec("ALTER TABLE products ADD FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL");
            }

            // 3. Bảng giỏ hàng
            $this->conn->exec("CREATE TABLE IF NOT EXISTS cart (
                id INT AUTO_INCREMENT PRIMARY KEY,
                session_id VARCHAR(255) NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            )");

            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Lỗi kết nối Database: " . $exception->getMessage();
        }
        return $this->conn;
    }
}