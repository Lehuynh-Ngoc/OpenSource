<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - HUTECH Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 shadow-sm">
        <div class="container mx-auto px-6 h-20 flex justify-between items-center">
            <a href="/Project1/product/index" class="text-3xl font-black italic tracking-tighter uppercase text-[#0054a6]">HUTECH <span class="text-orange-500">SHOP</span></a>
            
            <ul class="flex items-center gap-8 font-black text-xs uppercase tracking-widest text-gray-600">
                <li><a href="/Project1/product/index" class="hover:text-[#0054a6] transition">Sản phẩm</a></li>
                <li><a href="/Project1/default/promotions" class="hover:text-[#0054a6] transition">Ưu đãi</a></li>
                <li><a href="/Project1/default/about" class="hover:text-[#0054a6] transition">Giới thiệu</a></li>
                <li class="relative">
                    <a href="/Project1/cart/index" class="hover:text-[#0054a6] transition flex items-center gap-2">
                        Giỏ hàng
                        <?php if (isset($cartCount) && $cartCount > 0): ?>
                        <span class="bg-orange-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full shadow-lg shadow-orange-200">
                            <?= $cartCount ?>
                        </span>
                        <?php endif; ?>
                    </a>
                </li>

                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Admin Dropdown -->
                    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['username'] === 'admin'): ?>
                        <li class="group relative">
                            <button class="bg-gray-900 text-white px-5 py-2.5 rounded-xl hover:bg-black transition shadow-xl flex items-center gap-2 text-[10px]">
                                ⚙️ Quản lý <span class="text-[8px] opacity-50">▼</span>
                            </button>
                            <div class="absolute hidden group-hover:block bg-white text-gray-800 rounded-2xl shadow-2xl py-3 w-56 mt-1 border border-gray-100 left-0 overflow-hidden z-[100] animate-in fade-in slide-in-from-top-2 duration-200">
                                <a href="/Project1/admin/index" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] transition font-black">📦 Sản phẩm</a>
                                <a href="/Project1/admin/orders" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] transition font-black">📑 Đơn hàng</a>
                                <a href="/Project1/admin/promotions" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] transition font-black">🎁 Ưu đãi</a>
                                <a href="/Project1/admin/users" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] transition font-black">👥 Người dùng</a>
                            </div>
                        </li>
                    <?php endif; ?>
                    
                    <li class="flex items-center gap-6 border-l border-gray-100 pl-8">
                        <a href="/Project1/auth/profile" class="text-[#0054a6] hover:text-orange-500 transition italic">Chào, <?= htmlspecialchars($_SESSION['username']) ?></a>
                        <a href="/Project1/auth/logout" class="text-red-400 hover:text-red-600 transition font-bold">Thoát</a>
                    </li>
                <?php else: ?>
                    <li class="border-l border-gray-100 pl-8">
                        <a href="/Project1/auth/login" class="bg-[#0054a6] text-white px-6 py-2.5 rounded-xl hover:bg-blue-700 transition shadow-xl shadow-blue-100">Đăng nhập</a>
                    </li>
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

                    <div class="mb-8 flex items-center gap-6 py-4 px-6 bg-blue-50/50 rounded-2xl border border-blue-100/50">
                        <div class="flex-1 border-r border-blue-100 pr-6">
                            <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Trạng thái kho</p>
                            <div class="flex items-center gap-2">
                                <?php 
                                    $stock = (int)$product['stock'];
                                    $statusColor = 'bg-green-500';
                                    $pingColor = 'bg-green-400';
                                    $statusText = 'Còn hàng';
                                    
                                    if ($stock === 0) {
                                        $statusColor = 'bg-red-500';
                                        $pingColor = 'bg-red-400';
                                        $statusText = 'Hết hàng';
                                    } elseif ($stock <= 5) {
                                        $statusColor = 'bg-orange-500';
                                        $pingColor = 'bg-orange-400';
                                        $statusText = 'Sắp hết hàng';
                                    }
                                ?>
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full <?= $pingColor ?> opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 <?= $statusColor ?>"></span>
                                </span>
                                <span class="text-sm font-black text-gray-700 uppercase tracking-tight">
                                    <?= $statusText ?>
                                </span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Số lượng khả dụng</p>
                            <p class="text-2xl font-black text-[#0054a6] flex items-baseline gap-1">
                                <?= $stock ?> 
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">đơn vị</span>
                            </p>
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
                                <input type="number" name="quantity" value="<?= $stock > 0 ? 1 : 0 ?>" min="<?= $stock > 0 ? 1 : 0 ?>" max="<?= $stock ?>"
                                       <?= $stock <= 0 ? 'disabled' : '' ?>
                                       class="w-24 bg-gray-100 border-2 border-gray-200 rounded-2xl py-4 text-center font-black text-[#0054a6] text-xl focus:border-orange-500 outline-none transition disabled:opacity-50 disabled:cursor-not-allowed">
                            </div>
                            <button type="submit" 
                                    <?= $stock <= 0 ? 'disabled' : '' ?>
                                    class="flex-1 <?= $stock > 0 ? 'bg-[#0054a6] hover:bg-orange-600 shadow-blue-200' : 'bg-gray-400 cursor-not-allowed shadow-none' ?> text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest shadow-2xl transition active:scale-95 flex items-center justify-center gap-3">
                                <?= $stock > 0 ? '🛒 Thêm vào giỏ hàng' : '🚫 Hết hàng' ?>
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