-- Tạo bảng danh mục
CREATE TABLE IF NOT EXISTS `DanhMuc` (
  `MaDM` int(11) NOT NULL AUTO_INCREMENT,
  `TenDM` varchar(100) NOT NULL,
  `MaDMCha` int(11) DEFAULT NULL,
  `MoTa` text DEFAULT NULL,
  `TrangThai` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`MaDM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng sản phẩm
CREATE TABLE IF NOT EXISTS `SanPham` (
  `MaSP` int(11) NOT NULL AUTO_INCREMENT,
  `TenSanPham` varchar(255) NOT NULL,
  `Gia` decimal(10,2) NOT NULL,
  `GiaSale` decimal(10,2) DEFAULT NULL,
  `NoiBat` tinyint(1) DEFAULT 0,
  `MaDM` int(11) NOT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `MoTa` text DEFAULT NULL,
  `SoLuong` int(11) DEFAULT 0,
  `TrangThai` tinyint(1) DEFAULT 1,
  `NgayTao` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`MaSP`),
  FOREIGN KEY (`MaDM`) REFERENCES `DanhMuc`(`MaDM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu cho danh mục
INSERT INTO `DanhMuc` (`TenDM`, `MaDMCha`, `MoTa`) VALUES
('Sản phẩm mới', NULL, 'Các sản phẩm mới nhất'),
('Sản phẩm bán chạy', NULL, 'Các sản phẩm được ưa chuộng'),
('Chăm sóc da', NULL, 'Sản phẩm chăm sóc da'),
('Khuyễn mãi và combo', NULL, 'Các sản phẩm khuyến mãi'),
('Quà tặng', NULL, 'Sản phẩm quà tặng'),
('Son môi', NULL, 'Các loại son môi'),
('Son dưỡng môi', NULL, 'Son dưỡng môi'),
('Son màu', NULL, 'Son màu các loại'),
('Tẩy da chết môi', NULL, 'Sản phẩm tẩy da chết môi'),
('Kem nền', NULL, 'Kem nền trang điểm'),
('Kem má', NULL, 'Kem má hồng'),
('Tẩy trang - rửa mặt', NULL, 'Sản phẩm tẩy trang và rửa mặt'),
('Toner - xịt khoáng', NULL, 'Toner và xịt khoáng'),
('Dưỡng da', NULL, 'Sản phẩm dưỡng da'),
('Kem chống nắng', NULL, 'Kem chống nắng'),
('Sản phẩm gội đầu', NULL, 'Dầu gội và dầu xả'),
('Sản phẩm dưỡng tóc', NULL, 'Dưỡng tóc các loại'),
('Làm đẹp đường uống 1', NULL, 'Thực phẩm chức năng'),
('Xà bông thiên nhiên', NULL, 'Xà bông thiên nhiên'),
('Sữa tắm thiên nhiên', NULL, 'Sữa tắm thiên nhiên'),
('Dưỡng thể', NULL, 'Sản phẩm dưỡng thể'),
('Tẩy da chết body', NULL, 'Tẩy da chết toàn thân'),
('Chăm sóc răng miệng', NULL, 'Sản phẩm chăm sóc răng miệng'),
('Tắm bé', NULL, 'Sản phẩm tắm cho bé'),
('Chăm sóc bé', NULL, 'Sản phẩm chăm sóc bé'),
('Tinh dầu nhỏ giọt nguyên chất', NULL, 'Tinh dầu nguyên chất'),
('Tinh dầu trị liệu', NULL, 'Tinh dầu trị liệu'),
('Tinh dầu treo thông minh', NULL, 'Tinh dầu treo thông minh'),
('Dưới 300k', NULL, 'Sản phẩm dưới 300k'),
('Dưới 500k', NULL, 'Sản phẩm dưới 500k'),
('Dưới 800k', NULL, 'Sản phẩm dưới 800k'),
('Bộ Chăm sóc da ngừa lão hóa', NULL, 'Bộ sản phẩm chống lão hóa'),
('Bộ Chăm sóc da rau má', NULL, 'Bộ sản phẩm rau má'),
('Bộ Chăm sóc da tơ tằm', NULL, 'Bộ sản phẩm tơ tằm'),
('Bộ Chăm sóc da Sơ-ri', NULL, 'Bộ sản phẩm sơ-ri'),
('Chăm sóc nhà cửa', NULL, 'Sản phẩm chăm sóc nhà cửa'),
('Túi vải bảo vệ môi trường', NULL, 'Túi vải thân thiện môi trường'),
('Combo chăm sóc da', NULL, 'Combo chăm sóc da'),
('Combo chăm sóc tóc', NULL, 'Combo chăm sóc tóc'),
('Combo chăm sóc môi', NULL, 'Combo chăm sóc môi'),
('Combo khác', NULL, 'Combo khác');

-- Thêm dữ liệu mẫu cho sản phẩm
INSERT INTO `SanPham` (`TenSanPham`, `Gia`, `GiaSale`, `NoiBat`, `MaDM`, `HinhAnh`, `MoTa`, `SoLuong`) VALUES
('Son môi dưỡng ẩm', 150000.00, 120000.00, 1, 6, 'son-moi-1.jpg', 'Son môi dưỡng ẩm tự nhiên', 50),
('Kem dưỡng ẩm ban ngày', 250000.00, 200000.00, 1, 3, 'kem-duong-1.jpg', 'Kem dưỡng ẩm cho da khô', 30),
('Sữa rửa mặt dịu nhẹ', 180000.00, 150000.00, 1, 12, 'sua-rua-mat-1.jpg', 'Sữa rửa mặt cho da nhạy cảm', 40),
('Tẩy trang nước', 120000.00, 100000.00, 0, 12, 'tay-trang-1.jpg', 'Tẩy trang nước dịu nhẹ', 60),
('Kem chống nắng SPF50', 300000.00, 250000.00, 1, 15, 'kem-chong-nang-1.jpg', 'Kem chống nắng bảo vệ da', 25),
('Toner cân bằng da', 200000.00, 180000.00, 0, 13, 'toner-1.jpg', 'Toner cân bằng độ pH da', 35),
('Serum vitamin C', 350000.00, 300000.00, 1, 14, 'serum-vitamin-c-1.jpg', 'Serum vitamin C làm sáng da', 20),
('Mặt nạ dưỡng ẩm', 80000.00, 60000.00, 0, 3, 'mat-na-1.jpg', 'Mặt nạ dưỡng ẩm qua đêm', 100),
('Dầu gội thiên nhiên', 220000.00, 190000.00, 0, 16, 'dau-goi-1.jpg', 'Dầu gội thiên nhiên', 45),
('Dầu xả dưỡng tóc', 180000.00, 150000.00, 0, 17, 'dau-xa-1.jpg', 'Dầu xả dưỡng tóc mềm mượt', 50);
