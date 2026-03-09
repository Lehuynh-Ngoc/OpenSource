<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - HUTECH Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
        <h2 class="text-3xl font-black text-[#0054a6] text-center mb-6 uppercase tracking-tighter">Đăng Ký</h2>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 text-sm" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="/Project1/auth/register" method="POST" class="space-y-4">
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
            <div>
                <label class="block text-gray-700 font-bold mb-1">Xác nhận mật khẩu</label>
                <input type="password" name="confirm_password" required 
                       class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0054a6]">
            </div>
            <button type="submit" 
                    class="w-full bg-[#0054a6] text-white py-3 rounded-xl font-black uppercase tracking-widest hover:bg-orange-600 transition shadow-lg">
                Đăng Ký
            </button>
        </form>
        
        <p class="mt-6 text-center text-gray-600 text-sm">
            Đã có tài khoản? 
            <a href="/Project1/auth/login" class="text-[#0054a6] font-bold hover:underline">Đăng nhập</a>
        </p>
    </div>
</body>
</html>