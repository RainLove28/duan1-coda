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
        
        // Thời gian hết hạn (5 phút)
        $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        
        // Lưu OTP vào bảng users
        $sql_update = "UPDATE users SET otp = ?, otp_expires_at = ? WHERE id = ?";
        if ($this->db->execute($sql_update, [$otp, $expires_at, $user['id']])) {
            // Gửi email OTP
            $email_sent = sendOTPEmail($user['email'], $otp);
            
            if ($email_sent) {
                return ['success' => true, 'message' => 'Mã OTP đã được gửi đến email của bạn.'];
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
        // Kiểm tra user và OTP
        $sql = "SELECT id FROM users WHERE username = ? AND email = ? AND otp = ? AND otp_expires_at > NOW()";
        $user = $this->db->getOne($sql, [$username, $email, $otp]);
        
        if (!$user) {
            return ['success' => false, 'message' => 'Mã OTP không đúng hoặc đã hết hạn.'];
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
        $sql_update = "UPDATE users SET password = ?, otp = NULL, otp_expires_at = NULL WHERE username = ? AND email = ? AND otp = ?";
        if ($this->db->execute($sql_update, [$hashed_password, $username, $email, $otp])) {
            return ['success' => true, 'message' => 'Đổi mật khẩu thành công!'];
        }
        
        return ['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại.'];
    }
}
?>
