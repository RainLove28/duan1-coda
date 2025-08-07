<?php
session_start();
require_once '../site/model/config.php';
require_once '../site/model/database copy.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        try {
            $db = Database::getInstance();
            
            // Tìm tài khoản với username và password (không phân biệt vai trò)
            $query = "SELECT * FROM taikhoan WHERE TenDangNhap = ? AND MatKhau = ? AND TrangThai = 1";
            $user = $db->getOne($query, [$username, $password]);
            
            if ($user) {
                $_SESSION['user'] = [
                    'MaTK' => $user['MaTK'],
                    'TenDangNhap' => $user['TenDangNhap'],
                    'VaiTro' => $user['VaiTro'],
                    'HoTen' => $user['HoTen'],
                    'Email' => $user['Email']
                ];
                
                // Phân quyền: Admin vào admin panel, User vào trang chủ
                if ($user['VaiTro'] == 1) {
                    // Admin - vào admin panel
                    header('Location: index.php');
                } else {
                    // User - chuyển về trang chủ
                    header('Location: ../index.php');
                }
                exit;
            } else {
                $error = 'Tài khoản không tồn tại, sai mật khẩu hoặc đã bị khóa!';
            }
        } catch (Exception $e) {
            $error = 'Lỗi kết nối database: ' . $e->getMessage();
        }
    } else {
        $error = 'Vui lòng nhập đầy đủ thông tin!';
    }
} else {
    $error = '';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Hệ Thống - Aura Beauty</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #4a7c23;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4a7c23;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon input {
            padding-left: 45px;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #4a7c23 0%, #68b236 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .demo-info {
            margin-top: 20px;
            padding: 15px;
            background: #f0f9ff;
            border-radius: 10px;
            font-size: 14px;
            color: #0369a1;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">Aura Beauty</div>
        <div class="subtitle">Đăng nhập với bất kỳ tài khoản nào</div>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-triangle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>

            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Đăng nhập
            </button>
        </form>

        <div class="register-link" style="text-align: center; margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 8px;">
            <p style="color: #666; margin-bottom: 8px;">Chưa có tài khoản?</p>
            <a href="register.php" style="color: #007bff; text-decoration: none; font-weight: 600; font-size: 16px;">
                <i class="fas fa-user-plus"></i> Đăng ký ngay
            </a>
        </div>

        <div class="demo-info">
            <strong>Tài khoản khả dụng:</strong><br>
            <?php
            try {
                $db = Database::getInstance();
                $accounts = $db->getAll("SELECT TenDangNhap, MatKhau, HoTen, VaiTro FROM taikhoan WHERE TrangThai = 1 ORDER BY VaiTro DESC");
                
                if (empty($accounts)) {
                    echo "Không có tài khoản nào hoạt động!";
                } else {
                    foreach ($accounts as $acc) {
                        $role = $acc['VaiTro'] == 1 ? 'Admin' : 'User';
                        echo "<strong>{$acc['TenDangNhap']}</strong> / {$acc['MatKhau']} ({$role})<br>";
                    }
                }
            } catch (Exception $e) {
                echo "Username: admin<br>Password: admin123";
            }
            ?>
        </div>
    </div>
</body>
</html>
