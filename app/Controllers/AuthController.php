<?php
require_once 'app/models/UserModel.php';
require_once 'app/models/OrderModel.php';
require_once 'app/models/ReviewModel.php';

class AuthController {
    private $userModel;
    private $orderModel;
    private $reviewModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->orderModel = new OrderModel();
        $this->reviewModel = new ReviewModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function profile() {
        if (!isset($_SESSION['username'])) {
            header('Location: /Project1/auth/login');
            exit;
        }
        $user = $this->userModel->getUserByUsername($_SESSION['username']);
        
        // Nếu là Admin thì lấy toàn bộ đơn hàng, nếu là User thường thì chỉ lấy đơn của họ
        if ($user['role'] === 'admin' || $user['username'] === 'admin') {
            $allOrders = $this->orderModel->getAllOrders();
        } else {
            $allOrders = $this->orderModel->getOrdersByUserId($user['id']);
        }
        
        // Lọc trùng lặp ngay tại Controller để đảm bảo tính nhất quán
        $orders = [];
        $ids = [];
        foreach ($allOrders as $o) {
            if (!in_array($o['id'], $ids)) {
                $ids[] = $o['id'];
                $orders[] = $o;
            }
        }
        
        foreach ($orders as &$order) {
            $order['items'] = $this->orderModel->getOrderItems($order['id']);
            // Kiểm tra từng sản phẩm trong đơn đã được đánh giá chưa
            foreach ($order['items'] as &$item) {
                $item['is_reviewed'] = $this->reviewModel->checkUserReviewed($item['product_id'], $user['id'], $order['id']);
            }
        }
        
        require_once 'app/views/auth/profile.php';
    }

    public function submit_review() {
        if (!isset($_SESSION['username'])) exit;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'];
            $orderId = $_POST['order_id'];
            $rating = $_POST['rating'];
            $comment = $_POST['comment'];
            $userId = $_SESSION['user_id'];

            $this->reviewModel->add($productId, $userId, $orderId, $rating, $comment);
            header('Location: /Project1/auth/profile');
            exit;
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