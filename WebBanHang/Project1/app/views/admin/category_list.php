<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Quản lý danh mục - HUTECH Admin</title>
</head>
<body class="p-8 bg-slate-100 font-sans">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-lg border-t-4 border-orange-500">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-black text-orange-600 tracking-tighter uppercase">Quản lý danh mục</h2>
                <p class="text-gray-500 text-sm italic">Quản lý các nhóm sản phẩm tại HUTECH Shop</p>
            </div>
            <div class="flex gap-2">
                <a href="/Project1/admin/index" class="bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-bold hover:bg-gray-300 transition">Quản lý sản phẩm</a>
                <a href="/Project1/category/create" class="bg-[#0054a6] text-white px-5 py-2.5 rounded-xl font-bold hover:bg-blue-700 shadow-md transition flex items-center">
                    <span class="mr-2">+</span> Thêm danh mục
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[#0054a6] uppercase text-xs font-black tracking-widest border-b-2">
                        <th class="p-4 w-20">ID</th>
                        <th class="p-4">Tên danh mục</th>
                        <th class="p-4 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (!empty($categories)): ?>
                        <?php foreach($categories as $cat): ?>
                        <tr class="hover:bg-orange-50 transition duration-200">
                            <td class="p-4 font-bold text-gray-400">#<?= $cat['id'] ?></td>
                            <td class="p-4 font-black text-gray-800 uppercase"><?= htmlspecialchars($cat['name']) ?></td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="/Project1/category/edit/<?= $cat['id'] ?>" 
                                       class="bg-blue-100 text-blue-700 px-4 py-1.5 rounded-lg text-sm font-bold hover:bg-blue-700 hover:text-white transition">
                                        SỬA
                                    </a>
                                    <a href="/Project1/category/delete/<?= $cat['id'] ?>" 
                                       onclick="return confirm('Xóa danh mục này sẽ gỡ liên kết khỏi toàn bộ sản phẩm liên quan. Bạn chắc chắn chứ?')"
                                       class="bg-red-100 text-red-700 px-4 py-1.5 rounded-lg text-sm font-bold hover:bg-red-700 hover:text-white transition">
                                        XÓA
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="p-10 text-center text-gray-400 italic">
                                Chưa có danh mục nào. Hãy bấm "Thêm mới".
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>