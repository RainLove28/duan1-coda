<?php
/**
 * File cấu hình tập trung cho ứng dụng
 */

// Cấu hình database
define('DB_HOST', 'localhost');
define('DB_NAME', 'duan1');
define('DB_USER', 'root');
define('DB_PASS', '');

// Cấu hình ứng dụng
define('APP_NAME', 'Quản lý Cửa hàng');
define('APP_VERSION', '1.0.0');

// Cấu hình session
define('SESSION_TIMEOUT', 3600); // 1 giờ

// Cấu hình tồn kho
define('LOW_STOCK_THRESHOLD', 5); // Ngưỡng sắp hết hàng
define('OUT_OF_STOCK', 0); // Ngưỡng hết hàng

// Cấu hình upload
define('UPLOAD_PATH', '../public/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Cấu hình phân trang
define('ITEMS_PER_PAGE', 10);

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Error reporting (tắt trong production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
