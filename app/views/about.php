<?php
function parseMarkdown($markdown) {
    // Tách thành các khối dựa trên dấu ngắt dòng ---
    $sections = explode('---', $markdown);
    $html = "";

    foreach ($sections as $index => $section) {
        $section = trim($section);
        if (empty($section)) continue;

        // Bọc mỗi section vào một card trắng đẹp
        $html .= '<div class="bg-white rounded-[40px] shadow-2xl shadow-blue-900/5 p-10 md:p-16 border border-white/50 backdrop-blur-sm mb-12 hover:translate-y-[-5px] transition-all duration-500">';
        
        // Tiêu đề chính (#)
        $section = preg_replace('/^# (.*)$/m', '<h1 class="text-4xl font-black text-gray-800 uppercase mb-8 tracking-tighter flex items-center gap-4"><span class="w-2 h-10 bg-orange-500 rounded-full"></span>$1</h1>', $section);
        
        // Tiêu đề phụ (##)
        $section = preg_replace('/^## (.*)$/m', '<h2 class="text-xl font-black text-[#0054a6] uppercase mt-10 mb-6 flex items-center gap-2">🔹 $1</h2>', $section);
        
        // Tiêu đề nhỏ (###)
        $section = preg_replace('/^### (.*)$/m', '<h3 class="text-base font-black text-orange-500 uppercase mt-8 mb-4">$1</h3>', $section);
        
        // In đậm (**)
        $section = preg_replace('/\*\*(.*)\*\*/U', '<strong class="font-black text-gray-900 bg-orange-100 px-1 rounded">$1</strong>', $section);
        
        // Danh sách (-)
        $section = preg_replace('/^- (.*)$/m', '<li class="ml-6 mb-3 list-none text-gray-600 font-bold flex items-start gap-3"><span class="text-orange-500 mt-1">✦</span><span>$1</span></li>', $section);
        
        // Đoạn văn
        $lines = explode("\n", $section);
        foreach ($lines as &$line) {
            $trimmed = trim($line);
            if (!preg_match('/^<|^li/', $trimmed) && !empty($trimmed)) {
                $line = '<p class="text-gray-500 font-medium leading-relaxed mb-6 text-lg">' . $line . '</p>';
            }
        }
        $html .= implode("\n", $lines);
        $html .= '</div>';
    }
    
    return $html;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu & Điều khoản - HUTECH Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        .hero-gradient { background: radial-gradient(circle at top right, #0054a6, #003366); }
        .bg-pattern { background-image: radial-gradient(#0054a6 0.5px, transparent 0.5px); background-size: 24px 24px; opacity: 0.05; }
    </style>
</head>
<body class="bg-[#f8fafc] min-h-screen relative">
    <div class="fixed inset-0 bg-pattern pointer-events-none"></div>

    <!-- Header -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 shadow-sm">
        <div class="container mx-auto px-6 h-20 flex justify-between items-center">
            <a href="/Project1/product/index" class="text-3xl font-black italic tracking-tighter uppercase text-[#0054a6]">HUTECH <span class="text-orange-500">SHOP</span></a>
            
            <ul class="flex items-center gap-8 font-black text-xs uppercase tracking-widest text-gray-600">
                <li><a href="/Project1/product/index" class="hover:text-[#0054a6] transition">Sản phẩm</a></li>
                <li><a href="/Project1/default/promotions" class="hover:text-[#0054a6] transition">Ưu đãi</a></li>
                <li><a href="/Project1/default/about" class="hover:text-[#0054a6] transition text-[#0054a6]">Giới thiệu</a></li>
                <li class="relative">
                    <a href="/Project1/cart/index" class="hover:text-[#0054a6] transition flex items-center gap-2">
                        Giỏ hàng
                        <?php if (isset($cartCount) && $cartCount > 0): ?>
                        <span class="bg-orange-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full shadow-lg shadow-orange-200">
                            <?= $cartCount ?>
                        </span>
                        <?php endif; ?>
                    </a>
                </li>

                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Admin Dropdown -->
                    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['username'] === 'admin'): ?>
                        <li class="group relative">
                            <button class="bg-gray-900 text-white px-5 py-2.5 rounded-xl hover:bg-black transition shadow-xl flex items-center gap-2 text-[10px]">
                                ⚙️ Quản lý <span class="text-[8px] opacity-50">▼</span>
                            </button>
                            <div class="absolute hidden group-hover:block bg-white text-gray-800 rounded-2xl shadow-2xl py-3 w-56 mt-1 border border-gray-100 left-0 overflow-hidden z-[100] animate-in fade-in slide-in-from-top-2 duration-200">
                                <a href="/Project1/admin/index" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] transition font-black">📦 Sản phẩm</a>
                                <a href="/Project1/admin/orders" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] transition font-black">📑 Đơn hàng</a>
                                <a href="/Project1/admin/promotions" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] transition font-black">🎁 Ưu đãi</a>
                                <a href="/Project1/admin/users" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] transition font-black">👥 Người dùng</a>
                            </div>
                        </li>
                    <?php endif; ?>
                    
                    <li class="flex items-center gap-6 border-l border-gray-100 pl-8">
                        <a href="/Project1/auth/profile" class="text-[#0054a6] hover:text-orange-500 transition italic">Chào, <?= htmlspecialchars($_SESSION['username']) ?></a>
                        <a href="/Project1/auth/logout" class="text-red-400 hover:text-red-600 transition font-bold">Thoát</a>
                    </li>
                <?php else: ?>
                    <li class="border-l border-gray-100 pl-8">
                        <a href="/Project1/auth/login" class="bg-[#0054a6] text-white px-6 py-2.5 rounded-xl hover:bg-blue-700 transition shadow-xl shadow-blue-100">Đăng nhập</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient py-24 text-white overflow-hidden relative">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5 skew-x-[-20deg] translate-x-20"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <span class="inline-block bg-orange-500 text-white px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-6 shadow-xl">Welcome to HUTECH Shop</span>
            <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter leading-none mb-6">
                Tin cậy. <span class="text-orange-400">Hiện đại.</span><br>Sinh viên.
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl font-medium leading-relaxed opacity-80">
                Khám phá câu chuyện đằng sau hệ thống TMĐT hàng đầu dành cho cộng đồng sinh viên HUTECH và các quy định đảm bảo quyền lợi của bạn.
            </p>
        </div>
    </section>

    <main class="max-w-5xl mx-auto px-6 py-20 relative z-10">
        <div class="flex flex-col">
            <?= parseMarkdown($aboutContent) ?>
        </div>
        
        <!-- CTA Section -->
        <div class="mt-10 bg-[#0054a6] rounded-[40px] p-12 text-center text-white shadow-2xl shadow-blue-900/20 relative overflow-hidden">
            <div class="absolute inset-0 bg-orange-500/10 mix-blend-overlay"></div>
            <h2 class="text-3xl font-black uppercase tracking-tighter mb-4 relative z-10">Bạn đã sẵn sàng trải nghiệm?</h2>
            <p class="text-blue-100 mb-10 font-medium relative z-10">Hàng ngàn ưu đãi đang chờ đón bạn tại cửa hàng ngay bây giờ.</p>
            <a href="/Project1/product/index" class="inline-block bg-white text-[#0054a6] px-12 py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-orange-500 hover:text-white transition-all shadow-xl active:scale-95 relative z-10">
                Mua sắm ngay
            </a>
        </div>
    </main>

    <footer class="bg-gray-900 text-gray-500 py-16 text-center text-sm font-medium border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-2xl font-black italic tracking-tighter uppercase mb-8 text-gray-700">HUTECH <span class="text-gray-800">Shop</span></div>
            <p class="mb-2">&copy; 2026 HUTECH University - Hệ thống TMĐT Sinh viên</p>
            <p class="text-[10px] uppercase tracking-widest text-gray-600">Phát triển bởi Team Lập trình Web nâng cao</p>
        </div>
    </footer>
</body>
</html>