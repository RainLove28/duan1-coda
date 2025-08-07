<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../model/PasswordReset.php';

class PasswordResetController {
    private $passwordReset;
    
    public function __construct() {
        try {
            $this->passwordReset = new PasswordReset();
        } catch (Exception $e) {
            error_log("PasswordResetController constructor error: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Xử lý request gửi OTP
     */
    public function sendOTP() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        try {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            
            error_log("sendOTP called with username: $username, email: $email");
            
            if (empty($username) || empty($email)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin.']);
                return;
            }
            
            $result = $this->passwordReset->createOTP($username, $email);
            error_log("createOTP result: " . json_encode($result));
            echo json_encode($result);
        } catch (Exception $e) {
            error_log("PasswordResetController sendOTP error: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Xử lý request verify OTP
     */
    public function verifyOTP() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        try {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $otp = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_SPECIAL_CHARS);
            
            if (empty($username) || empty($email) || empty($otp)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin.']);
                return;
            }
            
            $result = $this->passwordReset->verifyOTP($username, $email, $otp);
            echo json_encode($result);
        } catch (Exception $e) {
            error_log("PasswordResetController verifyOTP error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Xử lý request reset password
     */
    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        try {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $otp = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_SPECIAL_CHARS);
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if (empty($username) || empty($email) || empty($otp) || empty($new_password) || empty($confirm_password)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin.']);
                return;
            }
            
            // Kiểm tra mật khẩu mới
            if (strlen($new_password) < 6) {
                echo json_encode(['success' => false, 'message' => 'Mật khẩu phải có ít nhất 6 ký tự.']);
                return;
            }
            
            if ($new_password !== $confirm_password) {
                echo json_encode(['success' => false, 'message' => 'Mật khẩu xác nhận không khớp.']);
                return;
            }
            
            $result = $this->passwordReset->resetPassword($username, $email, $otp, $new_password);
            echo json_encode($result);
        } catch (Exception $e) {
            error_log("PasswordResetController resetPassword error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }
}

// Xử lý request
if (isset($_GET['action'])) {
    try {
        $controller = new PasswordResetController();
        
        switch ($_GET['action']) {
            case 'send_otp':
                $controller->sendOTP();
                break;
            case 'verify_otp':
                $controller->verifyOTP();
                break;
            case 'reset_password':
                $controller->resetPassword();
                break;
            default:
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Action not found']);
        }
    } catch (Exception $e) {
        error_log("PasswordResetController main error: " . $e->getMessage());
        error_log("Stack trace: " . $e->getTraceAsString());
        echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No action specified']);
}
?>
