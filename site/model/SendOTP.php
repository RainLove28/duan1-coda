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
        $mail->Subject = "Mã OTP đặt lại mật khẩu - Aura Beauty";
        $mail->Body = "
        <html>
        <head>
            <title>Mã OTP đặt lại mật khẩu</title>
        </head>
        <body>
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #3E6907;'>Aura Beauty</h2>
                <h3>Mã OTP đặt lại mật khẩu</h3>
                <p>Xin chào,</p>
                <p>Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản Aura Beauty.</p>
                <p>Mã OTP của bạn là: <strong style='font-size: 24px; color: #e53935;'>{$otp}</strong></p>
                <p>Mã này có hiệu lực trong 5 phút.</p>
                <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
                <br>
                <p>Trân trọng,</p>
                <p>Đội ngũ Aura Beauty</p>
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
