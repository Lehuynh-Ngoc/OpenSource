# 🛒 WebBanHang - HUTECH Shop (PHP MVC)

Dự án website bán hàng (thương mại điện tử) được phát triển bằng ngôn ngữ **PHP thuần** (PHP 8.0+) theo mô hình kiến trúc **MVC** (Model-View-Controller) và cơ sở dữ liệu **MySQL**.

## 🌟 Tính năng nổi bật

### 👤 Người dùng (Khách hàng)
- **Xem sản phẩm**: Danh sách sản phẩm được phân loại theo danh mục rõ ràng.
- **Chi tiết sản phẩm**: Xem thông tin chi tiết, hình ảnh, giá và mô tả sản phẩm.
- **Giỏ hàng (Cart)**:
    - Thêm sản phẩm vào giỏ hàng.
    - Cập nhật số lượng, xóa sản phẩm khỏi giỏ hàng.
    - Hiển thị tổng tiền tự động.
- **Tài khoản**: Đăng ký và đăng nhập để quản lý giỏ hàng cá nhân.

### 🛡️ Quản trị viên (Admin)
- **Dashboard**: Quản lý tổng quát hệ thống.
- **Quản lý Sản phẩm**: 
    - Xem danh sách sản phẩm.
    - Thêm sản phẩm mới (hỗ trợ tải lên hình ảnh).
    - Sửa thông tin sản phẩm và cập nhật kho hàng.
    - Xóa sản phẩm.
- **Quản lý Danh mục**: Thêm, sửa, xóa các danh mục sản phẩm (Laptop, Smartphone, Phụ kiện, v.v.).
- **Quản lý Người dùng**:
    - Xem danh sách thành viên.
    - Phân quyền người dùng (User/Admin).
    - Xóa người dùng (Bảo vệ tài khoản admin mặc định).

## 🛠️ Công nghệ sử dụng
- **Ngôn ngữ**: PHP 8.0+
- **Database**: MySQL / MariaDB (PDO for safety)
- **Frontend**: TailwindCSS (Giao diện hiện đại, responsive)
- **Web Server**: Hỗ trợ Apache (thông qua XAMPP, Laragon) hoặc Server tích hợp của PHP.

## 🚀 Hướng dẫn cài đặt

### 1. Chuẩn bị
- Đảm bảo máy tính đã cài đặt **PHP** (đã cấu hình PATH) và **MySQL**.
- Khuyên dùng: [Laragon](https://laragon.org/) hoặc [XAMPP](https://www.apachefriends.org/).

### 2. Cấu hình Cơ sở dữ liệu
- Dự án đã tích hợp sẵn công cụ khởi tạo tự động.
- Chạy file `setup_database.bat` ở thư mục gốc.
- Công cụ này sẽ tự động:
    - Khởi tạo Database `webbanhang`.
    - Tạo các bảng: `users`, `products`, `categories`, `cart`.
    - Tạo tài khoản Admin mặc định.

### 3. Chạy ứng dụng
- Chạy file `run_web.bat` ở thư mục gốc.
- Trình duyệt sẽ tự động mở địa chỉ: [http://localhost:8000/Project1/](http://localhost:8000/Project1/)

---

## 🔑 Thông tin đăng nhập Admin (Mặc định)
- **Username**: `admin`
- **Password**: `admin123`

## 📁 Cấu trúc thư mục (MVC)
```text
WebBanHang/Project1/
├── app/
│   ├── Controllers/    # Xử lý logic nghiệp vụ
│   ├── models/         # Tương tác với Database
│   └── views/          # Giao diện người dùng
├── public/
│   └── uploads/        # Lưu trữ hình ảnh sản phẩm
├── index.php           # Front Controller (Điểm vào duy nhất)
├── router.php          # Điều hướng URL
└── setup_db.php        # Script khởi tạo database
```

## 🤝 Liên hệ
- Tác giả: Lehuynh-Ngoc
- GitHub: [https://github.com/Lehuynh-Ngoc](https://github.com/Lehuynh-Ngoc)
