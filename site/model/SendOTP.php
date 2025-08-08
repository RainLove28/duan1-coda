<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';
require __DIR__ . '/PHPMailer/Exception.php';

/**
 * Function để gửi email OTP
 */
function sendOTPEmail($to_email, $otp) {
    $mail = new PHPMailer(true);
    try {
        //Server config
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sivam.7e@gmail.com'; // 🔒 Gmail của bạn
        $mail->Password   = 'lfee ghmu rchv wkkr';   // 🔑 Mật khẩu ứng dụng
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('sivam.7e@gmail.com', 'Aura Beauty');
        $mail->addAddress($to_email);

        //Content
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "Mã OTP đặt lại mật khẩu - Aura Beauty";
        $mail->Body = "
        <!DOCTYPE html>
        <html lang='vi'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Mã OTP đặt lại mật khẩu</title>
            <style>
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                }
                .header {
                    text-align: center;
                    border-bottom: 2px solid #3E6907;
                    padding-bottom: 20px;
                    margin-bottom: 30px;
                }
                .header h2 {
                    color: #3E6907;
                    margin: 0;
                    font-size: 28px;
                }
                .otp-container {
                    text-align: center;
                    background-color: #f8f9fa;
                    padding: 20px;
                    border-radius: 8px;
                    margin: 20px 0;
                }
                .otp-code {
                    font-size: 32px;
                    font-weight: bold;
                    color: #e53935;
                    letter-spacing: 5px;
                    font-family: 'Courier New', monospace;
                }
                .footer {
                    margin-top: 30px;
                    padding-top: 20px;
                    border-top: 1px solid #eee;
                    text-align: center;
                    color: #666;
                }
                .warning {
                    background-color: #fff3cd;
                    border: 1px solid #ffeaa7;
                    color: #856404;
                    padding: 15px;
                    border-radius: 5px;
                    margin: 20px 0;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>🌟 Aura Beauty</h2>
                </div>
                
                <h3 style='color: #333; margin-bottom: 20px;'>🔐 Mã OTP đặt lại mật khẩu</h3>
                
                <p>Xin chào,</p>
                
                <p>Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản <strong>Aura Beauty</strong>.</p>
                
                <div class='otp-container'>
                    <p style='margin-bottom: 10px; color: #666;'>Mã OTP của bạn:</p>
                    <div class='otp-code'>{$otp}</div>
                    <p style='margin-top: 10px; color: #666; font-size: 14px;'>Mã này có hiệu lực trong <strong>1 phút</strong></p>
                </div>
                
                <div class='warning'>
                    <strong>⚠️ Lưu ý quan trọng:</strong><br>
                    • Không chia sẻ mã OTP này với bất kỳ ai<br>
                    • Mã OTP sẽ tự động hết hạn sau 1 phút<br>
                    • Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này
                </div>
                
                <div class='footer'>
                    <p><strong>Trân trọng,</strong></p>
                    <p>Đội ngũ Aura Beauty</p>
                    <p style='font-size: 12px; color: #999;'>Email này được gửi tự động, vui lòng không trả lời</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("OTP Email sending failed: " . $mail->ErrorInfo);
        return false;
    }
}

/**
 * Function để gửi email thông thường
 */
function sendEmail($to_email, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        //Server config
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sivam.7e@gmail.com'; // 🔒 Gmail của bạn
        $mail->Password   = 'lfee ghmu rchv wkkr';   // 🔑 Mật khẩu ứng dụng
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('sivam.7e@gmail.com', 'Aura Beauty');
        $mail->addAddress($to_email);

        //Content
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        return false;
    }
}
?>
