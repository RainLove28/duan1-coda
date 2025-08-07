<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../site/model/config.php';
require_once '../site/model/database copy.php';

echo "<h2>Test Login System</h2>";

try {
    $db = Database::getInstance();
    echo "<p style='color: green;'>✅ Database connection: OK</p>";
    
    // Test với tài khoản admin
    $username = 'admin';
    $password = 'admin123';
    
    echo "<h3>Testing login with: username='$username', password='$password'</h3>";
    
    // Query gốc
    $query = "SELECT * FROM taikhoan WHERE TenDangNhap = ? AND MatKhau = ? AND TrangThai = 'Hoạt động'";
    echo "<p><strong>Query:</strong> $query</p>";
    
    $user = $db->getOne($query, [$username, $password]);
    
    if ($user) {
        echo "<p style='color: green;'>✅ User found!</p>";
        echo "<pre>";
        print_r($user);
        echo "</pre>";
    } else {
        echo "<p style='color: red;'>❌ User not found!</p>";
        
        // Kiểm tra từng bước
        echo "<h4>Debug steps:</h4>";
        
        // 1. Kiểm tra username
        $userByName = $db->getOne("SELECT * FROM taikhoan WHERE TenDangNhap = ?", [$username]);
        if ($userByName) {
            echo "<p style='color: orange;'>⚠️ Username exists but condition failed</p>";
            echo "<pre>";
            print_r($userByName);
            echo "</pre>";
        } else {
            echo "<p style='color: red;'>❌ Username not found</p>";
        }
        
        // 2. Kiểm tra tất cả user active
        $activeUsers = $db->getAll("SELECT TenDangNhap, MatKhau, TrangThai FROM taikhoan WHERE TrangThai = 'Hoạt động'");
        echo "<h4>Active users:</h4>";
        echo "<pre>";
        print_r($activeUsers);
        echo "</pre>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
