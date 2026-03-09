<?php
require_once 'app/models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->login($username, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // ÉP BUỘC: Nếu tên là admin thì chắc chắn quyền là admin
                if ($user['username'] === 'admin') {
                    $_SESSION['role'] = 'admin';
                } else {
                    $_SESSION['role'] = $user['role'];
                }

                // Chuyển hướng dựa trên quyền
                if ($_SESSION['role'] === 'admin') {
                    header('Location: /Project1/admin/index');
                } else {
                    header('Location: /Project1/product/index');
                }
                exit;
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
            }
        }
        require_once 'app/views/auth/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm_password) {
                $error = "Mật khẩu xác nhận không khớp!";
            } else {
                try {
                    if ($this->userModel->register($username, $password)) {
                        header('Location: /Project1/auth/login');
                        exit;
                    } else {
                        $error = "Có lỗi xảy ra trong quá trình đăng ký!";
                    }
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        $error = "Tên đăng nhập '$username' đã tồn tại. Vui lòng chọn tên khác!";
                    } else {
                        $error = "Lỗi Database: " . $e->getMessage();
                    }
                }
            }
        }
        require_once 'app/views/auth/register.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /Project1/auth/login');
        exit;
    }
}