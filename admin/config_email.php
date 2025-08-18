<?php
session_start();
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $fromName = trim($_POST['from_name'] ?? 'COMEM Store');
    
    if (!empty($email) && !empty($password)) {
        // Đọc file EmailService hiện tại
        $emailServicePath = 'site/model/EmailService.php';
        $content = file_get_contents($emailServicePath);
        
        // Thay thế thông tin cấu hình
        $content = preg_replace(
            '/\$this->mail->Username = \'.*?\';/',
            "\$this->mail->Username = '{$email}';",
            $content
        );
        
        $content = preg_replace(
            '/\$this->mail->Password = \'.*?\';/',
            "\$this->mail->Password = '{$password}';",
            $content
        );
        
        $content = preg_replace(
            '/\$this->mail->setFrom\(\'.*?\', \'.*?\'\);/',
            "\$this->mail->setFrom('{$email}', '{$fromName}');",
            $content
        );
        
        // Lưu file
        if (file_put_contents($emailServicePath, $content)) {
            $message = 'Cấu hình email đã được cập nhật thành công!';
            $messageType = 'success';
        } else {
            $message = 'Lỗi: Không thể cập nhật file cấu hình.';
            $messageType = 'error';
        }
    } else {
        $message = 'Vui lòng nhập đầy đủ email và password.';
        $messageType = 'error';
    }
}

// Đọc cấu hình hiện tại
$currentEmail = 'your-email@gmail.com';
$currentName = 'COMEM Store';
$emailServiceContent = file_get_contents('site/model/EmailService.php');
if (preg_match('/\$this->mail->Username = \'(.*?)\';/', $emailServiceContent, $matches)) {
    $currentEmail = $matches[1];
}
if (preg_match('/\$this->mail->setFrom\(\'.*?\', \'(.*?)\'\);/', $emailServiceContent, $matches)) {
    $currentName = $matches[1];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cấu Hình Email - COMEM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .config-container { 
            max-width: 800px; 
            margin: 50px auto; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .config-header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 30px; 
            text-align: center; 
        }
        .config-body { padding: 40px; }
        .step-box { 
            background: #f8f9fa; 
            border-left: 4px solid #667eea; 
            padding: 20px; 
            margin: 20px 0; 
            border-radius: 0 8px 8px 0;
        }
        .alert { border-radius: 8px; }
        .form-control { border-radius: 8px; padding: 12px; }
        .btn { border-radius: 8px; padding: 12px 24px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="config-container">
            <div class="config-header">
                <i class="fas fa-envelope-open-text fa-3x mb-3"></i>
                <h2>Cấu Hình Email SMTP</h2>
                <p class="mb-0">Thiết lập gửi email thực tế cho chức năng quên mật khẩu</p>
            </div>
            
            <div class="config-body">
                <?php if ($message): ?>
                    <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'danger' ?>">
                        <i class="fas fa-<?= $messageType === 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <div class="step-box">
                    <h5><i class="fas fa-info-circle text-primary me-2"></i>Hướng dẫn tạo Gmail App Password:</h5>
                    <ol>
                        <li>Truy cập <a href="https://myaccount.google.com/" target="_blank">Google Account</a></li>
                        <li>Chọn <strong>Security</strong> → <strong>2-Step Verification</strong> (bật tính năng này)</li>
                        <li>Chọn <strong>App passwords</strong></li>
                        <li>Chọn app: <strong>Mail</strong>, device: <strong>Windows Computer</strong></li>
                        <li>Copy mật khẩu 16 ký tự và dán vào form dưới</li>
                    </ol>
                </div>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-envelope me-2"></i>Gmail Address</label>
                                <input type="email" class="form-control" name="email" 
                                       value="<?= htmlspecialchars($currentEmail !== 'your-email@gmail.com' ? $currentEmail : '') ?>"
                                       placeholder="example@gmail.com" required>
                                <small class="text-muted">Email Gmail của bạn</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-user me-2"></i>Tên Người Gửi</label>
                                <input type="text" class="form-control" name="from_name" 
                                       value="<?= htmlspecialchars($currentName) ?>"
                                       placeholder="COMEM Store" required>
                                <small class="text-muted">Tên hiển thị trong email</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-key me-2"></i>Gmail App Password</label>
                        <input type="password" class="form-control" name="password" 
                               placeholder="xxxx xxxx xxxx xxxx (16 ký tự)" required>
                        <small class="text-muted">App Password từ Google (không phải mật khẩu Gmail thường)</small>
                    </div>

                    <div class="mb-4">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Lưu ý bảo mật:</strong> Thông tin này sẽ được lưu trong file PHP. 
                            Không chia sẻ App Password với ai khác.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary me-3">
                        <i class="fas fa-save me-2"></i>Lưu Cấu Hình
                    </button>
                    
                    <a href="test_email.php" class="btn btn-secondary me-3">
                        <i class="fas fa-flask me-2"></i>Test Email
                    </a>
                    
                    <a href="site/index.php?page=forgot-password" class="btn btn-success">
                        <i class="fas fa-key me-2"></i>Thử Quên Mật Khẩu
                    </a>
                </form>

                <hr class="my-4">

                <div class="step-box">
                    <h5><i class="fas fa-list-check text-success me-2"></i>Trạng thái cấu hình:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Email hiện tại:</strong> 
                                <span class="<?= $currentEmail === 'your-email@gmail.com' ? 'text-danger' : 'text-success' ?>">
                                    <?= htmlspecialchars($currentEmail) ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tên gửi:</strong> 
                                <span class="text-info"><?= htmlspecialchars($currentName) ?></span>
                            </p>
                        </div>
                    </div>
                    <p><strong>Trạng thái:</strong> 
                        <?php if ($currentEmail === 'your-email@gmail.com'): ?>
                            <span class="badge bg-warning">Chưa cấu hình</span>
                        <?php else: ?>
                            <span class="badge bg-success">Đã cấu hình</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
