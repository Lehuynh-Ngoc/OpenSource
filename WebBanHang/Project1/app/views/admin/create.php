<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Thêm sản phẩm mới - HUTECH Admin</title>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden border-t-8 border-orange-500">
        <div class="bg-[#0054a6] p-6 text-white text-center">
            <h2 class="text-3xl font-black uppercase tracking-tighter">Thêm Sản Phẩm</h2>
            <p class="text-blue-100 text-sm opacity-80 uppercase font-bold mt-1">HUTECH SHOP MANAGEMENT</p>
        </div>

        <form action="/Project1/admin/store" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            
            <div>
                <label class="block text-sm font-black text-gray-700 uppercase mb-2 tracking-wide">Tên sản phẩm</label>
                <input type="text" name="name" placeholder="Ví dụ: Áo khoác HUTECH Ver 2026" required 
                       class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-[#0054a6] focus:ring-2 focus:ring-blue-100 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-black text-gray-700 uppercase mb-2 tracking-wide">Giá bán (VNĐ)</label>
                <input type="number" name="price" placeholder="Ví dụ: 250000" required 
                       class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-[#0054a6] focus:ring-2 focus:ring-blue-100 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-black text-gray-700 uppercase mb-2 tracking-wide">Hình ảnh đại diện</label>
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-44 border-2 border-gray-200 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden">
                        
                        <div id="preview-container" class="absolute inset-0 hidden">
                            <img id="image-preview" src="#" class="w-full h-full object-cover">
                        </div>

                        <div id="upload-instruction" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 font-bold">Bấm để tải ảnh lên</p>
                            <p class="text-xs text-gray-400 italic">PNG, JPG hoặc JPEG (Tỷ lệ 1:1 đẹp nhất)</p>
                        </div>

                        <input type="file" name="image" id="image-input" accept="image/*" class="hidden" />
                    </label>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-gray-100">
                <a href="/Project1/admin/index" class="flex-1 text-center bg-gray-100 text-gray-600 font-black py-4 rounded-2xl hover:bg-gray-200 transition tracking-widest text-sm uppercase"> Hủy bỏ </a>
                <button type="submit" class="flex-1 bg-[#0054a6] text-white font-black py-4 rounded-2xl hover:bg-orange-600 shadow-xl shadow-blue-200 transition tracking-widest text-sm uppercase"> Lưu Sản Phẩm </button>
            </div>
        </form>
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