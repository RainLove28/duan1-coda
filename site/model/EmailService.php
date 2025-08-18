<?php
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private $mail;
    
    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->setupSMTP();
    }
    
    private function setupSMTP() {
        try {
            // Cấu hình SMTP cho Gmail (sử dụng cùng config với SendOTP.php)
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'sivam.7e@gmail.com';           // Sử dụng email đã cấu hình
            $this->mail->Password = 'lfee ghmu rchv wkkr';          // Sử dụng App Password đã có
            $this->mail->SMTPSecure = 'tls';                        // Khớp với SendOTP.php
            $this->mail->Port = 587;
            $this->mail->CharSet = 'UTF-8';
            
            // Cấu hình người gửi
            $this->mail->setFrom('sivam.7e@gmail.com', 'COMEM Store');
            
        } catch (Exception $e) {
            throw new Exception("Lỗi cấu hình email: {$this->mail->ErrorInfo}");
        }
    }
    
    public function sendOTP($toEmail, $userName, $otp) {
        try {
            // Reset recipients
            $this->mail->clearAddresses();
            $this->mail->clearAttachments();
            
            // Người nhận
            $this->mail->addAddress($toEmail, $userName);
            
            // Nội dung email
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Mã OTP Khôi Phục Mật Khẩu - COMEM Store';
            
            $htmlBody = $this->getOTPEmailTemplate($userName, $otp);
            $this->mail->Body = $htmlBody;
            
            // Text version cho email client không hỗ trợ HTML
            $this->mail->AltBody = "Xin chào {$userName},\n\n"
                                 . "Mã OTP khôi phục mật khẩu của bạn là: {$otp}\n"
                                 . "Mã này có hiệu lực trong 15 phút.\n\n"
                                 . "Nếu bạn không yêu cầu khôi phục mật khẩu, vui lòng bỏ qua email này.\n\n"
                                 . "Trân trọng,\nCOMEM Store";
            
            // Gửi email
            $result = $this->mail->send();
            
            // Log thành công
            error_log("Email sent successfully to: {$toEmail}");
            
            return $result;
            
        } catch (Exception $e) {
            // Log lỗi chi tiết
            $errorMsg = "Email Error to {$toEmail}: " . $e->getMessage();
            error_log($errorMsg);
            
            // Ném lại exception với thông tin chi tiết hơn
            if (strpos($e->getMessage(), 'SMTP connect()') !== false) {
                throw new Exception("Không thể kết nối đến Gmail SMTP. Kiểm tra kết nối internet và cấu hình email.");
            } elseif (strpos($e->getMessage(), 'SMTP Error: Could not authenticate') !== false) {
                throw new Exception("Lỗi xác thực Gmail. Kiểm tra lại email và App Password.");
            } elseif (strpos($e->getMessage(), 'Invalid address') !== false) {
                throw new Exception("Địa chỉ email không hợp lệ: {$toEmail}");
            } else {
                throw new Exception("Lỗi gửi email: " . $e->getMessage());
            }
        }
    }
    
    private function getOTPEmailTemplate($userName, $otp) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Mã OTP Khôi Phục Mật Khẩu</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center; padding: 30px; border-radius: 10px 10px 0 0; }
                .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
                .otp-box { background: white; border: 2px dashed #667eea; padding: 20px; text-align: center; margin: 20px 0; border-radius: 8px; }
                .otp-code { font-size: 32px; font-weight: bold; color: #667eea; letter-spacing: 8px; margin: 10px 0; }
                .warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 5px; margin: 20px 0; }
                .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
                .btn { display: inline-block; padding: 12px 24px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🔐 Khôi Phục Mật Khẩu</h1>
                    <p>COMEM Store</p>
                </div>
                
                <div class='content'>
                    <h2>Xin chào {$userName}!</h2>
                    <p>Chúng tôi nhận được yêu cầu khôi phục mật khẩu cho tài khoản của bạn.</p>
                    
                    <div class='otp-box'>
                        <h3>Mã OTP của bạn là:</h3>
                        <div class='otp-code'>{$otp}</div>
                        <p><strong>Có hiệu lực trong 15 phút</strong></p>
                    </div>
                    
                    <div class='warning'>
                        <strong>⚠️ Lưu ý bảo mật:</strong><br>
                        • Không chia sẻ mã OTP này với bất kỳ ai<br>
                        • Chỉ nhập mã trên trang web chính thức của COMEM<br>
                        • Nếu bạn không yêu cầu khôi phục mật khẩu, vui lòng bỏ qua email này
                    </div>
                    
                    <p>Sau khi nhập mã OTP, bạn sẽ có thể đặt lại mật khẩu mới cho tài khoản.</p>
                    
                    <div class='footer'>
                        <p>Email này được gửi tự động, vui lòng không trả lời.</p>
                        <p><strong>COMEM Store</strong> - Hệ thống quản lý bán hàng</p>
                        <p>© 2025 COMEM. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </body>
        </html>";
    }
    
    public function sendPasswordResetConfirmation($toEmail, $userName) {
        try {
            $this->mail->clearAddresses();
            $this->mail->clearAttachments();
            
            $this->mail->addAddress($toEmail, $userName);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Mật Khẩu Đã Được Thay Đổi - COMEM Store';
            
            $htmlBody = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: #28a745; color: white; text-align: center; padding: 30px; border-radius: 10px 10px 0 0; }
                    .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
                    .success-box { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>✅ Thành Công!</h1>
                        <p>COMEM Store</p>
                    </div>
                    
                    <div class='content'>
                        <h2>Xin chào {$userName}!</h2>
                        
                        <div class='success-box'>
                            <strong>Mật khẩu của bạn đã được thay đổi thành công!</strong>
                        </div>
                        
                        <p>Thời gian thay đổi: " . date('d/m/Y H:i:s') . "</p>
                        
                        <p>Nếu bạn không thực hiện thay đổi này, vui lòng liên hệ ngay với chúng tôi để bảo mật tài khoản.</p>
                        
                        <p>Trân trọng,<br><strong>COMEM Store</strong></p>
                    </div>
                </div>
            </body>
            </html>";
            
            $this->mail->Body = $htmlBody;
            $this->mail->send();
            return true;
            
        } catch (Exception $e) {
            error_log("Email Error: " . $e->getMessage());
            return false;
        }
    }
}
?>
