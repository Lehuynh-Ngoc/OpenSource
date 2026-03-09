<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Ưu đãi - Admin</title>
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
                <a href="/Project1/admin/promotions" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 bg-orange-500 text-white shadow-lg shadow-orange-900/20">
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
                <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Quản lý Ưu đãi</h2>
                <p class="text-gray-500 font-medium">Thiết lập khuyến mãi cho sản phẩm/danh mục và quản lý mã giảm giá (voucher).</p>
            </div>

            <div class="grid grid-cols-2 gap-10">
                <!-- KHUYẾN MÃI -->
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="text-xl font-black text-gray-800 uppercase mb-6 flex items-center">
                            <span class="mr-2">🏷️</span> Thêm Khuyến mãi
                        </h3>
                        <form action="/Project1/admin/promotion_store" method="POST" class="space-y-4">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2">Tên khuyến mãi</label>
                                <input type="text" name="name" required placeholder="VD: Sale Hè Rực Rỡ" class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none font-bold">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Loại áp dụng</label>
                                    <select name="type" id="promo_type" class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white cursor-pointer">
                                        <option value="product">Sản phẩm cụ thể</option>
                                        <option value="category">Toàn bộ danh mục</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Đối tượng</label>
                                    <select name="target_id" id="promo_target" class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white cursor-pointer">
                                        <?php foreach($products as $p): ?>
                                            <option class="product-opt" value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                                        <?php endforeach; ?>
                                        <?php foreach($categories as $c): ?>
                                            <option class="category-opt hidden" value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Kiểu giảm giá</label>
                                    <select name="discount_type" class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white cursor-pointer">
                                        <option value="percent">Phần trăm (%)</option>
                                        <option value="fixed">Số tiền cố định (đ)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Giá trị giảm</label>
                                    <input type="number" name="discount_value" required placeholder="VD: 20" class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none font-bold">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 border-t pt-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Thời gian bắt đầu</label>
                                    <input type="datetime-local" name="start_date" required class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Thời gian kết thúc</label>
                                    <input type="datetime-local" name="end_date" required class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white">
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-orange-500 text-white py-3 rounded-xl font-black uppercase tracking-widest hover:bg-orange-600 transition">Thêm khuyến mãi</button>
                        </form>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50 border-b">
                                <tr class="text-gray-400 font-black uppercase tracking-widest">
                                    <th class="p-4">Tên / Đối tượng</th>
                                    <th class="p-4">Thời hạn</th>
                                    <th class="p-4 text-center">Giảm</th>
                                    <th class="p-4 text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach($promotions as $pr): ?>
                                <?php 
                                    $is_active = true;
                                    $now = new DateTime();
                                    $start = $pr['start_date'] ? new DateTime($pr['start_date']) : null;
                                    $end = $pr['end_date'] ? new DateTime($pr['end_date']) : null;
                                    if ($start && $now < $start) $is_active = false;
                                    if ($end && $now > $end) $is_active = false;
                                ?>
                                <tr class="<?= !$is_active ? 'opacity-50 grayscale' : '' ?>">
                                    <td class="p-4">
                                        <div class="font-black text-gray-800 uppercase"><?= $pr['name'] ?></div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase"><?= ($pr['type'] == 'product' ? '📦 ' : '📂 ') . $pr['target_name'] ?></div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-[10px] font-bold text-gray-500 uppercase">BĐ: <?= $pr['start_date'] ? date('H:i d/m/y', strtotime($pr['start_date'])) : '--' ?></div>
                                        <div class="text-[10px] font-bold text-red-400 uppercase">KT: <?= $pr['end_date'] ? date('H:i d/m/y', strtotime($pr['end_date'])) : '--' ?></div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full font-black">
                                            -<?= number_format($pr['discount_value']) ?><?= ($pr['discount_type'] == 'percent' ? '%' : 'đ') ?>
                                        </span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="/Project1/admin/promotion_delete/<?= $pr['id'] ?>" onclick="return confirm('Xóa khuyến mãi?')" class="text-red-400 hover:text-red-600">🗑️</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- VOUCHER -->
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="text-xl font-black text-gray-800 uppercase mb-6 flex items-center">
                            <span class="mr-2">🎟️</span> Thêm Voucher
                        </h3>
                        <form action="/Project1/admin/voucher_store" method="POST" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Mã Voucher</label>
                                    <input type="text" name="code" required placeholder="VD: HUTECH2024" class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none font-bold uppercase">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Hạn dùng</label>
                                    <input type="date" name="expiry_date" class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Kiểu giảm giá</label>
                                    <select name="discount_type" class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white cursor-pointer">
                                        <option value="fixed">Số tiền cố định (đ)</option>
                                        <option value="percent">Phần trăm (%)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Giá trị giảm</label>
                                    <input type="number" name="discount_value" required placeholder="VD: 50000" class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none font-bold">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Đơn tối thiểu (đ)</label>
                                    <input type="number" name="min_order_value" value="0" class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none font-bold">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Số lượt dùng</label>
                                    <input type="number" name="usage_limit" value="100" class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none font-bold">
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-[#0054a6] text-white py-3 rounded-xl font-black uppercase tracking-widest hover:bg-blue-700 transition">Thêm Voucher</button>
                        </form>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b">
                                <tr class="text-gray-400 text-xs font-black uppercase tracking-widest">
                                    <th class="p-4">Mã / Hạn dùng</th>
                                    <th class="p-4 text-center">Giảm</th>
                                    <th class="p-4 text-center">Dùng</th>
                                    <th class="p-4 text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach($vouchers as $v): ?>
                                <tr>
                                    <td class="p-4">
                                        <div class="font-black text-blue-600 uppercase text-xs"><?= $v['code'] ?></div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase">Hạn: <?= $v['expiry_date'] ?? 'Vĩnh viễn' ?></div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-black">
                                            -<?= number_format($v['discount_value']) ?><?= ($v['discount_type'] == 'percent' ? '%' : 'đ') ?>
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="text-xs font-black text-gray-600"><?= $v['used_count'] ?>/<?= $v['usage_limit'] ?></span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="/Project1/admin/voucher_delete/<?= $v['id'] ?>" onclick="return confirm('Xóa voucher?')" class="text-red-400 hover:text-red-600">🗑️</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const promoType = document.getElementById('promo_type');
        const promoTarget = document.getElementById('promo_target');
        const productOpts = document.querySelectorAll('.product-opt');
        const categoryOpts = document.querySelectorAll('.category-opt');

        promoType.addEventListener('change', function() {
            if (this.value === 'product') {
                productOpts.forEach(opt => opt.classList.remove('hidden'));
                categoryOpts.forEach(opt => opt.classList.add('hidden'));
                promoTarget.value = productOpts[0].value;
            } else {
                productOpts.forEach(opt => opt.classList.add('hidden'));
                categoryOpts.forEach(opt => opt.classList.remove('hidden'));
                promoTarget.value = categoryOpts[0].value;
            }
        });
    </script>
</body>
</html>