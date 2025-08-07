<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $note = $_POST['note'] ?? '';
    $pay = $_POST['pay_method'] ?? 'COD';

    $subject = "Aura Beauty - Xác nhận đơn hàng";
    $body = "
    <h3>Xin chào $fullname,</h3>
    <p>Cảm ơn bạn đã đặt hàng tại <strong>Aura Beauty</strong>!</p>
    <p><strong>Thông tin đơn hàng:</strong></p>
    <ul>
        <li>Họ tên: $fullname</li>
        <li>Điện thoại: $phone</li>
        <li>Email: $email</li>
        <li>Địa chỉ: $address</li>
        <li>Phương thức thanh toán: $pay</li>
        <li>Ghi chú: $note</li>
    </ul>
    <p>Chúng tôi sẽ sớm liên hệ với bạn để xác nhận đơn hàng.</p>
    <p>Trân trọng,<br><strong>Aura Beauty</strong></p>
    ";

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
        $mail->addAddress($email, $fullname);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        echo "<script>alert('Đặt hàng thành công! Email xác nhận đã gửi.'); window.location.href='../view/trangchu.html';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Gửi email thất bại: {$mail->ErrorInfo}'); history.back();</script>";
    }
}
?>
