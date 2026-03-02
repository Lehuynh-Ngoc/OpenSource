# WebBanHang - HUTECH Shop

Dự án website bán hàng đơn giản sử dụng mô hình MVC với PHP thuần.

## Yêu cầu hệ thống
- PHP 8.0 trở lên.
- Đã cài đặt biến môi trường cho PHP (hoặc sử dụng XAMPP/Laragon).

## Cài đặt & Chạy
Dự án đã tích hợp sẵn file khởi chạy tự động.

1. Clone repository về máy.
2. Chạy file `run_web.bat` ở thư mục gốc.
3. Trình duyệt sẽ tự động mở trang web tại địa chỉ: `http://localhost:8000/Project1/product/index`.

## Cấu trúc thư mục
- `app/Controllers`: Chứa logic xử lý (Admin, Cart, Product).
- `app/Models`: Chứa dữ liệu (Sử dụng Session để lưu trữ dữ liệu tạm thời thay vì Database).
- `app/Views`: Giao diện người dùng (TailwindCSS).
- `public/uploads`: Chứa ảnh sản phẩm tải lên.

## Tính năng
- **Khách hàng**: 
  - Xem danh sách sản phẩm.
  - Thêm sản phẩm vào giỏ hàng.
  - Quản lý giỏ hàng (hiển thị số lượng).
- **Quản trị viên (Admin)**:
  - Xem danh sách sản phẩm.
  - Thêm sản phẩm mới (có upload ảnh).
  - Chỉnh sửa thông tin, cập nhật ảnh sản phẩm.
  - Xóa sản phẩm.
