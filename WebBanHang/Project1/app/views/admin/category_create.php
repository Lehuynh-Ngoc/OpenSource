<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Thêm danh mục - HUTECH Admin</title>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden border-t-8 border-[#0054a6]">
        <div class="bg-slate-50 p-6 text-center">
            <h2 class="text-3xl font-black uppercase text-[#0054a6]">Thêm Danh Mục</h2>
        </div>
        <form action="/Project1/category/store" method="POST" class="p-8 space-y-6">
            <div>
                <label class="block text-sm font-black text-gray-700 uppercase mb-2">Tên danh mục</label>
                <input type="text" name="name" placeholder="Ví dụ: Giày thể thao" required 
                       class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-[#0054a6] outline-none transition font-bold uppercase">
            </div>
            <div class="flex gap-4 pt-4 border-t border-gray-100">
                <a href="/Project1/category/index" class="flex-1 text-center bg-gray-100 text-gray-600 font-black py-4 rounded-2xl hover:bg-gray-200 transition tracking-widest text-sm uppercase"> Hủy bỏ </a>
                <button type="submit" class="flex-1 bg-[#0054a6] text-white font-black py-4 rounded-2xl hover:bg-orange-600 shadow-xl transition tracking-widest text-sm uppercase"> Lưu danh mục </button>
            </div>
        </form>
    </div>
</body>
</html>