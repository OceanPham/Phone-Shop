# 📘 README – Hướng dẫn chạy dự án Laravel

Dự án này là ứng dụng Laravel. Tài liệu dưới đây giúp bạn cài đặt và chạy trên máy local nhanh chóng.

---

## ✅ Yêu cầu hệ thống

-   **PHP**: 8.3.16
-   **Composer**: 2.8.11 trở lên
-   **Node.js**: 18.x
-   **NPM**: đi kèm Node 18 (hoặc Yarn)
-   **CSDL**: MySQL/MariaDB (hoặc PostgreSQL)
-   (Khuyến nghị) **Redis** cho queue/cache (tuỳ dự án)

> Nếu bạn dùng **Laragon** (Windows), các dịch vụ MySQL/Apache đã có sẵn.

---

## ⚡ TL;DR – Cài nhanh

```bash
# 1) Clone hoặc pull repo
git clone <REPO_URL> project && cd project

# 2) Cài PHP dependencies
composer install

# 3) Cài JS dependencies
npm install

# 4) Tạo file .env và key
cp .env.example .env
php artisan key:generate

# 5) Cấu hình DB trong .env rồi migrate/seed
php artisan migrate --seed

# 6) Link storage (nếu có upload/file)
php artisan storage:link

# 7) Chạy server và build assets (tùy nhu cầu)
php artisan serve
npm run dev   # hoặc npm run build để build production
```

---

## 🛠️ Cài đặt chi tiết

### 1) Clone/pull mã nguồn

```bash
git clone <REPO_URL> project
cd project
```

### 2) Cài đặt PHP dependencies

```bash
composer install
```

> Sử dụng `composer install` để đảm bảo khớp phiên bản trong `composer.lock`.

### 3) Cài đặt JS dependencies

```bash
npm install
```

> Nếu dự án dùng Vite/Laravel Mix, lệnh này sẽ cài toàn bộ package frontend.

### 4) Tạo file môi trường & App Key

```bash
cp .env.example .env     # Windows PowerShell: copy .env.example .env
php artisan key:generate
```

### 5) Cấu hình môi trường

Mở `.env` và cập nhật các giá trị quan trọng:

```env
APP_NAME="Laravel"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

# Database (ví dụ MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ten_database
DB_USERNAME=root
DB_PASSWORD=

# Cache/Queue (tuỳ dự án)
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
```

### 6) Migrate & Seed dữ liệu

```bash
php artisan migrate
# hoặc nếu có dữ liệu mẫu
php artisan migrate --seed
```

### 7) Link storage (nếu có xử lý file/media)

```bash
php artisan storage:link
```

### 8) Chạy server ứng dụng

```bash
php artisan serve
# Mặc định chạy tại http://127.0.0.1:8000
```

### 9) Chạy/bundle assets (Vite)

Trong môi trường **dev** (watch thay đổi):

```bash
npm run dev
```

Build **production** (minify, optimize):

```bash
npm run build
```

---

## 🧪 Kiểm thử (nếu dự án có test)

```bash
php artisan test
# hoặc
./vendor/bin/phpunit
```

---

## 🔧 Lệnh Artisan & NPM thường dùng

```bash
# Clear & rebuild cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migration
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh --seed

# Queue (nếu dùng)
php artisan queue:work

# Storage
php artisan storage:link

# NPM
npm run dev       # Dev server/build nhanh
npm run build     # Build production
npm run preview   # (nếu cấu hình) Preview build
```

---

## 💡 Gợi ý cho môi trường Laragon (Windows)

-   Thêm host ảo nếu cần: **Menu Laragon → Apache → sites-enabled** hoặc dùng “**Quick app**”.
-   Nếu gặp lỗi quyền với thư mục `storage`/`bootstrap/cache`, cấp quyền ghi:

    ```bash
    # Với Git Bash/PowerShell, đảm bảo các thư mục này có quyền ghi
    ```

---

## 🚑 Khắc phục sự cố thường gặp

### 1) Git báo _“detected dubious ownership”_

Nếu repo nằm trong thư mục thuộc **Administrators** (Windows), Git sẽ chặn thao tác:

```text
fatal: detected dubious ownership in repository at '<path>'
```

Sửa nhanh (đánh dấu thư mục là an toàn):

```bash
git config --global --add safe.directory D:/Laragon/laragon/www/thephonestore/phone-shop
```

Hoặc đổi **owner** thư mục về user hiện tại (an toàn hơn về lâu dài).

### 2) Lỗi kết nối DB

-   Kiểm tra dịch vụ MySQL đã chạy.
-   Đúng `DB_HOST/DB_PORT/DB_DATABASE/DB_USERNAME/DB_PASSWORD` trong `.env`.
-   Thử: `php artisan migrate` để xác thực kết nối.

### 3) Lỗi key hoặc session

-   Tạo lại key: `php artisan key:generate`
-   Xoá cache: `php artisan optimize:clear`

### 4) Asset không load / 404

-   Chạy `npm run dev` (dev) hoặc `npm run build` (prod).
-   Kiểm tra cấu hình `APP_URL` trong `.env`.

---

## 📦 Cấu trúc thư mục (rút gọn)

```
app/            # Code ứng dụng (Models, Http/Controllers, ...)
bootstrap/      # Bootstrap files, cache
config/         # Config Laravel
database/       # Migrations, seeders, factories
public/         # Document root (index.php, assets đã build)
resources/      # Views, JS/TS, CSS
routes/         # Web/API routes
storage/        # Logs, cache, uploads (symlink tới public/storage)
tests/          # Test files
```

---

## 🔐 Biến môi trường quan trọng (tuỳ dự án)

-   `APP_ENV`, `APP_DEBUG`, `APP_URL`
-   `DB_*` cho database
-   `MAIL_*` nếu gửi mail
-   `CACHE_DRIVER`, `SESSION_DRIVER`, `QUEUE_CONNECTION`
-   `VITE_*` nếu dùng Vite với URL tùy chỉnh

---

## 🧭 Quy trình đề xuất khi cập nhật code

```bash
git pull
composer install --no-interaction --prefer-dist
php artisan migrate --force
npm install
npm run build
php artisan optimize:clear
```
