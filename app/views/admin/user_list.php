<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 text-white min-h-screen p-6 sticky top-0 flex flex-col">
            <h2 class="text-2xl font-black mb-10 italic tracking-tighter uppercase">HUTECH <span class="text-orange-500 italic">CP</span></h2>
            <nav class="space-y-2 flex-1">
                <a href="/Project1/admin/index" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 text-gray-400 hover:bg-gray-800 hover:text-white">
                    <span class="mr-3 text-lg">📦</span> Sản phẩm
                </a>
                <a href="/Project1/admin/promotions" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 text-gray-400 hover:bg-gray-800 hover:text-white">
                    <span class="mr-3 text-lg">🎁</span> Ưu đãi
                </a>
                <a href="/Project1/admin/users" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 bg-orange-500 text-white shadow-lg shadow-orange-900/20">
                    <span class="mr-3 text-lg">👥</span> Người dùng
                </a>
            </nav>

            <div class="pt-6 border-t border-gray-800 mt-auto">
                <a href="/Project1/product/index" class="flex items-center px-4 py-3 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] text-gray-500 hover:text-white transition-colors">
                    ← Xem Cửa Hàng
                </a>
                <a href="/Project1/auth/logout" class="flex items-center px-4 py-3 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] text-red-500/70 hover:text-red-500 transition-colors mt-2">
                    🚪 Đăng xuất
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-10">
            <div class="mb-10">
                <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Quản lý Người dùng</h2>
                <p class="text-gray-500 font-medium">Bạn đang có <?= count($users) ?> tài khoản trong hệ thống.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr class="text-gray-400 text-xs font-black uppercase tracking-widest">
                            <th class="p-6">ID</th>
                            <th class="p-6">Tên đăng nhập</th>
                            <th class="p-6 text-center">Vai trò</th>
                            <th class="p-6">Ngày tham gia</th>
                            <th class="p-6 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach($users as $user): ?>
                        <tr class="hover:bg-blue-50/30 transition group">
                            <td class="p-6 font-bold text-gray-400">#<?= $user['id'] ?></td>
                            <td class="p-6">
                                <span class="font-black text-gray-800 text-lg uppercase"><?= htmlspecialchars($user['username']) ?></span>
                            </td>
                            <td class="p-6 text-center">
                                <?php if ($user['username'] === 'admin'): ?>
                                    <span class="bg-red-50 text-red-600 px-4 py-1 rounded-full text-[10px] font-black uppercase border border-red-100">Super Admin</span>
                                <?php else: ?>
                                    <form action="/Project1/admin/update_user_role/<?= $user['id'] ?>" method="POST" class="inline-flex items-center gap-2">
                                        <select name="role" onchange="this.form.submit()" class="bg-gray-50 border-2 border-gray-100 text-[10px] font-black uppercase rounded-xl px-4 py-2 focus:border-orange-500 outline-none cursor-pointer">
                                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        </select>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td class="p-6 text-sm text-gray-500 font-medium"><?= $user['created_at'] ?></td>
                            <td class="p-6 text-center">
                                <?php if ($user['username'] !== 'admin'): ?>
                                    <a href="/Project1/admin/delete_user/<?= $user['id'] ?>" 
                                       onclick="return confirm('Xác nhận xóa người dùng này?')"
                                       class="text-red-400 hover:text-red-600 font-black text-xs uppercase tracking-widest">Xóa</a>
                                <?php else: ?>
                                    <span class="text-gray-300 text-[10px] font-black uppercase tracking-widest italic">Hệ thống</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <p class="text-center mt-10 text-gray-300 text-[10px] font-black uppercase tracking-[0.5em]">HUTECH Management System v2.0</p>
        </div>
    </div>
</body>
</html>