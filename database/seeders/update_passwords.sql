-- ========================================
-- CẬP NHẬT MẬT KHẨU CHO TẤT CẢ USER
-- ========================================
-- Mật khẩu: 123
-- Các loại hash được hỗ trợ:

-- 1. HASH MD5 (legacy system): 202cb962ac59075b964b07152d234b70
-- 2. HASH Laravel bcrypt: $2y$12$VJ4EWUTncG2.gTAhQAFfwe2wMSQ6VjwOeRMea4GqjZhgJuoCTbmfK

-- ========================================
-- CẬP NHẬT BẰNG MD5 (tương thích với legacy)
-- ========================================
UPDATE `tbl_nguoidung` SET `mat_khau` = '202cb962ac59075b964b07152d234b70' WHERE 1=1;

-- ========================================
-- HOẶC CẬP NHẬT BẰNG LARAVEL BCRYPT (recommended)
-- ========================================
-- UPDATE `tbl_nguoidung` SET `mat_khau` = '$2y$12$VJ4EWUTncG2.gTAhQAFfwe2wMSQ6VjwOeRMea4GqjZhgJuoCTbmfK' WHERE 1=1;

-- ========================================
-- KIỂM TRA KẾT QUẢ
-- ========================================
SELECT id, tai_khoan, ho_ten, email, LEFT(mat_khau, 20) as password_hash FROM `tbl_nguoidung` LIMIT 10;

-- ========================================
-- THÔNG TIN ĐĂNG NHẬP SAU KHI CẬP NHẬT
-- ========================================
/*
Tất cả user có thể đăng nhập với:
- Mật khẩu: 123

Test accounts:
1. Username: admin, Password: 123
2. Username: manager, Password: 123
3. Username: customer1, Password: 123
4. Username: customer2, Password: 123

Hoặc đăng nhập bằng email:
1. Email: admin@phonestore.com, Password: 123
2. Email: manager@phonestore.com, Password: 123
3. Email: customer1@email.com, Password: 123
4. Email: customer2@email.com, Password: 123
*/
