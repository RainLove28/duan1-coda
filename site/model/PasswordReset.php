<?php
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/SendOTP.php';

class PasswordReset {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Tạo OTP cho user
     */
    public function createOTP($username, $email) {
        // Kiểm tra username và email có tồn tại và match không
        $sql = "SELECT id, username, email FROM users WHERE username = ? AND email = ?";
        $user = $this->db->getOne($sql, [$username, $email]);
        
        if (!$user) {
            return ['success' => false, 'message' => 'Tài khoản hoặc email không đúng.'];
        }
        
        // Tạo OTP 6 số
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Thời gian hết hạn (1 phút)
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 minute'));
        
        // Lưu OTP vào bảng users
        $sql_update = "UPDATE users SET otp = ?, otp_expires_at = ? WHERE id = ?";
        if ($this->db->execute($sql_update, [$otp, $expires_at, $user['id']])) {
            // Gửi email OTP
            $email_sent = sendOTPEmail($user['email'], $otp);
            
            if ($email_sent) {
                return ['success' => true, 'message' => 'Mã OTP đã được gửi đến email của bạn. Mã có hiệu lực trong 1 phút.'];
            } else {
                return ['success' => false, 'message' => 'Không thể gửi email. Vui lòng thử lại.'];
            }
        }
        
        return ['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại.'];
    }
    
    /**
     * Verify OTP
     */
    public function verifyOTP($username, $email, $otp) {
        // Xóa OTP đã hết hạn trước khi verify
        $this->cleanExpiredOTP();
        
        // Lấy thông tin OTP từ database
        $sql = "SELECT id, otp, otp_expires_at FROM users WHERE username = ? AND email = ?";
        $user = $this->db->getOne($sql, [$username, $email]);
        
        if (!$user) {
            return ['success' => false, 'message' => 'Tài khoản hoặc email không đúng.'];
        }
        
        // Kiểm tra OTP có tồn tại không
        if (empty($user['otp'])) {
            return ['success' => false, 'message' => 'Không có mã OTP nào được tạo cho tài khoản này.'];
        }
        
        // Kiểm tra OTP có hết hạn không
        if (strtotime($user['otp_expires_at']) <= time()) {
            return ['success' => false, 'message' => 'Mã OTP đã hết hạn.'];
        }
        
        // So sánh OTP nhập vào với OTP trong database
        if ($user['otp'] !== $otp) {
            // Log để debug
            error_log("OTP mismatch - Input: $otp, Database: " . $user['otp']);
            return ['success' => false, 'message' => 'Mã OTP không đúng.'];
        }
        
        return ['success' => true, 'message' => 'OTP hợp lệ.'];
    }
    
    /**
     * Reset password
     */
    public function resetPassword($username, $email, $otp, $new_password) {
        // Verify OTP trước
        $verify_result = $this->verifyOTP($username, $email, $otp);
        if (!$verify_result['success']) {
            return $verify_result;
        }
        
        // Hash password mới
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update password và xóa OTP
        $sql_update = "UPDATE users SET password = ?, otp = NULL, otp_expires_at = NULL WHERE username = ? AND email = ?";
        if ($this->db->execute($sql_update, [$hashed_password, $username, $email])) {
            return ['success' => true, 'message' => 'Đổi mật khẩu thành công!'];
        }
        
        return ['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại.'];
    }
    
    /**
     * Xóa OTP đã hết hạn
     */
    private function cleanExpiredOTP() {
        $sql = "UPDATE users SET otp = NULL, otp_expires_at = NULL WHERE otp_expires_at <= NOW()";
        $this->db->execute($sql);
    }
    
    /**
     * Lấy thông tin OTP của user (cho debug)
     */
    public function getOTPInfo($username, $email) {
        $sql = "SELECT otp, otp_expires_at FROM users WHERE username = ? AND email = ?";
        return $this->db->getOne($sql, [$username, $email]);
    }
    
    /**
     * Test OTP (cho debug)
     */
    public function testOTP($username, $email, $otp) {
        $info = $this->getOTPInfo($username, $email);
        
        if (!$info) {
            return ['success' => false, 'message' => 'User không tồn tại'];
        }
        
        $result = [
            'user_exists' => !empty($info),
            'otp_in_db' => $info['otp'] ?? 'NULL',
            'otp_input' => $otp,
            'otp_match' => ($info['otp'] === $otp),
            'expires_at' => $info['otp_expires_at'] ?? 'NULL',
            'is_expired' => !empty($info['otp_expires_at']) && strtotime($info['otp_expires_at']) <= time()
        ];
        
        return $result;
    }
}
?>
