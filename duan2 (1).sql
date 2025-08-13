-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 12, 2025 at 03:20 PM
-- Server version: 9.0.1
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `duan2`
--

-- --------------------------------------------------------

--
-- Table structure for table `binhluan`
--

CREATE TABLE `binhluan` (
  `MaBL` int NOT NULL,
  `MaTK` int NOT NULL,
  `MaSP` int NOT NULL,
  `NoiDung` varchar(255) NOT NULL,
  `ThoiGian` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Ratting` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `binhluan`
--

INSERT INTO `binhluan` (`MaBL`, `MaTK`, `MaSP`, `NoiDung`, `ThoiGian`, `Ratting`) VALUES
(1, 1, 41, 'sản phẩm chất lượng giá siêu tốt', '2025-08-11 07:58:58', '5');

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

CREATE TABLE `danhmuc` (
  `MaDM` int NOT NULL,
  `TenDM` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `MoTa` varchar(100) NOT NULL,
  `MaDMCha` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `danhmuc`
--

INSERT INTO `danhmuc` (`MaDM`, `TenDM`, `MoTa`, `MaDMCha`) VALUES
(1, 'Trang điểm', '', NULL),
(2, 'Da', '', NULL),
(3, 'Tóc', '', NULL),
(4, 'Làm đẹp đường uống', '', NULL),
(5, 'Cơ thể', '', NULL),
(6, 'Em bé', '', NULL),
(7, 'Hương thơm', '', NULL),
(8, 'Quà tặng', '', NULL),
(9, 'Bộ sản phẩm', '', NULL),
(10, 'Khác', '', NULL),
(11, 'Sale', '', NULL),
(12, 'Combo chăm sóc da', '', 11),
(13, 'Combo chăm sóc tóc', '', 11),
(14, 'Combo chăm sóc môi', '', 11),
(15, 'Combo khác', '', 11),
(17, 'Son dưỡng môi', '', 1),
(18, 'Son màu', '', 1),
(19, 'Tẩy da chết môi', '', 1),
(20, 'Kem nền', '', 1),
(21, 'Kem má', '', 1),
(22, 'Tẩy trang - rửa mặt', '', 2),
(23, 'Toner - xịt khoáng', '', 2),
(24, 'Dưỡng da', '', 2),
(25, 'Kem chống nắng', '', 2),
(26, 'Sản phẩm gội đầu', '', 3),
(27, 'Sản phẩm dưỡng tóc', '', 3),
(28, 'Làm đẹp đường uống 1', '', 4),
(29, 'Xà bông thiên nhiên', '', 5),
(30, 'Sữa tắm thiên nhiên', '', 5),
(31, 'Dưỡng thể', '', 5),
(32, 'Tẩy da chết body', '', 5),
(33, 'Chăm sóc răng miệng', '', 5),
(34, 'Tắm bé', '', 6),
(35, 'Chăm sóc bé', '', 6),
(36, 'Tinh dầu nhỏ giọt nguyên chất', '', 7),
(37, 'Tinh dầu trị liệu', '', 7),
(38, 'Tinh dầu treo thông mình', '', 7),
(39, 'Dưới 300k', '', 8),
(40, 'Dưới 500k', '', 8),
(41, 'Dưới 800k', '', 8),
(42, 'Bộ chăm sóc da ngừa lão hóa', '', 9),
(43, 'Bộ chăm sóc da rau má', '', 9),
(44, 'Bộ chăm sóc da tơ tằm', '', 9),
(45, 'Bộ chăm sóc da Sơ-Ri', '', 9),
(46, 'Chăm sóc nhà cửa', '', 10),
(47, 'Túi vải bảo vệ môi trường', '', 10),
(48, 'Sản phẩm mới', '', NULL),
(49, 'Sản phẩm bán chạy', '', NULL),
(50, 'Chăm sóc da', '', NULL),
(51, 'Khuyễn mãi và combo', '', NULL),
(52, 'Son môi', '', NULL),
(53, 'Sản phẩm mới', 'Các sản phẩm mới nhất', NULL),
(54, 'Sản phẩm bán chạy', 'Các sản phẩm được ưa chuộng', NULL),
(55, 'Chăm sóc da', 'Sản phẩm chăm sóc da', NULL),
(56, 'Khuyễn mãi và combo', 'Các sản phẩm khuyến mãi', NULL),
(57, 'Quà tặng', 'Sản phẩm quà tặng', NULL),
(58, 'Son môi', 'Các loại son môi', NULL),
(59, 'Son dưỡng môi', 'Son dưỡng môi', NULL),
(60, 'Son màu', 'Son màu các loại', NULL),
(61, 'Tẩy da chết môi', 'Sản phẩm tẩy da chết môi', NULL),
(62, 'Kem nền', 'Kem nền trang điểm', NULL),
(63, 'Kem má', 'Kem má hồng', NULL),
(64, 'Tẩy trang - rửa mặt', 'Sản phẩm tẩy trang và rửa mặt', NULL),
(65, 'Toner - xịt khoáng', 'Toner và xịt khoáng', NULL),
(66, 'Dưỡng da', 'Sản phẩm dưỡng da', NULL),
(67, 'Kem chống nắng', 'Kem chống nắng', NULL),
(68, 'Sản phẩm gội đầu', 'Dầu gội và dầu xả', NULL),
(69, 'Sản phẩm dưỡng tóc', 'Dưỡng tóc các loại', NULL),
(70, 'Làm đẹp đường uống 1', 'Thực phẩm chức năng', NULL),
(71, 'Xà bông thiên nhiên', 'Xà bông thiên nhiên', NULL),
(72, 'Sữa tắm thiên nhiên', 'Sữa tắm thiên nhiên', NULL),
(73, 'Dưỡng thể', 'Sản phẩm dưỡng thể', NULL),
(74, 'Tẩy da chết body', 'Tẩy da chết toàn thân', NULL),
(75, 'Chăm sóc răng miệng', 'Sản phẩm chăm sóc răng miệng', NULL),
(76, 'Tắm bé', 'Sản phẩm tắm cho bé', NULL),
(77, 'Chăm sóc bé', 'Sản phẩm chăm sóc bé', NULL),
(78, 'Tinh dầu nhỏ giọt nguyên chất', 'Tinh dầu nguyên chất', NULL),
(79, 'Tinh dầu trị liệu', 'Tinh dầu trị liệu', NULL),
(80, 'Tinh dầu treo thông minh', 'Tinh dầu treo thông minh', NULL),
(81, 'Dưới 300k', 'Sản phẩm dưới 300k', NULL),
(82, 'Dưới 500k', 'Sản phẩm dưới 500k', NULL),
(83, 'Dưới 800k', 'Sản phẩm dưới 800k', NULL),
(84, 'Bộ Chăm sóc da ngừa lão hóa', 'Bộ sản phẩm chống lão hóa', NULL),
(85, 'Bộ Chăm sóc da rau má', 'Bộ sản phẩm rau má', NULL),
(86, 'Bộ Chăm sóc da tơ tằm', 'Bộ sản phẩm tơ tằm', NULL),
(87, 'Bộ Chăm sóc da Sơ-ri', 'Bộ sản phẩm sơ-ri', NULL),
(88, 'Chăm sóc nhà cửa', 'Sản phẩm chăm sóc nhà cửa', NULL),
(89, 'Túi vải bảo vệ môi trường', 'Túi vải thân thiện môi trường', NULL),
(90, 'Combo chăm sóc da', 'Combo chăm sóc da', NULL),
(91, 'Combo chăm sóc tóc', 'Combo chăm sóc tóc', NULL),
(92, 'Combo chăm sóc môi', 'Combo chăm sóc môi', NULL),
(93, 'Combo khác', 'Combo khác', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE `donhang` (
  `MaDH` int NOT NULL,
  `MaTK` int NOT NULL,
  `MaGG` int DEFAULT NULL,
  `HoTen` varchar(50) NOT NULL,
  `DiaChi` varchar(50) NOT NULL,
  `SoDienThoai` int NOT NULL,
  `TongTien` int NOT NULL,
  `TrangThai` varchar(50) DEFAULT 'Chờ xác nhận',
  `NgayDangKy` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MaPay` int NOT NULL,
  `GhiChu` text NOT NULL,
  `NgayDat` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DiaChiGiao` text,
  `PhuongThucThanhToan` varchar(50) DEFAULT 'Tiền mặt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donhangchitiet`
--

CREATE TABLE `donhangchitiet` (
  `MaCT` int NOT NULL,
  `MaDH` int NOT NULL,
  `MaSP` int NOT NULL,
  `Gia` varchar(50) NOT NULL,
  `SoLuong` int NOT NULL,
  `DonGia` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phuongthucthanhtoan`
--

CREATE TABLE `phuongthucthanhtoan` (
  `MaPay` int NOT NULL,
  `Ten` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` int NOT NULL,
  `TenSanPham` varchar(100) NOT NULL,
  `HinhAnh` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `DonGia` int NOT NULL,
  `NgayNhap` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GiaSale` int DEFAULT NULL,
  `MoTa` varchar(255) NOT NULL,
  `MaDM` int NOT NULL,
  `TrangThai` tinyint NOT NULL DEFAULT '0',
  `NoiBat` tinyint NOT NULL DEFAULT '0',
  `SoLuong` int NOT NULL,
  `Gia` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSanPham`, `HinhAnh`, `DonGia`, `NgayNhap`, `GiaSale`, `MoTa`, `MaDM`, `TrangThai`, `NoiBat`, `SoLuong`, `Gia`) VALUES
(1, 'Sữa Chống Nắng Sơ-ri Vitamin C Sáng Hồng SPF 50+ PA++++', 'https://media.comem.vn/uploads/2025/04/Frame_11256_sp2x.webp', 395000, '2025-07-31 23:15:59', NULL, 'Sữa chống nắng Sơ-ri Vitamin C Sáng Hồng SPF 50+ Natural Brightening Sunscreen là sản phẩm dạng sữa mỏng nhẹ. ', 48, 0, 1, 10, 10010024.00),
(2, 'Sữa Chống Nắng Rau Má Kiềm Dầu SPF 50+ PA++++', 'https://media.comem.vn/uploads/2025/04/Frame_11255_sp.webp', 395000, '2025-07-31 23:17:36', NULL, 'Sữa chống nắng Rau Má là sản phẩm chống nắng mới nằm trong bộ chăm sóc da Rau Má của nhà Cỏ.', 48, 0, 1, 10, 1957916.00),
(5, 'Bột uống Collagen - HA giúp Duy Trì Làn Da Săn Chắc, Trẻ Trung', 'https://media.comem.vn/uploads/2025/03/Frame_11249_sp2x.webp', 395000, '2025-07-31 23:28:21', NULL, '', 48, 0, 0, 10, 8759509.00),
(6, 'Kem Trang Điểm Thuỷ Tinh 3in1 Tích Hợp Phấn Má Phấn Mắt Son Môi', 'https://media.comem.vn/uploads/2024/12/Frame_1104_sp2x.webp', 140000, '2025-07-31 23:29:06', NULL, '', 48, 0, 0, 10, 6923797.00),
(7, 'Bột Uống Dâu Tằm - Biotin Ngừa Rụng Tóc', 'https://media.comem.vn/uploads/2025/03/Frame_11250_sp2x.webp', 320000, '2025-07-31 23:37:12', NULL, '', 48, 0, 0, 10, 7340457.00),
(8, 'Bột Uống Sơ-ri & Astaxanthin Giúp Sáng Da, Ngừa Đốm Nâu', 'https://media.comem.vn/uploads/2025/03/Frame_11248_sp2x.webp', 395000, '2025-07-31 23:37:46', NULL, '', 48, 0, 0, 10, 4930897.00),
(9, 'Cushion Phấn Nước Che Khuyết Điểm Trang Điểm Nền Mỏng Mịn Thủy Tinh', 'https://media.comem.vn/uploads/2024/12/Frame_1103_sp2x.webp', 290000, '2025-07-31 23:38:41', NULL, '', 48, 0, 0, 10, 1633114.00),
(10, 'Son Kem Bóng Thuỷ Tinh Môi Căng Mọng Mềm Mịn', 'https://media.comem.vn/uploads/2024/09/Frame_1063_sp2x.webp', 185000, '2025-07-31 23:39:22', NULL, '', 48, 0, 0, 10, 2372880.00),
(11, 'Sữa rửa mặt tạo bọt Tơ Tằm', 'https://media.comem.vn/uploads/2025/04/sua-rua-mat-tao-bot-to-tam_sp2x.webp', 95000, '2025-07-31 23:40:39', 96000, '', 49, 0, 0, 10, 5965058.00),
(12, 'Serum Tơ Tằm Cấp Ẩm Đa Tầng', 'https://media.comem.vn/uploads/2025/02/Frame_11226_sp2x.webp', 245000, '2025-07-31 23:42:53', NULL, '', 49, 0, 0, 10, 1706650.00),
(13, 'Kem Dưỡng Ẩm Tơ Tằm Cấp ẩm Đa Tầng', 'https://media.comem.vn/uploads/2025/02/Frame_11227_sp2x.webp', 315000, '2025-07-31 23:43:49', NULL, '', 49, 0, 0, 10, 9638076.00),
(14, 'Sữa Rửa Mặt Rau Má Tạo Bọt', 'https://media.comem.vn/uploads/November2022/bot-rua-mat-rau-ma-cho-da-dau_sp2x.webp', 120000, '2025-07-31 23:44:54', 121000, '', 49, 0, 0, 10, 2070434.00),
(15, 'Kem Chống Nắng Hây Hây', 'https://media.comem.vn/uploads/2025/06/kem-chong-nang-hay-hay-da-dau-mun_sp2x.webp', 260000, '2025-07-31 23:45:47', NULL, '', 49, 0, 0, 10, 10437940.00),
(16, 'Cushion Phấn Nước Che Khuyết Điểm Trang Điểm Nền Mỏng Mịn Thủy Tinh', 'https://media.comem.vn/uploads/2024/12/Frame_1103_sp2x.webp', 290000, '2025-07-31 23:46:53', NULL, '', 49, 0, 0, 10, 4978401.00),
(17, 'Kem Dưỡng Ẩm Sâm 1700 Ngừa Lão Hoá Da', 'https://media.comem.vn/uploads/2024/07/kem-duong-am-sam-1700_27_sp2x.webp', 520000, '2025-07-31 23:47:31', NULL, '', 49, 0, 0, 10, 2578187.00),
(18, 'Kem Chống Nắng Vật Lý Tone-up SPF 50+', 'https://media.comem.vn/uploads/2025/06/kem-chong-nang-vat-ly_sp2x.webp', 350000, '2025-07-31 23:48:06', NULL, '', 49, 0, 0, 10, 6955731.00),
(19, 'Sữa rửa mặt tạo bọt Tơ Tằm', 'https://media.comem.vn/uploads/2025/04/sua-rua-mat-tao-bot-to-tam_sp2x.webp', 95000, '2025-07-31 23:50:09', 96000, '', 50, 0, 0, 10, 6044096.00),
(20, 'Kem Dưỡng Ẩm Tơ Tằm Cấp ẩm Đa Tầng', 'https://media.comem.vn/uploads/2025/02/Frame_11227_sp2x.webp', 315000, '2025-07-31 23:51:46', NULL, '', 50, 0, 0, 10, 8353286.00),
(21, 'Kem Chống Nắng Hây Hây', 'https://media.comem.vn/uploads/2025/06/kem-chong-nang-hay-hay-da-dau-mun_sp2x.webp', 260000, '2025-07-31 23:52:17', NULL, '', 50, 0, 0, 10, 2634143.00),
(22, 'Nước tẩy trang Rau Má', 'https://media.comem.vn/uploads/2025/05/nuoc-tay-trang-rau-ma-150ml_sp2x.webp', 120000, '2025-07-31 23:54:07', NULL, '', 50, 0, 0, 10, 7110858.00),
(23, 'Serum Tơ Tằm Cấp Ẩm Đa Tầng', 'https://media.comem.vn/uploads/2025/02/Frame_11226_sp2x.webp', 245000, '2025-07-31 23:54:51', NULL, '', 50, 0, 0, 10, 6651862.00),
(24, 'Kem Dưỡng Ẩm Sâm 1700 Ngừa Lão Hoá Da', 'https://media.comem.vn/uploads/2024/07/kem-duong-am-sam-1700_27_sp2x.webp', 520000, '2025-07-31 23:55:21', NULL, '', 50, 0, 0, 10, 10926736.00),
(25, 'Active toner Tơ Tằm', 'https://media.comem.vn/uploads/2025/04/active-toner-to-tam_sp2x.webp', 190000, '2025-07-31 23:55:45', NULL, '', 50, 0, 0, 10, 3678095.00),
(26, 'Serum Sâm 1700 Ngừa Lão Hóa Da', 'https://media.comem.vn/uploads/2024/07/serum-sam-1700-ngua-lao-hoa-da_19_sp2x.webp', 580000, '2025-07-31 23:56:21', NULL, '', 50, 0, 0, 10, 4610268.00),
(27, 'Combo 3 bước làm sạch chiết xuất Rau Má cho da dầu', 'https://media.comem.vn/uploads/2025/04/Frame_11292_sp2x.webp', 460000, '2025-07-31 23:57:26', 530000, '', 51, 0, 0, 10, 1017054.00),
(28, 'Combo Kem Dưỡng Ẩm, Serum Tơ Tằm Cấp Ẩm Đa Tầng', 'https://media.comem.vn/uploads/2025/05/combo-kem-duong-am-to-tam-serum-cap-am-phuc-hoi-to-tam_sp2x.webp', 560000, '2025-07-31 23:59:16', 750000, '', 51, 0, 0, 10, 10254469.00),
(29, 'Combo Sữa rửa mặt tạo bọt Tơ Tằm + Kem dưỡng ẩm Tơ Tằm', 'https://media.comem.vn/uploads/2025/04/combo-sua-rua-mat-tao-bot-to-tam-kem-duong-am-to-tam_sp2x.webp', 410000, '2025-07-31 23:59:44', NULL, '', 51, 0, 0, 10, 7221182.00),
(30, 'Bộ chăm sóc da Sâm 1700 3 bước', 'https://media.comem.vn/uploads/2025/04/bo-cham-soc-da-sam-1700-3-buoc_sp2x.webp', 710000, '2025-08-01 00:00:25', 830000, '', 51, 0, 0, 10, 4342503.00),
(31, 'Combo Làm sạch Sâu Tơ Tằm cho da thường đến khô', 'https://media.comem.vn/uploads/2025/04/combo-lam-sach-sau-to-tam-cho-da-thuong-den-kho_sp2x.webp', 405, '2025-08-01 00:01:02', 475000, '', 51, 0, 0, 10, 9048969.00),
(32, 'Bộ Đôi Dưỡng Ẩm Sâm 1700 Ngừa Lão Hóa Da', 'https://media.comem.vn/uploads/2025/04/bo-doi-duong-am-sam-1700-ngua-lao-hoa-da_sp2x.webp', 1100000, '2025-08-01 00:01:56', 1370000, '', 51, 0, 0, 10, 1217339.00),
(33, 'Combo sáng da mờ nám chiết xuất Sơ-ri Vitamin C', 'https://media.comem.vn/uploads/2024/11/Frame_1070_sp2x.webp', 900000, '2025-08-01 00:02:33', 1150000, '', 51, 0, 0, 10, 7939788.00),
(34, 'Combo Gội xả thảo dược Tóc Mây - Tóc khỏe từ gốc, giảm gãy rụng', 'https://media.comem.vn/uploads/2025/04/bo-goi-xa-toc-may1_sp2x.webp', 570000, '2025-08-01 00:03:10', 690000, '', 51, 0, 0, 10, 5046923.00),
(35, '[SET QUÀ TẶNG] Mặt Nạ Ngủ Môi, Son Dưỡng Dành Cho Bạn Gái', 'https://media.comem.vn/uploads/2025/02/mat-na-ngu-moi-son-duong-moi-giftset_sp2x.webp', 215000, '2025-08-01 00:06:16', NULL, '', 8, 0, 0, 10, 10415253.00),
(36, '[SET QUÀ TẶNG] Bộ Combo Gồm Kem Dưỡng Da Tay Và Bọt Rửa Mặt', 'https://media.comem.vn/uploads/2025/02/bo-combo-gom-kem-duong-da-tay-va-bot-rua-mat-giftset_sp2x.webp', 220000, '2025-08-01 00:06:47', NULL, '', 8, 0, 0, 10, 5935498.00),
(37, '[SET QUÀ TẶNG] Bộ Sản Phẩm Gội Xả Thảo Dược Tóc Mây- Tóc Chắc Khỏe Giảm Gãy Rụng', 'https://media.comem.vn/uploads/2025/02/bo-goi-xa-toc-may-giftset_sp2x.webp', 570000, '2025-08-01 00:07:24', 690000, '', 8, 0, 0, 10, 7431729.00),
(38, '[SET QUÀ TẶNG] Combo 3 Màu Son Kem Nhung - Lì Mượt', 'https://media.comem.vn/uploads/2025/02/combo_3_son_kem_nhung0.3x_sp2x.webp', 555000, '2025-08-01 00:08:02', 675000, '', 8, 0, 0, 10, 8352152.00),
(39, '[SET QUÀ TẶNG] Sữa Rửa Mặt+ Toner Chiết Xuất Sơ-ri Vitamin C', 'https://media.comem.vn/uploads/2025/02/set-qua-tang-sua-rua-mat-toner-chiet-xuat-so-ri-vitamin-c-giftset_sp2x.webp', 430000, '2025-08-01 00:08:30', NULL, '', 8, 0, 0, 10, 8465574.00),
(40, '[SET QUÀ TẶNG] Kem Dưỡng Da Tay Trà Đào + Xịt Thơm Body Mist Colors', 'https://media.comem.vn/uploads/2025/02/bodymist__kem_tay_tra_dao0.3x_sp2x.webp', 335000, '2025-08-01 00:09:00', NULL, '', 8, 0, 0, 10, 6271415.00),
(41, '[SET QUÀ TẶNG] Bộ Sản Phẩm Chăm Sóc Tóc Toàn Diện Tóc Mây', 'https://media.comem.vn/uploads/2025/02/bo-cham-soc-toc-toc-may-cao-cap-giftset_sp2x.webp', 810000, '2025-08-01 00:09:41', 1050000, '', 8, 0, 0, 10, 4960352.00),
(42, '[SET QUÀ TẶNG] Bộ Đôi Môi Xinh Trang Điểm Môi Tự Nhiên Cỏ Mềm', 'https://media.comem.vn/uploads/2025/02/combo-moi-xinh-giftset_sp2x.webp', 288000, '2025-08-01 00:10:16', 408000, '', 8, 0, 0, 10, 4987519.00),
(43, 'Son Kem Bóng Thuỷ Tinh Môi Căng Mọng Mềm Mịn', 'https://media.comem.vn/uploads/2024/09/Frame_1063_sp2x.webp', 185000, '2025-08-01 00:11:49', NULL, '', 52, 0, 0, 10, 9056537.00),
(44, 'Kem Trang Điểm Thuỷ Tinh 3in1 Tích Hợp Phấn Má Phấn Mắt Son Môi', 'https://media.comem.vn/uploads/2024/12/Frame_1104_sp2x.webp', 140000, '2025-08-01 00:12:19', NULL, '', 52, 0, 0, 10, 9320128.00),
(45, 'Son Nhiên - Dưỡng Mọng Tự Nhiên', 'https://media.comem.vn/uploads/September2023/son-nhien-duong-mong-tu-nhien-1_sp2x.webp', 180000, '2025-08-01 00:12:54', NULL, '', 52, 0, 0, 10, 8431030.00),
(46, 'Son Dưỡng Gạo - 3 Lựa Chọn Hồng/ Cam/ Không Màu', 'https://media.comem.vn/uploads/2024/10/Group_445_sp2x.webp', 90000, '2025-08-01 00:13:24', NULL, '', 52, 0, 0, 10, 3194769.00),
(47, 'Son Lụa Diễm', 'https://media.comem.vn/uploads/December2022/son-lua-diem_sp2x.webp', 198000, '2025-08-01 00:14:00', NULL, '', 52, 0, 0, 10, 9680754.00),
(48, 'Son dưỡng Môi Hồng', 'https://media.comem.vn/uploads/March2023/son-duong-moi-hong-co-mem_sp2x.webp', 120000, '2025-08-01 00:14:52', NULL, '', 52, 0, 0, 10, 7819465.00),
(49, 'Son Nhã - Sắc Màu Thanh Nhã', 'https://media.comem.vn/uploads/September2023/son-nha-sac-mau-thanh-nha-1_sp2x.webp', 330000, '2025-08-01 00:15:24', NULL, '', 52, 0, 0, 10, 9055063.00),
(50, 'Son Lụa Búp bê', 'https://media.comem.vn/uploads/November2022/son-bup-be-cho-be-gai_sp2x.webp', 160000, '2025-08-01 00:16:02', NULL, '', 52, 0, 0, 10, 10816921.00),
(51, 'Combo Kem Dưỡng Ẩm, Serum Tơ Tằm Cấp Ẩm Đa Tầng', 'https://media.comem.vn/uploads/2025/05/combo-kem-duong-am-to-tam-serum-cap-am-phuc-hoi-to-tam_sp2x.webp', 560000, '2025-08-01 00:17:11', 750000, '', 12, 0, 0, 10, 5919415.00),
(52, 'Combo Sữa rửa mặt tạo bọt Tơ Tằm + Kem dưỡng ẩm Tơ Tằm', 'https://media.comem.vn/uploads/2025/04/combo-sua-rua-mat-tao-bot-to-tam-kem-duong-am-to-tam_sp2x.webp', 410000, '2025-08-01 00:18:54', NULL, '', 12, 0, 0, 10, 6146315.00),
(53, 'Combo sáng da mờ nám chiết xuất Sơ-ri Vitamin C', 'https://media.comem.vn/uploads/2024/11/Frame_1070_sp2x.webp', 900000, '2025-08-01 00:19:42', 1150000, '', 12, 0, 0, 10, 1973332.00),
(54, 'Bộ Chăm sóc da Tơ Tằm - dưỡng ẩm, ngừa lão hoá chuyên sâu 3 bước', 'https://media.comem.vn/uploads/2025/05/bo-cham-soc-da-to-tam-chuan_sp2x.webp', 600000, '2025-08-01 00:20:15', 670000, '', 12, 0, 0, 10, 10427714.00),
(55, 'Combo Dưỡng Da Tơ Tằm & Kem Chống Nắng Hây Hây', 'https://media.comem.vn/uploads/2025/06/combo-cham-soc-da-ban-ngay-da-dau-mun_sp2x.webp', 860000, '2025-08-01 00:20:52', 980000, '', 12, 0, 0, 10, 5218575.00),
(56, 'Combo 4 Mặt Nạ Sâm 1700 Ngừa Lão Hoá', 'https://media.comem.vn/uploads/2024/05/mat-na-sam-1700-ngua-lao-hoa-4_29_sp2x.webp', 100000, '2025-08-01 00:21:31', 200000, '', 12, 0, 0, 10, 3809735.00),
(57, 'Combo Rửa mặt sạch sâu - Double Cleansing từ thiên nhiên', 'https://media.comem.vn/uploads/May2023/combo-rua-mat-sach-sau_sp2x.webp', 260000, '2025-08-01 00:21:57', NULL, '', 12, 0, 0, 10, 2392949.00),
(58, 'Combo Rửa mặt sạch sâu - Double Cleansing từ thiên nhiên', 'https://media.comem.vn/uploads/May2023/combo-rua-mat-sach-sau_sp2x.webp', 300000, '2025-08-01 00:22:28', NULL, '', 12, 0, 0, 10, 9535543.00),
(59, 'Combo Gội xả thảo dược Tóc Mây - Tóc khỏe từ gốc, giảm gãy rụng', 'https://media.comem.vn/uploads/2025/04/bo-goi-xa-toc-may1_sp2x.webp', 570000, '2025-08-01 00:23:40', 690000, '', 13, 0, 0, 10, 9498867.00),
(60, 'Combo Gội Xả Ủ Suôn Mượt Phục Hồi Trái Bơ', 'https://media.comem.vn/uploads/2025/04/bo-cham-soc-toc-trai-bo-suon-muot-phuc-hoi_sp2x.webp', 515000, '2025-08-01 00:24:22', 640000, '', 13, 0, 0, 10, 7887709.00),
(61, 'Combo Chăm sóc tóc toàn diện Tóc Mây - Tóc chắc khỏe, giảm rụng ngay', 'https://media.comem.vn/uploads/2025/04/bo-cham-soc-toc-toc-may-cao-cap_sp2x.webp', 810000, '2025-08-01 00:25:03', 1050000, '', 13, 0, 0, 10, 9941943.00),
(62, 'Combo dưỡng Hồng Môi (Lipscrub Môi Hồng + Son dưỡng Môi Hồng)', 'https://media.comem.vn/uploads/2024/12/Frame_1110_sp2x.webp', 240000, '2025-08-01 00:25:48', 330000, '', 14, 0, 0, 10, 5046588.00),
(63, 'Combo Son Nhã Và Son dưỡng Nhiên', 'https://media.comem.vn/uploads/2024/12/Frame_1093_sp2x.webp', 510000, '2025-08-01 00:26:23', 600000, '', 14, 0, 0, 10, 4407111.00),
(64, 'Combo Sữa tắm dưỡng thể Hoa bưởi - Sáng da', 'https://media.comem.vn/uploads/2024/12/Frame_11061_sp2x.webp', 360000, '2025-08-01 00:27:18', 480000, '', 15, 0, 0, 10, 5895792.00),
(66, 'Bột Uống Sơ-ri Vitamin C', 'https://media.comem.vn/uploads/2025/01/Frame_11220_sp2x.webp', 120000, '2025-08-01 00:31:45', NULL, '', 15, 0, 0, 10, 5257630.00),
(67, 'Đá Thơm Thiên Nhiên Giúp Khử Mùi Làm Thơm Phòng', 'https://media.comem.vn/uploads/2024/12/Frame_1114_sp2x.webp', 120000, '2025-08-01 00:32:19', NULL, '', 15, 0, 0, 10, 7600773.00),
(68, '[SET QUÀ TẶNG] Combo Tất niên (Xà bông hạt mùi + tinh dầu hạt mùi)', 'https://media.comem.vn/uploads/February2022/XB_mui_gia_6_sp2x.webp', 430000, '2025-08-01 00:32:56', NULL, '', 15, 0, 0, 10, 1230975.00),
(69, 'Son Nhiên - Dưỡng Mọng Tự Nhiên', 'https://media.comem.vn/uploads/September2023/son-nhien-duong-mong-tu-nhien-1_sp2x.webp', 180000, '2025-08-01 00:37:38', NULL, '', 17, 0, 0, 10, 2352559.00),
(70, 'Son Dưỡng Gạo - 3 Lựa Chọn Hồng/ Cam/ Không Màu', 'https://media.comem.vn/uploads/2024/10/Group_445_sp2x.webp', 90000, '2025-08-01 00:38:10', NULL, '', 17, 0, 0, 10, 7069868.00),
(71, 'Son Dưỡng Gạo - 3 Lựa Chọn Hồng/ Cam/ Không Màu', 'https://media.comem.vn/uploads/2024/10/Group_445_sp2x.webp', 90000, '2025-08-01 00:38:41', NULL, '', 17, 0, 0, 10, 7291667.00),
(72, 'Son Dưỡng Gạo - 3 Lựa Chọn Hồng/ Cam/ Không Màu', 'https://media.comem.vn/uploads/2024/10/Group_446_sp2x.webp', 90000, '2025-08-01 00:39:11', NULL, '', 17, 0, 0, 10, 4248730.00),
(73, 'Son Dưỡng Gạo - 3 Lựa Chọn Hồng/ Cam/ Không Màu', 'https://media.comem.vn/uploads/2024/10/Group_447_sp2x.webp', 90000, '2025-08-01 00:39:37', NULL, '', 17, 0, 0, 10, 8368649.00),
(74, 'Son dưỡng Môi Hồng', 'https://media.comem.vn/uploads/March2023/son-duong-moi-hong-co-mem_sp2x.webp', 120000, '2025-08-01 00:40:03', NULL, '', 17, 0, 0, 10, 8097059.00),
(75, 'Combo dưỡng Hồng Môi (Lipscrub Môi Hồng + Son dưỡng Môi Hồng)', 'https://media.comem.vn/uploads/2024/12/Frame_1110_sp2x.webp', 240000, '2025-08-01 00:40:34', 330000, '', 17, 0, 0, 10, 4379345.00),
(76, 'Mặt nạ ngủ môi Môi Hồng', 'https://media.comem.vn/uploads/2024/07/Frame_1041_sp2x.webp', 125000, '2025-08-01 00:41:06', NULL, '', 17, 0, 0, 10, 6605551.00),
(77, 'Combo chăm sóc môi 3 bước', 'https://media.comem.vn/uploads/2025/05/combo-cham-soc-moi-3-buoc_sp2x.webp', 245000, '2025-08-01 00:41:41', 365000, '', 17, 0, 0, 10, 8889722.00),
(78, 'Son Lụa Diễm', 'https://media.comem.vn/uploads/December2022/son-lua-diem_sp2x.webp', 198000, '2025-08-01 00:43:23', NULL, '', 18, 0, 0, 10, 3631956.00),
(79, 'Son Kem Bóng Thuỷ Tinh Môi Căng Mọng Mềm Mịn', 'https://media.comem.vn/uploads/2024/09/Frame_1063_sp2x.webp', 185000, '2025-08-01 00:44:13', NULL, '', 18, 0, 0, 10, 10490615.00),
(80, 'Son Kem Nhung Lì Mượt Không Silicone Bản Nâng Cấp', 'https://media.comem.vn/uploads/2024/09/Frame_1062_(1)_sp2x.webp', 185000, '2025-08-01 00:44:52', NULL, '', 18, 0, 0, 10, 10557210.00),
(81, 'Son Nhã - Sắc Màu Thanh Nhã', 'https://media.comem.vn/uploads/September2023/son-nha-sac-mau-thanh-nha-1_sp2x.webp', 330000, '2025-08-01 00:45:43', NULL, '', 18, 0, 0, 10, 10314203.00),
(82, 'Combo Son Lụa Diễm và Son Dưỡng Môi', 'https://media.comem.vn/uploads/2025/02/Frame_11225_sp2x.webp', 288000, '2025-08-01 00:46:21', 378000, '', 18, 0, 0, 10, 8899388.00),
(83, 'Combo Son Lụa Diễm + Son Dưỡng Môi Hồng', 'https://media.comem.vn/uploads/2024/12/Frame_1072_sp2x.webp', 318000, '2025-08-01 00:46:58', 408000, '', 18, 0, 0, 10, 2554332.00),
(84, 'Combo Trang Điểm Son Lụa Diễm Mềm Mịn Và Phấn Nước Thuỷ Tinh', 'https://media.comem.vn/uploads/2024/12/Frame_11107_sp2x.webp', 488000, '2025-08-01 00:47:42', 628000, '', 18, 0, 0, 10, 5073496.00),
(85, 'Lip Scrub Môi Hồng', 'https://media.comem.vn/uploads/2024/09/Ava_web_-_KM_2_tang_1_(2)_sp2x.webp', 120000, '2025-08-01 00:50:38', NULL, '', 19, 0, 0, 10, 6704485.00),
(86, 'Combo dưỡng Hồng Môi (Lipscrub Môi Hồng + Son dưỡng Môi Hồng)', 'https://media.comem.vn/uploads/2024/12/Frame_1110_sp2x.webp', 240000, '2025-08-01 00:51:14', 330000, '', 19, 0, 0, 10, 7301939.00),
(87, 'Mặt nạ ngủ môi Môi Hồng', 'https://media.comem.vn/uploads/2024/07/Frame_1041_sp2x.webp', 125000, '2025-08-01 00:51:42', NULL, '', 19, 0, 0, 10, 5396241.00),
(88, 'Combo chăm sóc môi 3 bước', 'https://media.comem.vn/uploads/2025/05/combo-cham-soc-moi-3-buoc_sp2x.webp', 245000, '2025-08-01 00:52:17', 365000, '', 19, 0, 0, 10, 4075388.00),
(89, 'Combo 2 Sản Phẩm Giảm Thâm Dưỡng Mềm Môi Căng Mịn', 'https://media.comem.vn/uploads/2024/12/Frame_1111_sp2x.webp', 245000, '2025-08-01 00:52:54', 335000, '', 19, 0, 0, 10, 3188217.00),
(90, 'Cushion Phấn Nước Che Khuyết Điểm Trang Điểm Nền Mỏng Mịn Thủy Tinh', 'https://media.comem.vn/uploads/2024/12/Frame_1103_sp2x.webp', 290000, '2025-08-01 00:55:11', NULL, '', 20, 0, 0, 10, 2714921.00),
(91, 'Kem Trang Điểm Thuỷ Tinh 3in1 Tích Hợp Phấn Má Phấn Mắt Son Môi', 'https://media.comem.vn/uploads/2024/12/Frame_1104_sp2x.webp', 140000, '2025-08-01 00:55:41', NULL, '', 20, 0, 0, 10, 3009955.00),
(92, 'Bộ Đôi Trang Điểm Tự Nhiên Cushion Phấn Nước & Kem Trang Điểm Thủy Tinh', 'https://media.comem.vn/uploads/2025/01/Frame_1108_sp2x.webp', 430000, '2025-08-01 00:56:17', 520000, '', 20, 0, 0, 10, 5905012.00),
(93, 'Combo Trang Điểm Son Lụa Diễm Mềm Mịn Và Phấn Nước Thuỷ Tinh', 'https://media.comem.vn/uploads/2024/12/Frame_11107_sp2x.webp', 488000, '2025-08-01 00:56:51', 628000, '', 20, 0, 0, 10, 9495198.00),
(94, 'Trọn Bộ Combo Makeup Trang Điểm Son Kem, Phấn Nước Thuỷ Tinh', 'https://media.comem.vn/uploads/2024/12/Frame_13115_sp2x.webp', 475000, '2025-08-01 00:57:35', 565000, '', 20, 0, 0, 10, 8760953.00),
(95, 'Kem nền Hây Hây - Trang điểm tối giản đẹp xinh', 'https://media.comem.vn/uploads/December2022/kem-nen-mau-sang_sp2x.webp', 210000, '2025-08-01 00:58:05', NULL, '', 20, 0, 0, 10, 4319174.00),
(96, 'Cushion Phấn Nước Che Khuyết Điểm Trang Điểm Nền Mỏng Mịn Thủy Tinh', 'https://media.comem.vn/uploads/2024/12/Frame_1103_sp2x.webp', 290000, '2025-08-01 00:58:43', NULL, '', 21, 0, 0, 10, 4313010.00),
(97, 'Kem Trang Điểm Thuỷ Tinh 3in1 Tích Hợp Phấn Má Phấn Mắt Son Môi', 'https://media.comem.vn/uploads/2024/12/Frame_1104_sp2x.webp', 140000, '2025-08-01 00:59:15', NULL, '', 21, 0, 0, 10, 7607529.00),
(98, 'Kem má hồng Hây Hây', 'https://media.comem.vn/uploads/April2023/kem-ma-hong-hay-hay-qua-dao_sp2x.webp', 140000, '2025-08-01 00:59:59', NULL, '', 21, 0, 0, 10, 4098617.00),
(99, 'Kem má hồng Hây Hây', 'https://media.comem.vn/uploads/April2023/kem-ma-hong-hay-hay-qua-hong_sp2x.webp', 140000, '2025-08-01 01:00:49', NULL, '', 21, 0, 0, 10, 6670498.00),
(100, 'Dầu rửa mặt 3S - Cho da sạch, sáng, se', 'https://media.comem.vn/uploads/March2023/dau-rua-mat-3s_sp2x.webp', 170000, '2025-08-02 21:49:06', NULL, '', 22, 0, 0, 10, 10056640.00),
(101, 'Bột rửa mặt Taptap', 'https://media.comem.vn/uploads/2024/07/Frame_1034_sp2x.webp', 90000, '2025-08-02 21:49:58', NULL, '', 22, 0, 0, 10, 9271708.00),
(102, 'Xà bông thiên nhiên Gấc Nghệ', 'https://media.comem.vn/uploads/December2022/xa-bong-thien-nhien-gac-nghe_sp2x.webp', 130000, '2025-08-02 21:51:52', NULL, '', 22, 0, 0, 10, 5188619.00),
(103, 'Combo Rửa mặt sạch sâu - Double Cleansing từ thiên nhiên', 'https://media.comem.vn/uploads/May2023/combo-rua-mat-sach-sau_sp2x.webp', 260000, '2025-08-02 21:52:30', NULL, '', 22, 0, 0, 10, 7127972.00),
(104, 'Combo Dưỡng Da Tơ Tằm & Kem Chống Nắng Hây Hây', 'https://media.comem.vn/uploads/2025/06/combo-cham-soc-da-ban-ngay-da-dau-mun_sp2x.webp', 860000, '2025-08-02 21:53:11', 980000, '', 22, 0, 0, 10, 9074002.00),
(105, 'Bộ Chăm sóc da Tơ Tằm - dưỡng ẩm, ngừa lão hoá chuyên sâu 3 bước', 'https://media.comem.vn/uploads/2025/05/bo-cham-soc-da-to-tam-chuan_sp2x.webp', 600000, '2025-08-02 21:53:48', 670000, '', 22, 0, 0, 10, 2986097.00),
(106, 'Sữa rửa mặt Tạo bọt Sơ-ri Vitamin C', 'https://media.comem.vn/uploads/2024/09/ava_SRM_C_sp2x.webp', 180000, '2025-08-02 21:54:18', NULL, '', 22, 0, 0, 10, 6708479.00),
(107, 'Nước tẩy trang Tơ Tằm', 'https://media.comem.vn/uploads/2025/05/nuoc-tay-trang-to-tam-danh-cho-da-thuong-den-kho-350ml_sp2x.webp', 250000, '2025-08-02 21:54:47', NULL, '', 22, 0, 0, 10, 3584105.00),
(108, 'Active toner Tơ Tằm', 'https://media.comem.vn/uploads/2025/04/active-toner-to-tam_sp2x.webp', 190000, '2025-08-02 21:57:35', NULL, '', 23, 0, 0, 10, 6795088.00),
(109, 'Toner sáng da mờ nám Sơ-ri Vitamin C', 'https://media.comem.vn/uploads/2024/09/Toner_C_sp2x.webp', 250000, '2025-08-02 21:58:02', NULL, '', 23, 0, 0, 10, 2223126.00),
(110, 'Bộ Chăm sóc da Tơ Tằm - dưỡng ẩm, ngừa lão hoá chuyên sâu 3 bước', 'https://media.comem.vn/uploads/2025/05/bo-cham-soc-da-to-tam-chuan_sp2x.webp', 600000, '2025-08-02 21:58:39', 670000, '', 23, 0, 0, 10, 9730368.00),
(111, 'Combo Dưỡng Da Tơ Tằm & Kem Chống Nắng Hây Hây', 'https://media.comem.vn/uploads/2025/06/combo-cham-soc-da-ban-ngay-da-dau-mun_sp2x.webp', 860000, '2025-08-02 21:59:08', 980000, '', 23, 0, 0, 10, 10982464.00),
(112, 'Toner Rau Má', 'https://media.comem.vn/uploads/November2022/toner-rau-ma-ch-da-dau-mun_sp2x.webp', 220000, '2025-08-02 21:59:32', NULL, '', 23, 0, 0, 10, 4721214.00),
(113, 'Combo Chăm Sóc Da Ban Đêm Từ Tẩy Trang Đến Dưỡng Ẩm', 'https://media.comem.vn/uploads/2025/04/combo-cham-soc-da-ban-dem_sp2x.webp', 770000, '2025-08-02 22:01:01', 840000, '', 23, 0, 0, 10, 9658681.00),
(114, 'Xịt Khoáng Hoa Hồng', 'https://media.comem.vn/uploads/2024/07/Frame_1037_sp2x.webp', 165000, '2025-08-02 22:01:33', NULL, '', 23, 0, 0, 10, 3129765.00),
(115, 'Toner Sâm 1700 Ngừa Lão Hóa Da', 'https://media.comem.vn/uploads/2024/07/toner-sam-1700-ngua-lao-hoa-da_42_sp2x.webp', 270000, '2025-08-02 22:02:04', NULL, '', 23, 0, 0, 10, 5672781.00),
(116, 'Serum Tơ Tằm Cấp Ẩm Đa Tầng', 'https://media.comem.vn/uploads/2025/02/Frame_11226_sp2x.webp', 245000, '2025-08-02 22:04:31', NULL, '', 24, 0, 0, 10, 7974611.00),
(117, 'Combo Kem Dưỡng Ẩm, Serum Tơ Tằm Cấp Ẩm Đa Tầng', 'https://media.comem.vn/uploads/2025/05/combo-kem-duong-am-to-tam-serum-cap-am-phuc-hoi-to-tam_sp2x.webp', 560000, '2025-08-02 22:05:09', 750000, '', 24, 0, 0, 10, 1854711.00),
(118, 'Kem Dưỡng Ẩm Tơ Tằm Cấp ẩm Đa Tầng', 'https://media.comem.vn/uploads/2025/02/Frame_11227_sp2x.webp', 315000, '2025-08-02 22:05:45', NULL, '', 24, 0, 0, 10, 4349723.00),
(119, 'Combo Sữa rửa mặt tạo bọt Tơ Tằm + Kem dưỡng ẩm Tơ Tằm', 'https://media.comem.vn/uploads/2025/04/combo-sua-rua-mat-tao-bot-to-tam-kem-duong-am-to-tam_sp2x.webp', 410000, '2025-08-02 22:06:11', NULL, '', 24, 0, 0, 10, 5184485.00),
(120, 'Kem dưỡng ẩm kiềm dầu Rau má dành cho da dầu mụn', 'https://media.comem.vn/uploads/November2022/kem-duong-rau-ma-cho-da-dau-mun_sp2x.webp', 325000, '2025-08-02 22:06:44', NULL, '', 24, 0, 0, 10, 1873255.00),
(121, 'Kem Dưỡng Ẩm Sâm 1700 Ngừa Lão Hoá Da', 'https://media.comem.vn/uploads/2024/07/kem-duong-am-sam-1700_27_sp2x.webp', 520000, '2025-08-02 22:07:13', NULL, '', 24, 0, 0, 10, 2812823.00),
(122, 'Bộ Đôi Dưỡng Ẩm Sâm 1700 Ngừa Lão Hóa Da', 'https://media.comem.vn/uploads/2025/04/bo-doi-duong-am-sam-1700-ngua-lao-hoa-da_sp2x.webp', 1100000, '2025-08-02 22:07:53', 1370000, '', 24, 0, 0, 10, 7444348.00),
(123, 'Combo sáng da mờ nám chiết xuất Sơ-ri Vitamin C', 'https://media.comem.vn/uploads/2024/11/Frame_1070_sp2x.webp', 900000, '2025-08-02 22:08:33', 1150000, '', 24, 0, 0, 10, 7783275.00),
(124, 'Sữa Chống Nắng Rau Má Kiềm Dầu SPF 50+ PA++++', 'https://media.comem.vn/uploads/2025/04/Frame_11255_sp2x.webp', 395000, '2025-08-02 22:12:16', NULL, '', 25, 0, 0, 10, 5583328.00),
(125, 'Sữa Chống Nắng Sơ-ri Vitamin C Sáng Hồng SPF 50+ PA++++', 'https://media.comem.vn/uploads/2025/04/Frame_11256_sp2x.webp', 395000, '2025-08-02 22:12:56', NULL, '', 25, 0, 0, 10, 3566819.00),
(126, 'Kem Chống Nắng Vật Lý Tone-up SPF 50+', 'https://media.comem.vn/uploads/2025/06/kem-chong-nang-vat-ly_sp2x.webp', 350000, '2025-08-02 22:13:31', NULL, '', 25, 0, 0, 10, 10084110.00),
(127, 'Kem Chống Nắng Sâm 1700 S', 'https://media.comem.vn/uploads/2025/04/Frame_11256_sp2x.webp', 395000, '2025-08-02 22:13:59', NULL, '', 25, 0, 0, 10, 8720094.00),
(128, 'Kem Chống Nắng Sâm 1700 SPF 50+', 'https://media.comem.vn/uploads/2025/06/kem-chong-nang-sam-1700-chong-lao-hoa-cao-cap-da-dau-mun_sp2x.webp', 395000, '2025-08-02 22:14:40', NULL, '', 25, 0, 0, 10, 2348141.00),
(129, 'Kem Chống Nắng Hây Hây', 'https://media.comem.vn/uploads/2025/06/kem-chong-nang-hay-hay-da-dau-mun_sp2x.webp', 260000, '2025-08-02 22:15:08', NULL, '', 25, 0, 0, 10, 4580423.00),
(131, 'Kem chống nắng toàn thân Trái Bơ', 'https://media.comem.vn/uploads/2024/04/kem-chong-nang-toan-than-trai-bo_15_sp2x.webp', 425000, '2025-08-02 22:15:58', NULL, '', 25, 0, 0, 10, 4857692.00),
(132, 'Dầu Gội Dâu Tằm Ngừa Rụng Tóc', 'https://media.comem.vn/uploads/2024/08/srm_tram_tra_sp2x.webp', 270000, '2025-08-02 22:22:43', NULL, '', 26, 0, 0, 10, 9547194.00),
(133, 'Dầu Gội Trái Bơ Suôn Mượt Phục Hồi', 'https://media.comem.vn/uploads/2024/07/srm_tram_tra_(11)_sp2x.webp', 270000, '2025-08-02 22:23:13', NULL, '', 26, 0, 0, 10, 2162894.00),
(134, 'Combo Gội xả thảo dược Tóc Mây - Tóc khỏe từ gốc, giảm gãy rụng', 'https://media.comem.vn/uploads/2025/04/bo-goi-xa-toc-may1_sp2x.webp', 570000, '2025-08-02 22:23:44', NULL, '', 26, 0, 0, 10, 1172888.00),
(135, 'Combo Gội Xả Ủ Suôn Mượt Phục Hồi Trái Bơ', 'https://media.comem.vn/uploads/2025/04/bo-cham-soc-toc-trai-bo-suon-muot-phuc-hoi_sp2x.webp', 515000, '2025-08-02 22:24:19', NULL, '', 26, 0, 0, 10, 8375761.00),
(136, 'Bộ Chăm Sóc Tóc Ngăn Ngừa Rụng Tóc Dâu Tằm', 'https://media.comem.vn/uploads/2025/04/bo-cham-soc-toc-ngan-ngua-rung-toc-dau-tam_sp2x.webp', 970000, '2025-08-02 22:24:47', NULL, '', 26, 0, 0, 10, 7360140.00),
(137, 'Dầu gội thảo dược Tóc Mây', 'https://media.comem.vn/uploads/2024/07/srm_tram_tra_(8)_sp2x.webp', 325000, '2025-08-02 22:25:12', NULL, '', 26, 0, 0, 10, 10673417.00),
(138, 'Kem xả ủ Tóc Mây', 'https://media.comem.vn/uploads/October2023/kem-xa-u-toc-may_sp2x.webp', 245000, '2025-08-02 22:25:39', NULL, '', 26, 0, 0, 10, 10286667.00),
(139, 'Combo Chăm sóc tóc toàn diện Tóc Mây - Tóc chắc khỏe, giảm rụng ngay', 'https://media.comem.vn/uploads/2025/04/bo-cham-soc-toc-toc-may-cao-cap_sp2x.webp', 810000, '2025-08-02 22:26:03', NULL, '', 26, 0, 0, 10, 8413083.00),
(140, 'Dầu xả Dâu tằm ngừa rụng tóc', 'https://media.comem.vn/uploads/2024/08/srm_tram_tra_(1)_sp2x.webp', 245000, '2025-08-02 22:31:06', NULL, '', 27, 0, 0, 10, 10205414.00),
(141, 'Serum Dâu tằm ngừa rụng tóc', 'https://media.comem.vn/uploads/2024/08/srm_tram_tra_(2)_sp2x.webp', 455000, '2025-08-02 22:31:31', NULL, '', 27, 0, 0, 10, 4787823.00),
(142, 'Dầu Xả Trái Bơ Suôn Mượt Phục Hồi', 'https://media.comem.vn/uploads/2024/07/srm_tram_tra_sp2x.webp', 245000, '2025-08-02 22:31:59', NULL, '', 27, 0, 0, 10, 2322874.00),
(143, 'Combo Gội Xả Ủ Suôn Mượt Phục Hồi Trái Bơ', 'https://media.comem.vn/uploads/2025/04/bo-cham-soc-toc-trai-bo-suon-muot-phuc-hoi_sp2x.webp', 515000, '2025-08-02 22:32:32', NULL, '', 27, 0, 0, 10, 6250900.00),
(144, 'Combo Gội Xả Dâu Tằm Ngừa Rụng Tóc', 'https://media.comem.vn/uploads/2025/05/combo-goi-xa-dau-tam-ngua-rung-toc_sp2x.webp', 515000, '2025-08-02 22:33:02', 640000, '', 27, 0, 0, 10, 3285879.00),
(145, 'Bộ Chăm Sóc Tóc Ngăn Ngừa Rụng Tóc Dâu Tằm', 'https://media.comem.vn/uploads/2025/04/bo-cham-soc-toc-ngan-ngua-rung-toc-dau-tam_sp2x.webp', 970000, '2025-08-02 22:33:37', 1210000, '', 27, 0, 0, 10, 6676697.00),
(146, 'Serum Dưỡng Tóc Trái Bơ Suôn Mượt Phục Hồi', 'https://media.comem.vn/uploads/2025/01/Frame_11222_sp2x.webp', 295000, '2025-08-02 22:34:14', 415000, '', 27, 0, 0, 10, 2525849.00),
(147, 'Bột Uống Dâu Tằm - Biotin Ngừa Rụng Tóc', 'https://media.comem.vn/uploads/2025/03/Frame_11250_sp2x.webp', 320000, '2025-08-02 22:34:46', NULL, '', 27, 0, 0, 10, 1599153.00),
(148, 'Bột Uống Dâu Tằm - Biotin Ngừa Rụng Tóc', 'https://media.comem.vn/uploads/2025/03/Frame_11250_sp2x.webp', 320000, '2025-08-03 00:08:35', NULL, '', 28, 0, 0, 10, 9418219.00),
(149, 'Combo 3 Hộp Bột Uống Dâu Tằm - Biotin', 'https://media.comem.vn/uploads/2025/03/Frame_11245_sp2x.webp', 960000, '2025-08-03 00:09:31', NULL, '', 28, 0, 0, 10, 1293638.00),
(150, 'Bột Uống Sơ-ri & Astaxanthin Giúp Sáng Da, Ngừa Đốm Nâu', 'https://media.comem.vn/uploads/2025/03/Frame_11248_sp2x.webp', 395000, '2025-08-03 00:12:39', NULL, '', 28, 0, 0, 10, 7213531.00),
(151, 'Bột uống Collagen - HA giúp Duy Trì Làn Da Săn Chắc, Trẻ Trung', 'https://media.comem.vn/uploads/2025/03/Frame_11249_sp2x.webp', 395000, '2025-08-03 00:14:06', NULL, '', 28, 0, 0, 10, 1186746.00),
(152, 'Combo 3 Hộp Bột Uống Collagen - HA', 'https://media.comem.vn/uploads/2025/03/Frame_11244_sp2x.webp', 1185000, '2025-08-03 00:17:06', 1430000, '', 28, 0, 0, 10, 3293134.00),
(153, 'Combo 3 Hộp Bột Uống Sơ-ri & Astaxanthin', 'https://media.comem.vn/uploads/2025/03/Frame_11247_sp2x.webp', 1185000, '2025-08-03 00:36:12', 1650000, '', 28, 0, 0, 10, 1905435.00),
(154, 'Xà bông Hữu cơ (Tặng túi tạo bọt)', 'https://media.comem.vn/uploads/November2022/xa-bong-huu-co-may_sp2x.webp', 130000, '2025-08-03 01:13:18', NULL, '', 29, 0, 0, 10, 8647774.00),
(155, 'Xà bông Hữu cơ (Tặng túi tạo bọt)', 'https://media.comem.vn/uploads/January2023/xa-bong-huu-co-dem_sp2x.webp', 130000, '2025-08-03 01:13:45', NULL, '', 29, 0, 0, 10, 6522567.00),
(156, 'Sữa Tắm Sâm 1700 Hương Thơm Dịu Nhẹ', 'https://media.comem.vn/uploads/2025/02/Frame_11230_sp2x.webp', 185000, '2025-08-03 01:29:55', NULL, '', 30, 0, 0, 10, 5669514.00),
(157, 'Sữa tắm Phố Xa Brightening (Hương hoa bưởi)', 'https://media.comem.vn/uploads/2024/11/Frame_1098_sp2x.webp', 195000, '2025-08-03 01:51:06', NULL, '', 30, 0, 0, 10, 7779867.00),
(158, 'Sữa Dưỡng Thể Sâm 1700 Ngừa Lão Hoá Da', 'https://media.comem.vn/uploads/2025/02/Frame_11228_sp2x.webp', 185000, '2025-08-03 01:52:51', NULL, '', 31, 0, 0, 10, 10890797.00),
(159, 'Kem dưỡng da tay Trà Đào', 'https://media.comem.vn/uploads/2025/02/kem-duong-da-tay-mui-dao_sp2x.webp', 125000, '2025-08-03 02:08:37', NULL, '', 31, 0, 0, 10, 10114384.00),
(160, 'Combo Làm Sạch Da Body Sữa Tắm Và Tẩy Da Chết Mật Ong Cà Phê', 'https://media.comem.vn/uploads/2025/04/combo-lam-sach-da-body-sua-tam-va-tay-da-chet-mat-ong-ca-phe_sp2x.webp', 360000, '2025-08-03 02:25:21', 480000, '', 32, 0, 0, 10, 6899530.00),
(161, 'Tẩy Da Chết Body Mật Ong Cà Phê', 'https://media.comem.vn/uploads/2024/10/Frame_1065_sp2x.webp', 165000, '2025-08-03 02:25:43', NULL, '', 32, 0, 0, 10, 3154498.00),
(162, 'Combo nước súc miệng Keo Ong Bạc Hà và Cam Ngọt', 'https://media.comem.vn/uploads/2025/04/combo-nuoc-suc-mieng-keo-ong_sp2x.webp', 240000, '2025-08-03 02:27:19', 365000, '', 33, 0, 0, 10, 4073899.00),
(163, 'Combo chăm sóc răng miệng Keo Ong', 'https://media.comem.vn/uploads/2025/04/combo-cham-soc-rang-mieng-keo-ong_sp2x.webp', 200000, '2025-08-03 02:27:52', 280000, '', 33, 0, 0, 10, 9906005.00),
(164, 'Sáp Ấm Cho Bé', 'https://media.comem.vn/uploads/2024/07/Frame_1040_sp2x.webp', 90000, '2025-08-03 02:29:34', NULL, '', 35, 0, 0, 10, 6308327.00),
(165, 'Son Lụa Búp bê', 'https://media.comem.vn/uploads/November2022/son-bup-be-cho-be-gai_sp2x.webp', 160000, '2025-08-03 02:30:01', NULL, '', 35, 0, 0, 10, 10823623.00),
(166, 'Sữa tắm gội em bé Pippi Notears (Không cay mắt)', 'https://media.comem.vn/uploads/2024/09/Ava_web_-_KM_2_tang_1_(1)_sp2x.webp', 195000, '2025-08-03 02:36:41', NULL, '', 34, 0, 0, 10, 4193133.00),
(167, 'Kem Em Bé Cỏ Mềm', 'https://media.comem.vn/uploads/2024/07/Frame_1036_sp2x.webp', 100000, '2025-08-03 02:39:18', NULL, '', 34, 0, 0, 10, 7494795.00),
(168, 'Tinh dầu hạt Mùi già - Hương của Quê nhà', 'https://media.comem.vn/uploads/January2023/tinh-dau-hat-mui-gia_sp2x.webp', 250000, '2025-08-03 03:02:01', NULL, '', 36, 0, 0, 10, 3894579.00),
(169, 'Tinh dầu nguyên chất (Lọ to 20ml)', 'https://media.comem.vn/uploads/January2023/tinh-dau-oai-huong_sp2x.webp', 200000, '2025-08-03 03:02:35', NULL, '', 36, 0, 0, 10, 5988512.00),
(170, 'Tinh dầu trị liệu - Chữa lành bằng mùi hương', 'https://media.comem.vn/uploads/November2022/tinh-dau-lan-tinh_sp2x.webp', 185000, '2025-08-03 03:42:15', NULL, '', 37, 0, 0, 10, 7258824.00),
(171, 'Tinh dầu treo thông minh', 'https://media.comem.vn/uploads/November2022/tinh-dau-treo-dong-que-sa-chanh_sp2x.webp', 180000, '2025-08-03 03:43:57', NULL, '', 38, 0, 0, 10, 7328585.00),
(172, '[SET QUÀ TẶNG] Mặt Nạ Ngủ Môi, Son Dưỡng Dành Cho Bạn Gái', 'https://media.comem.vn/uploads/2025/02/mat-na-ngu-moi-son-duong-moi-giftset_sp2x.webp', 215000, '2025-08-03 03:48:12', NULL, '', 39, 0, 0, 10, 3866452.00),
(173, '[SET QUÀ TẶNG] Combo 3 Màu Son Kem Nhung - Lì Mượt', 'https://media.comem.vn/uploads/2025/02/combo_3_son_kem_nhung0.3x_sp2x.webp', 245000, '2025-08-03 03:50:55', NULL, '', 40, 0, 0, 10, 6346506.00),
(174, '[SET QUÀ TẶNG] Combo 2 Bước Chuyên Sâu Sâm 1700 Cấp Ẩm Ngừa Lão Hoá', 'https://media.comem.vn/uploads/2025/02/combo-2-buoc-chuyen-sau-sam-1700-cap-am-ngua-lao-hoa_sp2x.webp', 700000, '2025-08-03 03:53:26', NULL, '', 41, 0, 0, 10, 9133174.00),
(175, 'Kem Dưỡng Ẩm Sâm 1700 Ngừa Lão Hoá Da', 'https://media.comem.vn/uploads/2024/07/kem-duong-am-sam-1700_27_sp2x.webp', 520000, '2025-08-03 03:54:33', NULL, '', 42, 0, 0, 10, 5626353.00),
(176, 'Kem dưỡng ẩm kiềm dầu Rau má dành cho da dầu mụn', 'https://media.comem.vn/uploads/November2022/kem-duong-rau-ma-cho-da-dau-mun_sp2x.webp', 325000, '2025-08-03 03:57:59', NULL, '', 43, 0, 0, 10, 9732245.00),
(177, 'Serum Tơ Tằm Cấp Ẩm Đa Tầng', 'https://media.comem.vn/uploads/2025/02/Frame_11226_sp2x.webp', 240000, '2025-08-03 03:59:20', NULL, '', 44, 0, 0, 10, 10782167.00),
(178, 'Combo sáng da mờ nám chiết xuất Sơ-ri Vitamin C', 'https://media.comem.vn/uploads/2024/11/Frame_1070_sp2x.webp', 900000, '2025-08-03 04:01:04', 1150000, '', 45, 0, 0, 10, 3714099.00),
(179, 'Nước rửa chén bát Bồ Hòn Men Gạo LÀNH Homecare', 'https://media.comem.vn/uploads/2024/07/srm_tram_tra_(4)_sp2x.webp', 120000, '2025-08-03 04:03:38', NULL, '', 30, 1, 0, 10, 5223997.00),
(180, 'Túi vải đựng mỹ phẩm', 'blunt-cut-long-hair-with-mid-point-layers.jpg', 40000, '2025-08-03 04:04:29', NULL, '', 47, 0, 0, 0, 3977690.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `address` text,
  `image` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `otp` varchar(6) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT 'Hoạt động',
  `ngaytao` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `mobile`, `address`, `image`, `birthday`, `role`, `otp`, `otp_expires_at`, `created_at`, `updated_at`, `status`, `ngaytao`) VALUES
(6, 'admin', 'admin123', 'Quản trị viên', 'admin@codaa.com', '123456781', 'Hà Nội', NULL, NULL, 'admin', NULL, NULL, '2025-07-29 05:24:06', '2025-08-11 09:47:30', 'Hoạt động', '2025-08-04 04:12:01'),
(31, 'tranthi22042', '$2y$10$gAnbvps4hP1aDx4rYXtGf.//VFzYZqBs54K13wK6OBy.HLsIbxcv6', 'trần thị trọng', 'maxcode22401@gmail.com', NULL, NULL, NULL, NULL, 'user', NULL, NULL, '2025-08-12 13:27:00', '2025-08-12 13:27:15', 'active', '2025-08-12 13:27:00');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `MaGG` int NOT NULL,
  `Ten` varchar(50) NOT NULL,
  `TienGiam` varchar(100) NOT NULL,
  `MoTa` varchar(100) NOT NULL,
  `NgayHetHan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `HoatDong` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`MaBL`);

--
-- Indexes for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`MaDM`),
  ADD KEY `fk_danhmuc_MaDMCha` (`MaDMCha`);

--
-- Indexes for table `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDH`);

--
-- Indexes for table `donhangchitiet`
--
ALTER TABLE `donhangchitiet`
  ADD PRIMARY KEY (`MaCT`);

--
-- Indexes for table `phuongthucthanhtoan`
--
ALTER TABLE `phuongthucthanhtoan`
  ADD PRIMARY KEY (`MaPay`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `fk_sanpham_danhmuc` (`MaDM`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_otp` (`otp`,`otp_expires_at`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`MaGG`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `MaBL` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `MaDM` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `donhang`
--
ALTER TABLE `donhang`
  MODIFY `MaDH` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donhangchitiet`
--
ALTER TABLE `donhangchitiet`
  MODIFY `MaCT` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phuongthucthanhtoan`
--
ALTER TABLE `phuongthucthanhtoan`
  MODIFY `MaPay` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `MaGG` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD CONSTRAINT `fk_danhmuc_MaDMCha` FOREIGN KEY (`MaDMCha`) REFERENCES `danhmuc` (`MaDM`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_sanpham_danhmuc` FOREIGN KEY (`MaDM`) REFERENCES `danhmuc` (`MaDM`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
