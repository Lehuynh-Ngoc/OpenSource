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
            
            // Bảng sản phẩm
            $this->conn->exec("CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                price INT NOT NULL,
                image VARCHAR(255) DEFAULT 'default.jpg',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            // Bảng giỏ hàng (MỚI)
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