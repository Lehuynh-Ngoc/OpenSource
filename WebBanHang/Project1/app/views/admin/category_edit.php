<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sửa danh mục - HUTECH Admin</title>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden border-t-8 border-orange-500">
        <div class="bg-slate-50 p-6 text-center">
            <h2 class="text-3xl font-black uppercase text-orange-600">Sửa Danh Mục</h2>
        </div>
        <form action="/Project1/category/update/<?= $category['id'] ?>" method="POST" class="p-8 space-y-6">
            <div>
                <label class="block text-sm font-black text-gray-700 uppercase mb-2">Tên danh mục mới</label>
                <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" required 
                       class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none transition font-bold uppercase">
            </div>
            <div class="flex gap-4 pt-4 border-t border-gray-100">
                <a href="/Project1/category/index" class="flex-1 text-center bg-gray-100 text-gray-600 font-black py-4 rounded-2xl hover:bg-gray-200 transition tracking-widest text-sm uppercase"> Hủy bỏ </a>
                <button type="submit" class="flex-1 bg-orange-500 text-white font-black py-4 rounded-2xl hover:bg-orange-600 shadow-xl transition tracking-widest text-sm uppercase"> Cập nhật </button>
            </div>
        </form>
    </div>
</body>
</html>