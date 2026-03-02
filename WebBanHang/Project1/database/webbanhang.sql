CREATE DATABASE IF NOT EXISTS webbanhang;
USE webbanhang;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dữ liệu mẫu
INSERT INTO products (name, price, image) VALUES 
('Áo Thun HUTECH', 150000, 'default.jpg'),
('Balo HUTECH', 300000, 'default.jpg');