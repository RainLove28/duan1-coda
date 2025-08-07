<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../model/database.php';
require_once __DIR__ . '/../model/auth.php';

// Khởi tạo kết nối cơ sở dữ liệu
$db = Database::getInstance();

// Xác định tab hiện tại (đăng nhập hoặc đăng ký) dựa trên tham số URL
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
            $message = "Hello from PHP!";
            echo "<script>console.log(" . json_encode($message) . ");</script>";
            header('Location: index.php?page=home');
            exit;
        } else {
            $errors[] = 'Tài khoản hoặc mật khẩu không đúng.';
        }
    }
}

// Xử lý gửi lại OTP
if (isset($_POST['resend_otp'])) {
    $_SESSION['otp'] = rand(100000, 999999);
    $success = 'Mã OTP mới đã được gửi!';
}
?>

<div class="container">
    <div class="left-panel">
        <div class="logo"> 
            <img src="/New folder/duan1-coda/public/img/logo.png" alt="">
        </div>
    </div>
    <div class="right-panel">
        <div class="form-box">
            <div class="brand-name">Aura Beauty</div>          
            <div class="tab">
                <a href="?page=login.php&tab=register" class="tablink <?php echo $tab === 'register' ? 'active' : ''; ?>">Đăng ký</a>
                <a href="?page=login.php&tab=login" class="tablink <?php echo $tab === 'login' ? 'active' : ''; ?>">Đăng nhập</a>
            </div>

            <!-- Hiển thị thông báo lỗi -->
            <?php if (!empty($errors)): ?>
                <div style="color: red; margin-bottom: 10px;">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <!-- Hiển thị thông báo thành công -->
            <?php if (!empty($success)): ?>
                <div style="color: green; margin-bottom: 10px;">
                    <p><?php echo $success; ?></p>
                </div>
            <?php endif; ?>

            <!-- Form đăng ký -->
            <?php if ($tab === 'register'): ?>
                <form class="form" method="POST" action="?page=login.php&tab=register">
                    <label for="username">Tài khoản</label>
                    <input type="text" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
                    <label for="password">Mật khẩu</label>
                    <input type="password" name="password" required>
                    <div class="checkbox">
                        <input type="checkbox" name="terms" required>
                        <span>Chấp nhận điều khoản</span>
                    </div>
                    <button type="submit" class="btn register">Đăng ký</button>
                    <button type="button" class="btn google" disabled>
                        <img src="https://img.icons8.com/color/20/000000/google-logo.png" alt="Google">
                        Đăng nhập bằng Google
                    </button>
                </form>
            <!-- Form đăng nhập -->
            <?php else: ?>
                <form class="form" method="POST" action="?page=login.php&tab=login">
                    <label for="username">Tài khoản</label>
                    <input type="text" name="username" value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>" >
                    <label for="password">Mật khẩu</label>
                    <input type="password" name="password" >
                    <button type="submit" class="btn login">Đăng nhập</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

