<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Quản lý sản phẩm - HUTECH Admin</title>
</head>
<body class="p-8 bg-slate-100 font-sans">
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-2xl shadow-lg border-t-4 border-[#0054a6]">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-black text-[#0054a6] tracking-tighter uppercase">Danh sách sản phẩm</h2>
                <p class="text-gray-500 text-sm italic">Quản lý kho hàng nội bộ HUTECH Shop</p>
            </div>
            <div class="flex gap-2">
                <a href="/Project1/product/index" class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-bold hover:bg-gray-300 transition">Xem Shop</a>
                <a href="/Project1/admin/create" class="bg-orange-500 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-orange-600 shadow-md transition flex items-center">
                    <span class="mr-2">+</span> Thêm mới
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[#0054a6] uppercase text-xs font-black tracking-widest border-b-2">
                        <th class="p-4">Ảnh</th>
                        <th class="p-4">Tên sản phẩm</th>
                        <th class="p-4">Giá bán</th>
                        <th class="p-4 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (!empty($products)): ?>
                        <?php foreach($products as $p): ?>
                        <tr class="hover:bg-blue-50/50 transition duration-200">
                            <td class="p-4 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden border">
                                    <img src="/Project1/public/uploads/<?= isset($p['image']) ? $p['image'] : 'default.jpg' ?>?t=<?= time() ?>" 
                                    class="w-full h-full object-cover">
                                </div>
                            </td>
                            
                            <td class="p-4">
                                <span class="font-bold text-gray-800 text-lg uppercase"><?= htmlspecialchars($p['name']) ?></span>
                            </td>
                            
                            <td class="p-4">
                                <span class="text-orange-600 font-black text-lg"><?= number_format($p['price']) ?>đ</span>
                            </td>
                            
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="/Project1/admin/edit/<?= $p['id'] ?>" 
                                       class="bg-blue-100 text-blue-700 px-4 py-1.5 rounded-lg text-sm font-bold hover:bg-blue-700 hover:text-white transition">
                                        SỬA
                                    </a>
                                    <a href="/Project1/admin/delete/<?= $p['id'] ?>" 
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')"
                                       class="bg-red-100 text-red-700 px-4 py-1.5 rounded-lg text-sm font-bold hover:bg-red-700 hover:text-white transition">
                                        XÓA
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="p-10 text-center text-gray-400 italic font-medium">
                                Kho hàng trống. Vui lòng bấm "Thêm mới" để bắt đầu.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <p class="text-center mt-6 text-gray-400 text-xs">HUTECH MVC Project - Hệ thống quản lý kho v1.0</p>
</body>
</html>