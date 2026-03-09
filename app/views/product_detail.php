<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - HUTECH Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-[#0054a6] p-4 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-black italic tracking-tighter">HUTECH <a href="/Project1/product/index" class="text-orange-400 hover:underline">SHOP</a></h1>
            <ul class="flex space-x-6 items-center font-bold">
                <li><a href="/Project1/product/index" class="hover:text-orange-400 transition text-sm">Sản phẩm</a></li>
                <li class="relative">
                    <a href="/Project1/cart/index" class="hover:text-orange-400 transition flex items-center text-sm">
                        Giỏ hàng
                    </a>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Menu Quản lý Dropdown -->
                    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['username'] === 'admin'): ?>
                        <li class="group relative">
                            <button class="text-xs font-black uppercase tracking-widest bg-orange-500 px-4 py-2 rounded-xl hover:bg-orange-600 transition shadow-lg flex items-center gap-2">
                                ⚙️ Quản lý <span class="text-[10px]">▼</span>
                            </button>
                            <div class="absolute hidden group-hover:block bg-white text-gray-800 rounded-2xl shadow-2xl py-3 w-56 mt-1 border border-gray-100 left-0 overflow-hidden z-[100]">
                                <a href="/Project1/admin/index" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] font-black text-xs uppercase tracking-widest transition">📦 Sản phẩm</a>
                                <a href="/Project1/admin/promotions" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] font-black text-xs uppercase tracking-widest transition">🎁 Ưu đãi</a>
                                <a href="/Project1/admin/users" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] font-black text-xs uppercase tracking-widest transition">👥 Người dùng</a>
                            </div>
                        </li>
                    <?php endif; ?>
                    
                    <li class="text-sm text-orange-300 italic">Chào, <?= htmlspecialchars($_SESSION['username']) ?></li>
                    <li><a href="/Project1/auth/logout" class="text-sm hover:text-red-400 transition font-bold">Thoát</a></li>
                <?php else: ?>
                    <li><a href="/Project1/auth/login" class="text-sm hover:text-orange-400 transition">Đăng nhập</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main class="container mx-auto my-10 px-4">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="flex flex-col md:flex-row">
                <!-- Ảnh sản phẩm -->
                <div class="md:w-1/2 p-8 bg-gray-50">
                    <div class="aspect-square rounded-2xl overflow-hidden shadow-inner bg-white border">
                        <img src="/Project1/public/uploads/<?= $product['image'] ?>" class="w-full h-full object-contain">
                    </div>
                </div>

                <!-- Thông tin sản phẩm -->
                <div class="md:w-1/2 p-10 flex flex-col">
                    <div class="mb-6">
                        <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                            <?= htmlspecialchars($product['category_name'] ?? 'Sản phẩm') ?>
                        </span>
                        <h1 class="text-4xl font-black text-gray-800 uppercase tracking-tighter mt-4 leading-tight">
                            <?= htmlspecialchars($product['name']) ?>
                        </h1>
                    </div>

                    <div class="mb-8">
                        <p class="text-gray-400 text-xs font-black uppercase tracking-widest mb-1">Giá bán niêm yết</p>
                        <p class="text-5xl font-black text-orange-600 tracking-tighter">
                            <?= number_format($product['price']) ?> <span class="text-2xl">đ</span>
                        </p>
                    </div>

                    <div class="mb-8 p-6 bg-blue-50 rounded-2xl border border-blue-100">
                        <p class="text-[#0054a6] font-black uppercase text-xs tracking-widest mb-2 italic">Trạng thái kho hàng</p>
                        <div class="flex items-center gap-4">
                            <span class="text-3xl font-black text-[#0054a6]"><?= $product['stock'] ?></span>
                            <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest leading-none">Sản phẩm<br>có sẵn</span>
                        </div>
                    </div>

                    <div class="flex-1 space-y-4">
                        <p class="text-gray-400 font-black uppercase text-[10px] tracking-[0.2em]">Mô tả sản phẩm</p>
                        <div class="text-gray-600 leading-relaxed font-medium">
                            <?= nl2br(htmlspecialchars($product['description'] ?: 'Chưa có mô tả chi tiết cho sản phẩm này.')) ?>
                        </div>
                    </div>

                    <div class="mt-10 pt-10 border-t border-gray-100">
                        <form action="/Project1/cart/add/<?= $product['id'] ?>" method="POST" class="flex gap-4">
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Số lượng</label>
                                <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>"
                                       class="w-24 bg-gray-100 border-2 border-gray-200 rounded-2xl py-4 text-center font-black text-[#0054a6] text-xl focus:border-orange-500 outline-none transition">
                            </div>
                            <button type="submit" class="flex-1 bg-[#0054a6] text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-orange-600 shadow-2xl shadow-blue-200 transition active:scale-95 flex items-center justify-center gap-3">
                                🛒 Thêm vào giỏ hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 text-center">
            <a href="/Project1/product/index" class="text-[#0054a6] font-black uppercase text-xs tracking-widest hover:text-orange-600 transition">
                ← Tiếp tục mua sắm các sản phẩm khác
            </a>
        </div>
    </main>

    <footer class="bg-gray-900 text-gray-500 py-10 text-center text-sm font-medium mt-20">
        <p>&copy; 2026 HUTECH University - Hệ thống TMĐT Sinh viên</p>
    </footer>
</body>
</html>