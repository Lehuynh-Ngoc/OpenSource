<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản - HUTECH Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        .hero-gradient { background: radial-gradient(circle at top right, #0054a6, #003366); }
        .bg-pattern { background-image: radial-gradient(#0054a6 0.5px, transparent 0.5px); background-size: 24px 24px; opacity: 0.05; }
    </style>
</head>
<body class="bg-[#f8fafc] min-h-screen relative pb-20">
    <div class="fixed inset-0 bg-pattern pointer-events-none"></div>

    <!-- Header -->
    <header class="glass-nav sticky top-0 z-50 border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="/Project1/product/index" class="text-3xl font-black italic tracking-tighter uppercase text-[#0054a6]">HUTECH <span class="text-orange-500">Shop</span></a>
            
            <nav>
                <ul class="flex items-center gap-8 font-black text-[11px] uppercase tracking-widest text-gray-600">
                    <li><a href="/Project1/product/index" class="hover:text-[#0054a6] transition">Sản phẩm</a></li>
                    <li><a href="/Project1/default/promotions" class="hover:text-[#0054a6] transition">Ưu đãi</a></li>
                    <li><a href="/Project1/default/about" class="hover:text-[#0054a6] transition">Giới thiệu</a></li>
                    <li class="relative">
                        <a href="/Project1/cart/index" class="hover:text-[#0054a6] transition flex items-center gap-2">
                            Giỏ hàng
                        </a>
                    </li>

                    <?php if (isset($_SESSION['username'])): ?>
                        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['username'] === 'admin'): ?>
                            <li class="group relative">
                                <button class="bg-gray-900 text-white px-5 py-2.5 rounded-xl hover:bg-black transition shadow-xl flex items-center gap-2 text-[10px]">
                                    ⚙️ Quản lý <span class="text-[8px] opacity-50">▼</span>
                                </button>
                                <div class="absolute hidden group-hover:block bg-white text-gray-800 rounded-2xl shadow-2xl py-3 w-56 mt-1 border border-gray-100 right-0 overflow-hidden z-[100] animate-in fade-in slide-in-from-top-2 duration-200">
                                    <a href="/Project1/admin/index" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] transition font-black">📦 Sản phẩm</a>
                                    <a href="/Project1/admin/orders" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] transition font-black">📑 Đơn hàng</a>
                                    <a href="/Project1/admin/promotions" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] transition font-black">🎁 Ưu đãi</a>
                                    <a href="/Project1/admin/users" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] transition font-black">👥 Người dùng</a>
                                </div>
                            </li>
                        <?php endif; ?>
                        
                        <li class="flex items-center gap-6 border-l border-gray-100 pl-8">
                            <a href="/Project1/auth/profile" class="text-orange-500 transition italic">Chào, <?= htmlspecialchars($_SESSION['username']) ?></a>
                            <a href="/Project1/auth/logout" class="text-red-400 hover:text-red-600 transition font-bold">Thoát</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <?php 
        // LỌC ĐƠN HÀNG DUY NHẤT NGAY TỪ ĐẦU
        $uniqueOrders = [];
        $seenIds = [];
        foreach ($orders as $o) {
            if (!in_array($o['id'], $seenIds)) {
                $seenIds[] = $o['id'];
                $uniqueOrders[] = $o;
            }
        }

        // TÍNH TOÁN THỐNG KÊ
        $totalSpent = 0;
        $activeCount = 0;
        $cancelledCount = 0;
        $receivedCount = 0;

        foreach ($uniqueOrders as $o) {
            if ($o['status'] === 'cancelled') {
                $cancelledCount++;
            } else {
                $activeCount++;
                if ($o['status'] === 'received') {
                    $receivedCount++;
                    $totalSpent += $o['total_amount'];
                }
            }
        }
    ?>

    <!-- Hero Dashboard Section -->
    <section class="hero-gradient py-20 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5 skew-x-[-20deg] translate-x-20"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row items-center gap-10">
                <div class="w-32 h-32 bg-white/10 backdrop-blur-md rounded-[40px] border border-white/20 flex items-center justify-center text-5xl shadow-2xl">
                    👤
                </div>
                <div class="text-center md:text-left flex-1">
                    <span class="inline-block bg-orange-500 text-white px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-4 shadow-xl">HUTECH Member</span>
                    <h1 class="text-5xl font-black uppercase tracking-tighter mb-2"><?= htmlspecialchars($user['username']) ?></h1>
                    <p class="text-blue-200 font-medium opacity-80 uppercase tracking-widest text-xs">
                        <?= $user['role'] === 'admin' ? '💎 Quản trị viên hệ thống' : '🛒 Khách hàng thân thiết' ?>
                    </p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 w-full md:w-auto">
                    <div class="bg-white/10 backdrop-blur-md border border-white/10 p-6 rounded-[32px] text-center">
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-1">Tổng chi tiêu</p>
                        <p class="text-2xl font-black text-orange-400"><?= number_format($totalSpent) ?>đ</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/10 p-6 rounded-[32px] text-center">
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-1">Đơn hoạt động</p>
                        <p class="text-2xl font-black text-blue-300"><?= $activeCount ?></p>
                    </div>
                    <div class="hidden sm:block bg-white/10 backdrop-blur-md border border-white/10 p-6 rounded-[32px] text-center">
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-1">Đã hủy</p>
                        <p class="text-2xl font-black text-red-400"><?= $cancelledCount ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="max-w-6xl mx-auto px-6 -mt-10 relative z-20">
        <div class="bg-white rounded-[40px] shadow-2xl shadow-blue-900/10 p-8 md:p-12 border border-white">
            <div class="flex justify-between items-center mb-12">
                <h3 class="text-3xl font-black text-gray-800 uppercase tracking-tighter flex items-center gap-4">
                    <span class="w-2 h-8 bg-[#0054a6] rounded-full"></span>
                    <?= ($user['role'] === 'admin') ? 'Quản lý Đơn hàng Toàn hệ thống' : 'Lịch sử mua hàng của bạn' ?>
                </h3>
                <div class="flex gap-2">
                    <span class="bg-blue-50 text-[#0054a6] px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border border-blue-100">
                        Tổng cộng: <?= count($uniqueOrders) ?> đơn
                    </span>
                </div>
            </div>

            <?php if (empty($uniqueOrders)): ?>
                <div class="text-center py-24 bg-gray-50/50 rounded-[40px] border-2 border-dashed border-gray-100">
                    <div class="text-6xl mb-6 opacity-20">📦</div>
                    <p class="text-gray-400 font-black uppercase tracking-[0.2em] italic">Chưa có dữ liệu đơn hàng</p>
                    <a href="/Project1/product/index" class="mt-8 inline-block bg-[#0054a6] text-white px-10 py-4 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-orange-600 transition shadow-xl shadow-blue-100">Khám phá cửa hàng ngay</a>
                </div>
            <?php else: ?>
                <div class="space-y-12">
                    <?php foreach ($uniqueOrders as $order): ?>
                        <div class="group relative bg-white border-2 border-gray-50 rounded-[40px] overflow-hidden hover:border-blue-100 hover:shadow-2xl transition-all duration-500">
                            <!-- Order Header -->
                            <div class="bg-gray-50/50 px-10 py-6 flex flex-wrap justify-between items-center gap-4 border-b border-gray-50">
                                <div class="flex items-center gap-4">
                                    <div class="bg-white p-3 rounded-2xl shadow-sm font-black text-gray-400 text-xs uppercase border border-gray-100">
                                        #<?= $order['id'] ?>
                                    </div>
                                    <div>
                                        <?php if (($user['role'] === 'admin') && isset($order['username'])): ?>
                                            <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-0.5">Khách hàng</p>
                                            <p class="text-sm font-black text-gray-800 uppercase tracking-tight"><?= htmlspecialchars($order['username']) ?></p>
                                        <?php else: ?>
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Thời gian đặt</p>
                                            <p class="text-sm font-black text-gray-800 tracking-tight"><?= date('H:i - d/m/Y', strtotime($order['created_at'])) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php 
                                    $statusConfig = [
                                        'pending' => ['text' => 'Chờ xác nhận', 'bg' => 'bg-gray-100', 'textCol' => 'text-gray-500', 'step' => 0],
                                        'confirmed' => ['text' => 'Đã xác nhận', 'bg' => 'bg-blue-100', 'textCol' => 'text-blue-600', 'step' => 1],
                                        'shipping' => ['text' => 'Giao ĐVVC', 'bg' => 'bg-purple-100', 'textCol' => 'text-purple-600', 'step' => 2],
                                        'delivering' => ['text' => 'Đang giao hàng', 'bg' => 'bg-orange-100', 'textCol' => 'text-orange-600', 'step' => 3],
                                        'received' => ['text' => 'Đã hoàn tất', 'bg' => 'bg-green-100', 'textCol' => 'text-green-600', 'step' => 4],
                                        'cancelled' => ['text' => 'Đã hủy đơn', 'bg' => 'bg-red-100', 'textCol' => 'text-red-600', 'step' => -1]
                                    ];
                                    $curr = $statusConfig[$order['status']];
                                ?>
                                <div class="<?= $curr['bg'] ?> <?= $curr['textCol'] ?> px-6 py-2 rounded-full font-black text-[10px] uppercase tracking-widest shadow-sm">
                                    <?= $curr['text'] ?>
                                </div>
                            </div>

                            <!-- Progress Track -->
                            <?php if ($order['status'] !== 'cancelled'): ?>
                            <div class="px-10 py-10 bg-white">
                                <div class="relative flex justify-between">
                                    <?php 
                                        $steps = ['pending', 'confirmed', 'shipping', 'delivering', 'received'];
                                        $labels = ['Chờ duyệt', 'Xác nhận', 'Vận chuyển', 'Đang giao', 'Đã nhận'];
                                    ?>
                                    <?php foreach ($steps as $idx => $step): ?>
                                        <div class="flex flex-col items-center relative z-10">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-black transition-all duration-700 <?= $idx <= $curr['step'] ? 'bg-[#0054a6] text-white shadow-xl shadow-blue-200' : 'bg-gray-100 text-gray-300' ?>">
                                                <?= $idx + 1 ?>
                                            </div>
                                            <p class="mt-3 text-[9px] font-black uppercase tracking-tighter <?= $idx <= $curr['step'] ? 'text-gray-800' : 'text-gray-300' ?>"><?= $labels[$idx] ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                    <!-- Background Line -->
                                    <div class="absolute top-5 left-0 w-full h-1 bg-gray-50 rounded-full -z-0"></div>
                                    <!-- Active Progress Line -->
                                    <div class="absolute top-5 left-0 h-1 bg-[#0054a6] transition-all duration-1000 ease-out rounded-full shadow-lg shadow-blue-200" style="width: <?= ($curr['step'] / 4) * 100 ?>%"></div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Order Items -->
                            <div class="px-10 py-8 bg-gray-50/20 space-y-6">
                                <?php foreach ($order['items'] as $item): ?>
                                    <div class="flex items-center gap-8 group/item">
                                        <div class="relative">
                                            <img src="/Project1/public/uploads/<?= $item['image'] ?>" class="w-20 h-20 object-cover rounded-3xl border-2 border-white shadow-lg group-hover/item:scale-105 transition-transform duration-300">
                                            <span class="absolute -top-2 -right-2 bg-gray-900 text-white w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-black shadow-lg">x<?= $item['quantity'] ?></span>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-base font-black text-gray-800 uppercase tracking-tight mb-1"><?= htmlspecialchars($item['name']) ?></h4>
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Đơn giá: <?= number_format($item['price']) ?>đ</p>
                                        </div>
                                        <?php if ($order['status'] === 'received'): ?>
                                            <?php if ($item['is_reviewed']): ?>
                                                <span class="text-[10px] font-black text-green-500 uppercase flex items-center gap-1">
                                                    <span class="text-sm">✓</span> Đã đánh giá
                                                </span>
                                            <?php else: ?>
                                                <button onclick='openReviewModal(<?= json_encode($item) ?>, <?= $order['id'] ?>)' class="bg-white border-2 border-gray-100 text-gray-800 px-6 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all shadow-sm">Viết đánh giá</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Order Footer -->
                            <div class="px-10 py-8 border-t border-gray-50 flex flex-wrap justify-between items-center gap-6">
                                <div class="flex gap-10">
                                    <div>
                                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">Vận chuyển</p>
                                        <p class="text-xs font-black text-gray-700 uppercase"><?= strtoupper($order['shipping_method'] ?? 'N/A') ?></p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">Khu vực</p>
                                        <p class="text-xs font-black text-gray-700 uppercase"><?= strtoupper($order['shipping_region'] ?? 'N/A') ?></p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-8">
                                    <div class="text-right">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tổng thanh toán</p>
                                        <p class="text-3xl font-black text-orange-600 tracking-tighter"><?= number_format($order['total_amount']) ?>đ</p>
                                    </div>

                                    <div class="flex gap-2">
                                        <?php if ($order['status'] === 'delivering'): ?>
                                            <form action="/Project1/order/confirm_received" method="POST">
                                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                <button type="submit" onclick="return confirm('Xác nhận bạn đã nhận được hàng?')" class="bg-green-500 text-white px-8 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-green-600 transition-all shadow-xl shadow-green-100">Xác nhận đã nhận</button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if (in_array($order['status'], ['pending', 'confirmed'])): ?>
                                            <form action="/Project1/order/cancel" method="POST">
                                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')" class="bg-gray-100 text-red-500 border border-red-50 px-8 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-red-500 hover:text-white transition-all">Hủy đơn hàng</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- MODAL ĐÁNH GIÁ (GIỮ NGUYÊN LOGIC CŨ NHƯNG THÊM STYLE) -->
    <div id="reviewModal" class="hidden fixed inset-0 bg-gray-900/80 z-[100] flex items-center justify-center p-4 backdrop-blur-md">
        <div class="bg-white rounded-[50px] shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-300 border border-white">
            <div class="bg-[#0054a6] p-10 text-white text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-orange-500/10 mix-blend-overlay"></div>
                <h3 class="text-2xl font-black uppercase tracking-tighter relative z-10">🌟 Đánh giá sản phẩm</h3>
                <p id="review_product_name" class="text-[10px] text-blue-100 font-bold mt-2 uppercase tracking-[0.2em] relative z-10 opacity-80"></p>
            </div>
            <form action="/Project1/auth/submit_review" method="POST" class="p-12 space-y-8">
                <input type="hidden" name="product_id" id="review_product_id">
                <input type="hidden" name="order_id" id="review_order_id">
                
                <div class="text-center">
                    <label class="block text-xs font-black text-gray-400 uppercase mb-6 tracking-widest italic">Mức độ hài lòng của bạn?</label>
                    <div class="flex justify-center gap-4">
                        <?php for($i=1; $i<=5; $i++): ?>
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="<?= $i ?>" required class="hidden peer">
                                <div class="text-4xl grayscale peer-checked:grayscale-0 group-hover:scale-125 transition-all duration-300 drop-shadow-sm">⭐</div>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase mb-3 tracking-widest italic ml-2">Cảm nhận chi tiết</label>
                    <textarea name="comment" rows="4" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..." required class="w-full border-2 border-gray-100 p-6 rounded-[32px] focus:border-[#0054a6] focus:bg-blue-50/30 outline-none font-medium transition-all"></textarea>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeReviewModal()" class="flex-1 bg-gray-100 text-gray-500 py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-gray-200 transition-all">Để sau</button>
                    <button type="submit" class="flex-1 bg-orange-500 text-white py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-orange-600 transition-all shadow-xl shadow-orange-100">Gửi đánh giá</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReviewModal(item, orderId) {
            document.getElementById('review_product_id').value = item.product_id;
            document.getElementById('review_order_id').value = orderId;
            document.getElementById('review_product_name').innerText = item.name;
            document.getElementById('reviewModal').classList.remove('hidden');
        }
        function closeReviewModal() {
            document.getElementById('reviewModal').classList.add('hidden');
        }
    </script>

    <footer class="bg-gray-900 text-gray-600 py-16 text-center text-sm font-medium border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-2xl font-black italic tracking-tighter uppercase mb-8 text-gray-800">HUTECH <span class="text-gray-900">Shop</span></div>
            <p class="mb-2">&copy; 2026 HUTECH University - Hệ thống TMĐT Sinh viên</p>
            <p class="text-[10px] uppercase tracking-widest text-gray-700">Premium Dashboard Interface v3.0</p>
        </div>
    </footer>
</body>
</html>