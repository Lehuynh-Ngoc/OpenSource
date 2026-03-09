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
                <li><a href="/Project1/product/index" class="hover:text-orange-400 transition text-sm">Sản phẩm</a></li>
                <li class="relative">
                    <a href="/Project1/cart/index" class="hover:text-orange-400 transition flex items-center text-sm">
                        Giỏ hàng
                        <?php if (isset($cartCount) && $cartCount > 0): ?>
                        <span class="absolute -top-2 -right-4 bg-orange-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full border-2 border-[#0054a6]">
                            <?= $cartCount ?>
                        </span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Menu Quản lý Dropdown -->
                    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['username'] === 'admin'): ?>
                        <li class="group relative">
                            <button class="text-xs font-black uppercase tracking-widest bg-orange-500 px-4 py-2 rounded-xl hover:bg-orange-600 transition shadow-lg flex items-center gap-2">
                                ⚙️ Quản lý <span class="text-[10px]">▼</span>
                            </button>
                            <div class="absolute hidden group-hover:block bg-white text-gray-800 rounded-2xl shadow-2xl py-3 w-56 mt-1 border border-gray-100 left-0 overflow-hidden z-[100]">
                                <a href="/Project1/admin/index" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] font-black text-xs uppercase tracking-widest transition">📦 Sản phẩm</a>
                                <a href="/Project1/admin/promotions" class="block px-6 py-3 hover:bg-blue-50 hover:text-[#0054a6] font-black text-xs uppercase tracking-widest transition">🎁 Ưu đãi</a>
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
    </nav>

    <header id="main-banner" class="relative overflow-hidden bg-[#0054a6] py-24 text-white text-center transition-all duration-700 ease-in-out">
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full opacity-20 pointer-events-none">
            <div id="bg-circle-1" class="absolute top-[-10%] left-[-5%] w-64 h-64 bg-white rounded-full blur-3xl transition-all duration-700"></div>
            <div id="bg-circle-2" class="absolute bottom-[-10%] right-[-5%] w-96 h-96 bg-orange-400 rounded-full blur-3xl transition-all duration-700"></div>
        </div>

        <!-- Mũi tên điều hướng -->
        <button onclick="prevSlide()" class="absolute left-4 md:left-10 top-1/2 -translate-y-1/2 z-20 w-12 h-12 flex items-center justify-center bg-white/10 hover:bg-white/20 rounded-full backdrop-blur-md border border-white/20 transition-all active:scale-90">
            <span class="text-2xl">❮</span>
        </button>
        <button onclick="nextSlide()" class="absolute right-4 md:right-10 top-1/2 -translate-y-1/2 z-20 w-12 h-12 flex items-center justify-center bg-white/10 hover:bg-white/20 rounded-full backdrop-blur-md border border-white/20 transition-all active:scale-90">
            <span class="text-2xl">❯</span>
        </button>

        <div id="banner-content" class="container mx-auto px-4 relative z-10 transition-all duration-500 opacity-100">
            <h2 id="banner-title" class="text-5xl md:text-7xl font-black uppercase tracking-tighter mb-4 drop-shadow-2xl">
                Cửa hàng sinh viên <span class="text-orange-400">HUTECH</span>
            </h2>
            <p id="banner-subtitle" class="text-xl md:text-2xl font-bold text-blue-100 opacity-90 tracking-wide uppercase">
                Đồng phục - Phụ kiện - Chất lượng cao
            </p>
            
            <div id="banner-tags" class="mt-10 flex justify-center items-center gap-3 text-xs font-black tracking-widest uppercase">
                <span class="bg-orange-500 px-3 py-1 rounded-full shadow-lg">Uy tín</span>
                <span class="w-1.5 h-1.5 bg-white/30 rounded-full"></span>
                <span class="bg-white/10 px-3 py-1 rounded-full backdrop-blur-sm border border-white/10">Sinh viên</span>
                <span class="w-1.5 h-1.5 bg-white/30 rounded-full"></span>
                <span class="bg-orange-500 px-3 py-1 rounded-full shadow-lg">Giá rẻ</span>
            </div>

            <!-- Các dấu chấm điều hướng (Dots) - Đã di chuyển vào đây để không bị dính -->
            <div id="banner-dots" class="mt-10 flex justify-center gap-3">
                <!-- Sẽ được tạo tự động bằng JS -->
            </div>
        </div>

        <script>
            const slides = [
                {
                    bg: "bg-[#0054a6]",
                    title: 'Cửa hàng sinh viên <span class="text-orange-400">HUTECH</span>',
                    subtitle: "Đồng phục - Phụ kiện - Chất lượng cao",
                    circle1: "bg-white",
                    circle2: "bg-orange-400"
                },
                {
                    bg: "bg-[#059669]", // Xanh lá
                    title: 'Đồng phục <span class="text-yellow-300">Năng động</span>',
                    subtitle: "Chất liệu bền bỉ - Thiết kế hiện đại cho sinh viên",
                    circle1: "bg-yellow-200",
                    circle2: "bg-green-300"
                },
                {
                    bg: "bg-[#7c3aed]", // Tím
                    title: 'Phụ kiện <span class="text-pink-400">Cá tính</span>',
                    subtitle: "Balo - Mũ - Sổ tay - Khẳng định phong cách riêng",
                    circle1: "bg-pink-300",
                    circle2: "bg-purple-300"
                },
                {
                    bg: "bg-[#ea580c]", // Cam đậm
                    title: 'Ưu đãi <span class="text-white underline">Đặc quyền</span>',
                    subtitle: "Giảm giá đặc biệt cho Tân sinh viên khóa mới",
                    circle1: "bg-orange-200",
                    circle2: "bg-red-400"
                },
                {
                    bg: "bg-[#1e293b]", // Xanh đen (Slate)
                    title: 'Chất lượng <span class="text-blue-400">Vượt trội</span>',
                    subtitle: "Sản phẩm chính hãng - Đổi trả dễ dàng trong 7 ngày",
                    circle1: "bg-blue-300",
                    circle2: "bg-slate-400"
                }
            ];

            let currentSlide = 0;
            const banner = document.getElementById('main-banner');
            const bContent = document.getElementById('banner-content');
            const bTitle = document.getElementById('banner-title');
            const bSubtitle = document.getElementById('banner-subtitle');
            const bCircle1 = document.getElementById('bg-circle-1');
            const bCircle2 = document.getElementById('bg-circle-2');
            const bDotsContainer = document.getElementById('banner-dots');

            // Tạo các dấu chấm dựa trên số lượng slide
            function createDots() {
                bDotsContainer.innerHTML = '';
                slides.forEach((_, index) => {
                    const dot = document.createElement('button');
                    dot.className = `w-3 h-3 rounded-full transition-all duration-300 ${index === 0 ? 'bg-white w-8' : 'bg-white/30 hover:bg-white/60'}`;
                    dot.onclick = () => {
                        currentSlide = index;
                        updateSlide(currentSlide);
                        resetTimer();
                    };
                    bDotsContainer.appendChild(dot);
                });
            }

            function updateSlide(index) {
                bContent.style.opacity = '0';
                bContent.style.transform = 'translateY(10px)';

                setTimeout(() => {
                    const s = slides[index];
                    banner.className = `relative overflow-hidden ${s.bg} py-24 text-white text-center transition-all duration-700 ease-in-out`;
                    bCircle1.className = `absolute top-[-10%] left-[-5%] w-64 h-64 ${s.circle1} rounded-full blur-3xl transition-all duration-700`;
                    bCircle2.className = `absolute bottom-[-10%] right-[-5%] w-96 h-96 ${s.circle2} rounded-full blur-3xl transition-all duration-700`;

                    bTitle.innerHTML = s.title;
                    bSubtitle.innerText = s.subtitle;

                    // Cập nhật trạng thái các dấu chấm
                    const dots = bDotsContainer.querySelectorAll('button');
                    dots.forEach((dot, i) => {
                        if (i === index) {
                            dot.className = "w-8 h-3 rounded-full bg-white transition-all duration-300";
                        } else {
                            dot.className = "w-3 h-3 rounded-full bg-white/30 hover:bg-white/60 transition-all duration-300";
                        }
                    });

                    bContent.style.opacity = '1';
                    bContent.style.transform = 'translateY(0)';
                }, 300);
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % slides.length;
                updateSlide(currentSlide);
            }

            function prevSlide() {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                updateSlide(currentSlide);
            }

            let slideTimer = setInterval(nextSlide, 5000);
            function resetTimer() {
                clearInterval(slideTimer);
                slideTimer = setInterval(nextSlide, 5000);
            }

            createDots();
        </script>

        <!-- Menu Danh Mục (Nằm trong header để đẹp hơn) -->
        <div class="mt-12 flex justify-center gap-3 flex-wrap px-4 relative z-10">
            <a href="/Project1/product/index" 
               class="px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all duration-300 shadow-xl <?= (!isset($categoryId) || $categoryId == null) ? 'bg-orange-500 text-white scale-110' : 'bg-white/10 text-white hover:bg-white/20 backdrop-blur-md border border-white/10' ?>">
               Tất cả
            </a>
            <?php if(!empty($categories)): foreach($categories as $cat): ?>
            <a href="/Project1/product/index/<?= $cat['id'] ?>" 
               class="px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all duration-300 shadow-xl <?= (isset($categoryId) && $categoryId == $cat['id']) ? 'bg-orange-500 text-white scale-110' : 'bg-white/10 text-white hover:bg-white/20 backdrop-blur-md border border-white/10' ?>">
               <?= $cat['name'] ?>
            </a>
            <?php endforeach; endif; ?>
        </div>
    </header>

    <div class="bg-white shadow-sm border-b sticky top-[72px] z-40">
        <div class="container mx-auto px-4 py-4 flex flex-col md:flex-row gap-6 items-center justify-between">
            
            <!-- 1. PHẦN TÌM KIẾM THÔNG MINH -->
            <?php $currentSearch = $_GET['search'] ?? ''; ?>
            <form action="/Project1/product/index<?= isset($categoryId) ? '/'.$categoryId : '' ?>" method="GET" id="search-form" class="relative w-full md:w-96 flex gap-2">
                <div class="relative flex-1">
                    <input type="text" name="search" id="search-input" value="<?= htmlspecialchars($currentSearch) ?>" 
                           placeholder="Tìm tên sản phẩm..." 
                           class="w-full pl-12 pr-4 py-3 rounded-2xl border-2 border-gray-100 focus:border-[#0054a6] outline-none transition-all font-bold text-sm">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔍</div>
                </div>
                
                <button type="submit" id="search-btn" class="min-w-[100px] bg-[#0054a6] text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-md">
                    Tìm
                </button>

                <script>
                    const searchInput = document.getElementById('search-input');
                    const searchBtn = document.getElementById('search-btn');
                    const initialSearch = "<?= addslashes($currentSearch) ?>";

                    function updateSearchBtn() {
                        if (searchInput.value.trim() === initialSearch && initialSearch !== "") {
                            searchBtn.innerText = "Xóa Tìm";
                            searchBtn.classList.replace('bg-[#0054a6]', 'bg-red-500');
                            searchBtn.type = "button";
                            searchBtn.onclick = () => window.location.href = "/Project1/product/index<?= isset($categoryId) ? '/'.$categoryId : '' ?>";
                        } else {
                            searchBtn.innerText = "Tìm";
                            searchBtn.classList.replace('bg-red-500', 'bg-[#0054a6]');
                            searchBtn.type = "submit";
                            searchBtn.onclick = null;
                        }
                    }
                    searchInput.addEventListener('input', updateSearchBtn);
                    updateSearchBtn();
                </script>
            </form>

            <!-- 2. PHẦN BỘ LỌC THÔNG MINH -->
            <?php $currentSort = $_GET['sort'] ?? ''; ?>
            <form action="/Project1/product/index<?= isset($categoryId) ? '/'.$categoryId : '' ?>" method="GET" id="filter-form" class="flex items-center gap-2 w-full md:w-auto">
                <div class="flex items-center bg-gray-50 rounded-2xl border-2 border-gray-100 p-1">
                    <select name="sort" id="sort-select" 
                            class="px-4 py-2 bg-transparent outline-none font-bold text-sm cursor-pointer min-w-[150px]">
                        <option value="">Mới nhất</option>
                        <option value="price_asc" <?= ($currentSort == 'price_asc') ? 'selected' : '' ?>>Giá thấp → cao</option>
                        <option value="price_desc" <?= ($currentSort == 'price_desc') ? 'selected' : '' ?>>Giá cao → thấp</option>
                    </select>
                    
                    <button type="submit" id="filter-btn" class="min-w-[80px] bg-[#0054a6] text-white px-6 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-orange-500 transition-all">
                        Lọc
                    </button>
                </div>

                <script>
                    const sortSelect = document.getElementById('sort-select');
                    const filterBtn = document.getElementById('filter-btn');
                    const initialSort = "<?= addslashes($currentSort) ?>";

                    function updateFilterBtn() {
                        if (sortSelect.value === initialSort && initialSort !== "") {
                            filterBtn.innerText = "Xóa Lọc";
                            filterBtn.classList.replace('bg-[#0054a6]', 'bg-red-500');
                            filterBtn.type = "button";
                            filterBtn.onclick = () => window.location.href = "/Project1/product/index<?= isset($categoryId) ? '/'.$categoryId : '' ?>";
                        } else {
                            filterBtn.innerText = "Lọc";
                            filterBtn.classList.replace('bg-red-500', 'bg-[#0054a6]');
                            filterBtn.type = "submit";
                            filterBtn.onclick = null;
                        }
                    }
                    sortSelect.addEventListener('change', updateFilterBtn);
                    updateFilterBtn();
                </script>
            </form>

        </div>
    </div>

    <main class="container mx-auto my-10 p-4">
        <?php if (!empty($products)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($products as $item): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col relative">
                    <!-- Link bọc toàn bộ phần trên của Card -->
                    <a href="/Project1/product/detail/<?= $item['id'] ?>" class="block flex-1">
                        <div class="relative overflow-hidden h-48 bg-gray-100">
                            <img src="/Project1/public/uploads/<?= (!empty($item['image'])) ? $item['image'] : 'default.jpg' ?>" 
                                 alt="<?= htmlspecialchars($item['name']) ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <!-- Overlay khi hover -->
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition"></div>
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1 truncate group-hover:text-[#0054a6] transition"><?= htmlspecialchars($item['name']) ?></h3>
                            <p class="text-xl font-black text-orange-600 mb-1"><?= number_format($item['price']) ?>đ</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Kho: <?= $item['stock'] ?? 10 ?> sản phẩm</p>
                        </div>
                    </a>

                    <!-- Nút Thêm vào giỏ nhanh -->
                    <div class="p-4 pt-0">
                        <form action="/Project1/cart/add/<?= $item['id'] ?>" method="POST">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" 
                                    class="w-full bg-[#0054a6] text-white py-2 rounded-xl font-black uppercase text-[10px] tracking-widest hover:bg-orange-600 transition-all shadow-md active:scale-95 flex justify-center items-center gap-2">
                                + Giỏ hàng nhanh
                            </button>
                        </form>
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