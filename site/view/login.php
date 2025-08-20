<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../model/database.php';
require_once __DIR__ . '/../model/SendOTP.php';

$errors = [];
$success = '';
$active_tab = $_GET['tab'] ?? 'login';

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (empty($username) || empty($password)) {
        $errors[] = 'Vui lòng nhập đầy đủ tài khoản và mật khẩu.';
    } else {
        try {
            $db = Database::getInstance();
            $user = $db->getOne("SELECT * FROM users WHERE username = ? OR email = ?", [$username, $username]);
            
            if ($user) {
                $passwordValid = false;
                if (password_verify($password, $user['password'])) {
                    $passwordValid = true;
                } elseif ($user['password'] === $password) {
                    $passwordValid = true;
                }
                
                if ($passwordValid) {
                    $_SESSION['user'] = $user;
                    
                    // Cũng set userInfo để tương thích với các module khác
                    $_SESSION['userInfo'] = [
                        'userId' => $user['id'],
                        'username' => $user['username'], 
                        'fullname' => $user['fullname'],
                        'address' => $user['address'] ?? '',
                        'mobile' => $user['mobile'] ?? '',
                        'email' => $user['email'] ?? '',
                        'role' => $user['role']
                    ];
                    
                    if ($user['role'] === 'admin') {
                        header('Location: /PHP1/duan-coda%20(1)/duan1-coda/admin/index.php');
                    } else {
                        header('Location: index.php?page=home');
                    }
                    exit();
                } else {
                    $errors[] = 'Mật khẩu không đúng.';
                }
            } else {
                $errors[] = 'Tài khoản không tồn tại.';
            }
        } catch (Exception $e) {
            $errors[] = 'Lỗi hệ thống: ' . $e->getMessage();
        }
    }
}

// Xử lý đăng ký
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $active_tab = 'register';
    $username = trim($_POST['reg_username'] ?? '');
    $email = trim($_POST['reg_email'] ?? '');
    $fullname = trim($_POST['reg_fullname'] ?? '');
    $password = trim($_POST['reg_password'] ?? '');
    $confirm_password = trim($_POST['reg_confirm_password'] ?? '');
    
    if (empty($username) || empty($email) || empty($fullname) || empty($password)) {
        $errors[] = 'Vui lòng nhập đầy đủ thông tin.';
    } elseif ($password !== $confirm_password) {
        $errors[] = 'Mật khẩu xác nhận không khớp.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    } else {
        try {
            $db = Database::getInstance();
            
            // Debug log
            error_log("DEBUG: Checking registration for email: $email, username: $username");
            
            // Kiểm tra username đã tồn tại
            $existing_user = $db->getOne("SELECT id FROM users WHERE username = ?", [$username]);
            if ($existing_user) {
                error_log("DEBUG: Username $username already exists");
                $errors[] = 'Tên đăng nhập đã tồn tại.';
            }
            
            // Kiểm tra email đã tồn tại
            $existing_email = $db->getOne("SELECT id FROM users WHERE email = ?", [$email]);
            if ($existing_email) {
                error_log("DEBUG: Email $email already exists");
                $errors[] = 'Email đã được sử dụng.';
            } else {
                error_log("DEBUG: Email $email is available for registration");
            }
            
            if (empty($errors)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $otp_expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                
                // Debug log
                error_log("DEBUG: Attempting to register user: $email with OTP: $otp");
                
                $sql = "INSERT INTO users (username, email, fullname, password, role, otp, otp_expires_at, status) VALUES (?, ?, ?, ?, 'user', ?, ?, 'pending')";
                
                if ($db->execute($sql, [$username, $email, $fullname, $hashed_password, $otp, $otp_expires_at])) {
                    // Debug log
                    error_log("DEBUG: User inserted successfully");
                    
                    // Gửi email xác thực
                    if (sendOTPEmail($email, $otp)) {
                        error_log("DEBUG: OTP email sent successfully to $email");
                        $success = 'Đăng ký thành công! Mã OTP đã được gửi đến email (có hiệu lực 15 phút). Vui lòng kiểm tra email để xác thực tài khoản.';
                        $active_tab = 'verify';
                        $_SESSION['verify_email'] = $email;
                    } else {
                        error_log("DEBUG: Failed to send OTP email to $email");
                        $errors[] = 'Đăng ký thành công nhưng không thể gửi email xác thực. Vui lòng liên hệ admin.';
                    }
                } else {
                    error_log("DEBUG: Failed to insert user to database");
                    $errors[] = 'Lỗi khi tạo tài khoản.';
                }
            }
        } catch (Exception $e) {
            $errors[] = 'Lỗi hệ thống: ' . $e->getMessage();
        }
    }
}

// Xử lý xác thực OTP
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_otp'])) {
    $active_tab = 'verify';
    $email = $_SESSION['verify_email'] ?? '';
    $otp = trim($_POST['otp'] ?? '');
    
    if (empty($otp)) {
        $errors[] = 'Vui lòng nhập mã OTP.';
    } else {
        try {
            $db = Database::getInstance();
            
            // Debug: Kiểm tra thông tin OTP
            $debug_user = $db->getOne("SELECT email, otp, otp_expires_at, NOW() as server_time FROM users WHERE email = ?", [$email]);
            error_log("DEBUG OTP: " . json_encode($debug_user));
            
            $user = $db->getOne("SELECT * FROM users WHERE email = ? AND otp = ?", [$email, $otp]);
            
            if ($user) {
                // Kiểm tra thời hạn OTP riêng biệt
                $current_time = time();
                $expires_time = strtotime($user['otp_expires_at']);
                
                error_log("DEBUG: Current time: $current_time, Expires time: $expires_time, Diff: " . ($expires_time - $current_time));
                
                if ($expires_time > $current_time) {
                    // OTP còn hiệu lực
                    $db->execute("UPDATE users SET status = 'active', otp = NULL, otp_expires_at = NULL WHERE id = ?", [$user['id']]);
                    $success = 'Xác thực thành công! Bạn có thể đăng nhập ngay bây giờ.';
                    $active_tab = 'login';
                    unset($_SESSION['verify_email']);
                } else {
                    $errors[] = 'Mã OTP đã hết hạn. Vui lòng gửi lại mã mới.';
                }
            } else {
                $errors[] = 'Mã OTP không đúng.';
            }
        } catch (Exception $e) {
            error_log("ERROR in OTP verification: " . $e->getMessage());
            $errors[] = 'Lỗi hệ thống: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Aura Beauty</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #056405ff 0%, #0d8a06ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .auth-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .auth-header h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .auth-header p {
            color: #666;
            font-size: 14px;
        }
        
        /* Tab Navigation */
        .tab-navigation {
            display: flex;
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 30px;
        }
        
        .tab-btn {
            flex: 1;
            padding: 15px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            color: #666;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .tab-btn.active {
            color: #667eea;
        }
        
        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: #667eea;
        }
        
        .tab-btn:hover {
            color: #667eea;
        }
        
        /* Tab Content */
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .error-messages, .success-message {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .error-messages {
            background: #fee;
            border: 1px solid #fcc;
        }
        
        .success-message {
            background: #efe;
            border: 1px solid #cfc;
        }
        
        .error-messages ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .error-messages li {
            color: #c33;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .success-message {
            color: #2d5a3d;
            font-size: 14px;
        }
        
        .btn-primary {
            width: 100%;
            padding: 15px;
             background: linear-gradient(135deg, #056405ff 0%, #0d8a06ff 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            width: 100%;
            padding: 12px;
            background: #f8f9fa;
            color: #333;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: #e9ecef;
            border-color: #667eea;
        }
        
        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
            color: #666;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e5e9;
        }
        
        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
        }
        
        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 12px;
            background: #4285f4;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .google-btn:hover {
            background: #3367d6;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
        
        .otp-input {
            text-align: center;
            font-size: 24px;
            letter-spacing: 5px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1><img src="path/to/logo.png" alt=""> Aura Beauty</h1>
            <p>Chào mừng bạn đến với hệ thống quản lý</p>
        </div>
        
        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <button class="tab-btn <?= $active_tab === 'login' ? 'active' : '' ?>" onclick="switchTab('login')">
                Đăng nhập
            </button>
            <button class="tab-btn <?= $active_tab === 'register' ? 'active' : '' ?>" onclick="switchTab('register')">
                Đăng ký
            </button>
            <button class="tab-btn <?= $active_tab === 'verify' ? 'active' : '' ?>" onclick="switchTab('verify')" 
                    style="<?= $active_tab !== 'verify' ? 'display:none;' : '' ?>">
                Xác thực
            </button>
        </div>
        
        <!-- Messages -->
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="success-message">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        
        <!-- Login Tab -->
        <div id="login-tab" class="tab-content <?= $active_tab === 'login' ? 'active' : '' ?>">
            <form method="POST" action="?page=login">
                <div class="form-group">
                    <label for="username">Tên đăng nhập hoặc Email</label>
                    <input type="text" id="username" name="username" required autocomplete="username" 
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                </div>
                
                <button type="submit" name="login" class="btn-primary">Đăng nhập</button>
                
                <div class="divider">
                    <span>hoặc</span>
                </div>
                
                <button type="button" class="google-btn" onclick="loginWithGoogle()">
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Đăng nhập bằng Google
                </button>
                
                <button type="button" class="btn-secondary" onclick="window.location.href='index.php?page=forgot-password'">
                    Quên mật khẩu?
                </button>
            </form>
        </div>
        
        <!-- Register Tab -->
        <div id="register-tab" class="tab-content <?= $active_tab === 'register' ? 'active' : '' ?>">
            <form method="POST" action="?page=login">
                <div class="form-group">
                    <label for="reg_fullname">Họ và tên</label>
                    <input type="text" id="reg_fullname" name="reg_fullname" required 
                           value="<?= htmlspecialchars($_POST['reg_fullname'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="reg_username">Tên đăng nhập</label>
                    <input type="text" id="reg_username" name="reg_username" required 
                           value="<?= htmlspecialchars($_POST['reg_username'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="reg_email">Email</label>
                    <input type="email" id="reg_email" name="reg_email" required 
                           value="<?= htmlspecialchars($_POST['reg_email'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="reg_password">Mật khẩu</label>
                    <input type="password" id="reg_password" name="reg_password" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="reg_confirm_password">Xác nhận mật khẩu</label>
                    <input type="password" id="reg_confirm_password" name="reg_confirm_password" required minlength="6">
                </div>
                
                <button type="submit" name="register" class="btn-primary">Đăng ký</button>
            </form>
        </div>
        
        <!-- Verify Tab -->
        <div id="verify-tab" class="tab-content <?= $active_tab === 'verify' ? 'active' : '' ?>">
            <form method="POST" action="?page=login">
                <p style="text-align: center; margin-bottom: 20px; color: #666;">
                    Chúng tôi đã gửi mã xác thực đến email: <strong><?= htmlspecialchars($_SESSION['verify_email'] ?? '') ?></strong>
                </p>
                
                <div style="text-align: center; margin-bottom: 15px; padding: 10px; background: #e3f2fd; border-radius: 5px; color: #1976d2;">
                    <i class="fas fa-clock"></i> Mã OTP có hiệu lực trong <strong>15 phút</strong>
                    <div id="countdown-timer" style="font-weight: bold; margin-top: 5px; color: #d32f2f;"></div>
                </div>
                
                <div class="form-group">
                    <label for="otp">Mã OTP (6 số)</label>
                    <input type="text" id="otp" name="otp" required maxlength="6" 
                           class="otp-input" placeholder="000000">
                </div>
                
                <button type="submit" name="verify_otp" class="btn-primary">Xác thực</button>
                
                <button type="button" class="btn-secondary" onclick="resendOTP()">
                    Gửi lại mã OTP
                </button>
            </form>
        </div>
        
        <div class="back-link">
            <a href="/PHP1/dự án 1/index.php">← Quay về trang chủ</a>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Add active class to selected button
            document.querySelector(`[onclick="switchTab('${tabName}')"]`).classList.add('active');
            
            // Update URL
            window.history.replaceState({}, '', `?tab=${tabName}`);
        }
        
        function loginWithGoogle() {
            // Redirect to Google OAuth
            window.location.href = 'google-auth.php';
        }
        
        function resendOTP() {
            fetch('resend-otp.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: '<?= $_SESSION['verify_email'] ?? '' ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Mã OTP mới đã được gửi đến email của bạn!');
                    // Restart countdown timer
                    startOTPCountdown();
                } else {
                    alert('Lỗi: ' + data.message);
                }
            })
            .catch(error => {
                alert('Có lỗi xảy ra khi gửi lại OTP');
            });
        }
        
        // Auto-format OTP input
        document.getElementById('otp').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });

        // OTP Countdown Timer
        function startOTPCountdown() {
            const countdownElement = document.getElementById('countdown-timer');
            if (!countdownElement) return;
            
            // Set 15 minutes countdown (15 * 60 = 900 seconds)
            let timeLeft = 15 * 60;
            
            const timer = setInterval(function() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                
                countdownElement.innerHTML = `Thời gian còn lại: ${minutes}:${seconds.toString().padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    countdownElement.innerHTML = `<span style="color: #d32f2f;">⚠️ Mã OTP đã hết hạn</span>`;
                    countdownElement.style.background = '#ffebee';
                }
                
                timeLeft--;
            }, 1000);
        }

        // Start countdown when on verify tab
        if (document.getElementById('verify-tab').classList.contains('active')) {
            startOTPCountdown();
        }
    </script>
</body>
</html>
