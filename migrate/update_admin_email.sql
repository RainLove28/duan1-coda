-- Cập nhật email cho user admin
UPDATE `users` SET `email` = 'ikuysle@outlook.com' WHERE `username` = 'admin';

-- Thêm user test nếu chưa có
INSERT INTO `users` (`username`, `password`, `fullname`, `email`, `role`) VALUES
('testuser', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Test User', 'test@example.com', 'user')
ON DUPLICATE KEY UPDATE `email` = VALUES(`email`);

-- Kiểm tra dữ liệu
SELECT `username`, `email`, `role` FROM `users`;
