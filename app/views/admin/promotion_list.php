<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Ưu đãi - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Thêm Flatpickr để nhập ngày giờ đúng định dạng dd/mm/yyyy HH:MM -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>
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
                <a href="/Project1/admin/orders" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 text-gray-400 hover:bg-gray-800 hover:text-white">
                    <span class="mr-3 text-lg">📑</span> Đơn hàng
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
                                        <option class="product-opt" value="0">-- Tất cả sản phẩm --</option>
                                        <?php foreach($products as $p): ?>
                                            <option class="product-opt" value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                                        <?php endforeach; ?>
                                        <option class="category-opt hidden" value="0">-- Tất cả danh mục --</option>
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
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Bắt đầu (dd/mm/yyyy HH:MM)</label>
                                    <input type="text" name="start_date" required placeholder="11/03/2026 14:30" class="datetime-picker w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Kết thúc (dd/mm/yyyy HH:MM)</label>
                                    <input type="text" name="end_date" required placeholder="20/03/2026 23:59" class="datetime-picker w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white">
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
                                    $now = new DateTime();
                                    $start = $pr['start_date'] ? new DateTime($pr['start_date']) : null;
                                    $end = $pr['end_date'] ? new DateTime($pr['end_date']) : null;
                                    
                                    $status = 'active'; 
                                    $statusText = 'Đang chạy';
                                    $rowClass = 'bg-white border-l-4 border-green-500';
                                    $statusBadge = 'bg-green-500 text-white';

                                    if ($start && $now < $start) {
                                        $status = 'pending';
                                        $statusText = 'Chờ chạy';
                                        $rowClass = 'bg-blue-50/30 border-l-4 border-blue-400';
                                        $statusBadge = 'bg-blue-400 text-white';
                                    } elseif ($end && $now > $end) {
                                        $status = 'expired';
                                        $statusText = 'Đã kết thúc';
                                        $rowClass = 'bg-gray-100/50 opacity-70 border-l-4 border-gray-300';
                                        $statusBadge = 'bg-gray-400 text-white';
                                    } elseif ($end) {
                                        $diff = $now->diff($end);
                                        $hoursLeft = ($diff->days * 24) + $diff->h;
                                        if ($hoursLeft <= 24) {
                                            $status = 'expiring';
                                            $statusText = 'Sắp hết hạn';
                                            $rowClass = $hoursLeft <= 6 ? 'bg-red-50 border-l-4 border-red-600' : 'bg-orange-50 border-l-4 border-orange-500';
                                            $statusBadge = $hoursLeft <= 6 ? 'bg-red-600 text-white animate-pulse' : 'bg-orange-500 text-white';
                                        }
                                    }
                                ?>
                                <tr class="transition-all hover:shadow-md <?= $rowClass ?>">
                                    <td class="p-4">
                                        <div class="font-black text-gray-800 uppercase text-xs"><?= $pr['name'] ?></div>
                                        <div class="text-[10px] text-blue-600 font-black uppercase mt-1 flex items-center gap-1">
                                            <?= ($pr['type'] == 'product' ? '📦 Sản phẩm: ' : '📂 Danh mục: ') ?>
                                            <span class="truncate max-w-[150px]"><?= $pr['target_name'] ?></span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-[10px] font-black text-gray-500 uppercase">BĐ: <?= $pr['start_date'] ? date('d/m/Y H:i', strtotime($pr['start_date'])) : '--' ?></div>
                                        <div class="text-[10px] font-black text-red-500 uppercase">KT: <?= $pr['end_date'] ? date('d/m/Y H:i', strtotime($pr['end_date'])) : '--' ?></div>
                                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-[9px] font-black uppercase tracking-tight shadow-sm <?= $statusBadge ?>">
                                            <?= $statusText ?>
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="inline-flex flex-col items-center bg-blue-50 px-3 py-1 rounded-xl border border-blue-100">
                                            <span class="text-[9px] font-black text-blue-400 uppercase tracking-tighter">Giảm giá</span>
                                            <span class="text-blue-700 font-black text-xs">
                                                -<?= number_format($pr['discount_value']) ?><?= ($pr['discount_type'] == 'percent' ? '%' : 'đ') ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="flex justify-end gap-1">
                                            <button onclick='openEditModal(<?= json_encode($pr) ?>)' class="p-2 hover:bg-blue-100 rounded-xl transition text-blue-600" title="Chỉnh sửa">✏️</button>
                                            <a href="/Project1/admin/promotion_delete/<?= $pr['id'] ?>" onclick="return confirm('Xóa khuyến mãi này?')" class="p-2 hover:bg-red-100 rounded-xl transition text-red-500" title="Xóa">🗑️</a>
                                        </div>
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
                                <div class="col-span-2">
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Loại Voucher</label>
                                    <select name="target_type" class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white cursor-pointer">
                                        <option value="order">Giảm giá Đơn hàng (Sản phẩm)</option>
                                        <option value="shipping">Giảm giá Vận chuyển</option>
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Mã Voucher</label>
                                    <input type="text" name="code" required placeholder="VD: HUTECH2024" class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none font-bold uppercase">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 border-t pt-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Bắt đầu (dd/mm/yyyy HH:MM)</label>
                                    <input type="text" name="start_date" required placeholder="11/03/2026 14:30" class="datetime-picker w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Kết thúc (dd/mm/yyyy HH:MM)</label>
                                    <input type="text" name="end_date" required placeholder="20/03/2026 23:59" class="datetime-picker w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white">
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
                                    <th class="p-4">Mã / Loại</th>
                                    <th class="p-4">Thời hạn</th>
                                    <th class="p-4 text-center">Giảm</th>
                                    <th class="p-4 text-center">Dùng</th>
                                    <th class="p-4 text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach($vouchers as $v): ?>
                                <?php 
                                    $now = new DateTime();
                                    $start = $v['start_date'] ? new DateTime($v['start_date']) : null;
                                    $end = $v['end_date'] ? new DateTime($v['end_date']) : null;
                                    
                                    $vStatus = 'active'; 
                                    $vStatusText = 'Khả dụng';
                                    $vRowClass = 'bg-white border-l-4 border-blue-500';
                                    $vStatusBadge = 'bg-blue-500 text-white';

                                    if ($v['used_count'] >= $v['usage_limit']) {
                                        $vStatus = 'out';
                                        $vStatusText = 'Hết lượt';
                                        $vRowClass = 'bg-gray-100/50 opacity-60 border-l-4 border-gray-300';
                                        $vStatusBadge = 'bg-gray-400 text-white';
                                    } elseif ($start && $now < $start) {
                                        $vStatus = 'pending';
                                        $vStatusText = 'Chờ chạy';
                                        $vRowClass = 'bg-purple-50/30 border-l-4 border-purple-400';
                                        $vStatusBadge = 'bg-purple-400 text-white';
                                    } elseif ($end && $now > $end) {
                                        $vStatus = 'expired';
                                        $vStatusText = 'Hết hạn';
                                        $vRowClass = 'bg-gray-100/50 opacity-60 border-l-4 border-gray-300';
                                        $vStatusBadge = 'bg-gray-400 text-white';
                                    } elseif ($end) {
                                        $diff = $now->diff($end);
                                        $hoursLeft = ($diff->days * 24) + $diff->h;
                                        if ($hoursLeft <= 24) {
                                            $vStatus = 'expiring';
                                            $vStatusText = 'Sắp hết';
                                            $vRowClass = 'bg-orange-50 border-l-4 border-orange-500';
                                            $vStatusBadge = 'bg-orange-500 text-white shadow-orange-100 shadow-sm';
                                        }
                                    }
                                ?>
                                <tr class="transition-all hover:shadow-md <?= $vRowClass ?>">
                                    <td class="p-4">
                                        <div class="font-black text-[#0054a6] uppercase text-xs tracking-wider"><?= $v['code'] ?></div>
                                        <div class="text-[9px] font-black <?= $v['target_type'] == 'shipping' ? 'text-green-500' : 'text-orange-500' ?> uppercase mt-1 flex items-center gap-1">
                                            <?= $v['target_type'] == 'shipping' ? '🚚 Vận chuyển' : '📦 Đơn hàng' ?>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-[9px] font-black <?= $vStatus == 'pending' ? 'text-gray-400' : 'text-gray-500' ?> uppercase">BĐ: <?= $v['start_date'] ? date('d/m/Y H:i', strtotime($v['start_date'])) : '--' ?></div>
                                        <div class="text-[9px] font-black <?= $vStatus == 'expired' ? 'text-red-300' : ($vStatus == 'expiring' ? 'text-red-600' : 'text-red-400') ?> uppercase">KT: <?= $v['end_date'] ? date('d/m/Y H:i', strtotime($v['end_date'])) : '--' ?></div>
                                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[8px] font-black uppercase tracking-tighter <?= $vStatusBadge ?>">
                                            <?= $vStatusText ?>
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="inline-block bg-gray-50 px-2 py-1 rounded-lg border border-gray-100">
                                            <span class="text-[10px] font-black text-gray-700">
                                                -<?= number_format($v['discount_value']) ?><?= ($v['discount_type'] == 'percent' ? '%' : 'đ') ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-gray-800"><?= $v['used_count'] ?>/<?= $v['usage_limit'] ?></span>
                                            <div class="w-12 h-1 bg-gray-100 rounded-full mt-1 overflow-hidden mx-auto">
                                                <div class="h-full bg-blue-500" style="width: <?= min(100, ($v['used_count'] / $v['usage_limit']) * 100) ?>%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="flex justify-end gap-1">
                                            <button onclick='openVoucherEditModal(<?= json_encode($v) ?>)' class="p-2 hover:bg-blue-100 rounded-xl transition text-blue-600" title="Chỉnh sửa">✏️</button>
                                            <a href="/Project1/admin/voucher_delete/<?= $v['id'] ?>" onclick="return confirm('Xóa voucher này?')" class="p-2 hover:bg-red-100 rounded-xl transition text-red-500" title="Xóa">🗑️</a>
                                        </div>
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

    <!-- MODAL CHỈNH SỬA KHUYẾN MÃI -->
    <div id="editPromoModal" class="hidden fixed inset-0 bg-black/50 z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="bg-[#0054a6] p-6 text-white flex justify-between items-center">
                <h3 class="text-xl font-black uppercase tracking-tighter">✏️ Chỉnh sửa Khuyến mãi</h3>
                <button onclick="closeEditModal()" class="text-2xl hover:scale-110 transition">✕</button>
            </div>
            <form action="/Project1/admin/promotion_update" method="POST" class="p-8 space-y-4">
                <input type="hidden" name="id" id="edit_id">
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Tên khuyến mãi</label>
                    <input type="text" name="name" id="edit_name" required class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-[#0054a6] outline-none font-bold">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Loại áp dụng</label>
                        <select name="type" id="edit_type" class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white cursor-pointer">
                            <option value="product">Sản phẩm cụ thể</option>
                            <option value="category">Toàn bộ danh mục</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Đối tượng</label>
                        <select name="target_id" id="edit_target" class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white cursor-pointer">
                            <!-- JS sẽ tự động điền các option vào đây -->
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Kiểu giảm giá</label>
                        <select name="discount_type" id="edit_discount_type" class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white cursor-pointer">
                            <option value="percent">Phần trăm (%)</option>
                            <option value="fixed">Số tiền cố định (đ)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Giá trị giảm</label>
                        <input type="number" name="discount_value" id="edit_discount_value" required class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-[#0054a6] outline-none font-bold">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Bắt đầu</label>
                        <input type="text" name="start_date" id="edit_start_date" required class="datetime-picker w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Kết thúc</label>
                        <input type="text" name="end_date" id="edit_end_date" required class="datetime-picker w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white">
                    </div>
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-100 text-gray-500 py-3 rounded-xl font-black uppercase tracking-widest hover:bg-gray-200 transition">Hủy</button>
                    <button type="submit" class="flex-1 bg-orange-500 text-white py-3 rounded-xl font-black uppercase tracking-widest hover:bg-orange-600 transition shadow-lg shadow-orange-200">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL CHỈNH SỬA VOUCHER -->
    <div id="editVoucherModal" class="hidden fixed inset-0 bg-black/50 z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="bg-[#0054a6] p-6 text-white flex justify-between items-center">
                <h3 class="text-xl font-black uppercase tracking-tighter">✏️ Chỉnh sửa Voucher</h3>
                <button onclick="closeVoucherEditModal()" class="text-2xl hover:scale-110 transition">✕</button>
            </div>
            <form action="/Project1/admin/voucher_update" method="POST" class="p-8 space-y-4">
                <input type="hidden" name="id" id="v_edit_id">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Loại Voucher</label>
                        <select name="target_type" id="v_edit_target_type" class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white cursor-pointer">
                            <option value="order">Giảm giá Đơn hàng (Sản phẩm)</option>
                            <option value="shipping">Giảm giá Vận chuyển</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Mã Voucher</label>
                        <input type="text" name="code" id="v_edit_code" required class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-[#0054a6] outline-none font-bold uppercase">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Kiểu giảm giá</label>
                        <select name="discount_type" id="v_edit_discount_type" class="w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white cursor-pointer">
                            <option value="fixed">Số tiền cố định (đ)</option>
                            <option value="percent">Phần trăm (%)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Giá trị giảm</label>
                        <input type="number" name="discount_value" id="v_edit_discount_value" required class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-[#0054a6] outline-none font-bold">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Bắt đầu</label>
                        <input type="text" name="start_date" id="v_edit_start_date" required class="datetime-picker w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Kết thúc</label>
                        <input type="text" name="end_date" id="v_edit_end_date" required class="datetime-picker w-full border-2 border-gray-100 p-3 rounded-xl font-bold bg-white">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Đơn tối thiểu (đ)</label>
                        <input type="number" name="min_order_value" id="v_edit_min_order_value" class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-[#0054a6] outline-none font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Số lượt dùng</label>
                        <input type="number" name="usage_limit" id="v_edit_usage_limit" class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-[#0054a6] outline-none font-bold">
                    </div>
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeVoucherEditModal()" class="flex-1 bg-gray-100 text-gray-500 py-3 rounded-xl font-black uppercase tracking-widest hover:bg-gray-200 transition">Hủy</button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-black uppercase tracking-widest hover:bg-blue-700 transition shadow-lg shadow-blue-200">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Khởi tạo Flatpickr cho các ô nhập liệu ngày giờ
        const fpConfig = {
            enableTime: true,
            dateFormat: "d/m/Y H:i",
            time_24hr: true,
            locale: "vn"
        };
        const pickers = flatpickr(".datetime-picker", fpConfig);

        function openVoucherEditModal(v) {
            document.getElementById('v_edit_id').value = v.id;
            document.getElementById('v_edit_code').value = v.code;
            document.getElementById('v_edit_target_type').value = v.target_type;
            document.getElementById('v_edit_discount_type').value = v.discount_type;
            document.getElementById('v_edit_discount_value').value = v.discount_value;
            document.getElementById('v_edit_min_order_value').value = v.min_order_value;
            document.getElementById('v_edit_usage_limit').value = v.usage_limit;

            const formatDate = (dateStr) => {
                if (!dateStr) return '';
                const parts = dateStr.split(/[- :]/);
                return `${parts[2]}/${parts[1]}/${parts[0]} ${parts[3]}:${parts[4]}`;
            };

            document.querySelectorAll('#editVoucherModal .datetime-picker').forEach(el => {
                if (el._flatpickr) {
                    const dateVal = el.id === 'v_edit_start_date' ? v.start_date : v.end_date;
                    el._flatpickr.setDate(formatDate(dateVal));
                }
            });

            document.getElementById('editVoucherModal').classList.remove('hidden');
        }

        function closeVoucherEditModal() {
            document.getElementById('editVoucherModal').classList.add('hidden');
        }

        // Lưu trữ danh sách options để dùng cho Modal
        const productOptions = `
            <option value="0">-- Tất cả sản phẩm --</option>
            <?php foreach($products as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
            <?php endforeach; ?>
        `;
        const categoryOptions = `
            <option value="0">-- Tất cả danh mục --</option>
            <?php foreach($categories as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
        `;

        const editType = document.getElementById('edit_type');
        const editTarget = document.getElementById('edit_target');

        // Lắng nghe sự thay đổi loại áp dụng trong Modal
        editType.addEventListener('change', function() {
            updateEditTargetOptions(this.value);
        });

        function updateEditTargetOptions(type, selectedId = "0") {
            editTarget.innerHTML = (type === 'product') ? productOptions : categoryOptions;
            editTarget.value = selectedId;
        }

        function openEditModal(promo) {
            document.getElementById('edit_id').value = promo.id;
            document.getElementById('edit_name').value = promo.name;
            document.getElementById('edit_type').value = promo.type;
            
            // Cập nhật danh sách đối tượng và chọn giá trị hiện tại
            updateEditTargetOptions(promo.type, promo.target_id);

            document.getElementById('edit_discount_type').value = promo.discount_type;
            document.getElementById('edit_discount_value').value = promo.discount_value;
            
            const formatDate = (dateStr) => {
                if (!dateStr) return '';
                const parts = dateStr.split(/[- :]/);
                return `${parts[2]}/${parts[1]}/${parts[0]} ${parts[3]}:${parts[4]}`;
            };
            
            document.querySelectorAll('#editPromoModal .datetime-picker').forEach(el => {
                if (el._flatpickr) {
                    const dateVal = el.id === 'edit_start_date' ? promo.start_date : promo.end_date;
                    el._flatpickr.setDate(formatDate(dateVal));
                }
            });
            
            document.getElementById('editPromoModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editPromoModal').classList.add('hidden');
        }

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