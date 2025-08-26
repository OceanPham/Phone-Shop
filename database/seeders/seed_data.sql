-- ========================================
-- DATA SEEDING FOR LARAVEL PHONE SHOP
-- Dựa trên duan1_database_v2.sql và migrations
-- ========================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- ========================================
-- 1. CATEGORIES (tbl_danhmuc)
-- ========================================
INSERT INTO `tbl_danhmuc` (`ma_danhmuc`, `ten_danhmuc`, `hinh_anh`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'Oppo', 'a96-pink-1920.png', 'Danh mục điện thoại Oppo', NOW(), NOW()),
(2, 'Iphone', 'iPhone 14 Pro 128GB _ chinh hang.png', 'Danh mục điện thoại Iphone', NOW(), NOW()),
(3, 'Samsung', 'sam sung galaxy s23 cateogory.jpg', 'Danh mục điện thoại Samsung', NOW(), NOW()),
(4, 'Xiaomi', 'Xiaomi 12T.jpg', 'Danh mục điện thoại Xiaomi', NOW(), NOW());

-- ========================================
-- 2. SUB CATEGORIES (tbl_danhmuc_phu)
-- ========================================
INSERT INTO `tbl_danhmuc_phu` (`id`, `iddm`, `ten_danhmucphu`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 1, 'Oppo A', '', NOW(), NOW()),
(2, 1, 'Oppo Find X', '', NOW(), NOW()),
(3, 1, 'Oppo Reno', '', NOW(), NOW()),
(4, 2, 'Iphone 14', '', NOW(), NOW()),
(5, 2, 'I phone 13', '', NOW(), NOW()),
(6, 2, 'I phone 12', '', NOW(), NOW()),
(7, 2, 'I phone 11', '', NOW(), NOW()),
(8, 2, 'I phone X', '', NOW(), NOW()),
(9, 3, 'Galaxy Z', '', NOW(), NOW()),
(10, 3, 'Galaxy S', '', NOW(), NOW()),
(11, 3, 'Galaxy A', '', NOW(), NOW()),
(12, 3, 'Galaxy M', '', NOW(), NOW()),
(13, 4, 'Xiaomi Redmi', '', NOW(), NOW()),
(14, 4, 'Xiaomi Mi', '', NOW(), NOW()),
(15, 4, 'Xiaomi Poco', '', NOW(), NOW());

-- ========================================
-- 3. USERS (tbl_nguoidung)
-- ========================================
INSERT INTO `tbl_nguoidung` (`id`, `tai_khoan`, `mat_khau`, `ho_ten`, `diachi`, `shipping_id`, `sodienthoai`, `kich_hoat`, `hinh_anh`, `email`, `vai_tro`, `congty`, `default_payment`, `about_me`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', '123 Admin Street', 0, '0999999999', 1, 'admin-avatar.jpg', 'admin@phonestore.com', 1, 'Phone Store', 'codpayment', 'System Administrator', NOW(), NOW()),
(2, 'manager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Manager User', '456 Manager Ave', 0, '0888888888', 1, 'manager-avatar.jpg', 'manager@phonestore.com', 2, 'Phone Store', 'codpayment', 'Store Manager', NOW(), NOW()),
(3, 'customer1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn A', '789 Customer Road', 0, '0777777777', 1, 'customer1-avatar.jpg', 'customer1@email.com', 3, NULL, 'codpayment', 'Khách hàng thân thiết', NOW(), NOW()),
(4, 'customer2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Thị B', '321 Customer Lane', 0, '0666666666', 1, 'customer2-avatar.jpg', 'customer2@email.com', 3, NULL, 'vnpaypayment', 'Khách hàng mới', NOW(), NOW());

-- ========================================
-- 4. PRODUCTS (tbl_sanpham)
-- ========================================
INSERT INTO `tbl_sanpham` (`masanpham`, `tensp`, `don_gia`, `ton_kho`, `images`, `giam_gia`, `ngay_nhap`, `mo_ta`, `information`, `ma_danhmuc`, `id_dmphu`, `promote`, `dac_biet`, `so_luot_xem`, `created_at`, `updated_at`) VALUES
(1, 'Điện thoại OPPO Reno8 T 5G 256GB', 10999000.00, 50, 'oppo-reno8t-vang1-thumb-600x600.jpg,oppo-reno8t-den1-thumb-600x600.jpg', 5.00, '2023-04-01 09:20:03',
'<p>OPPO Reno8 T 5G 128GB là mẫu điện thoại đầu tiên trong năm 2023 mà OPPO kinh doanh tại Việt Nam. Máy nhận được khá nhiều sự quan tâm đến từ cộng đồng công nghệ về thông số kỹ thuật hết sức ấn tượng như: Camera 108 MP, chipset nhà Qualcomm và màn hình AMOLED.</p>',
'Màn hình: AMOLED6.7"Full HD+; Hệ điều hành: Android 13; Camera sau: Chính 108 MP & Phụ 2 MP, 2 MP; Camera trước: 32 MP; Chip: Snapdragon 695 5G RAM: 8 GB',
1, 3, 1, 1, 13, NOW(), NOW()),

(2, 'iPhone 14 Pro Max 256GB', 27990000.00, 25, 'iphone14prm-1.jpg,iphone14prm-2.jpg,iphone14prm-3.jpg', 3.00, '2023-03-13 16:16:32',
'<p>iPhone 14 Pro Max 256GB cũng đã được chính thức lộ diện trên toàn cầu với chip hiệu năng khủng cùng sự nâng cấp về camera từ nhà Apple.</p>',
'Màn hình: OLED6.7" Super Retina XDR; Hệ điều hành: iOS 16; Camera sau: Chính 48 MP & Phụ 12 MP, 12 MP; Camera trước: 12 MP; Chip: Apple A16 Bionic',
2, 4, 1, 1, 45, NOW(), NOW()),

(3, 'Samsung Galaxy S23 Ultra 256GB', 26990000.00, 30, 's23u-1.png,s23u-2.png,s23u-3.png', 5.00, '2023-03-17 13:26:50',
'<p>Samsung Galaxy S23 Ultra là điện thoại cao cấp với camera 200MP ấn tượng cùng khung viền vuông vức sang trọng.</p>',
'Màn hình: Dynamic AMOLED 2X 6.8"; Camera sau: Chính 200MP, Tele 10MP x2, Siêu rộng 12MP; Chip: Snapdragon 8 Gen 2; RAM: 8GB; Pin: 5.000mAh',
3, 10, 1, 1, 38, NOW(), NOW()),

(4, 'Xiaomi 13 Pro 5G 256GB', 29990000.00, 20, 'xiaomi-13-pro-trang.jpeg,xiaomi-13-pro-trang-1.jpeg', 8.00, '2023-03-13 20:48:54',
'<p>Xiaomi 13 Pro với chip Snapdragon 8 Gen 2 mạnh mẽ cùng sự cộng tác với Leica để khiến người dùng đam mê nhiếp ảnh.</p>',
'Màn hình: AMOLED6.73"Quad HD+; Camera sau: Chính 50 MP & Phụ 50 MP, 50 MP; Chip: Snapdragon 8 Gen 2; RAM: 12 GB; Pin: 4820 mAh120 W',
4, 14, 1, 1, 22, NOW(), NOW()),

(5, 'OPPO A96 128GB', 5990000.00, 100, 'a96-navigation-pink-v1.png,a96-pink-1920.png', 8.00, '2023-03-12 09:21:43',
'<p>OPPO A96 sở hữu ngoại hình bắt mắt cùng cấu hình ấn tượng trong phân khúc giá.</p>',
'Màn hình: IPS LCD6.59"Full HD+; Camera sau: Chính 50 MP & Phụ 2 MP; Chip: Snapdragon 680; RAM: 8 GB; Pin: 5000 mAh33 W',
1, 1, 0, 0, 15, NOW(), NOW()),

(6, 'iPhone 13 256GB', 16990000.00, 60, 'iphone13-1.jpg,iphone13-2.jpg', 5.00, '2023-03-13 16:19:19',
'<p>iPhone 13 với cấu hình mạnh mẽ hơn, pin "trâu" hơn và khả năng quay phim chụp ảnh ấn tượng.</p>',
'Màn hình: OLED6.1"Super Retina XDR; Camera sau: 2 camera 12 MP; Chip: Apple A15 Bionic; RAM: 4 GB; Pin: 3240 mAh20 W',
2, 5, 0, 0, 28, NOW(), NOW()),

(7, 'Samsung Galaxy A73 5G 256GB', 10290000.00, 80, 'a73-1.jpg,a73-2.jpg', 5.00, '2023-03-17 13:26:50',
'<p>Galaxy A73 5G với camera 108MP và màn hình Super AMOLED Plus 6.7 inch.</p>',
'Màn hình: Super AMOLED 6.7"; Camera sau: Chính 108 MP; Chip: Snapdragon 778G 5G; RAM: 8GB; Pin: 5,000mAh',
3, 11, 0, 0, 18, NOW(), NOW()),

(8, 'Xiaomi Redmi Note 11 Pro 128GB', 6190000.00, 90, 'xiaomi-redmi-note-11-pro.jpeg', 10.00, '2023-03-13 20:35:08',
'<p>Redmi Note 11 Pro với camera AI 108 MP và pin lớn, sạc siêu nhanh.</p>',
'Màn hình: AMOLED6.67"Full HD+; Camera sau: Chính 108 MP; Chip: MediaTek Helio G96; RAM: 8 GB; Pin: 5000 mAh67 W',
4, 13, 0, 0, 35, NOW(), NOW());

-- ========================================
-- 5. BLOG CATEGORIES (tbl_blog_cate)
-- ========================================
INSERT INTO `tbl_blog_cate` (`blogcate_id`, `catename`, `intro_cate`, `images`, `date_create`, `created_at`, `updated_at`) VALUES
(1, 'Thủ thuật', 'Các mẹo và thủ thuật sử dụng điện thoại', 'thuthuat.jpg', NOW(), NOW(), NOW()),
(2, 'Tin tức điện thoại', 'Tin tức mới nhất về công nghệ điện thoại', 'tintucdienthoai.jpg', NOW(), NOW(), NOW()),
(3, 'Hướng dẫn', 'Hướng dẫn sử dụng các tính năng', 'huong-dan.jpeg', NOW(), NOW(), NOW());

-- ========================================
-- 6. BLOGS (tbl_blog)
-- ========================================
INSERT INTO `tbl_blog` (`blog_id`, `blog_title`, `noi_dung`, `images`, `create_time`, `blogcate_id`, `tags`, `duyet`, `created_at`, `updated_at`) VALUES
(1, 'Thông báo Messenger không có âm thanh trên Android',
'<p>Bị nhỡ thông báo ứng dụng, không nhận được thông báo cuộc gọi, tin nhắn từ Messenger là sự cố mà bất kỳ Messenger-er nào cũng mắc phải.</p>
<h2>Cách sửa lỗi thông báo Messenger không có âm thanh</h2>
<p>Nếu bạn không nghe thấy chuông báo thì vấn đề có thể đến từ kết nối Internet của dế yêu.</p>',
'ketnoimang.jpg,thumb-mess.jpg', '2023-03-15 14:13:38', 1, 'Điện Thoại', 1, NOW(), NOW()),

(2, 'OPPO Reno8 T 5G có trọng lượng khoảng bao nhiêu?',
'<p>Reno8 T 5G trang bị màn hình cong 3D 120Hz đầu tiên trong phân khúc tầm giá của OPPO.</p>
<p>Với tần số quét màn hình 120Hz và tốc độ lấy mẫu cảm ứng 1000Hz, người dùng có được một màn hình mượt mà.</p>',
'thumb-blog2.jpg', '2023-03-15 19:47:28', 2, 'Tin Tức, Điện Thoại', 1, NOW(), NOW()),

(3, 'Cách chèn chữ vào ảnh trên iPhone cực nhanh',
'<p>Bạn đang tìm kiếm cách viết chữ lên ảnh trên điện thoại iPhone nhưng chưa biết cách thực hiện.</p>
<ul>
<li>Mở ứng dụng Ảnh trên iPhone.</li>
<li>Chọn ảnh mà bạn muốn viết chữ lên ảnh > Chọn Sửa.</li>
<li>Nhấn vào biểu tượng 3 dấu chấm > Chọn Đánh dấu.</li>
</ul>',
'thumb-chenchutreniphone.jpg', '2023-03-16 16:09:15', 3, 'Hướng Dẫn, Điện Thoại', 1, NOW(), NOW());

-- ========================================
-- 7. ORDERS (tbl_order)
-- ========================================
INSERT INTO `tbl_order` (`id`, `madonhang`, `tongdonhang`, `shipping_fee`, `vat_fee`, `pttt`, `iduser`, `name`, `dienThoai`, `email`, `address`, `ghichu`, `timeorder`, `trangthai`, `thanhtoan`, `coupon_code`, `created_at`, `updated_at`) VALUES
(1, 'ORD2024001', 10999000, 50000.00, 100000.00, 'Thanh toán khi nhận hàng', 3, 'Nguyễn Văn A', '0777777777', 'customer1@email.com', '789 Customer Road', 'Giao hàng cẩn thận', '2024-01-15 10:30:00', 4, 1, '', NOW(), NOW()),
(2, 'ORD2024002', 27990000, 0.00, 200000.00, 'Thanh toán VNpay', 4, 'Trần Thị B', '0666666666', 'customer2@email.com', '321 Customer Lane', 'Hàng dễ vỡ', '2024-01-16 14:20:00', 4, 1, '', NOW(), NOW());

-- ========================================
-- 8. ORDER DETAILS (tbl_order_detail)
-- ========================================
INSERT INTO `tbl_order_detail` (`id`, `idsanpham`, `iddonhang`, `soluong`, `dongia`, `tensp`, `hinhanh`, `ma_danhmuc`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 10999000, 'Điện thoại OPPO Reno8 T 5G 256GB', 'oppo-reno8t-vang1-thumb-600x600.jpg', 1, NOW(), NOW()),
(2, 2, 2, 1, 27990000, 'iPhone 14 Pro Max 256GB', 'iphone14prm-1.jpg', 2, NOW(), NOW());

-- ========================================
-- 9. COMMENTS (tbl_comment)
-- ========================================
INSERT INTO `tbl_comment` (`ma_binhluan`, `noi_dung`, `ma_sanpham`, `ma_nguoidung`, `duyet`, `ngay_binhluan`, `created_at`, `updated_at`) VALUES
(1, 'Sản phẩm rất tốt, đáng giá tiền!', 1, 3, 1, '2024-01-15 15:30:00', NOW(), NOW()),
(2, 'Camera chụp ảnh đẹp, màn hình sắc nét.', 2, 4, 1, '2024-01-16 16:45:00', NOW(), NOW());

-- ========================================
-- 10. REVIEWS (tbl_danhgiasp)
-- ========================================
INSERT INTO `tbl_danhgiasp` (`id_review`, `iduser`, `idsanpham`, `images_review`, `noidung`, `rating_star`, `date_create`, `iddonhang`, `trangthai_review`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '', 'Sản phẩm đẹp, chất lượng tốt, giao hàng nhanh. Rất hài lòng!', 5.0, '2024-01-15 18:00:00', 1, 1, NOW(), NOW()),
(2, 4, 2, '', 'iPhone 14 Pro Max thật sự ấn tượng, camera Pro Max không thể chê!', 4.8, '2024-01-16 19:30:00', 2, 1, NOW(), NOW());

-- ========================================
-- 11. BANNERS (tbl_banner)
-- ========================================
INSERT INTO `tbl_banner` (`id`, `name`, `idsp`, `images`, `noi_dung`, `date_create`, `info`, `created_at`, `updated_at`) VALUES
(1, 'iPhone 14 Pro Max Khuyến Mãi', 2, 'iphone14prm-banner.png', 'Sản phẩm khuyến mãi trong tháng 3, giá mềm ưu đãi cho các khách hàng mới nhất.', '2024-03-17 18:55:08', 'Màn hình: OLED 6.7" Super Retina, Camera: 48MP', NOW(), NOW()),
(2, 'OPPO Reno8 T Giảm Giá', 1, 'oppo-reno8t-banner.png', 'Ưu đãi đặc biệt cho OPPO Reno8 T 5G, số lượng có hạn!', '2024-03-17 18:57:34', 'Chip: Snapdragon 695 5G, RAM: 8GB', NOW(), NOW());

-- ========================================
-- 12. COUPONS (tbl_coupon)
-- ========================================
INSERT INTO `tbl_coupon` (`coupon_id`, `coupon_name`, `coupon_code`, `coupon_number`, `coupon_condition`, `coupon_value`, `coupon_start_time`, `coupon_end_time`, `coupon_status`, `coupon_desc`, `created_at`, `updated_at`) VALUES
(1, 'Mã giảm giá chào mừng', 'WELCOME2024', 100, 2, 10.00, '2024-01-01 00:00:00', '2024-12-31 23:59:59', 1, 'Mã giảm giá chào mừng năm mới 2024', NOW(), NOW()),
(2, 'Mã giảm giá smartphone', 'SMARTPHONE20', 50, 2, 20.00, '2024-01-01 00:00:00', '2024-06-30 23:59:59', 1, 'Giảm 20% cho đơn hàng smartphone cao cấp', NOW(), NOW());

-- ========================================
-- 13. SLIDERS (tbl_slider)
-- ========================================
INSERT INTO `tbl_slider` (`slider_id`, `slider_name`, `slider_image`, `slider_url`, `date_create`, `slider_status`, `created_at`, `updated_at`) VALUES
(1, 'Khuyến mãi mùa hè 2024', 'summer-promotion-2024.jpg', '/products?category=promotion', '2024-03-17 18:41:33', 1, NOW(), NOW()),
(2, 'iPhone 14 Series Ra mắt', 'iphone14-series-banner.jpg', '/products?category=iphone', '2024-03-17 18:45:00', 1, NOW(), NOW()),
(3, 'Samsung Galaxy S23 Ultra', 'samsung-s23-ultra-banner.jpg', '/products/3', '2024-03-17 18:50:00', 1, NOW(), NOW());

-- ========================================
-- 14. SHIPPING (tbl_shipping)
-- ========================================
INSERT INTO `tbl_shipping` (`shipping_id`, `shipping_name`, `shipping_address`, `shipping_phone`, `shipping_email`, `shipping_notes`, `iduser`, `created_at`, `updated_at`) VALUES
(1, 'Nguyễn Văn A', '789 Customer Road, Quận 1, TP.HCM', '0777777777', 'customer1@email.com', 'Giao hàng trong giờ hành chính', 3, NOW(), NOW()),
(2, 'Trần Thị B', '321 Customer Lane, Quận 3, TP.HCM', '0666666666', 'customer2@email.com', 'Gọi trước khi giao', 4, NOW(), NOW());

-- ========================================
-- 15. VNPAY TRANSACTIONS (tbl_vnpay_transaction)
-- ========================================
INSERT INTO `tbl_vnpay_transaction` (`id`, `vnp_Amount`, `vnp_BankCode`, `vnp_BankTranNo`, `vnp_CardType`, `vnp_OrderInfo`, `vnp_PayDate`, `vnp_ResponseCode`, `vnp_TmnCode`, `vnp_TransactionNo`, `vnp_TransactionStatus`, `vnp_TxnRef`, `vnp_SecureHashType`, `vnp_SecureHash`, `order_id`, `created_at`, `updated_at`) VALUES
(1, 27990000.00, 'NCB', 'NCB123456789', 'ATM', 'Thanh toán đơn hàng ORD2024002', '2024-01-16 14:25:00', '00', 'PHONESTORE', 'VNP123456789', '1', 'ORD2024002', 'SHA256', 'hash_example', 2, NOW(), NOW());
