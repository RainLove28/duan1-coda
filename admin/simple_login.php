<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Aura Beauty</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #044406ff;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h1 {
            color: #333;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
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
        .demo-accounts {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .demo-accounts h4 {
            color: #333;
            margin-bottom: 10px;
        }
        .demo-accounts p {
            margin: 5px 0;
            font-size: 14px;
        }
        .quick-login {
            margin-top: 15px;
        }
        .quick-login button {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1> Aura Beauty</h1>
         
        </div>

        <?php
        session_start();
        $error = '';
        $success = '';

        // Kiểm tra thông báo logout
        if (isset($_GET['message']) && $_GET['message'] === 'logout_success') {
            $success = 'Đã đăng xuất thành công!';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            if (!empty($username) && !empty($password)) {
                try {
                    require_once '../site/model/config.php';
                    require_once '../site/model/database copy.php';
                    
                    $db = Database::getInstance();
                    
                    // Tìm user với username và password
                    $query = "SELECT * FROM taikhoan WHERE TenDangNhap = ? AND MatKhau = ? AND TrangThai = 'Hoạt động'";
                    $user = $db->getOne($query, [$username, $password]);
                    
                    if ($user) {
                        // Lưu thông tin user vào session
                        $_SESSION['user'] = [
                            'MaTK' => $user['MaTK'] ?? $user['ID'],
                            'TenDangNhap' => $user['TenDangNhap'],
                            'VaiTro' => $user['VaiTro'],
                            'HoTen' => $user['HoTen'],
                            'Email' => $user['Email']
                        ];
                        
                        // Phân quyền: Admin vào admin cũ, User vào trang chủ
                        if ($user['VaiTro'] == 1) {
                            // Admin - vào admin cũ (đầy đủ chức năng)
                            header('Location: index.php');
                            exit;
                        } else {
                            // User - chuyển về trang chủ
                            header('Location: ../index.php');
                            exit;
                        }
                    } else {
                        $error = 'Tài khoản không tồn tại, sai mật khẩu hoặc đã bị khóa!';
                    }
                } catch (Exception $e) {
                    $error = 'Lỗi kết nối database: ' . $e->getMessage();
                }
            } else {
                $error = 'Vui lòng nhập đầy đủ thông tin!';
            }
        }
        ?>

        <?php if ($error): ?>
            <div class="alert alert-error">
                ❌ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                ✅ <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" 
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" 
                       placeholder="Nhập tên đăng nhập" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" 
                       placeholder="Nhập mật khẩu" required>
            </div>

            <button type="submit" class="login-btn">
                🚀 Đăng Nhập
            </button>
        </form>

        <!-- <div class="demo-accounts">
            <h4>📋 Tài khoản demo:</h4>
            <?php
            try {
                require_once '../site/model/config.php';
                require_once '../site/model/database copy.php';
                
                $db = Database::getInstance();
                $accounts = $db->getAll("SELECT TenDangNhap, MatKhau, HoTen, VaiTro FROM taikhoan WHERE TrangThai = 1 ORDER BY VaiTro DESC LIMIT 5");
                
                if ($accounts) {
                    foreach ($accounts as $acc) {
                        $role = $acc['VaiTro'] == 1 ? 'Admin' : 'User';
                        $color = $acc['VaiTro'] == 1 ? 'color: red; font-weight: bold;' : 'color: blue;';
                        echo "<p><strong>{$acc['TenDangNhap']}</strong> / {$acc['MatKhau']} (<span style='$color'>$role</span>)</p>";
                    }
                    
                    echo "<div class='quick-login'>";
                    echo "<p><strong>Quick Login:</strong></p>";
                    foreach ($accounts as $acc) {
                        if ($acc['VaiTro'] == 1) {
                            echo "<button onclick='quickLogin(\"{$acc['TenDangNhap']}\", \"{$acc['MatKhau']}\")'>Login as {$acc['TenDangNhap']}</button>";
                        }
                    }
                    echo "</div>";
                } else {
                    echo "<p>Không có tài khoản nào!</p>";
                }
            } catch (Exception $e) {
                echo "<p>Lỗi: " . $e->getMessage() . "</p>";
            }
            ?>
        </div> -->

        <p style="text-align: center; margin-top: 20px;">
            <a href="register.php" style="color: #667eea; text-decoration: none;">
                📝 Chưa có tài khoản? Đăng ký ngay
            </a>
        </p>

        <!-- Tùy chọn Admin
        <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; text-align: center;">
            <h4 style="margin-bottom: 10px; color: #333;">🔧 Tùy chọn Admin Panel</h4>
            <p style="margin-bottom: 15px; color: #666; font-size: 14px;">
                ✅ <strong>Đăng nhập ở trên sẽ vào Admin Cũ (đầy đủ chức năng)</strong><br>
                Hoặc bạn có thể chọn phiên bản khác:
            </p>
            <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                <a href="login.php" style="background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-size: 14px;">
                    🛠️ Admin Cũ (Form khác)
                </a>
                <a href="admin_panel.php" style="background: #667eea; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-size: 14px;">
                    ✨ Admin Mới (Giao diện đẹp)
                </a>
            </div>
        </div>
    </div> -->

    <script>
        function quickLogin(username, password) {
            document.getElementById('username').value = username;
            document.getElementById('password').value = password;
        }
    </script>
</body>
</html>
