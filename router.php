<?php
// router.php - Dành cho PHP built-in server

$uri = $_SERVER["REQUEST_URI"];
$path = parse_url($uri, PHP_URL_PATH);

// 1. Xử lý tiền tố /Project1/ một cách an toàn
// Nếu path là "/Project1/product/index" -> biến nó thành "/product/index"
if (strpos($path, '/Project1') === 0) {
    $path = substr($path, strlen('/Project1'));
}

// Đảm bảo path không trống
if ($path === '' || $path === '/') {
    $path = '/';
}

// 2. Kiểm tra tệp tĩnh (CSS, JS, Image)
$file = __DIR__ . $path;
if ($path !== '/' && file_exists($file) && !is_dir($file)) {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if ($ext !== 'php') {
        $mime_types = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
        ];
        header("Content-Type: " . ($mime_types[$ext] ?? 'application/octet-stream'));
        readfile($file);
        return true;
    }
}

// 3. Gán giá trị cho $_GET['url'] để index.php xử lý
// Loại bỏ dấu gạch chéo ở đầu: "/product/index" -> "product/index"
$_GET['url'] = ltrim($path, '/');

// 4. Gọi file index.php gốc
require 'index.php';