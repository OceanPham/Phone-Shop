-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 26, 2025 at 03:31 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `duan1_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('LZbNUJ0VtG5vnvxCd52TCMOZOR76uyvXqkcBxdxc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWkxMRE16SVBZS3hsa2NiNFZwTFVpT2I2MkNKN0FleWxreUhoeENwWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYXJ0L2FwaS9jb3VudCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1756179025);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idsp` bigint UNSIGNED DEFAULT NULL,
  `images` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noi_dung` text COLLATE utf8mb4_unicode_ci,
  `date_create` datetime NOT NULL,
  `info` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_banner`
--

INSERT INTO `tbl_banner` (`id`, `name`, `idsp`, `images`, `noi_dung`, `date_create`, `info`, `created_at`, `updated_at`) VALUES
(1, 'iPhone 14 Pro Max Khuyến Mãi', 2, 'iphone14prm-banner.png', 'Sản phẩm khuyến mãi trong tháng 3, giá mềm ưu đãi cho các khách hàng mới nhất.', '2024-03-17 18:55:08', 'Màn hình: OLED 6.7\" Super Retina, Camera: 48MP', '2025-08-25 05:17:28', '2025-08-25 05:17:28'),
(2, 'OPPO Reno8 T Giảm Giá', 1, 'oppo-reno8t-banner.png', 'Ưu đãi đặc biệt cho OPPO Reno8 T 5G, số lượng có hạn!', '2024-03-17 18:57:34', 'Chip: Snapdragon 695 5G, RAM: 8GB', '2025-08-25 05:17:28', '2025-08-25 05:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog`
--

CREATE TABLE `tbl_blog` (
  `blog_id` bigint UNSIGNED NOT NULL,
  `blog_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `noi_dung` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `blogcate_id` bigint UNSIGNED DEFAULT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci,
  `duyet` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_blog`
--

INSERT INTO `tbl_blog` (`blog_id`, `blog_title`, `noi_dung`, `images`, `create_time`, `blogcate_id`, `tags`, `duyet`, `created_at`, `updated_at`) VALUES
(1, 'Thông báo Messenger không có âm thanh trên Android', '<p>Bị nhỡ thông báo ứng dụng, không nhận được thông báo cuộc gọi, tin nhắn từ Messenger là sự cố mà bất kỳ Messenger-er nào cũng mắc phải.</p>\r\n<h2>Cách sửa lỗi thông báo Messenger không có âm thanh</h2>\r\n<p>Nếu bạn không nghe thấy chuông báo thì vấn đề có thể đến từ kết nối Internet của dế yêu.</p>', 'ketnoimang.jpg,thumb-mess.jpg', '2023-03-15 14:13:38', 1, 'Điện Thoại', 1, '2025-08-25 05:17:28', '2025-08-25 05:17:28'),
(2, 'OPPO Reno8 T 5G có trọng lượng khoảng bao nhiêu?', '<p>Reno8 T 5G trang bị màn hình cong 3D 120Hz đầu tiên trong phân khúc tầm giá của OPPO.</p>\r\n<p>Với tần số quét màn hình 120Hz và tốc độ lấy mẫu cảm ứng 1000Hz, người dùng có được một màn hình mượt mà.</p>', 'thumb-blog2.jpg', '2023-03-15 19:47:28', 2, 'Tin Tức, Điện Thoại', 1, '2025-08-25 05:17:28', '2025-08-25 05:17:28'),
(3, 'Cách chèn chữ vào ảnh trên iPhone cực nhanh', '<p>Bạn đang tìm kiếm cách viết chữ lên ảnh trên điện thoại iPhone nhưng chưa biết cách thực hiện.</p>\r\n<ul>\r\n<li>Mở ứng dụng Ảnh trên iPhone.</li>\r\n<li>Chọn ảnh mà bạn muốn viết chữ lên ảnh > Chọn Sửa.</li>\r\n<li>Nhấn vào biểu tượng 3 dấu chấm > Chọn Đánh dấu.</li>\r\n</ul>', 'thumb-chenchutreniphone.jpg', '2023-03-16 16:09:15', 3, 'Hướng Dẫn, Điện Thoại', 1, '2025-08-25 05:17:28', '2025-08-25 05:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog_cate`
--

CREATE TABLE `tbl_blog_cate` (
  `blogcate_id` bigint UNSIGNED NOT NULL,
  `catename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro_cate` text COLLATE utf8mb4_unicode_ci,
  `images` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_blog_cate`
--

INSERT INTO `tbl_blog_cate` (`blogcate_id`, `catename`, `intro_cate`, `images`, `date_create`, `created_at`, `updated_at`) VALUES
(1, 'Thủ thuật', 'Các mẹo và thủ thuật sử dụng điện thoại', 'thuthuat.jpg', '2025-08-25 05:17:28', '2025-08-25 05:17:28', '2025-08-25 05:17:28'),
(2, 'Tin tức điện thoại', 'Tin tức mới nhất về công nghệ điện thoại', 'tintucdienthoai.jpg', '2025-08-25 05:17:28', '2025-08-25 05:17:28', '2025-08-25 05:17:28'),
(3, 'Hướng dẫn', 'Hướng dẫn sử dụng các tính năng', 'huong-dan.jpeg', '2025-08-25 05:17:28', '2025-08-25 05:17:28', '2025-08-25 05:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog_comment`
--

CREATE TABLE `tbl_blog_comment` (
  `blogcomment_id` bigint UNSIGNED NOT NULL,
  `id_blog` bigint UNSIGNED NOT NULL,
  `noi_dung` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_comment` datetime NOT NULL,
  `duyet` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `ma_binhluan` bigint UNSIGNED NOT NULL,
  `noi_dung` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ma_sanpham` bigint UNSIGNED NOT NULL,
  `ma_nguoidung` bigint UNSIGNED NOT NULL,
  `duyet` tinyint(1) NOT NULL DEFAULT '0',
  `ngay_binhluan` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_comment`
--

INSERT INTO `tbl_comment` (`ma_binhluan`, `noi_dung`, `ma_sanpham`, `ma_nguoidung`, `duyet`, `ngay_binhluan`, `created_at`, `updated_at`) VALUES
(1, 'Sản phẩm rất tốt, đáng giá tiền!', 1, 3, 1, '2024-01-15 15:30:00', '2025-08-25 05:17:28', '2025-08-25 05:17:28'),
(2, 'Camera chụp ảnh đẹp, màn hình sắc nét.', 2, 4, 1, '2024-01-16 16:45:00', '2025-08-25 05:17:28', '2025-08-25 05:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coupon`
--

CREATE TABLE `tbl_coupon` (
  `coupon_id` bigint UNSIGNED NOT NULL,
  `coupon_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_number` int NOT NULL,
  `coupon_condition` tinyint NOT NULL,
  `coupon_value` decimal(10,2) NOT NULL,
  `coupon_start_time` datetime NOT NULL,
  `coupon_end_time` datetime NOT NULL,
  `coupon_status` tinyint(1) NOT NULL DEFAULT '1',
  `coupon_desc` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_coupon`
--

INSERT INTO `tbl_coupon` (`coupon_id`, `coupon_name`, `coupon_code`, `coupon_number`, `coupon_condition`, `coupon_value`, `coupon_start_time`, `coupon_end_time`, `coupon_status`, `coupon_desc`, `created_at`, `updated_at`) VALUES
(1, 'Mã giảm giá chào mừng', 'WELCOME2024', 100, 2, 10.00, '2024-01-01 00:00:00', '2024-12-31 23:59:59', 1, 'Mã giảm giá chào mừng năm mới 2024', '2025-08-25 05:17:28', '2025-08-25 05:17:28'),
(2, 'Mã giảm giá smartphone', 'SMARTPHONE20', 50, 2, 20.00, '2024-01-01 00:00:00', '2024-06-30 23:59:59', 1, 'Giảm 20% cho đơn hàng smartphone cao cấp', '2025-08-25 05:17:28', '2025-08-25 05:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_danhgiasp`
--

CREATE TABLE `tbl_danhgiasp` (
  `id_review` bigint UNSIGNED NOT NULL,
  `iduser` bigint UNSIGNED NOT NULL,
  `idsanpham` bigint UNSIGNED NOT NULL,
  `images_review` text COLLATE utf8mb4_unicode_ci,
  `noidung` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating_star` decimal(2,1) NOT NULL,
  `date_create` datetime NOT NULL,
  `iddonhang` bigint UNSIGNED NOT NULL,
  `trangthai_review` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_danhgiasp`
--

INSERT INTO `tbl_danhgiasp` (`id_review`, `iduser`, `idsanpham`, `images_review`, `noidung`, `rating_star`, `date_create`, `iddonhang`, `trangthai_review`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '', 'Sản phẩm đẹp, chất lượng tốt, giao hàng nhanh. Rất hài lòng!', 5.0, '2024-01-15 18:00:00', 1, 1, '2025-08-25 05:17:28', '2025-08-25 05:17:28'),
(2, 4, 2, '', 'iPhone 14 Pro Max thật sự ấn tượng, camera Pro Max không thể chê!', 4.8, '2024-01-16 19:30:00', 2, 1, '2025-08-25 05:17:28', '2025-08-25 05:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_danhmuc`
--

CREATE TABLE `tbl_danhmuc` (
  `ma_danhmuc` bigint UNSIGNED NOT NULL,
  `ten_danhmuc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hinh_anh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_danhmuc`
--

INSERT INTO `tbl_danhmuc` (`ma_danhmuc`, `ten_danhmuc`, `hinh_anh`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'Oppo', 'a96-pink-1920.png', 'Danh mục điện thoại Oppo', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(2, 'Iphone', 'iPhone 14 Pro 128GB _ chinh hang.png', 'Danh mục điện thoại Iphone', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(3, 'Samsung', 'sam sung galaxy s23 cateogory.jpg', 'Danh mục điện thoại Samsung', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(4, 'Xiaomi', 'Xiaomi 12T.jpg', 'Danh mục điện thoại Xiaomi', '2025-08-25 05:17:27', '2025-08-25 05:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_danhmuc_phu`
--

CREATE TABLE `tbl_danhmuc_phu` (
  `id` bigint UNSIGNED NOT NULL,
  `iddm` bigint UNSIGNED NOT NULL,
  `ten_danhmucphu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_danhmuc_phu`
--

INSERT INTO `tbl_danhmuc_phu` (`id`, `iddm`, `ten_danhmucphu`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 1, 'Oppo A', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(2, 1, 'Oppo Find X', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(3, 1, 'Oppo Reno', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(4, 2, 'Iphone 14', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(5, 2, 'I phone 13', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(6, 2, 'I phone 12', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(7, 2, 'I phone 11', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(8, 2, 'I phone X', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(9, 3, 'Galaxy Z', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(10, 3, 'Galaxy S', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(11, 3, 'Galaxy A', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(12, 3, 'Galaxy M', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(13, 4, 'Xiaomi Redmi', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(14, 4, 'Xiaomi Mi', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(15, 4, 'Xiaomi Poco', '', '2025-08-25 05:17:27', '2025-08-25 05:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nguoidung`
--

CREATE TABLE `tbl_nguoidung` (
  `id` bigint UNSIGNED NOT NULL,
  `tai_khoan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mat_khau` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ho_ten` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vai_tro` tinyint NOT NULL DEFAULT '3' COMMENT '1: admin, 2: moderator, 3: customer',
  `diachi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sodienthoai` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hinh_anh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kich_hoat` tinyint NOT NULL DEFAULT '1',
  `shipping_id` bigint UNSIGNED DEFAULT NULL,
  `default_payment` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'codpayment',
  `congty` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_me` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_nguoidung`
--

INSERT INTO `tbl_nguoidung` (`id`, `tai_khoan`, `mat_khau`, `ho_ten`, `email`, `vai_tro`, `diachi`, `sodienthoai`, `hinh_anh`, `kich_hoat`, `shipping_id`, `default_payment`, `congty`, `about_me`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$mxMRRqqds7lC.6UY5ycL..Ce4iOGbC7xEQBDDobGmGCLJ54MHT4oa', 'Administrator', 'admin@phonestore.com', 1, '123 Admin Street', '0999999999', 'admin-avatar.jpg', 1, 0, 'codpayment', 'Phone Store', 'System Administrator', NULL, NULL, '2025-08-25 05:17:27', '2025-08-24 22:53:15'),
(2, 'manager', '202cb962ac59075b964b07152d234b70', 'Manager User', 'manager@phonestore.com', 2, '456 Manager Ave', '0888888888', 'manager-avatar.jpg', 1, 0, 'codpayment', 'Phone Store', 'Store Manager', NULL, NULL, '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(3, 'customer1', '$2y$12$82WGLEaMnPKDATUdmpowZewdeWhHQNQs.XhbBiTo.3XL0DlZcKsi.', 'Nguyễn Văn A', 'customer1@email.com', 3, '789 Customer Road', '0777777777', 'customer1-avatar.jpg', 1, 0, 'codpayment', NULL, 'Khách hàng thân thiết', NULL, NULL, '2025-08-25 05:17:27', '2025-08-24 22:53:48'),
(4, 'customer2', '202cb962ac59075b964b07152d234b70', 'Trần Thị B', 'customer2@email.com', 3, '321 Customer Lane', '0666666666', 'customer2-avatar.jpg', 1, 0, 'vnpaypayment', NULL, 'Khách hàng mới', NULL, NULL, '2025-08-25 05:17:27', '2025-08-25 05:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` bigint UNSIGNED NOT NULL,
  `madonhang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tongdonhang` decimal(10,2) NOT NULL,
  `pttt` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iduser` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dienThoai` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ghichu` text COLLATE utf8mb4_unicode_ci,
  `timeorder` datetime NOT NULL,
  `trangthai` tinyint NOT NULL DEFAULT '1',
  `thanhtoan` tinyint(1) NOT NULL DEFAULT '0',
  `coupon_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `vat_fee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `madonhang`, `tongdonhang`, `pttt`, `iduser`, `name`, `dienThoai`, `address`, `ghichu`, `timeorder`, `trangthai`, `thanhtoan`, `coupon_code`, `shipping_fee`, `vat_fee`, `email`, `created_at`, `updated_at`) VALUES
(1, 'ORD2024001', 10999000.00, 'Thanh toán khi nhận hàng', 3, 'Nguyễn Văn A', '0777777777', '789 Customer Road', 'Giao hàng cẩn thận', '2024-01-15 10:30:00', 4, 1, '', 50000.00, 100000.00, 'customer1@email.com', '2025-08-25 05:17:28', '2025-08-25 05:17:28'),
(2, 'ORD2024002', 27990000.00, 'Thanh toán VNpay', 4, 'Trần Thị B', '0666666666', '321 Customer Lane', 'Hàng dễ vỡ', '2024-01-16 14:20:00', 4, 1, '', 0.00, 200000.00, 'customer2@email.com', '2025-08-25 05:17:28', '2025-08-25 05:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_detail`
--

CREATE TABLE `tbl_order_detail` (
  `id` bigint UNSIGNED NOT NULL,
  `idsanpham` bigint UNSIGNED NOT NULL,
  `iddonhang` bigint UNSIGNED NOT NULL,
  `soluong` int NOT NULL,
  `dongia` decimal(10,2) NOT NULL,
  `tensp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hinhanh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ma_danhmuc` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_order_detail`
--

INSERT INTO `tbl_order_detail` (`id`, `idsanpham`, `iddonhang`, `soluong`, `dongia`, `tensp`, `hinhanh`, `ma_danhmuc`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 10999000.00, 'Điện thoại OPPO Reno8 T 5G 256GB', 'oppo-reno8t-vang1-thumb-600x600.jpg', 1, '2025-08-25 05:17:28', '2025-08-25 05:17:28'),
(2, 2, 2, 1, 27990000.00, 'iPhone 14 Pro Max 256GB', 'iphone14prm-1.jpg', 2, '2025-08-25 05:17:28', '2025-08-25 05:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reply_blog_comments`
--

CREATE TABLE `tbl_reply_blog_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `comment_id` bigint UNSIGNED NOT NULL,
  `reply_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply_author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reply_date` datetime NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reply_comments_product`
--

CREATE TABLE `tbl_reply_comments_product` (
  `id` bigint UNSIGNED NOT NULL,
  `comment_id` bigint UNSIGNED NOT NULL,
  `reply_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply_author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reply_date` datetime NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reply_reviews`
--

CREATE TABLE `tbl_reply_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `review_id` bigint UNSIGNED NOT NULL,
  `reply_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply_author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reply_date` datetime NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sanpham`
--

CREATE TABLE `tbl_sanpham` (
  `masanpham` bigint UNSIGNED NOT NULL,
  `tensp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `don_gia` decimal(10,2) NOT NULL,
  `ton_kho` int NOT NULL DEFAULT '0',
  `images` text COLLATE utf8mb4_unicode_ci,
  `giam_gia` decimal(5,2) NOT NULL DEFAULT '0.00',
  `ngay_nhap` datetime NOT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `information` text COLLATE utf8mb4_unicode_ci,
  `ma_danhmuc` bigint UNSIGNED NOT NULL,
  `id_dmphu` bigint UNSIGNED DEFAULT NULL,
  `promote` tinyint(1) NOT NULL DEFAULT '0',
  `dac_biet` tinyint(1) NOT NULL DEFAULT '0',
  `so_luot_xem` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_sanpham`
--

INSERT INTO `tbl_sanpham` (`masanpham`, `tensp`, `don_gia`, `ton_kho`, `images`, `giam_gia`, `ngay_nhap`, `mo_ta`, `information`, `ma_danhmuc`, `id_dmphu`, `promote`, `dac_biet`, `so_luot_xem`, `created_at`, `updated_at`) VALUES
(1, 'Điện thoại OPPO Reno8 T 5G 256GB', 10999000.00, 50, 'oppo-reno-8t.jpg', 5.00, '2023-04-01 09:20:03', '<p>OPPO Reno8 T 5G 128GB là mẫu điện thoại đầu tiên trong năm 2023 mà OPPO kinh doanh tại Việt Nam. Máy nhận được khá nhiều sự quan tâm đến từ cộng đồng công nghệ về thông số kỹ thuật hết sức ấn tượng như: Camera 108 MP, chipset nhà Qualcomm và màn hình AMOLED.</p>', 'Màn hình: AMOLED6.7\"Full HD+; Hệ điều hành: Android 13; Camera sau: Chính 108 MP & Phụ 2 MP, 2 MP; Camera trước: 32 MP; Chip: Snapdragon 695 5G RAM: 8 GB', 1, 3, 1, 1, 162, '2025-08-25 05:17:27', '2025-08-25 11:00:20'),
(2, 'iPhone 14 Pro Max 256GB', 27990000.00, 25, 'thumb-iphone14prm-1.jpg', 3.00, '2023-03-13 16:16:32', '<p>iPhone 14 Pro Max 256GB cũng đã được chính thức lộ diện trên toàn cầu với chip hiệu năng khủng cùng sự nâng cấp về camera từ nhà Apple.</p>', 'Màn hình: OLED6.7\" Super Retina XDR; Hệ điều hành: iOS 16; Camera sau: Chính 48 MP & Phụ 12 MP, 12 MP; Camera trước: 12 MP; Chip: Apple A16 Bionic', 2, 4, 1, 1, 68, '2025-08-25 05:17:27', '2025-08-25 09:01:27'),
(3, 'Samsung Galaxy S23 Ultra 256GB', 26990000.00, 30, 's23u-1.png,s23u-2.png,s23u-3.png', 5.00, '2023-03-17 13:26:50', '<p>Samsung Galaxy S23 Ultra là điện thoại cao cấp với camera 200MP ấn tượng cùng khung viền vuông vức sang trọng.</p>', 'Màn hình: Dynamic AMOLED 2X 6.8\"; Camera sau: Chính 200MP, Tele 10MP x2, Siêu rộng 12MP; Chip: Snapdragon 8 Gen 2; RAM: 8GB; Pin: 5.000mAh', 3, 10, 1, 1, 39, '2025-08-25 05:17:27', '2025-08-25 00:04:30'),
(4, 'Xiaomi 13 Pro 5G 256GB', 29990000.00, 20, 'thumb-xiaomi-poco-f3.jpeg', 8.00, '2023-03-13 20:48:54', '<p>Xiaomi 13 Pro với chip Snapdragon 8 Gen 2 mạnh mẽ cùng sự cộng tác với Leica để khiến người dùng đam mê nhiếp ảnh.</p>', 'Màn hình: AMOLED6.73\"Quad HD+; Camera sau: Chính 50 MP & Phụ 50 MP, 50 MP; Chip: Snapdragon 8 Gen 2; RAM: 12 GB; Pin: 4820 mAh120 W', 4, 14, 1, 1, 22, '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(5, 'OPPO A96 128GB', 5990000.00, 100, 'oppo-a77s-xanh.jpg', 8.00, '2023-03-12 09:21:43', '<p>OPPO A96 sở hữu ngoại hình bắt mắt cùng cấu hình ấn tượng trong phân khúc giá.</p>', 'Màn hình: IPS LCD6.59\"Full HD+; Camera sau: Chính 50 MP & Phụ 2 MP; Chip: Snapdragon 680; RAM: 8 GB; Pin: 5000 mAh33 W', 1, 1, 0, 0, 16, '2025-08-25 05:17:27', '2025-08-25 00:04:34'),
(6, 'iPhone 13 256GB', 16990000.00, 60, 'iphone13-1.jpg,iphone13-2.jpg', 5.00, '2023-03-13 16:19:19', '<p>iPhone 13 với cấu hình mạnh mẽ hơn, pin \"trâu\" hơn và khả năng quay phim chụp ảnh ấn tượng.</p>', 'Màn hình: OLED6.1\"Super Retina XDR; Camera sau: 2 camera 12 MP; Chip: Apple A15 Bionic; RAM: 4 GB; Pin: 3240 mAh20 W', 2, 5, 0, 0, 28, '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(7, 'Samsung Galaxy A73 5G 256GB', 10290000.00, 80, 'a73-1.jpg,a73-2.jpg', 5.00, '2023-03-17 13:26:50', '<p>Galaxy A73 5G với camera 108MP và màn hình Super AMOLED Plus 6.7 inch.</p>', 'Màn hình: Super AMOLED 6.7\"; Camera sau: Chính 108 MP; Chip: Snapdragon 778G 5G; RAM: 8GB; Pin: 5,000mAh', 3, 11, 0, 0, 18, '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(8, 'Xiaomi Redmi Note 11 Pro 128GB', 6190000.00, 90, 'thumb-xiaomi-poco-f3.jpeg', 10.00, '2023-03-13 20:35:08', '<p>Redmi Note 11 Pro với camera AI 108 MP và pin lớn, sạc siêu nhanh.</p>', 'Màn hình: AMOLED6.67\"Full HD+; Camera sau: Chính 108 MP; Chip: MediaTek Helio G96; RAM: 8 GB; Pin: 5000 mAh67 W', 4, 13, 0, 0, 35, '2025-08-25 05:17:27', '2025-08-25 05:17:27'),
(10, 'Điện thoại OPPO SUpper Reno8 T 5G 11111 GB', 10999000.00, 50, '1756177736_68ad25489cc15.png', 5.00, '2025-08-25 16:48:15', 'OPPO Reno8 T 5G 128GB là mẫu điện thoại đầu tiên trong năm 2023 mà OPPO kinh doanh tại Việt Nam. Máy nhận được khá nhiều sự quan tâm đến từ cộng đồng công nghệ về thông số kỹ thuật hết sức ấn tượng như: Camera 108 MP, chipset nhà Qualcomm và màn hình AMOLED.', 'Màn hình: AMOLED6.7\"Full HD+; Hệ điều hành: Android 13; Camera sau: Chính 108 MP & Phụ 2 MP, 2 MP; Camera trước: 32 MP; Chip: Snapdragon 695 5G RAM: 8 GB', 1, NULL, 1, 1, 61, '2025-08-25 09:48:15', '2025-08-25 20:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shipping`
--

CREATE TABLE `tbl_shipping` (
  `shipping_id` bigint UNSIGNED NOT NULL,
  `shipping_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_notes` text COLLATE utf8mb4_unicode_ci,
  `iduser` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_shipping`
--

INSERT INTO `tbl_shipping` (`shipping_id`, `shipping_name`, `shipping_address`, `shipping_phone`, `shipping_email`, `shipping_notes`, `iduser`, `created_at`, `updated_at`) VALUES
(1, 'Nguyễn Văn A', '789 Customer Road, Quận 1, TP.HCM', '0777777777', 'customer1@email.com', 'Giao hàng trong giờ hành chính', 3, '2025-08-25 05:17:29', '2025-08-25 05:17:29'),
(2, 'Trần Thị B', '321 Customer Lane, Quận 3, TP.HCM', '0666666666', 'customer2@email.com', 'Gọi trước khi giao', 4, '2025-08-25 05:17:29', '2025-08-25 05:17:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `slider_id` bigint UNSIGNED NOT NULL,
  `slider_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slider_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slider_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `slider_status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`slider_id`, `slider_name`, `slider_image`, `slider_url`, `date_create`, `slider_status`, `created_at`, `updated_at`) VALUES
(1, 'Khuyến mãi mùa hè 2024', 'summer-promotion-2024.jpg', '/products?category=promotion', '2024-03-17 18:41:33', 1, '2025-08-25 05:17:29', '2025-08-25 05:17:29'),
(2, 'iPhone 14 Series Ra mắt', 'iphone14-series-banner.jpg', '/products?category=iphone', '2024-03-17 18:45:00', 1, '2025-08-25 05:17:29', '2025-08-25 05:17:29'),
(3, 'Samsung Galaxy S23 Ultra', 'samsung-s23-ultra-banner.jpg', '/products/3', '2024-03-17 18:50:00', 1, '2025-08-25 05:17:29', '2025-08-25 05:17:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vnpay_transaction`
--

CREATE TABLE `tbl_vnpay_transaction` (
  `id` bigint UNSIGNED NOT NULL,
  `vnp_Amount` decimal(15,2) NOT NULL,
  `vnp_BankCode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vnp_BankTranNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vnp_CardType` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vnp_OrderInfo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vnp_PayDate` datetime DEFAULT NULL,
  `vnp_ResponseCode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vnp_TmnCode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vnp_TransactionNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vnp_TransactionStatus` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vnp_TxnRef` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vnp_SecureHashType` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vnp_SecureHash` text COLLATE utf8mb4_unicode_ci,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_vnpay_transaction`
--

INSERT INTO `tbl_vnpay_transaction` (`id`, `vnp_Amount`, `vnp_BankCode`, `vnp_BankTranNo`, `vnp_CardType`, `vnp_OrderInfo`, `vnp_PayDate`, `vnp_ResponseCode`, `vnp_TmnCode`, `vnp_TransactionNo`, `vnp_TransactionStatus`, `vnp_TxnRef`, `vnp_SecureHashType`, `vnp_SecureHash`, `order_id`, `created_at`, `updated_at`) VALUES
(1, 27990000.00, 'NCB', 'NCB123456789', 'ATM', 'Thanh toán đơn hàng ORD2024002', '2024-01-16 14:25:00', '00', 'PHONESTORE', 'VNP123456789', '1', 'ORD2024002', 'SHA256', 'hash_example', 2, '2025-08-25 05:17:29', '2025-08-25 05:17:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_banner_idsp_index` (`idsp`);

--
-- Indexes for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  ADD PRIMARY KEY (`blog_id`),
  ADD KEY `tbl_blog_duyet_create_time_index` (`duyet`,`create_time`),
  ADD KEY `tbl_blog_blogcate_id_index` (`blogcate_id`);

--
-- Indexes for table `tbl_blog_cate`
--
ALTER TABLE `tbl_blog_cate`
  ADD PRIMARY KEY (`blogcate_id`),
  ADD KEY `tbl_blog_cate_catename_index` (`catename`);

--
-- Indexes for table `tbl_blog_comment`
--
ALTER TABLE `tbl_blog_comment`
  ADD PRIMARY KEY (`blogcomment_id`),
  ADD KEY `tbl_blog_comment_id_blog_duyet_index` (`id_blog`,`duyet`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`ma_binhluan`),
  ADD KEY `tbl_comment_ma_nguoidung_foreign` (`ma_nguoidung`),
  ADD KEY `tbl_comment_ma_sanpham_duyet_index` (`ma_sanpham`,`duyet`);

--
-- Indexes for table `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `tbl_coupon_coupon_code_unique` (`coupon_code`),
  ADD KEY `tbl_coupon_coupon_code_coupon_status_index` (`coupon_code`,`coupon_status`),
  ADD KEY `tbl_coupon_coupon_start_time_coupon_end_time_index` (`coupon_start_time`,`coupon_end_time`);

--
-- Indexes for table `tbl_danhgiasp`
--
ALTER TABLE `tbl_danhgiasp`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `tbl_danhgiasp_iduser_foreign` (`iduser`),
  ADD KEY `tbl_danhgiasp_iddonhang_foreign` (`iddonhang`),
  ADD KEY `tbl_danhgiasp_idsanpham_rating_star_index` (`idsanpham`,`rating_star`);

--
-- Indexes for table `tbl_danhmuc`
--
ALTER TABLE `tbl_danhmuc`
  ADD PRIMARY KEY (`ma_danhmuc`),
  ADD KEY `tbl_danhmuc_ten_danhmuc_index` (`ten_danhmuc`);

--
-- Indexes for table `tbl_danhmuc_phu`
--
ALTER TABLE `tbl_danhmuc_phu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_danhmuc_phu_iddm_ten_danhmucphu_index` (`iddm`,`ten_danhmucphu`);

--
-- Indexes for table `tbl_nguoidung`
--
ALTER TABLE `tbl_nguoidung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_nguoidung_email_unique` (`email`),
  ADD KEY `tbl_nguoidung_email_vai_tro_index` (`email`,`vai_tro`),
  ADD KEY `tbl_nguoidung_tai_khoan_index` (`tai_khoan`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_order_madonhang_unique` (`madonhang`),
  ADD KEY `tbl_order_iduser_trangthai_index` (`iduser`,`trangthai`),
  ADD KEY `tbl_order_madonhang_index` (`madonhang`),
  ADD KEY `tbl_order_timeorder_index` (`timeorder`);

--
-- Indexes for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_order_detail_idsanpham_foreign` (`idsanpham`),
  ADD KEY `tbl_order_detail_ma_danhmuc_foreign` (`ma_danhmuc`),
  ADD KEY `tbl_order_detail_iddonhang_idsanpham_index` (`iddonhang`,`idsanpham`);

--
-- Indexes for table `tbl_reply_blog_comments`
--
ALTER TABLE `tbl_reply_blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_reply_blog_comments_comment_id_approved_index` (`comment_id`,`approved`);

--
-- Indexes for table `tbl_reply_comments_product`
--
ALTER TABLE `tbl_reply_comments_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_reply_comments_product_comment_id_approved_index` (`comment_id`,`approved`);

--
-- Indexes for table `tbl_reply_reviews`
--
ALTER TABLE `tbl_reply_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_reply_reviews_review_id_approved_index` (`review_id`,`approved`);

--
-- Indexes for table `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  ADD PRIMARY KEY (`masanpham`),
  ADD KEY `tbl_sanpham_id_dmphu_foreign` (`id_dmphu`),
  ADD KEY `tbl_sanpham_ma_danhmuc_dac_biet_index` (`ma_danhmuc`,`dac_biet`),
  ADD KEY `tbl_sanpham_tensp_don_gia_index` (`tensp`,`don_gia`),
  ADD KEY `tbl_sanpham_so_luot_xem_index` (`so_luot_xem`);

--
-- Indexes for table `tbl_shipping`
--
ALTER TABLE `tbl_shipping`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `tbl_shipping_iduser_index` (`iduser`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`slider_id`),
  ADD KEY `tbl_slider_slider_status_date_create_index` (`slider_status`,`date_create`);

--
-- Indexes for table `tbl_vnpay_transaction`
--
ALTER TABLE `tbl_vnpay_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_vnpay_transaction_vnp_txnref_vnp_responsecode_index` (`vnp_TxnRef`,`vnp_ResponseCode`),
  ADD KEY `tbl_vnpay_transaction_order_id_index` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  MODIFY `blog_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_blog_cate`
--
ALTER TABLE `tbl_blog_cate`
  MODIFY `blogcate_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_blog_comment`
--
ALTER TABLE `tbl_blog_comment`
  MODIFY `blogcomment_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `ma_binhluan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_coupon`
--
ALTER TABLE `tbl_coupon`
  MODIFY `coupon_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_danhgiasp`
--
ALTER TABLE `tbl_danhgiasp`
  MODIFY `id_review` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_danhmuc`
--
ALTER TABLE `tbl_danhmuc`
  MODIFY `ma_danhmuc` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_danhmuc_phu`
--
ALTER TABLE `tbl_danhmuc_phu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_nguoidung`
--
ALTER TABLE `tbl_nguoidung`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_reply_blog_comments`
--
ALTER TABLE `tbl_reply_blog_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_reply_comments_product`
--
ALTER TABLE `tbl_reply_comments_product`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_reply_reviews`
--
ALTER TABLE `tbl_reply_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  MODIFY `masanpham` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_shipping`
--
ALTER TABLE `tbl_shipping`
  MODIFY `shipping_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `slider_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_vnpay_transaction`
--
ALTER TABLE `tbl_vnpay_transaction`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD CONSTRAINT `tbl_banner_idsp_foreign` FOREIGN KEY (`idsp`) REFERENCES `tbl_sanpham` (`masanpham`);

--
-- Constraints for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  ADD CONSTRAINT `tbl_blog_blogcate_id_foreign` FOREIGN KEY (`blogcate_id`) REFERENCES `tbl_blog_cate` (`blogcate_id`);

--
-- Constraints for table `tbl_blog_comment`
--
ALTER TABLE `tbl_blog_comment`
  ADD CONSTRAINT `tbl_blog_comment_id_blog_foreign` FOREIGN KEY (`id_blog`) REFERENCES `tbl_blog` (`blog_id`);

--
-- Constraints for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD CONSTRAINT `tbl_comment_ma_nguoidung_foreign` FOREIGN KEY (`ma_nguoidung`) REFERENCES `tbl_nguoidung` (`id`),
  ADD CONSTRAINT `tbl_comment_ma_sanpham_foreign` FOREIGN KEY (`ma_sanpham`) REFERENCES `tbl_sanpham` (`masanpham`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_danhgiasp`
--
ALTER TABLE `tbl_danhgiasp`
  ADD CONSTRAINT `tbl_danhgiasp_iddonhang_foreign` FOREIGN KEY (`iddonhang`) REFERENCES `tbl_order` (`id`),
  ADD CONSTRAINT `tbl_danhgiasp_idsanpham_foreign` FOREIGN KEY (`idsanpham`) REFERENCES `tbl_sanpham` (`masanpham`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_danhgiasp_iduser_foreign` FOREIGN KEY (`iduser`) REFERENCES `tbl_nguoidung` (`id`);

--
-- Constraints for table `tbl_danhmuc_phu`
--
ALTER TABLE `tbl_danhmuc_phu`
  ADD CONSTRAINT `tbl_danhmuc_phu_iddm_foreign` FOREIGN KEY (`iddm`) REFERENCES `tbl_danhmuc` (`ma_danhmuc`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_iduser_foreign` FOREIGN KEY (`iduser`) REFERENCES `tbl_nguoidung` (`id`);

--
-- Constraints for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  ADD CONSTRAINT `tbl_order_detail_iddonhang_foreign` FOREIGN KEY (`iddonhang`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_order_detail_idsanpham_foreign` FOREIGN KEY (`idsanpham`) REFERENCES `tbl_sanpham` (`masanpham`),
  ADD CONSTRAINT `tbl_order_detail_ma_danhmuc_foreign` FOREIGN KEY (`ma_danhmuc`) REFERENCES `tbl_danhmuc` (`ma_danhmuc`);

--
-- Constraints for table `tbl_reply_blog_comments`
--
ALTER TABLE `tbl_reply_blog_comments`
  ADD CONSTRAINT `tbl_reply_blog_comments_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `tbl_blog_comment` (`blogcomment_id`);

--
-- Constraints for table `tbl_reply_comments_product`
--
ALTER TABLE `tbl_reply_comments_product`
  ADD CONSTRAINT `tbl_reply_comments_product_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `tbl_comment` (`ma_binhluan`);

--
-- Constraints for table `tbl_reply_reviews`
--
ALTER TABLE `tbl_reply_reviews`
  ADD CONSTRAINT `tbl_reply_reviews_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `tbl_danhgiasp` (`id_review`);

--
-- Constraints for table `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  ADD CONSTRAINT `tbl_sanpham_id_dmphu_foreign` FOREIGN KEY (`id_dmphu`) REFERENCES `tbl_danhmuc_phu` (`id`),
  ADD CONSTRAINT `tbl_sanpham_ma_danhmuc_foreign` FOREIGN KEY (`ma_danhmuc`) REFERENCES `tbl_danhmuc` (`ma_danhmuc`);

--
-- Constraints for table `tbl_shipping`
--
ALTER TABLE `tbl_shipping`
  ADD CONSTRAINT `tbl_shipping_iduser_foreign` FOREIGN KEY (`iduser`) REFERENCES `tbl_nguoidung` (`id`);

--
-- Constraints for table `tbl_vnpay_transaction`
--
ALTER TABLE `tbl_vnpay_transaction`
  ADD CONSTRAINT `tbl_vnpay_transaction_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
