<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 text-white min-h-screen p-6 sticky top-0 flex flex-col">
            <h2 class="text-2xl font-black mb-10 italic tracking-tighter uppercase">HUTECH <span class="text-orange-500 italic">CP</span></h2>
            <nav class="space-y-2 flex-1">
                <a href="/Project1/admin/index" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 bg-orange-500 text-white shadow-lg shadow-orange-900/20">
                    <span class="mr-3 text-lg">📦</span> Sản phẩm
                </a>
                <a href="/Project1/admin/orders" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 text-gray-400 hover:bg-gray-800 hover:text-white">
                    <span class="mr-3 text-lg">📑</span> Đơn hàng
                </a>
                <a href="/Project1/admin/promotions" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 text-gray-400 hover:bg-gray-800 hover:text-white">
                    <span class="mr-3 text-lg">🎁</span> Ưu đãi
                </a>
                <a href="/Project1/admin/users" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 text-gray-400 hover:bg-gray-800 hover:text-white">
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
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Quản lý Sản phẩm</h2>
                    <p class="text-gray-500 font-medium">Bạn đang có <?= count($products) ?> sản phẩm trong kho.</p>
                </div>
                <div class="flex gap-4">
                    <a href="/Project1/admin/categories" class="bg-[#0054a6] text-white px-8 py-3 rounded-2xl font-black uppercase tracking-widest hover:bg-blue-700 shadow-xl shadow-blue-100 transition active:scale-95">
                        📂 Quản lý danh mục
                    </a>
                    <a href="/Project1/admin/create" class="bg-orange-500 text-white px-8 py-3 rounded-2xl font-black uppercase tracking-widest hover:bg-orange-600 shadow-xl shadow-orange-100 transition active:scale-95">
                        + Thêm sản phẩm mới
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr class="text-gray-400 text-xs font-black uppercase tracking-widest">
                            <th class="p-6">Ảnh</th>
                            <th class="p-6">Tên sản phẩm</th>
                            <th class="p-6">Giá niêm yết</th>
                            <th class="p-6">Số lượng</th>
                            <th class="p-6 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (!empty($products)): foreach($products as $p): ?>
                        <tr class="hover:bg-blue-50/30 transition group">
                            <td class="p-6">
                                <img src="/Project1/public/uploads/<?= $p['image'] ?>" class="w-16 h-16 object-cover rounded-xl border group-hover:scale-105 transition">
                            </td>
                            <td class="p-6">
                                <span class="font-black text-gray-800 text-lg uppercase"><?= htmlspecialchars($p['name']) ?></span>
                            </td>
                            <td class="p-6">
                                <span class="font-black text-[#0054a6] text-xl"><?= number_format($p['price']) ?>đ</span>
                            </td>
                            <td class="p-6">
                                <span class="font-black text-gray-600"><?= $p['stock'] ?? 0 ?></span>
                            </td>
                            <td class="p-6 text-center">
                                <div class="flex justify-center gap-4">
                                    <a href="/Project1/admin/edit/<?= $p['id'] ?>" class="text-blue-500 hover:text-blue-700 font-black text-xs uppercase tracking-widest">Sửa</a>
                                    <a href="/Project1/admin/delete/<?= $p['id'] ?>" onclick="return confirm('Xác nhận xóa?')" class="text-red-400 hover:text-red-600 font-black text-xs uppercase tracking-widest">Xóa</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="4" class="p-20 text-center text-gray-400 font-bold italic uppercase tracking-widest">Kho hàng trống rỗng</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <p class="text-center mt-10 text-gray-300 text-[10px] font-black uppercase tracking-[0.5em]">HUTECH Management System v2.0</p>
        </div>
    </div>
</body>
</html>