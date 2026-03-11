<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng - Admin</title>
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
                <a href="/Project1/admin/orders" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 bg-orange-500 text-white shadow-lg shadow-orange-900/20">
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
                <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Quản lý Đơn hàng</h2>
                <p class="text-gray-500 font-medium">Theo dõi và cập nhật trạng thái vận chuyển.</p>
            </div>

            <div class="space-y-6">
                <?php 
                $displayedIds = [];
                foreach ($orders as $order): 
                    // Nếu ID này đã được hiển thị rồi thì bỏ qua
                    if (in_array($order['id'], $displayedIds)) continue;
                    $displayedIds[] = $order['id'];
                ?>
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 flex justify-between items-center bg-gray-50/50 border-b border-gray-100">
                            <div>
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Đơn hàng</span>
                                <span class="text-sm font-black text-gray-800 ml-1">#<?= $order['id'] ?> - Khách: <?= htmlspecialchars($order['username']) ?></span>
                            </div>
                            <form action="/Project1/order/update_status" method="POST" class="flex items-center gap-3">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <select name="status" class="bg-white border-2 border-gray-200 text-[10px] font-black uppercase rounded-xl px-4 py-2 focus:border-orange-500 outline-none cursor-pointer">
                                    <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Chờ xác nhận</option>
                                    <option value="confirmed" <?= $order['status'] == 'confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
                                    <option value="shipping" <?= $order['status'] == 'shipping' ? 'selected' : '' ?>>Giao ĐVVC</option>
                                    <option value="delivering" <?= $order['status'] == 'delivering' ? 'selected' : '' ?>>Đang giao</option>
                                    <option value="received" <?= $order['status'] == 'received' ? 'selected' : '' ?>>Đã nhận</option>
                                    <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                                </select>
                                <button type="submit" class="bg-[#0054a6] text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase hover:bg-orange-500 transition">Cập nhật</button>
                            </form>
                        </div>
                        <div class="p-6 grid grid-cols-2 gap-10">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase mb-4 tracking-widest">Sản phẩm</p>
                                <div class="space-y-3">
                                    <?php foreach ($order['items'] as $item): ?>
                                        <div class="flex items-center gap-3">
                                            <img src="/Project1/public/uploads/<?= $item['image'] ?>" class="w-10 h-10 object-cover rounded-lg border">
                                            <div class="flex-1">
                                                <p class="text-xs font-bold text-gray-800 uppercase truncate max-w-[200px]"><?= htmlspecialchars($item['name']) ?></p>
                                                <p class="text-[9px] text-gray-400 font-black">SL: <?= $item['quantity'] ?> × <?= number_format($item['price']) ?>đ</p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="border-l border-gray-100 pl-10 flex flex-col justify-between">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Thông tin giao hàng</p>
                                    <p class="text-xs font-bold text-gray-700"><?= htmlspecialchars($order['customer_name']) ?> - <?= $order['customer_phone'] ?></p>
                                    <p class="text-xs text-gray-500 mt-1"><?= htmlspecialchars($order['customer_address'] ?? 'N/A') ?></p>
                                    <p class="text-[9px] font-black text-blue-500 mt-2 uppercase tracking-tight"><?= strtoupper($order['shipping_method'] ?? 'N/A') ?> • <?= strtoupper($order['shipping_region'] ?? 'N/A') ?></p>
                                </div>
                                <div class="flex justify-between items-end mt-6">
                                    <p class="text-gray-400 text-[10px] font-bold"><?= $order['created_at'] ?></p>
                                    <p class="text-xl font-black text-orange-600 tracking-tighter"><?= number_format($order['total_amount']) ?>đ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>