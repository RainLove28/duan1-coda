<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../site/model/config.php';
require_once '../site/model/database copy.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    // Validate input
    if (!empty($username) && !empty($password) && !empty($confirmPassword) && !empty($fullName) && !empty($email)) {
        
        // Kiểm tra mật khẩu khớp
        if ($password !== $confirmPassword) {
            $error = 'Mật khẩu xác nhận không khớp!';
        } 
        // Kiểm tra độ dài mật khẩu
        else if (strlen($password) < 6) {
            $error = 'Mật khẩu phải có ít nhất 6 ký tự!';
        }
        // Kiểm tra định dạng email
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email không hợp lệ!';
        }
        else {
            try {
                $db = Database::getInstance();
                
                // Kiểm tra username đã tồn tại
                $existingUser = $db->getOne("SELECT * FROM taikhoan WHERE TenDangNhap = ?", [$username]);
                if ($existingUser) {
                    $error = 'Tên đăng nhập đã tồn tại!';
                } else {
                    // Kiểm tra email đã tồn tại
                    $existingEmail = $db->getOne("SELECT * FROM taikhoan WHERE Email = ?", [$email]);
                    if ($existingEmail) {
                        $error = 'Email đã được sử dụng!';
                    } else {
                        // Tạo tài khoản mới (VaiTro = 0 cho user thường)
                        $result = $db->execute(
                            "INSERT INTO taikhoan (TenDangNhap, MatKhau, HoTen, Email, VaiTro, TrangThai) VALUES (?, ?, ?, ?, 0, 'Hoạt động')", 
                            [$username, $password, $fullName, $email]
                        );
                        
                        if ($result) {
                            $success = 'Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.';
                            // Clear form data
                            $username = $password = $confirmPassword = $fullName = $email = '';
                        } else {
                            $error = 'Có lỗi xảy ra trong quá trình đăng ký!';
                        }
                    }
                }
            } catch (Exception $e) {
                $error = 'Lỗi kết nối database: ' . $e->getMessage();
            }
        }
    } else {
        $error = 'Vui lòng điền đầy đủ thông tin!';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản - CODA</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
              background: #044406ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }

        .register-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .register-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .register-form {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4CAF50;
            background: white;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .form-group i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .register-btn {
            width: 100%;
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #45a049;
            text-decoration: underline;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
            animation: fadeIn 0.3s ease;
        }

        .alert-error {
            background: #ffe6e6;
            color: #d63031;
            border: 1px solid #fab1a0;
        }

        .alert-success {
            background: #e8f5e8;
            color: #00b894;
            border: 1px solid #81ecec;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .password-strength {
            margin-top: 5px;
            font-size: 12px;
        }

        .strength-weak { color: #e74c3c; }
        .strength-medium { color: #f39c12; }
        .strength-strong { color: #27ae60; }

        @media (max-width: 480px) {
            .register-container {
                margin: 10px;
            }
            
            .register-header {
                padding: 25px 30px;
            }
            
            .register-form {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1><i class="fas fa-user-plus"></i> Đăng Ký</h1>
            <p>Tạo tài khoản mới để trải nghiệm CODAA</p>
        </div>
        
        <div class="register-form">
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" id="username" name="username" 
                           value="<?= htmlspecialchars($username ?? '') ?>" 
                           placeholder="Nhập tên đăng nhập" required>
                    <i class="fas fa-user"></i>
                </div>
                
                <div class="form-group">
                    <label for="full_name">Họ và tên</label>
                    <input type="text" id="full_name" name="full_name" 
                           value="<?= htmlspecialchars($fullName ?? '') ?>" 
                           placeholder="Nhập họ và tên đầy đủ" required>
                    <i class="fas fa-id-card"></i>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           value="<?= htmlspecialchars($email ?? '') ?>" 
                           placeholder="Nhập địa chỉ email" required>
                    <i class="fas fa-envelope"></i>
                </div>
                
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" 
                           placeholder="Nhập mật khẩu (ít nhất 6 ký tự)" required>
                    <i class="fas fa-lock"></i>
                    <div class="password-strength" id="passwordStrength"></div>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu</label>
                    <input type="password" id="confirm_password" name="confirm_password" 
                           placeholder="Nhập lại mật khẩu" required>
                    <i class="fas fa-lock"></i>
                </div>
                
                <button type="submit" class="register-btn">
                    <i class="fas fa-user-plus"></i> Đăng Ký
                </button>
                
                <div class="login-link">
                    <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('passwordStrength');
            
            if (password.length === 0) {
                strengthDiv.innerHTML = '';
                return;
            }
            
            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            let text = '';
            let className = '';
            
            if (strength <= 2) {
                text = 'Mật khẩu yếu';
                className = 'strength-weak';
            } else if (strength <= 3) {
                text = 'Mật khẩu trung bình';
                className = 'strength-medium';
            } else {
                text = 'Mật khẩu mạnh';
                className = 'strength-strong';
            }
            
            strengthDiv.innerHTML = `<span class="${className}">${text}</span>`;
        });
        
        // Confirm password validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.style.borderColor = '#e74c3c';
            } else {
                this.style.borderColor = '#e1e5e9';
            }
        });
    </script>
</body>
</html>
