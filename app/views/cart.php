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
                <a href="/Project1/product/index" class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#0054a6] font-black">H</div>
                    <h1 class="text-2xl font-bold uppercase tracking-tighter">HUTECH SHOP</h1>
                </a>
            </div>
            <ul class="flex space-x-6 items-center font-bold">
                <li><a href="/Project1/product/index" class="hover:text-orange-400 transition text-sm">Sản phẩm</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Menu Quản lý Dropdown -->
                    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['username'] === 'admin'): ?>
                        <li class="group relative">
                            <button class="text-xs font-black uppercase tracking-widest bg-orange-500 px-4 py-2 rounded-xl hover:bg-orange-600 transition shadow-lg flex items-center gap-2">
                                ⚙️ Quản lý <span class="text-[10px]">▼</span>
                            </button>
                            <div class="absolute hidden group-hover:block bg-white text-gray-800 rounded-2xl shadow-2xl py-3 w-56 mt-1 border border-gray-100 left-0 overflow-hidden z-[100]">
                                <a href="/Project1/admin/index" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] font-black text-xs uppercase tracking-widest transition">📦 Sản phẩm</a>
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
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b text-[#0054a6] font-black uppercase text-xs tracking-widest">
                        <th class="p-6 text-center w-20">Chọn</th>
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
                            if ($item['is_selected']) {
                                $totalMoney += $subTotal;
                            }
                    ?>
                    <tr class="hover:bg-blue-50/30 transition <?= !$item['is_selected'] ? 'opacity-60 grayscale-[0.5]' : '' ?>">
                        <td class="p-6 text-center">
                            <form action="/Project1/cart/toggle/<?= $item['cart_id'] ?>" method="POST" id="form-toggle-<?= $item['cart_id'] ?>">
                                <input type="hidden" name="selected" value="0">
                                <input type="checkbox" name="selected" value="1" 
                                       <?= $item['is_selected'] ? 'checked' : '' ?>
                                       onchange="document.getElementById('form-toggle-<?= $item['cart_id'] ?>').submit()"
                                       class="w-6 h-6 cursor-pointer accent-orange-500">
                            </form>
                        </td>
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
                            <form action="/Project1/cart/update/<?= $item['cart_id'] ?>" method="POST" class="inline-flex items-center justify-center bg-gray-100 px-2 py-1 rounded-xl border-2 border-gray-200">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" 
                                       class="w-12 bg-transparent text-center font-black text-[#0054a6] text-lg focus:outline-none">
                                <button type="submit" class="ml-2 text-xs bg-[#0054a6] text-white px-2 py-1 rounded-lg hover:bg-orange-500 transition">Lưu</button>
                            </form>
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
                        <td colspan="6" class="p-32 text-center">
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
                         <!-- Form Thanh toán -->
                         <form action="/Project1/order/checkout" method="POST" class="flex gap-4 w-full">
                            <input type="hidden" name="payment_method" id="payment_method" value="checkout">
                            <button type="submit" onclick="document.getElementById('payment_method').value='pay_later'" class="flex-1 bg-white border-2 border-[#0054a6] text-[#0054a6] px-8 py-4 rounded-2xl font-black hover:bg-gray-50 transition uppercase tracking-widest">Trả sau</button>
                            <button type="submit" onclick="document.getElementById('payment_method').value='checkout'" class="flex-1 bg-[#0054a6] text-white px-10 py-4 rounded-2xl font-black hover:bg-orange-600 transition shadow-2xl shadow-blue-200 uppercase tracking-widest">Thanh Toán</button>
                         </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <p class="text-center mt-10 text-gray-400 text-xs font-bold uppercase tracking-[0.2em]">HUTECH E-Commerce System v2.0</p>
    </main>
</body>
</html>