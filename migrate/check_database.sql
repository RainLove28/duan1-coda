-- Kiểm tra và cập nhật database
USE `duan1-coda`;

-- Kiểm tra bảng users
DESCRIBE users;

-- Kiểm tra user admin
SELECT id, username, email, role FROM users WHERE username = 'admin';

-- Cập nhật email cho admin nếu cần
UPDATE users SET email = 'ikuysle@outlook.com' WHERE username = 'admin';

-- Thêm cột OTP nếu chưa có
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS `otp` varchar(6) DEFAULT NULL AFTER `role`,
ADD COLUMN IF NOT EXISTS `otp_expires_at` timestamp NULL DEFAULT NULL AFTER `otp`;

-- Kiểm tra lại sau khi cập nhật
SELECT id, username, email, role, otp, otp_expires_at FROM users WHERE username = 'admin';
