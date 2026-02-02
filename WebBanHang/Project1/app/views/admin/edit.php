<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Chỉnh sửa sản phẩm - HUTECH Admin</title>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden border-t-8 border-blue-600">
        <div class="bg-orange-500 p-6 text-white text-center">
            <h2 class="text-3xl font-black uppercase tracking-tighter">Cập Nhật Sản Phẩm</h2>
            <p class="text-orange-100 text-sm opacity-90 uppercase font-bold mt-1">ID Sản phẩm: <?= $product['id'] ?></p>
        </div>

        <form action="/Project1/admin/update/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            
            <div>
                <label class="block text-sm font-black text-gray-700 uppercase mb-2 tracking-wide">Tên sản phẩm</label>
                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required 
                       class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition font-medium">
            </div>

            <div>
                <label class="block text-sm font-black text-gray-700 uppercase mb-2 tracking-wide">Giá bán (VNĐ)</label>
                <input type="number" name="price" value="<?= $product['price'] ?>" required 
                       class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-100 outline-none transition font-bold text-orange-600">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase mb-2 tracking-wide">Ảnh hiện tại</label>
                    <div class="h-32 w-full rounded-2xl border-2 border-gray-100 overflow-hidden bg-gray-50 flex items-center justify-center">
                        <img src="/Project1/public/uploads/<?= isset($product['image']) ? $product['image'] : 'default.jpg' ?>" 
                             class="w-full h-full object-cover">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase mb-2 tracking-wide">Thay ảnh mới</label>
                    <label class="flex flex-col items-center justify-center h-32 w-full border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden">
                        <div id="preview-container" class="absolute inset-0 hidden">
                            <img id="image-preview" src="#" class="w-full h-full object-cover">
                        </div>
                        <div id="upload-icon" class="text-center">
                            <svg class="w-8 h-8 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            <span class="text-[10px] text-gray-400 font-bold uppercase">Bấm để đổi</span>
                        </div>
                        <input type="file" name="image" id="image-input" accept="image/*" class="hidden" />
                    </label>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-gray-100">
                <a href="/Project1/admin/index" class="flex-1 text-center bg-gray-100 text-gray-500 font-black py-4 rounded-2xl hover:bg-gray-200 transition tracking-widest text-sm uppercase"> Quay lại </a>
                <button type="submit" class="flex-1 bg-[#0054a6] text-white font-black py-4 rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-100 transition tracking-widest text-sm uppercase"> Cập Nhật </button>
            </div>
        </form>
    </div>

    <script>
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const previewContainer = document.getElementById('preview-container');
        const uploadIcon = document.getElementById('upload-icon');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.setAttribute('src', e.target.result);
                    previewContainer.classList.remove('hidden');
                    uploadIcon.classList.add('opacity-0');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>