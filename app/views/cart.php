<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Giỏ hàng - HUTECH Shop</title>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <header class="bg-[#0054a6] p-6 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="/Project1/product/index" class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#0054a6] font-black">H</div>
                    <h1 class="text-2xl font-bold uppercase tracking-tighter">HUTECH SHOP</h1>
                </a>
            </div>
            <ul class="flex space-x-6 items-center font-bold">
                <li><a href="/Project1/product/index" class="hover:text-orange-400 transition text-sm">Sản phẩm</a></li>
                <?php if (isset($_SESSION['username'])): ?>
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
    </header>

    <main class="container mx-auto py-10 px-4">
        <?php if (!empty($cart)): ?>
            <!-- GIAO DIỆN CÓ SẢN PHẨM (GIỮ NGUYÊN) -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b text-[#0054a6] font-black uppercase text-xs tracking-widest">
                            <th class="p-6 text-center w-20">Chọn</th>
                            <th class="p-6">Sản phẩm</th>
                            <th class="p-6">Giá niêm yết</th>
                            <th class="p-6 text-center">Số lượng</th>
                            <th class="p-6">Thành tiền</th>
                            <th class="p-6 text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php 
                        $totalMoney = 0;
                        foreach($cart as $item): 
                            $subTotal = (int)$item['price'] * (int)$item['quantity'];
                            if ($item['is_selected']) {
                                $totalMoney += $subTotal;
                            }
                        ?>
                        <tr class="hover:bg-blue-50/30 transition <?= !$item['is_selected'] ? 'opacity-60 grayscale-[0.5]' : '' ?>">
                            <td class="p-6 text-center">
                                <form action="/Project1/cart/toggle/<?= $item['cart_id'] ?>" method="POST">
                                    <input type="checkbox" name="selected" value="1" 
                                           <?= $item['is_selected'] ? 'checked' : '' ?>
                                           onchange="this.form.submit()"
                                           class="w-6 h-6 cursor-pointer accent-orange-500">
                                </form>
                            </td>
                            <td class="p-6 flex items-center gap-4">
                                <img src="/Project1/public/uploads/<?= $item['image'] ?>" class="w-20 h-20 object-cover rounded-2xl border shadow-sm">
                                <div>
                                    <span class="font-black text-gray-800 text-lg uppercase"><?= htmlspecialchars($item['name']) ?></span>
                                </div>
                            </td>
                            <td class="p-6 font-bold text-gray-600"><?= number_format($item['price']) ?>đ</td>
                            
                            <td class="p-6 text-center">
                                <form action="/Project1/cart/update/<?= $item['cart_id'] ?>" method="POST" class="inline-flex items-center bg-gray-100 px-2 py-1 rounded-xl">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" 
                                           onchange="this.form.submit()"
                                           class="w-12 bg-transparent text-center font-black text-[#0054a6] focus:outline-none">
                                </form>
                            </td>

                            <td class="p-6 font-black text-[#0054a6] text-xl"><?= number_format($subTotal) ?>đ</td>
                            <td class="p-6 text-center">
                                <a href="/Project1/cart/remove/<?= $item['cart_id'] ?>" class="text-red-300 hover:text-red-500">✕</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="p-10 bg-gray-50 flex justify-between items-center">
                    <a href="/Project1/cart/clear" class="text-gray-400 font-bold hover:text-red-500 transition uppercase text-xs">[ Xóa tất cả ]</a>
                    <div class="text-right">
                        <p class="text-gray-500 font-bold uppercase text-xs mb-1 tracking-widest">Tạm tính (SP đã chọn)</p>
                        <p class="text-5xl font-black text-orange-600 tracking-tighter"><?= number_format($totalMoney) ?>đ</p>
                        <div class="mt-6">
                            <a href="/Project1/order/checkout" class="bg-[#0054a6] text-white px-12 py-4 rounded-2xl font-black hover:bg-orange-600 transition shadow-xl uppercase tracking-widest">
                                Tiếp tục thanh toán →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- GIAO DIỆN GIỎ HÀNG TRỐNG (CẬP NHẬT MỚI) -->
            <div class="max-w-4xl mx-auto text-center py-20 px-6">
                <div class="relative inline-block mb-10">
                    <!-- Hình ảnh túi mua sắm trống -->
                    <div class="w-64 h-64 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-8 float-animation">
                        <span class="text-9xl">🛒</span>
                    </div>
                    <div class="absolute -top-4 -right-4 w-16 h-16 bg-orange-400 rounded-full flex items-center justify-center text-white text-3xl font-black shadow-lg animate-bounce">
                        ?
                    </div>
                </div>

                <h2 class="text-4xl md:text-5xl font-black text-gray-800 uppercase tracking-tighter mb-4">
                    Giỏ hàng đang <span class="text-orange-500 underline decoration-blue-500">trống rỗng</span>
                </h2>
                <p class="text-gray-500 text-lg font-medium max-w-lg mx-auto mb-10 leading-relaxed">
                    Có vẻ như bạn chưa chọn được món đồ nào ưng ý. Đừng lo, HUTECH SHOP đang có rất nhiều sản phẩm mới cực chất đang chờ bạn khám phá!
                </p>

                <div class="flex flex-col md:flex-row justify-center gap-4">
                    <a href="/Project1/product/index" class="bg-[#0054a6] text-white px-10 py-5 rounded-3xl font-black uppercase tracking-widest hover:bg-orange-600 shadow-2xl shadow-blue-200 transition-all active:scale-95">
                        🛍️ Khám phá cửa hàng ngay
                    </a>
                    <a href="/Project1/default/promotions" class="bg-white border-2 border-gray-100 text-gray-500 px-10 py-5 rounded-3xl font-black uppercase tracking-widest hover:border-orange-400 hover:text-orange-500 transition-all">
                        🏷️ Xem các ưu đãi hot
                    </a>
                </div>

                <!-- Section Gợi ý nhanh -->
                <div class="mt-24 pt-10 border-t border-gray-100">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-[0.5em] mb-10">Tại sao nên mua sắm tại HUTECH SHOP?</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="p-6 rounded-3xl bg-white border border-gray-50 shadow-sm hover:shadow-md transition">
                            <div class="text-3xl mb-3">🎓</div>
                            <h4 class="font-black text-gray-800 uppercase text-sm mb-2">Dành riêng cho Hutecher</h4>
                            <p class="text-xs text-gray-400 font-bold leading-relaxed">Sản phẩm mang bản sắc và niềm tự hào của sinh viên HUTECH.</p>
                        </div>
                        <div class="p-6 rounded-3xl bg-white border border-gray-100 shadow-sm hover:shadow-md transition">
                            <div class="text-3xl mb-3">⚡</div>
                            <h4 class="font-black text-gray-800 uppercase text-sm mb-2">Thanh toán siêu tốc</h4>
                            <p class="text-xs text-gray-400 font-bold leading-relaxed">Quy trình đơn giản, hỗ trợ nhiều hình thức thanh toán linh hoạt.</p>
                        </div>
                        <div class="p-6 rounded-3xl bg-white border border-gray-100 shadow-sm hover:shadow-md transition">
                            <div class="text-3xl mb-3">🛡️</div>
                            <h4 class="font-black text-gray-800 uppercase text-sm mb-2">Đảm bảo chất lượng</h4>
                            <p class="text-xs text-gray-400 font-bold leading-relaxed">Hàng chính hãng, đổi trả dễ dàng nếu không ưng ý.</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer class="bg-gray-900 text-gray-500 py-10 text-center text-sm font-medium mt-20">
        <p>&copy; 2026 HUTECH University - Hệ thống TMĐT Sinh viên</p>
    </footer>
</body>
</html>