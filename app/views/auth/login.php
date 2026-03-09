<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - HUTECH Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
        <h2 class="text-3xl font-black text-[#0054a6] text-center mb-6 uppercase tracking-tighter">Đăng Nhập</h2>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 text-sm" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="/Project1/auth/login" method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-700 font-bold mb-1">Tên đăng nhập</label>
                <input type="text" name="username" required 
                       class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0054a6]">
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-1">Mật khẩu</label>
                <input type="password" name="password" required 
                       class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0054a6]">
            </div>
            <button type="submit" 
                    class="w-full bg-[#0054a6] text-white py-3 rounded-xl font-black uppercase tracking-widest hover:bg-orange-600 transition shadow-lg">
                Đăng Nhập
            </button>
        </form>
        
        <p class="mt-6 text-center text-gray-600 text-sm">
            Chưa có tài khoản? 
            <a href="/Project1/auth/register" class="text-[#0054a6] font-bold hover:underline">Đăng ký ngay</a>
        </p>
    </div>
</body>
</html>