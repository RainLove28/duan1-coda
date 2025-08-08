<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../model/database.php';
require_once __DIR__ . '/../model/auth.php';

// Khởi tạo kết nối cơ sở dữ liệu
$db = Database::getInstance();

// Xác định tab hiện tại (đăng nhập, đăng ký, hoặc quên mật khẩu)
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'login';
$errors = [];
$success = '';

// Xử lý khi người dùng gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tab === 'register') { // Xử lý form đăng ký
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST['password'];
        $terms = isset($_POST['terms']);

        // Kiểm tra dữ liệu đầu vào
        if (empty($username) || empty($password) || !$terms) {
            $errors[] = 'Vui lòng điền đầy đủ thông tin và chấp nhận điều khoản.';
        } else {
            // Validation bổ sung
            if (strlen($username) < 3) {
                $errors[] = 'Tài khoản phải có ít nhất 3 ký tự.';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        } else {
                // Kiểm tra trùng tài khoản
                $sql_check = "SELECT * FROM users WHERE username = ?";
                $user_exist = $db->getOne($sql_check, [$username]);
                if ($user_exist) {
                    $errors[] = 'Tài khoản đã tồn tại.';
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
                    if ($db->execute($sql, [$username, $hashed_password])) {
                        $success = 'Đăng ký thành công! Vui lòng đăng nhập.';
                        $tab = 'login';
                    } else {
                        $errors[] = 'Đăng ký thất bại. Vui lòng thử lại.';
                    }
                }
            }
        }
    } else if ($tab === 'login') { // Xử lý form đăng nhập
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = isset($_POST['password']) ? $_POST['password'] : '';
        
    if (empty($username) || empty($password)) {
        $errors[] = 'Vui lòng điền đầy đủ thông tin.';
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";
        $user = $db->getOne($sql, [$username]);
        if ($user && password_verify($password, $user['password'])) {
            // Set session khi đăng nhập thành công
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            
            header('Location: index.php?page=home');
            exit;
        } else {
            $errors[] = 'Tài khoản hoặc mật khẩu không đúng.';
            }
        }
    }
}

// Xử lý gửi lại OTP
if (isset($_POST['resend_otp'])) {
    $_SESSION['otp'] = rand(100000, 999999);
    $success = 'Mã OTP mới đã được gửi!';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aura Beauty - Đăng nhập</title>
    <link rel="stylesheet" href="public/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="container">
    <div class="left-panel">
        <div class="logo"> 
                <img src="public/img/logo.png" alt="Aura Beauty Logo">
        </div>
    </div>
    <div class="right-panel">
        <div class="form-box">
                <h2 class="brand-name">Aura Beauty</h2>
                
                <!-- Tab Navigation -->
            <div class="tab">
                    <button class="tablink <?php echo $tab === 'register' ? 'active' : ''; ?>" onclick="switchTab('register')">Đăng ký</button>
                    <button class="tablink <?php echo $tab === 'login' ? 'active' : ''; ?>" onclick="switchTab('login')">Đăng nhập</button>
                    <button class="tablink <?php echo $tab === 'forgot' ? 'active' : ''; ?>" onclick="switchTab('forgot')">Quên mật khẩu</button>
            </div>

                <!-- Error Messages -->
            <?php if (!empty($errors)): ?>
                    <div class="error-message">
                    <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

                <!-- Success Messages -->
            <?php if (!empty($success)): ?>
                    <div class="success-message">
                        <p><?php echo htmlspecialchars($success); ?></p>
                </div>
            <?php endif; ?>

                <!-- Register Form -->
                <form id="register-form" class="form <?php echo $tab === 'register' ? '' : 'hidden'; ?>" method="POST" action="?page=login.php&tab=register">
                    <label>Tài khoản</label>
                    <input type="text" name="username" placeholder="Nhập tên tài khoản" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>

                    <label>Mật khẩu</label>
                    <input type="password" name="password" placeholder="Nhập mật khẩu" required>

                    <label class="checkbox">
                        <input type="checkbox" name="terms" required>
                        Chấp nhận điều khoản
                    </label>

                    <button type="submit" class="btn register">Đăng ký</button>
                    <button type="button" class="btn google" disabled>
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                        Đăng nhập bằng Google
                    </button>
                </form>

                <!-- Login Form -->
                <form id="login-form" class="form <?php echo $tab === 'login' ? '' : 'hidden'; ?>" method="POST" action="?page=login.php&tab=login">
                    <label>Tài khoản</label>
                    <input type="text" name="username" placeholder="Nhập tên tài khoản" value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>" required>

                    <label>Mật khẩu</label>
                    <input type="password" name="password" placeholder="Nhập mật khẩu" required>

                    <div class="login-options">
                        <label class="checkbox">
                            <input type="checkbox" name="remember">
                            Ghi nhớ đăng nhập
                        </label>
                        <a href="#" onclick="switchTab('forgot')" class="forgot-password">Quên mật khẩu</a>
                    </div>

                    <button type="submit" class="btn register">Đăng nhập</button>

                    <button type="button" class="btn google" disabled>
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                        Đăng nhập bằng Google
                    </button>

                    <button type="button" class="btn admin" onclick="window.location.href='admin/'">
                        <img src="https://www.svgrepo.com/show/506501/user-circle.svg" alt="Admin">
                        Đăng nhập Admin
                    </button>
                </form>

                <!-- Forgot Password Form -->
                <form id="forgot-form" class="form <?php echo $tab === 'forgot' ? '' : 'hidden'; ?>">
                    <label>Tài khoản</label>
                    <input type="text" id="forgot-username" placeholder="Nhập tên tài khoản" required>

                    <label>Email</label>
                    <input type="email" id="forgot-email" placeholder="Nhập email đăng ký" required>

                    <button type="button" class="btn register" onclick="sendOTP()">Gửi mã OTP</button>

                    <div id="otp-section" style="display: none;">
                        <label>Mã OTP</label>
                        <div class="otp-group">
                            <input type="text" id="otp-input" placeholder="Nhập mã 6 số" maxlength="6">
                            <button type="button" id="resend-btn" disabled>Gửi lại mã sau <span id="countdown">60</span>s</button>
                        </div>
                        <button type="button" class="btn register" onclick="verifyOTP()">Xác nhận OTP</button>
                    </div>

                    <div id="password-section" style="display: none;">
                        <label>Mật khẩu mới</label>
                        <input type="password" id="new-password" placeholder="Nhập mật khẩu mới" required>

                        <label>Xác nhận mật khẩu</label>
                        <input type="password" id="confirm-password" placeholder="Nhập lại mật khẩu mới" required>

                        <button type="button" class="btn register" onclick="resetPassword()">Đổi mật khẩu</button>
                    </div>

                    <button type="button" class="btn google" onclick="switchTab('login')">
                        <i class="fas fa-arrow-left"></i>
                        Quay lại đăng nhập
                    </button>
                </form>
        </div>
    </div>
</div>

    <script>
        function switchTab(tab) {
            // Ẩn tất cả forms
            document.querySelectorAll(".form").forEach(form => form.classList.add("hidden"));
            document.querySelectorAll(".tablink").forEach(btn => btn.classList.remove("active"));
            
            // Hiện form tương ứng
            if (tab === 'register') {
                document.getElementById("register-form").classList.remove("hidden");
                document.querySelector(".tablink:nth-child(1)").classList.add("active");
            } else if (tab === 'login') {
                document.getElementById("login-form").classList.remove("hidden");
                document.querySelector(".tablink:nth-child(2)").classList.add("active");
            } else if (tab === 'forgot') {
                document.getElementById("forgot-form").classList.remove("hidden");
                document.querySelector(".tablink:nth-child(3)").classList.add("active");
                // Clear form khi chuyển đến tab forgot
                clearForgotPasswordForm();
            }
        }

        // Gửi OTP
        function sendOTP() {
            const username = document.getElementById('forgot-username').value;
            const email = document.getElementById('forgot-email').value;
            
            if (!username || !email) {
                alert('Vui lòng điền đầy đủ thông tin.');
                return;
            }

            const formData = new FormData();
            formData.append('username', username);
            formData.append('email', email);

            fetch('controller/PasswordResetController.php?action=send_otp', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    alert(data.message);
                    document.getElementById('otp-section').style.display = 'block';
                    startCountdown();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            });
        }

        // Verify OTP
        function verifyOTP() {
            const username = document.getElementById('forgot-username').value;
            const email = document.getElementById('forgot-email').value;
            const otp = document.getElementById('otp-input').value;
            
            if (!otp) {
                alert('Vui lòng nhập mã OTP.');
                return;
            }

            const formData = new FormData();
            formData.append('username', username);
            formData.append('email', email);
            formData.append('otp', otp);

            fetch('controller/PasswordResetController.php?action=verify_otp', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    document.getElementById('password-section').style.display = 'block';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            });
        }

        // Reset Password
        function resetPassword() {
            const username = document.getElementById('forgot-username').value;
            const email = document.getElementById('forgot-email').value;
            const otp = document.getElementById('otp-input').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            if (!newPassword || !confirmPassword) {
                alert('Vui lòng điền đầy đủ thông tin.');
                return;
            }

            if (newPassword !== confirmPassword) {
                alert('Mật khẩu xác nhận không khớp.');
                return;
            }

            const formData = new FormData();
            formData.append('username', username);
            formData.append('email', email);
            formData.append('otp', otp);
            formData.append('new_password', newPassword);
            formData.append('confirm_password', confirmPassword);

            fetch('controller/PasswordResetController.php?action=reset_password', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Clear tất cả form fields
                    clearForgotPasswordForm();
                    // Chuyển về tab login
                    switchTab('login');
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            });
        }

        // Function để clear form quên mật khẩu
        function clearForgotPasswordForm() {
            // Clear input fields
            document.getElementById('forgot-username').value = '';
            document.getElementById('forgot-email').value = '';
            document.getElementById('otp-input').value = '';
            document.getElementById('new-password').value = '';
            document.getElementById('confirm-password').value = '';
            
            // Ẩn các section
            document.getElementById('otp-section').style.display = 'none';
            document.getElementById('password-section').style.display = 'none';
            
            // Reset countdown
            if (window.countdownTimer) {
                clearInterval(window.countdownTimer);
            }
            const resendBtn = document.getElementById("resend-btn");
            resendBtn.textContent = "Gửi lại mã";
            resendBtn.disabled = false;
            resendBtn.classList.add("enabled");
        }

        // Countdown timer
        let countdown = 60;
        const resendBtn = document.getElementById("resend-btn");
        const countdownSpan = document.getElementById("countdown");

        function startCountdown() {
            resendBtn.disabled = true;
            resendBtn.classList.remove("enabled");
            countdown = 60;
            countdownSpan.textContent = countdown;
            window.countdownTimer = setInterval(() => {
                countdown--;
                countdownSpan.textContent = countdown;
                if (countdown <= 0) {
                    clearInterval(window.countdownTimer);
                    resendBtn.textContent = "Gửi lại mã";
                    resendBtn.disabled = false;
                    resendBtn.classList.add("enabled");
                }
            }, 1000);
        }

        resendBtn.addEventListener("click", () => {
            if (!resendBtn.disabled) {
                sendOTP();
                resendBtn.innerHTML = `Gửi lại mã sau <span id="countdown">60</span>s`;
                startCountdown();
            }
        });

        // Auto-switch tab based on URL parameter
        <?php if ($tab): ?>
        switchTab('<?php echo $tab; ?>');
        <?php endif; ?>
    </script>
</body>
</html>

