<?php
require_once 'app/models/PromotionModel.php';
require_once 'app/models/VoucherModel.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';

class DefaultController
{
    private $promotionModel;
    private $voucherModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->promotionModel = new PromotionModel();
        $this->voucherModel = new VoucherModel();
    }

    public function promotions() {
        $promotions = $this->promotionModel->getAll();
        $vouchers = $this->voucherModel->getAll();
        
        // Chỉ lấy những cái đang còn hạn/còn lượt dùng cho giao diện khách hàng
        $activePromotions = array_filter($promotions, function($p) {
            $now = new DateTime();
            $start = $p['start_date'] ? new DateTime($p['start_date']) : null;
            $end = $p['end_date'] ? new DateTime($p['end_date']) : null;
            if ($start && $now < $start) return false;
            if ($end && $now > $end) return false;
            return $p['status'] == 1;
        });

        $activeVouchers = array_filter($vouchers, function($v) {
            $now = new DateTime();
            $expiry = $v['expiry_date'] ? new DateTime($v['expiry_date']) : null;
            if ($expiry && $now > $expiry) return false;
            if ($v['used_count'] >= $v['usage_limit']) return false;
            return $v['status'] == 1;
        });

        require_once 'app/views/promotions.php';
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