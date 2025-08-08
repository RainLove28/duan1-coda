<?php
/**
 * Script tự động xóa OTP hết hạn
 * Có thể chạy bằng cron job: */1 * * * * php /path/to/cleanup_expired_otp.php
 */

require_once __DIR__ . '/site/model/database.php';

try {
    $db = Database::getInstance();
    
    // Xóa OTP đã hết hạn
    $sql = "UPDATE users SET otp = NULL, otp_expires_at = NULL WHERE otp_expires_at <= NOW()";
    $result = $db->execute($sql);
    
    // Đếm số OTP đã xóa
    $sql_count = "SELECT COUNT(*) as count FROM users WHERE otp IS NOT NULL AND otp_expires_at <= NOW()";
    $count = $db->getOne($sql_count);
    
    $log_message = date('Y-m-d H:i:s') . " - Cleaned up " . $count['count'] . " expired OTP(s)\n";
    
    // Ghi log
    file_put_contents(__DIR__ . '/logs/otp_cleanup.log', $log_message, FILE_APPEND);
    
    echo "Success: Cleaned up " . $count['count'] . " expired OTP(s)\n";
    
} catch (Exception $e) {
    $error_message = date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n";
    file_put_contents(__DIR__ . '/logs/otp_cleanup.log', $error_message, FILE_APPEND);
    echo "Error: " . $e->getMessage() . "\n";
}
?>
