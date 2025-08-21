<?php
// Session đã được start trong index.php
require_once 'model/database.php';
require_once 'model/EmailService.php';

$step = $_GET['step'] ?? $_POST['step'] ?? 'email';
$errors = [];
$success = '';

// Xử lý success message từ URL
if (isset($_GET['success'])) {
    if ($step === 'otp') {
        $success = "✅ Mã OTP đã được gửi đến email. Vui lòng kiểm tra hộp thư của bạn (có hiệu lực trong 15 phút).";
    } elseif ($step === 'password') {
        $success = 'Xác thực thành công! Vui lòng đặt mật khẩu mới.';
    } elseif ($step === 'complete') {
        $success = 'Đặt lại mật khẩu thành công! Bạn có thể đăng nhập với mật khẩu mới.';
    }
}

// Xử lý các bước
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $step = $_POST['step'] ?? $step; // Lấy step từ POST trước
    
    if ($step === 'email') {
        $email = trim($_POST['email'] ?? '');
        
        if (empty($email)) {
            $errors[] = 'Vui lòng nhập email.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ.';
        } else {
            try {
                $db = Database::getInstance();
                
                // Kiểm tra email có tồn tại không
                $sql = "SELECT id, fullname FROM users WHERE email = ?";
                $user = $db->getOne($sql, [$email]);
                
                if ($user) {
                    // Tạo OTP 6 chữ số
                    $otp = sprintf('%06d', mt_rand(0, 999999));
                    $expires = date('Y-m-d H:i:s', time() + 900); // Hết hạn sau 15 phút
                    
                    // Lưu OTP vào session
                    $_SESSION['reset_password'] = [
                        'email' => $email,
                        'user_id' => $user['id'],
                        'otp' => $otp,
                        'expires' => $expires,
                        'attempts' => 0
                    ];
                    
                    // Gửi OTP qua email
                    try {
                        $emailService = new EmailService();
                        $emailSent = $emailService->sendOTP($email, $user['fullname'], $otp);
                        
                        if ($emailSent) {
                            // Redirect để tránh resubmit và chuyển step
                            header("Location: ?page=forgot-password&step=otp");
                            exit;
                        } else {
                            $errors[] = "Không thể gửi email. Vui lòng thử lại sau.";
                        }
                        
                    } catch (Exception $emailError) {
                        // Log lỗi chi tiết
                        error_log("Email Error: " . $emailError->getMessage() . " | OTP for {$email}: {$otp}");
                        $errors[] = "Lỗi gửi email: " . $emailError->getMessage();
                    }
                } else {
                    $errors[] = 'Email không tồn tại trong hệ thống.';
                }
            } catch (Exception $e) {
                $errors[] = 'Lỗi hệ thống: ' . $e->getMessage();
            }
        }
    } elseif ($step === 'otp') {
        $otp = trim($_POST['otp'] ?? '');
        
        if (empty($otp)) {
            $errors[] = 'Vui lòng nhập mã OTP.';
        } elseif (!isset($_SESSION['reset_password'])) {
            $errors[] = 'Phiên làm việc đã hết hạn. Vui lòng thử lại.';
            $step = 'email';
        } else {
            $resetData = $_SESSION['reset_password'];
            
            // Kiểm tra hết hạn
            if (time() > strtotime($resetData['expires'])) {
                $errors[] = 'Mã OTP đã hết hạn. Vui lòng thử lại.';
                unset($_SESSION['reset_password']);
                $step = 'email';
            } elseif ($resetData['attempts'] >= 3) {
                $errors[] = 'Bạn đã nhập sai quá 3 lần. Vui lòng thử lại.';
                unset($_SESSION['reset_password']);
                $step = 'email';
            } elseif ($otp !== $resetData['otp']) {
                $_SESSION['reset_password']['attempts']++;
                $remaining = 3 - $_SESSION['reset_password']['attempts'];
                $errors[] = "Mã OTP không đúng. Còn lại {$remaining} lần thử.";
            } else {
                // OTP đúng, chuyển sang bước đặt mật khẩu mới
                $success = 'Xác thực thành công! Vui lòng đặt mật khẩu mới.';
                header("Location: ?page=forgot-password&step=password&success=1");
                exit;
            }
        }
    } elseif ($step === 'password') {
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if (empty($password)) {
            $errors[] = 'Vui lòng nhập mật khẩu mới.';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        } elseif ($password !== $confirmPassword) {
            $errors[] = 'Xác nhận mật khẩu không khớp.';
        } elseif (!isset($_SESSION['reset_password'])) {
            $errors[] = 'Phiên làm việc đã hết hạn. Vui lòng thử lại.';
            $step = 'email';
        } else {
            try {
                $db = Database::getInstance();
                $resetData = $_SESSION['reset_password'];
                
                // Cập nhật mật khẩu
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password = ? WHERE id = ?";
                $db->execute($sql, [$hashedPassword, $resetData['user_id']]);
                
                // Gửi email xác nhận thay đổi mật khẩu
                try {
                    $emailService = new EmailService();
                    $emailService->sendPasswordResetConfirmation($resetData['email'], 'Người dùng');
                } catch (Exception $e) {
                    // Không làm gián đoạn quá trình nếu gửi email thất bại
                    error_log("Failed to send password reset confirmation: " . $e->getMessage());
                }
                
                // Xóa session reset
                unset($_SESSION['reset_password']);
                
                $success = 'Đặt lại mật khẩu thành công! Bạn có thể đăng nhập với mật khẩu mới.';
                header("Location: ?page=forgot-password&step=complete&success=1");
                exit;
            } catch (Exception $e) {
                $errors[] = 'Lỗi hệ thống: ' . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu - COMEM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #3d640f;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .forgot-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }
        .forgot-header {
            background: #579510ff;
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        .forgot-body {
            padding: 40px 30px;
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: bold;
            position: relative;
        }
        .step.active {
            background: #3d640f;
            color: white;
        }
        .step.completed {
            background: #3d640f;
            color: white;
        }
        .step.inactive {
            background: #e9ecef;
            color: #6c757d;
        }
        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        .form-control:focus {
            border-color: #3d640f;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: #3d640f;
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 600;
            width: 100%;
        }
        .btn-secondary {
            border-radius: 8px;
            padding: 10px 20px;
            margin-top: 10px;
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .otp-input {
            font-size: 1.5rem;
            text-align: center;
            letter-spacing: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="forgot-container">
                    <div class="forgot-header">
                        <i class="fas fa-key fa-2x mb-3"></i>
                        <h4 class="mb-0">Quên Mật Khẩu</h4>
                        <p class="mb-0">Khôi phục tài khoản của bạn</p>
                    </div>
                    
                    <div class="forgot-body">
                        <!-- Step Indicator -->
                        <div class="step-indicator">
                            <div class="step <?= ($step === 'email') ? 'active' : (in_array($step, ['otp', 'password', 'complete']) ? 'completed' : 'inactive') ?>">1</div>
                            <div class="step <?= ($step === 'otp') ? 'active' : (in_array($step, ['password', 'complete']) ? 'completed' : 'inactive') ?>">2</div>
                            <div class="step <?= ($step === 'password') ? 'active' : ($step === 'complete' ? 'completed' : 'inactive') ?>">3</div>
                        </div>

                        <!-- Error Messages -->
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php foreach ($errors as $error): ?>
                                    <div><?= htmlspecialchars($error) ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Success Messages -->
                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <?= $success ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($step === 'email'): ?>
                            <!-- Step 1: Email Input -->
                            <h5 class="mb-3">Bước 1: Nhập Email</h5>
                            <p class="text-muted mb-4">Nhập email đã đăng ký để nhận mã xác thực OTP</p>
                            
                            <form method="POST">
                                <input type="hidden" name="step" value="email">
                                <div class="mb-3">
                                    <label class="form-label">Email đã đăng ký</label>
                                    <input type="email" class="form-control" name="email" 
                                           placeholder="Nhập email của bạn" required 
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Gửi Mã OTP
                                </button>
                            </form>

                        <?php elseif ($step === 'otp'): ?>
                            <!-- Step 2: OTP Verification -->
                            <h5 class="mb-3">Bước 2: Xác Thực OTP</h5>
                            <p class="text-muted mb-4">Nhập mã OTP 6 chữ số đã được gửi đến email của bạn</p>
                            
                            <form method="POST">
                                <input type="hidden" name="step" value="otp">
                                <div class="mb-3">
                                    <label class="form-label">Mã OTP</label>
                                    <input type="text" class="form-control otp-input" name="otp" 
                                           placeholder="000000" maxlength="6" required 
                                           pattern="[0-9]{6}" title="Mã OTP phải là 6 chữ số">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-2"></i>Xác Thực
                                </button>
                                <a href="?step=email" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Quay Lại
                                </a>
                            </form>

                        <?php elseif ($step === 'password'): ?>
                            <!-- Step 3: New Password -->
                            <h5 class="mb-3">Bước 3: Đặt Mật Khẩu Mới</h5>
                            <p class="text-muted mb-4">Tạo mật khẩu mới cho tài khoản của bạn</p>
                            
                            <form method="POST">
                                <input type="hidden" name="step" value="password">
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu mới</label>
                                    <input type="password" class="form-control" name="password" 
                                           placeholder="Nhập mật khẩu mới (ít nhất 6 ký tự)" required minlength="6">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Xác nhận mật khẩu</label>
                                    <input type="password" class="form-control" name="confirm_password" 
                                           placeholder="Nhập lại mật khẩu mới" required minlength="6">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Đặt Lại Mật Khẩu
                                </button>
                            </form>

                        <?php elseif ($step === 'complete'): ?>
                            <!-- Step 4: Complete -->
                            <div class="text-center">
                                <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                                <h5 class="text-success mb-3">Hoàn Thành!</h5>
                                <p class="text-muted mb-4">Mật khẩu của bạn đã được đặt lại thành công.</p>
                                <a href="index.php?page=login" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Đăng Nhập Ngay
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="back-link">
                            <a href="index.php?page=login" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-2"></i>Quay về trang đăng nhập
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto format OTP input
        document.addEventListener('DOMContentLoaded', function() {
            const otpInput = document.querySelector('.otp-input');
            if (otpInput) {
                otpInput.addEventListener('input', function(e) {
                    // Chỉ cho phép số
                    this.value = this.value.replace(/[^0-9]/g, '');
                    
                    // Giới hạn 6 ký tự
                    if (this.value.length > 6) {
                        this.value = this.value.slice(0, 6);
                    }
                });
                
                otpInput.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    this.value = paste.replace(/[^0-9]/g, '').slice(0, 6);
                });
            }
        });
    </script>
</body>
</html>
