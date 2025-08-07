<?php
require_once 'site/model/database.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $db = Database::getInstance();
    $stmt = $db->getConnection()->prepare("SELECT id FROM users WHERE verification_token = :token AND email_verified = 0");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch();

    if ($user) {
        $stmt = $db->getConnection()->prepare("UPDATE users SET email_verified = 1, verification_token = NULL WHERE id = :id");
        $stmt->execute(['id' => $user['id']]);
        echo "Email đã được xác minh thành công. Bạn có thể đăng nhập.";
    } else {
        echo "Mã xác minh không hợp lệ hoặc đã được sử dụng.";
    }
} else {
    echo "Không có mã xác minh.";
}
?>