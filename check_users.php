<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'app/models/Database.php';
require_once 'app/models/UserModel.php';

$userModel = new UserModel();

// --- POWER FIX LOGIC ---
if (isset($_GET['action']) && $_GET['action'] === 'force_admin') {
    $db = (new Database())->getConnection();
    // 1. Reset admin role in DB
    $stmt = $db->prepare("UPDATE users SET role = 'admin' WHERE username = 'admin'");
    $stmt->execute();
    
    // 2. Find the admin user
    $stmt = $db->prepare("SELECT * FROM users WHERE username = 'admin'");
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        // 3. Force session
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['role'] = 'admin';
        header('Location: /Project1/admin/index');
        exit;
    } else {
        die("Loi: Tai khoan 'admin' khong ton tai. Hay chay create_admin.php truoc.");
    }
}

// --- DISPLAY LOGIC ---
$users = $userModel->getAll();

echo "<style>body{font-family:sans-serif; padding:20px; line-height:1.6;} table{border-collapse:collapse; width:100%; margin-bottom:20px;} th,td{border:1px solid #ddd; padding:12px; text-align:left;} th{background:#f4f4f4;} .status-ok{color:green; font-weight:bold;} .status-error{color:red; font-weight:bold;}</style>";

echo "<h1>HE THONG KIEM TRA & SUA LOI</h1>";

echo "<h3>1. Danh sach nguoi dung trong Database:</h3>";
echo "<table>";
echo "<tr><th>ID</th><th>Username</th><th>Role (Phai la 'admin')</th></tr>";
foreach ($users as $u) {
    $is_admin_role = ($u['role'] === 'admin');
    echo "<tr>";
    echo "<td>" . $u['id'] . "</td>";
    echo "<td>" . htmlspecialchars($u['username']) . "</td>";
    echo "<td class='".($is_admin_role ? 'status-ok' : 'status-error')."'>" . htmlspecialchars($u['role']) . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h3>2. Du lieu Session hien tai:</h3>";
echo "<pre style='background:#f9f9f9; pading:15px; border:1px solid #ccc;'>";
print_r($_SESSION);
echo "</pre>";

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    echo "<p class='status-ok'>CHUC MUNG: Session cua ban dang co quyen 'admin'.</p>";
} else {
    echo "<p class='status-error'>CANH BAO: Session cua ban KHONG co quyen 'admin'.</p>";
}

echo "<hr>";
echo "<h3>3. Giai phap:</h3>";
echo "<ul>";
echo "<li><a href='?action=force_admin' style='background:orange; color:white; padding:10px 20px; text-decoration:none; border-radius:5px; font-weight:bold;'>BAM VAO DAY DE TU DONG SUA LOI & DANG NHAP ADMIN</a></li>";
echo "<li style='margin-top:20px;'><a href='/Project1/product/index'>Quay lai Trang chu</a></li>";
echo "</ul>";
