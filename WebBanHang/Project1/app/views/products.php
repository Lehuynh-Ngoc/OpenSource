<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HUTECH Shop - Danh sách sản phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-[#0054a6] p-4 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-black italic tracking-tighter">HUTECH <span class="text-orange-400">SHOP</span></h1>
            <ul class="flex space-x-6 items-center font-bold">
                <li><a href="/Project1/product/index" class="hover:text-orange-400 transition">Sản phẩm</a></li>
                <li class="relative">
                    <a href="/Project1/cart/index" class="hover:text-orange-400 transition flex items-center">
                        Giỏ hàng
                        <?php if (isset($cartCount) && $cartCount > 0): ?>
                        <span class="absolute -top-2 -right-4 bg-orange-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full border-2 border-[#0054a6]">
                            <?= $cartCount ?>
                        </span>
                        <?php endif; ?>
                    </a>
                </li>
                <li><a href="/Project1/admin/index" class="bg-white/10 px-3 py-1 rounded-lg hover:bg-white/20 text-sm font-medium">Quản trị</a></li>
            </ul>
        </div>
    </nav>

    <header class="bg-white py-12 border-b text-center">
        <h2 class="text-4xl font-extrabold text-gray-800 uppercase tracking-tight">Cửa hàng sinh viên HUTECH</h2>
        <p class="text-gray-500 mt-2 font-medium">Đồng phục - Phụ kiện - Chất lượng cao</p>
    </header>

    <main class="container mx-auto my-10 p-4">
        <?php if (!empty($products)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php foreach ($products as $item): ?>
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 group flex flex-col">
                    <div class="relative overflow-hidden h-64 bg-gray-100">
                        <img src="/Project1/public/uploads/<?= (!empty($item['image'])) ? $item['image'] : 'default.jpg' ?>" 
                             alt="<?= htmlspecialchars($item['name']) ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-800 mb-1"><?= htmlspecialchars($item['name']) ?></h3>
                        <p class="text-2xl font-black text-orange-600 mb-4"><?= number_format($item['price']) ?>đ</p>
                        
                        <div class="mt-auto">
                            <form action="/Project1/cart/add/<?= $item['id'] ?>" method="POST" class="space-y-3">
                                <div class="flex items-center justify-between bg-gray-50 p-2 rounded-xl border border-gray-100">
                                    <span class="text-xs font-bold text-gray-400 uppercase ml-2">Số lượng</span>
                                    <input type="number" name="quantity" value="1" min="1" required
                                           class="w-20 bg-white border-2 border-gray-200 rounded-lg p-1 text-center font-bold text-[#0054a6] outline-none focus:border-orange-500 transition">
                                </div>
                                
                                <button type="submit" 
                                        class="w-full bg-[#0054a6] text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-orange-600 transition-all shadow-lg shadow-blue-50 active:scale-95 flex justify-center items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Thêm vào giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed">
                <p class="text-gray-400 text-xl italic font-medium">Hiện tại chưa có sản phẩm nào được bày bán.</p>
            </div>
        <?php endif; ?>
    </main>

    <footer class="bg-gray-900 text-gray-500 py-10 text-center text-sm font-medium">
        <p>&copy; 2026 HUTECH University - Khoa Công nghệ thông tin</p>
        <p class="mt-1 uppercase tracking-widest text-[10px]">Lập trình web nâng cao với mô hình MVC</p>
    </footer>

</body>
</html>