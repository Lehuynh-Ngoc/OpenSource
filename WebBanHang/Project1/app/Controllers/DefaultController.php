<?php
class DefaultController
{
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        // Nếu chưa đăng nhập, trang đầu tiên hiện ra sẽ là trang đăng nhập
        if (!isset($_SESSION['username'])) {
            header('Location: /Project1/auth/login');
            exit;
        }

        // Nếu đã đăng nhập, tùy theo quyền mà chuyển hướng
        if ($_SESSION['role'] === 'admin') {
            header('Location: /Project1/admin/index');
        } else {
            header('Location: /Project1/product/index');
        }
        exit;
    }
}