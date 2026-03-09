<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Thanh toán - HUTECH Shop</title>
</head>
<body class="bg-gray-50 min-h-screen pb-20">
    <header class="bg-[#0054a6] p-6 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto">
            <a href="/Project1/cart/index" class="font-black uppercase tracking-widest text-sm flex items-center gap-2">
                ← Quay lại giỏ hàng
            </a>
        </div>
    </header>

    <main class="container mx-auto py-10 px-4">
        <form action="/Project1/order/process" method="POST">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- CỘT TRÁI: THÔNG TIN GIAO HÀNG & TÓM TẮT SP -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <h3 class="text-2xl font-black text-gray-800 uppercase mb-6 flex items-center gap-2">
                        <span class="text-3xl">🚛</span> Thông tin giao hàng
                    </h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-xs font-black text-gray-400 uppercase mb-2">Họ và tên người nhận</label>
                            <input type="text" name="customer_name" required placeholder="Nhập tên người nhận" 
                                   class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-[#0054a6] outline-none font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase mb-2">Số điện thoại</label>
                            <input type="text" name="customer_phone" required placeholder="0xxx xxx xxx" 
                                   class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-[#0054a6] outline-none font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase mb-2">Địa chỉ nhận hàng</label>
                            <input type="text" name="customer_address" required placeholder="Số nhà, tên đường, phường/xã..." 
                                   class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-[#0054a6] outline-none font-bold">
                        </div>
                    </div>
                </div>

                <!-- Danh sách sản phẩm rút gọn -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="p-6 bg-gray-50 border-b">
                        <h3 class="font-black text-gray-800 uppercase text-sm tracking-widest">Sản phẩm thanh toán (<?= count($selectedItems) ?>)</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <?php foreach($selectedItems as $item): ?>
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img src="/Project1/public/uploads/<?= $item['image'] ?>" class="w-16 h-16 object-cover rounded-xl border">
                                <div>
                                    <p class="font-black text-gray-800 uppercase text-sm"><?= htmlspecialchars($item['name']) ?></p>
                                    <p class="text-xs text-gray-400 font-bold uppercase">SL: <?= $item['quantity'] ?></p>
                                    <?php if ($item['promotion']): ?>
                                        <p class="text-[9px] bg-orange-500 text-white font-black px-2 py-0.5 rounded-full inline-block mt-1 uppercase">
                                            🎁 <?= $item['promotion']['name'] ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="<?= $item['promotion'] ? 'line-through text-gray-300 text-[10px]' : 'font-bold text-gray-600' ?>"><?= number_format($item['price'] * $item['quantity']) ?>đ</p>
                                <?php if ($item['promotion']): ?>
                                    <p class="font-black text-orange-600"><?= number_format($item['discounted_price'] * $item['quantity']) ?>đ</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- CỘT PHẢI: TỔNG TIỀN & VOUCHER -->
            <div class="space-y-6">
                <!-- Voucher Section -->
                <div class="bg-white rounded-3xl shadow-xl p-6 border border-gray-100">
                    <h3 class="text-lg font-black text-gray-800 uppercase mb-4">🎟️ Mã giảm giá</h3>
                    <?php if (isset($_SESSION['voucher_code'])): ?>
                        <div class="bg-green-50 border-2 border-green-100 p-4 rounded-2xl flex justify-between items-center">
                            <p class="font-black text-green-700 uppercase"><?= $_SESSION['voucher_code'] ?></p>
                            <a href="/Project1/cart/remove_voucher" class="text-green-500 hover:text-red-500 font-black text-xs">✕ Gỡ bỏ</a>
                        </div>
                    <?php else: ?>
                        <div class="flex gap-2">
                            <input type="text" id="voucher_input" placeholder="Mã giảm giá..." class="flex-1 border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none font-bold uppercase text-sm">
                            <button type="button" onclick="applyVoucher()" class="bg-[#0054a6] text-white px-4 py-3 rounded-xl font-black uppercase text-[10px] hover:bg-blue-700 transition">Áp dụng</button>
                        </div>
                        <?php if (isset($_SESSION['voucher_error'])): ?>
                            <p class="text-red-500 text-[9px] font-black uppercase mt-2 italic"><?= $_SESSION['voucher_error'] ?></p>
                            <?php unset($_SESSION['voucher_error']); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Summary Section -->
                <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
                    <h3 class="text-xl font-black text-gray-800 uppercase mb-6">Tóm tắt đơn hàng</h3>
                    <div class="space-y-4 border-b border-gray-100 pb-6 mb-6">
                        <div class="flex justify-between font-bold text-gray-500">
                            <span>Tạm tính:</span>
                            <span><?= number_format($totalBefore) ?>đ</span>
                        </div>
                        <div class="flex justify-between font-bold text-orange-500 text-sm italic">
                            <span>Giảm giá SP:</span>
                            <span>-<?= number_format($totalPromoDiscount) ?>đ</span>
                        </div>
                        <?php 
                        $totalAfterPromo = $totalBefore - $totalPromoDiscount;
                        $voucherDiscount = 0;
                        if (isset($voucher) && $totalAfterPromo >= $voucher['min_order_value']) {
                            if ($voucher['discount_type'] == 'percent') {
                                $voucherDiscount = $totalAfterPromo * ($voucher['discount_value'] / 100);
                            } else {
                                $voucherDiscount = min($totalAfterPromo, $voucher['discount_value']);
                            }
                        }
                        ?>
                        <div class="flex justify-between font-bold text-green-500 text-sm italic">
                            <span>Voucher:</span>
                            <span>-<?= number_format($voucherDiscount) ?>đ</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-end mb-8">
                        <span class="font-black text-gray-800 uppercase text-xs">Tổng thanh toán:</span>
                        <p class="text-4xl font-black text-orange-600 tracking-tighter"><?= number_format(max(0, $totalAfterPromo - $voucherDiscount)) ?>đ</p>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2 text-center">Phương thức thanh toán</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="border-2 border-gray-100 p-3 rounded-xl cursor-pointer hover:border-[#0054a6] transition flex flex-col items-center gap-1 has-[:checked]:border-[#0054a6] has-[:checked]:bg-blue-50">
                                <input type="radio" name="payment_method" value="pay_later" checked class="hidden">
                                <span class="text-xl">🏠</span>
                                <span class="text-[9px] font-black uppercase text-gray-500">Khi nhận hàng</span>
                            </label>
                            <label class="border-2 border-gray-100 p-3 rounded-xl cursor-pointer hover:border-[#0054a6] transition flex flex-col items-center gap-1 has-[:checked]:border-[#0054a6] has-[:checked]:bg-blue-50">
                                <input type="radio" name="payment_method" value="checkout" class="hidden">
                                <span class="text-xl">💳</span>
                                <span class="text-[9px] font-black uppercase text-gray-500">Thẻ / Ví điện tử</span>
                            </label>
                        </div>
                        <button type="submit" class="w-full bg-[#0054a6] text-white py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-orange-600 transition shadow-xl shadow-blue-100 active:scale-95">Xác nhận đặt hàng</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </main>

    <!-- Form ẩn để áp dụng voucher -->
    <form id="voucher-form" action="/Project1/cart/apply_voucher" method="POST" class="hidden">
        <input type="hidden" name="voucher_code" id="hidden_voucher_code">
        <!-- Để voucher controller có thể back về trang checkout -->
        <input type="hidden" name="redirect" value="order/checkout">
    </form>

    <script>
        function applyVoucher() {
            const code = document.getElementById('voucher_input').value;
            if (code) {
                document.getElementById('hidden_voucher_code').value = code;
                document.getElementById('voucher-form').submit();
            }
        }
    </script>
</body>
</html>