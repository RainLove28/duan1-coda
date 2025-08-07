-- Thêm cột OTP vào bảng users (nếu chưa có)
ALTER TABLE `users` 
ADD COLUMN `otp` varchar(6) DEFAULT NULL AFTER `role`,
ADD COLUMN `otp_expires_at` timestamp NULL DEFAULT NULL AFTER `otp`,
ADD INDEX `idx_otp` (`otp`, `otp_expires_at`);

-- Cập nhật email cho user test nếu chưa có
UPDATE `users` SET `email` = 'test@example.com' WHERE `username` = 'testuser' AND `email` IS NULL;

-- Thêm user test nếu chưa có
INSERT INTO `users` (`username`, `password`, `fullname`, `email`, `role`) VALUES
('testuser', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Test User', 'test@example.com', 'user')
ON DUPLICATE KEY UPDATE `email` = VALUES(`email`);
