<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Ưu đãi & Khuyến mãi - HUTECH Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <li><a href="/Project1/cart/index" class="hover:text-orange-400 transition text-sm">Giỏ hàng</a></li>
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
                <?php endif; ?>
            </ul>
        </div>
    </header>

    <main class="container mx-auto py-16 px-4">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-black text-gray-800 uppercase tracking-tighter mb-4">Mã Giảm Giá & <span class="text-orange-500">Ưu Đãi Hot</span></h2>
            <p class="text-gray-500 font-bold uppercase text-xs tracking-[0.5em]">HUTECH E-Commerce Deal Center</p>
        </div>

        <!-- PHẦN VOUCHER -->
        <div class="mb-20">
            <h3 class="text-2xl font-black text-[#0054a6] uppercase mb-8 flex items-center gap-3">
                <span class="text-4xl">🎟️</span> Mã giảm giá toàn sàn
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if (!empty($activeVouchers)): foreach($activeVouchers as $v): ?>
                <div class="bg-white border-2 border-dashed border-gray-100 rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-orange-500/5 rounded-full group-hover:scale-150 transition-transform"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-6">
                            <span class="bg-orange-500 text-white px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg">Voucher</span>
                            <span class="text-gray-300 font-bold text-[10px] uppercase">Hạn: <?= $v['expiry_date'] ? date('d/m/y', strtotime($v['expiry_date'])) : 'Vĩnh viễn' ?></span>
                        </div>
                        <h4 class="text-4xl font-black text-[#0054a6] mb-2">
                            -<?= number_format($v['discount_value']) ?><?= ($v['discount_type'] == 'percent' ? '%' : 'đ') ?>
                        </h4>
                        <p class="text-gray-400 font-bold text-xs uppercase mb-6 italic">Đơn tối thiểu <?= number_format($v['min_order_value']) ?>đ</p>
                        
                        <div class="bg-gray-50 p-4 rounded-2xl flex justify-between items-center border border-gray-100 group-hover:bg-[#0054a6] group-hover:border-[#0054a6] transition-colors">
                            <span class="font-black text-xl text-gray-800 uppercase tracking-widest group-hover:text-white"><?= $v['code'] ?></span>
                            <button onclick="copyToClipboard('<?= $v['code'] ?>')" class="text-[10px] font-black uppercase bg-[#0054a6] text-white px-3 py-1.5 rounded-lg group-hover:bg-orange-500 transition-all active:scale-95">Sao chép</button>
                        </div>
                        <p class="text-[9px] text-gray-300 font-bold uppercase mt-4 text-center">Đã dùng <?= $v['used_count'] ?>/<?= $v['usage_limit'] ?> lượt</p>
                    </div>
                </div>
                <?php endforeach; else: ?>
                    <p class="text-gray-400 italic font-bold">Hiện không có mã giảm giá nào.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- PHẦN KHUYẾN MÃI THEO SP/DANH MỤC -->
        <div>
            <h3 class="text-2xl font-black text-orange-500 uppercase mb-8 flex items-center gap-3">
                <span class="text-4xl">🎁</span> Chương trình khuyến mãi
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if (!empty($activePromotions)): foreach($activePromotions as $p): ?>
                <div class="bg-[#0054a6] rounded-3xl p-8 shadow-xl text-white relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full group-hover:scale-150 transition-transform"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-6">
                            <span class="bg-white text-[#0054a6] px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg"><?= $p['type'] == 'product' ? 'Sản phẩm' : 'Danh mục' ?></span>
                        </div>
                        <h4 class="text-2xl font-black uppercase tracking-tighter mb-1"><?= $p['name'] ?></h4>
                        <p class="text-blue-100 text-xs font-bold uppercase mb-6"><?= $p['target_name'] ?></p>
                        
                        <div class="flex items-end gap-3 mb-6">
                            <span class="text-5xl font-black text-orange-400">-<?= number_format($p['discount_value']) ?><?= ($p['discount_type'] == 'percent' ? '%' : 'đ') ?></span>
                        </div>

                        <div class="border-t border-white/20 pt-4 flex justify-between items-center text-[10px] font-black uppercase">
                            <span>Bắt đầu: <?= date('d/m/y', strtotime($p['start_date'])) ?></span>
                            <span class="text-orange-400">Kết thúc: <?= date('d/m/y', strtotime($p['end_date'])) ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                    <p class="text-gray-400 italic font-bold">Hiện không có khuyến mãi nào.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Đã sao chép mã giảm giá: ' + text);
            });
        }
    </script>

    <footer class="bg-gray-900 text-gray-500 py-10 text-center text-sm font-medium mt-20">
        <p>&copy; 2026 HUTECH University - Trung tâm Ưu đãi Sinh viên</p>
    </footer>
</body>
</html>