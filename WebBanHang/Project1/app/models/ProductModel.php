<?php
class ProductModel {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = [
                // Bổ sung thêm trường image cho dữ liệu mẫu
                ['id' => 1, 'name' => 'Áo Thun HUTECH', 'price' => 150000, 'image' => 'default.jpg'],
                ['id' => 2, 'name' => 'Balo HUTECH', 'price' => 300000, 'image' => 'default.jpg']
            ];
        }
    }

    public function getAll() { return $_SESSION['products']; }

    public function getById($id) {
        foreach ($_SESSION['products'] as $p) {
            if ($p['id'] == $id) return $p;
        }
        return null;
    }

    // Thêm tham số $image vào hàm add
    public function add($name, $price, $image = 'default.jpg') {
    $id = time(); 
    $_SESSION['products'][] = [
        'id' => $id, 
        'name' => $name, 
        'price' => $price, 
        'image' => $image ?: 'default.jpg' // Nếu $image trống thì dùng mặc định
    ];
}

    public function delete($id) {
        $_SESSION['products'] = array_filter($_SESSION['products'], fn($p) => $p['id'] != $id);
    }

    // Thêm tham số $image và sửa lỗi dấu => thành dấu =
   public function update($id, $name, $price, $image) {
    if (isset($_SESSION['products'])) {
        foreach ($_SESSION['products'] as &$p) { // BẮT BUỘC phải có dấu &
            if ($p['id'] == $id) {
                $p['name'] = $name;
                $p['price'] = (int)$price;
                $p['image'] = $image;
                return true; // Thoát hàm ngay khi tìm thấy và sửa xong
            }
        }
    }
    return false;
}
}