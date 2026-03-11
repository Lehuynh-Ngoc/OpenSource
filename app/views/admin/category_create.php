<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm danh mục - Admin</title>
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
            <div class="mb-10">
                <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Thêm danh mục mới</h2>
                <p class="text-gray-500 font-medium">Tạo danh mục mới để phân loại sản phẩm.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-sm p-8 border border-gray-100 max-w-2xl">
                <form action="/Project1/admin/category_store" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Tên danh mục</label>
                        <input type="text" name="name" required placeholder="Nhập tên danh mục..."
                               class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-orange-500 outline-none transition font-bold text-lg">
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 bg-orange-500 text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-orange-600 shadow-xl shadow-orange-100 transition active:scale-95">
                            Lưu danh mục
                        </button>
                        <a href="/Project1/admin/categories" class="flex-1 bg-gray-100 text-gray-600 py-4 rounded-2xl font-black text-center uppercase tracking-widest hover:bg-gray-200 transition">
                            Hủy bỏ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>