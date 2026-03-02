<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Giỏ hàng - HUTECH Shop</title>
</head>
<body class="bg-gray-50 min-h-screen">
    <header class="bg-[#0054a6] p-6 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#0054a6] font-black">H</div>
                <h1 class="text-2xl font-bold uppercase tracking-tighter">Giỏ Hàng Của Bạn</h1>
            </div>
            <a href="/Project1/product/index" class="text-sm font-bold bg-orange-500 px-6 py-2 rounded-xl hover:bg-orange-600 transition shadow-md">
                ← Tiếp tục mua sắm
            </a>
        </div>
    </header>

    <main class="container mx-auto py-10 px-4">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b text-[#0054a6] font-black uppercase text-xs tracking-widest">
                        <th class="p-6">Sản phẩm</th>
                        <th class="p-6">Giá niêm yết</th>
                        <th class="p-6 text-center">Số lượng</th>
                        <th class="p-6">Thành tiền</th>
                        <th class="p-6 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php 
                    $totalMoney = 0;
                    if (!empty($cart)): 
                        foreach($cart as $item): 
                            $subTotal = (int)$item['price'] * (int)$item['quantity'];
                            $totalMoney += $subTotal;
                    ?>
                    <tr class="hover:bg-blue-50/30 transition">
                        <td class="p-6 flex items-center gap-4">
                            <div class="relative">
                                <img src="/Project1/public/uploads/<?= $item['image'] ?>" class="w-20 h-20 object-cover rounded-2xl border shadow-sm">
                            </div>
                            <div>
                                <span class="font-black text-gray-800 text-lg uppercase"><?= htmlspecialchars($item['name']) ?></span>
                                <p class="text-xs text-gray-400 mt-1">Mã SP: <?= $item['id'] ?></p>
                            </div>
                        </td>
                        <td class="p-6 font-bold text-gray-600"><?= number_format($item['price']) ?>đ</td>
                        
                        <td class="p-6 text-center">
                            <div class="inline-flex items-center justify-center bg-gray-100 px-4 py-2 rounded-xl border-2 border-gray-200">
                                <span class="font-black text-[#0054a6] text-lg"><?= $item['quantity'] ?></span>
                            </div>
                        </td>

                        <td class="p-6 font-black text-[#0054a6] text-xl"><?= number_format($subTotal) ?>đ</td>
                        <td class="p-6 text-center">
                            <!-- Lưu ý: $item['cart_id'] là ID của dòng trong bảng cart -->
                            <a href="/Project1/cart/remove/<?= $item['cart_id'] ?>" 
                               onclick="return confirm('Xóa sản phẩm này khỏi giỏ?')"
                               class="inline-flex items-center justify-center w-10 h-10 bg-red-50 text-red-500 rounded-full hover:bg-red-500 hover:text-white transition shadow-sm">
                                ✕
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-32 text-center">
                            <div class="flex flex-col items-center">
                                <div class="text-6xl mb-4">🛒</div>
                                <p class="text-gray-400 italic font-medium text-xl uppercase tracking-tighter">Giỏ hàng đang trống rỗng</p>
                                <a href="/Project1/product/index" class="mt-6 text-[#0054a6] font-bold border-b-2 border-[#0054a6]">Quay lại shop ngay</a>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if (!empty($cart)): ?>
            <div class="p-10 bg-gradient-to-r from-blue-50 to-white flex flex-col md:flex-row justify-between items-center gap-6">
                <a href="/Project1/cart/clear" onclick="return confirm('Bạn muốn làm trống giỏ hàng?')" class="text-gray-400 font-bold hover:text-red-500 transition uppercase text-xs tracking-widest">
                    [ Xóa tất cả giỏ hàng ]
                </a>
                <div class="text-center md:text-right">
                    <p class="text-gray-500 font-bold uppercase text-xs tracking-widest mb-1">Số tiền cần thanh toán</p>
                    <p class="text-5xl font-black text-orange-600 tracking-tighter"><?= number_format($totalMoney) ?> <span class="text-2xl">VNĐ</span></p>
                    <div class="flex gap-4 mt-6">
                         <button class="flex-1 bg-white border-2 border-[#0054a6] text-[#0054a6] px-8 py-4 rounded-2xl font-black hover:bg-gray-50 transition uppercase tracking-widest">Trả sau</button>
                         <button class="flex-1 bg-[#0054a6] text-white px-10 py-4 rounded-2xl font-black hover:bg-orange-600 transition shadow-2xl shadow-blue-200 uppercase tracking-widest">Thanh Toán</button>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <p class="text-center mt-10 text-gray-400 text-xs font-bold uppercase tracking-[0.2em]">HUTECH E-Commerce System v2.0</p>
    </main>
</body>
</html>