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

            // 5. Bảng Đơn hàng (CẬP NHẬT)
            $this->conn->exec("CREATE TABLE IF NOT EXISTS orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                customer_name VARCHAR(255),
                customer_phone VARCHAR(20),
                customer_address TEXT,
                total_before_discount INT NOT NULL,
                discount_amount INT DEFAULT 0,
                total_amount INT NOT NULL,
                voucher_code VARCHAR(50),
                payment_method VARCHAR(50) DEFAULT 'pay_later',
                status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
            )");

            // Kiểm tra và cập nhật các cột thiếu cho orders
            $orderCols = [
                'customer_name' => "VARCHAR(255) AFTER user_id",
                'customer_phone' => "VARCHAR(20) AFTER customer_name",
                'customer_address' => "TEXT AFTER customer_phone",
                'total_before_discount' => "INT NOT NULL AFTER customer_address",
                'discount_amount' => "INT DEFAULT 0 AFTER total_before_discount",
                'voucher_code' => "VARCHAR(50) AFTER total_amount"
            ];
            foreach($orderCols as $col => $attr) {
                try {
                    $this->conn->query("SELECT $col FROM orders LIMIT 1");
                } catch (Exception $e) {
                    $this->conn->exec("ALTER TABLE orders ADD COLUMN $col $attr");
                }
            }

            // 7. Bảng Khuyến mãi (Promotions - cho sản phẩm hoặc danh mục)
            $this->conn->exec("CREATE TABLE IF NOT EXISTS promotions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                type ENUM('product', 'category') NOT NULL,
                target_id INT NOT NULL,
                discount_type ENUM('fixed', 'percent') NOT NULL,
                discount_value INT NOT NULL,
                start_date DATETIME,
                end_date DATETIME,
                status TINYINT(1) DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            // Kiểm tra và cập nhật các cột thiếu cho promotions
            $promoCols = [
                'start_date' => "DATETIME AFTER discount_value",
                'end_date' => "DATETIME AFTER start_date"
            ];
            foreach($promoCols as $col => $attr) {
                try {
                    $this->conn->query("SELECT $col FROM promotions LIMIT 1");
                } catch (Exception $e) {
                    $this->conn->exec("ALTER TABLE promotions ADD COLUMN $col $attr");
                }
            }

            // 8. Bảng Voucher (Mã giảm giá cho đơn hàng)
            $this->conn->exec("CREATE TABLE IF NOT EXISTS vouchers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                code VARCHAR(50) NOT NULL UNIQUE,
                discount_type ENUM('fixed', 'percent') NOT NULL,
                discount_value INT NOT NULL,
                min_order_value INT DEFAULT 0,
                usage_limit INT DEFAULT 1,
                used_count INT DEFAULT 0,
                expiry_date DATE,
                status TINYINT(1) DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Lỗi kết nối Database: " . $exception->getMessage();
        }
        return $this->conn;
    }
}