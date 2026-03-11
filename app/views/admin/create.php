<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 text-white min-h-screen p-6 sticky top-0 flex flex-col">
            <h2 class="text-2xl font-black mb-10 italic tracking-tighter uppercase">HUTECH <span class="text-orange-500 italic">CP</span></h2>
            <nav class="space-y-2 flex-1">
                <a href="/Project1/admin/index" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 bg-orange-500 text-white shadow-lg shadow-orange-900/20">
                    <span class="mr-3 text-lg">📦</span> Sản phẩm
                </a>
                <a href="/Project1/admin/orders" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 text-gray-400 hover:bg-gray-800 hover:text-white">
                    <span class="mr-3 text-lg">📑</span> Đơn hàng
                </a>
                <a href="/Project1/admin/promotions" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 text-gray-400 hover:bg-gray-800 hover:text-white">
                    <span class="mr-3 text-lg">🎁</span> Ưu đãi
                </a>
                <a href="/Project1/admin/users" class="flex items-center px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all duration-300 text-gray-400 hover:bg-gray-800 hover:text-white">
                    <span class="mr-3 text-lg">👥</span> Người dùng
                </a>
            </nav>

            <div class="pt-6 border-t border-gray-800 mt-auto">
                <a href="/Project1/product/index" class="flex items-center px-4 py-3 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] text-gray-500 hover:text-white transition-colors">
                    ← Xem Cửa Hàng
                </a>
                <a href="/Project1/auth/logout" class="flex items-center px-4 py-3 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] text-red-500/70 hover:text-red-500 transition-colors mt-2">
                    🚪 Đăng xuất
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-10">
            <div class="mb-10">
                <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Thêm sản phẩm mới</h2>
                <p class="text-gray-500 font-medium">Nhập thông tin sản phẩm để bày bán lên cửa hàng.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-sm p-8 border border-gray-100 max-w-3xl">
                <form action="/Project1/admin/store" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Tên sản phẩm</label>
                                <input type="text" name="name" required placeholder="Ví dụ: Áo khoác HUTECH"
                                       class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-orange-500 outline-none transition font-bold text-lg">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Giá bán (VNĐ)</label>
                                <input type="number" name="price" required placeholder="Ví dụ: 250000"
                                       class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-orange-500 outline-none transition font-bold text-lg">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Số lượng kho</label>
                                <input type="number" name="stock" value="10" required
                                       class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-orange-500 outline-none transition font-bold text-lg">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Danh mục</label>
                                <select name="category_id" class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-orange-500 outline-none transition font-bold text-gray-600 appearance-none bg-white cursor-pointer">
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php if(!empty($categories)): foreach($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Hình ảnh</label>
                            <label class="flex flex-col items-center justify-center w-full h-[285px] border-2 border-gray-100 border-dashed rounded-3xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden group">
                                <div id="preview-container" class="absolute inset-0 hidden">
                                    <img id="image-preview" src="#" class="w-full h-full object-cover">
                                </div>
                                <div id="upload-instruction" class="text-center group-hover:scale-110 transition-transform">
                                    <div class="text-4xl mb-2">📸</div>
                                    <p class="text-xs font-black text-gray-400 uppercase">Tải ảnh lên</p>
                                </div>
                                <input type="file" name="image" id="image-input" accept="image/*" class="hidden" />
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Mô tả sản phẩm</label>
                        <textarea name="description" rows="5" placeholder="Nhập mô tả chi tiết về sản phẩm..."
                                  class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-orange-500 outline-none transition font-medium"></textarea>
                    </div>

                    <div class="flex gap-4 pt-6 border-t border-gray-50">
                        <button type="submit" class="flex-1 bg-orange-500 text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-orange-600 shadow-xl shadow-orange-100 transition active:scale-95">
                            Lưu sản phẩm
                        </button>
                        <a href="/Project1/admin/index" class="flex-1 bg-gray-100 text-gray-600 py-4 rounded-2xl font-black text-center uppercase tracking-widest hover:bg-gray-200 transition">
                            Hủy bỏ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const previewContainer = document.getElementById('preview-container');
        const uploadInstruction = document.getElementById('upload-instruction');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.setAttribute('src', e.target.result);
                    previewContainer.classList.remove('hidden');
                    uploadInstruction.classList.add('opacity-0');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>