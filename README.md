# WebBanHang - HUTECH Shop

Dự án website bán hàng đơn giản sử dụng mô hình MVC với PHP thuần và MySQL.

## Yêu cầu hệ thống
- PHP 8.0 trở lên.
- MySQL / MariaDB (thông qua XAMPP, Laragon, hoặc Docker).
- Đã cài đặt biến môi trường cho PHP.

## Cài đặt & Chạy
Dự án đã tích hợp sẵn file khởi chạy tự động.

1. Clone repository về máy.
2. Chạy file `run_web.bat` ở thư mục gốc.
3. Trình duyệt sẽ tự động mở trang web tại địa chỉ: `http://localhost:8000/Project1/product/index`.
   - Lưu ý: File `Database.php` sẽ tự động khởi tạo database `webbanhang` và các bảng dữ liệu nếu chưa tồn tại.

## Cấu trúc thư mục
- `app/Controllers`: Chứa logic xử lý (Admin, Category, Product, Cart).
- `app/Models`: Quản lý kết nối Database và thao tác dữ liệu (Sử dụng MySQL).
- `app/Views`: Giao diện người dùng (TailwindCSS).
- `public/uploads`: Chứa ảnh sản phẩm tải lên.

## Tính năng
- **Khách hàng**: 
  - Xem danh sách sản phẩm theo từng danh mục.
  - Thêm sản phẩm vào giỏ hàng (lưu trữ trong database).
  - Quản lý giỏ hàng (hiển thị số lượng, giá tiền).
- **Quản trị viên (Admin)**:
  - **Quản lý Sản phẩm**: Xem, Thêm (có upload ảnh), Sửa, Xóa.
  - **Quản lý Danh mục**: Thêm, Sửa, Xóa danh mục sản phẩm.
  - Phân loại sản phẩm theo danh mục.
