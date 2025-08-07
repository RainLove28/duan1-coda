<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug: Kiểm tra session
error_log("Session data: " . print_r($_SESSION, true));

// Tạm thời bỏ qua session check để test
/*
// Kiểm tra user đã đăng nhập chưa
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    // Nếu chưa đăng nhập, redirect về login
    header('Location: index.php?page=login.php');
    exit;
}

// Kiểm tra user_id có tồn tại không
if (!isset($_SESSION['user_id'])) {
    error_log("User ID not found in session");
    header('Location: index.php?page=login.php');
    exit;
}
*/

// Tạm thời set user_id = 1 để test
$user_id = 1;

require_once __DIR__ . '/../model/database.php';

$db = Database::getInstance();

// Lấy thông tin user
$sql = "SELECT * FROM users WHERE id = ?";
$user = $db->getOne($sql, [$user_id]);

// Debug: Kiểm tra user data
error_log("User data: " . print_r($user, true));

if (!$user) {
    error_log("User not found in database");
    // Tạo user test nếu không có
    $user = [
        'id' => 1,
        'username' => 'admin',
        'fullname' => 'Administrator',
        'email' => 'ikuysle@outlook.com',
        'mobile' => '(+84) 374 411 689',
        'address' => '340/5c, Đường Nguyễn Bình, ...',
        'gender' => 'Nam'
    ];
}

$message = '';
$message_type = '';

// Xử lý form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $mobile = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Validation
    if (empty($fullname) || empty($email)) {
        $message = 'Vui lòng điền đầy đủ thông tin bắt buộc!';
        $message_type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Email không hợp lệ!';
        $message_type = 'error';
    } else {
        // Kiểm tra email có bị trùng không (trừ user hiện tại)
        $sql_check = "SELECT id FROM users WHERE email = ? AND id != ?";
        $existing_user = $db->getOne($sql_check, [$email, $user_id]);
        
        if ($existing_user) {
            $message = 'Email đã được sử dụng bởi tài khoản khác!';
            $message_type = 'error';
        } else {
            // Update thông tin user
            $sql_update = "UPDATE users SET fullname = ?, email = ?, mobile = ?, address = ?, gender = ? WHERE id = ?";
            if ($db->execute($sql_update, [$fullname, $email, $mobile, $address, $gender, $user_id])) {
                $message = 'Cập nhật thông tin thành công!';
                $message_type = 'success';
                
                // Refresh user data
                $user = $db->getOne($sql, [$user_id]);
            } else {
                $message = 'Có lỗi xảy ra. Vui lòng thử lại!';
                $message_type = 'error';
            }
        }
    }
}
?>

<style>
/* Reset styles cho user profile để tránh conflict */
.user-profile-container * {
    box-sizing: border-box;
}

.user-profile-container {
    min-height: 100vh;
    background-color: #f5f5f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
    line-height: 1.6;
}

/* Header cho profile */
.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.header-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.back-btn {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    transition: opacity 0.3s;
}

.back-btn:hover {
    opacity: 0.8;
}

.header-container h1 {
    font-size: 1.8rem;
    font-weight: 600;
}

/* Main layout */
.account-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 2rem;
    min-height: calc(100vh - 200px);
}

/* Sidebar */
.sidebar {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    height: fit-content;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #eee;
    margin-bottom: 1.5rem;
}

.user-info img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.user-info span {
    font-weight: 600;
    color: #333;
}

.sidebar ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.sidebar ul li {
    margin-bottom: 0.5rem;
}

.sidebar ul li a {
    display: block;
    padding: 0.75rem 1rem;
    color: #666;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s;
}

.sidebar ul li a:hover,
.sidebar ul li a.active {
    background-color: #667eea;
    color: white;
}

/* Main content */
main {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.profile-title {
    font-size: 1.8rem;
    color: #333;
    margin-bottom: 2rem;
    border-bottom: 2px solid #667eea;
    padding-bottom: 0.5rem;
}

/* Messages */
.message {
    padding: 1rem;
    border-radius: 5px;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Form styles */
.profile-form {
    max-width: 600px;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e1e5e9;
    border-radius: 5px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #667eea;
}

.form-group input[readonly] {
    background-color: #f8f9fa;
    color: #6c757d;
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

/* Radio group */
.radio-group {
    display: flex;
    gap: 2rem;
    align-items: center;
}

.radio-group input[type="radio"] {
    width: auto;
    margin-right: 0.5rem;
}

.radio-group label {
    display: inline;
    margin-bottom: 0;
    font-weight: normal;
}

/* Form actions */
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #eee;
}

.save-btn,
.cancel-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
}

.save-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.save-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.cancel-btn {
    background-color: #6c757d;
    color: white;
}

.cancel-btn:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
}

/* Responsive design */
@media (max-width: 768px) {
    .account-section {
        grid-template-columns: 1fr;
        gap: 1rem;
        padding: 0 1rem;
    }
    
    .header-container {
        padding: 0 1rem;
        flex-direction: column;
        gap: 1rem;
    }
    
    .sidebar {
        order: 2;
    }
    
    main {
        order: 1;
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .radio-group {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
}

@media (max-width: 480px) {
    .header-container h1 {
        font-size: 1.5rem;
    }
    
    .profile-title {
        font-size: 1.5rem;
    }
    
    main {
        padding: 1rem;
    }
    
    .sidebar {
        padding: 1rem;
    }
}
</style>

<div class="user-profile-container">
    <header class="profile-header">
        <div class="header-container">
            <a href="index.php?page=home" class="back-btn">
                <i class="fas fa-arrow-left"></i> Quay lại trang chủ
            </a>
            <h1>Aura Beauty</h1>
        </div>
    </header>
    
    <section class="account-section">
        <aside class="sidebar">
            <div class="user-info">
                <img src="https://via.placeholder.com/50" alt="User Avatar">
                <span><?php echo htmlspecialchars($user['username']); ?></span>
            </div>
            <ul>
                <li><a href="#" class="active">Hồ Sơ</a></li>
                <li><a href="#">Thông Báo</a></li>
                <li><a href="#">Đơn Mua Hàng</a></li>
                <li><a href="#">Địa Chỉ</a></li>
                <li><a href="#">Ngân Hàng</a></li>
                <li><a href="#">Cài Đặt Thông Báo</a></li>
                <li><a href="#">Nhật Ký Thiệp Lì Xì</a></li>
                <li><a href="index.php?page=logout">Thoát</a></li>
            </ul>
        </aside>
        
        <main>
            <h2 class="profile-title">Hồ Sơ Của Tôi</h2>
            
            <?php if ($message): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form id="profileForm" class="profile-form" method="POST">
                <div class="form-group">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label for="fullname">Họ và Tên *</label>
                    <input type="text" id="fullname" name="fullname" 
                           value="<?php echo htmlspecialchars($user['fullname'] ?? ''); ?>" 
                           placeholder="Họ và Tên" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" 
                           placeholder="email@example.com" required>
                </div>
                
                <div class="form-group">
                    <label for="mobile">Số điện thoại</label>
                    <input type="tel" id="mobile" name="mobile" 
                           value="<?php echo htmlspecialchars($user['mobile'] ?? ''); ?>" 
                           placeholder="(+84) 374 411 689">
                </div>
                
                <div class="form-group">
                    <label>Giới tính</label>
                    <div class="radio-group">
                        <input type="radio" name="gender" value="Nam" 
                               <?php echo ($user['gender'] ?? '') === 'Nam' ? 'checked' : ''; ?>> Nam
                        <input type="radio" name="gender" value="Nữ" 
                               <?php echo ($user['gender'] ?? '') === 'Nữ' ? 'checked' : ''; ?>> Nữ
                        <input type="radio" name="gender" value="Khác" 
                               <?php echo ($user['gender'] ?? '') === 'Khác' ? 'checked' : ''; ?>> Khác
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <textarea id="address" name="address" placeholder="340/5c, Đường Nguyễn Bỉnh, ..."><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" id="saveBtn" class="save-btn">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                    <a href="index.php?page=home" class="cancel-btn">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </main>
    </section>
</div>

<script>
// User Profile Management JavaScript - Inline để tránh conflict
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide messages after 5 seconds
    const messages = document.querySelectorAll('.message');
    messages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => {
                message.style.display = 'none';
            }, 300);
        }, 5000);
    });

    // Form validation
    const form = document.getElementById('profileForm');
    const saveBtn = document.getElementById('saveBtn');

    if (form) {
        form.addEventListener('submit', function(e) {
            const fullname = document.getElementById('fullname').value.trim();
            const email = document.getElementById('email').value.trim();
            const mobile = document.getElementById('mobile').value.trim();

            // Reset previous error states
            clearErrors();

            let hasErrors = false;

            // Validate fullname
            if (!fullname) {
                showError('fullname', 'Họ và tên là bắt buộc');
                hasErrors = true;
            } else if (fullname.length < 2) {
                showError('fullname', 'Họ và tên phải có ít nhất 2 ký tự');
                hasErrors = true;
            }

            // Validate email
            if (!email) {
                showError('email', 'Email là bắt buộc');
                hasErrors = true;
            } else if (!isValidEmail(email)) {
                showError('email', 'Email không hợp lệ');
                hasErrors = true;
            }

            // Validate mobile (optional but if provided, must be valid)
            if (mobile && !isValidPhone(mobile)) {
                showError('mobile', 'Số điện thoại không hợp lệ');
                hasErrors = true;
            }

            if (hasErrors) {
                e.preventDefault();
                return false;
            }

            // Show loading state
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lưu...';
        });
    }

    // Real-time validation
    const inputs = document.querySelectorAll('.form-group input, .form-group textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            // Clear error when user starts typing
            clearFieldError(this);
        });
    });

    // Sidebar navigation
    const sidebarLinks = document.querySelectorAll('.sidebar ul li a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove active class from all links
            sidebarLinks.forEach(l => l.classList.remove('active'));
            // Add active class to clicked link
            this.classList.add('active');
        });
    });
});

// Helper functions
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    // Accept Vietnamese phone numbers
    const phoneRegex = /^(\+84|84|0)[0-9]{9}$/;
    return phoneRegex.test(phone.replace(/\s/g, ''));
}

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name || field.id;

    clearFieldError(field);

    switch (fieldName) {
        case 'fullname':
            if (!value) {
                showFieldError(field, 'Họ và tên là bắt buộc');
            } else if (value.length < 2) {
                showFieldError(field, 'Họ và tên phải có ít nhất 2 ký tự');
            }
            break;

        case 'email':
            if (!value) {
                showFieldError(field, 'Email là bắt buộc');
            } else if (!isValidEmail(value)) {
                showFieldError(field, 'Email không hợp lệ');
            }
            break;

        case 'mobile':
            if (value && !isValidPhone(value)) {
                showFieldError(field, 'Số điện thoại không hợp lệ');
            }
            break;
    }
}

function showFieldError(field, message) {
    const formGroup = field.closest('.form-group');
    const existingError = formGroup.querySelector('.field-error');
    
    if (!existingError) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.color = '#dc3545';
        errorDiv.style.fontSize = '0.875rem';
        errorDiv.style.marginTop = '0.25rem';
        errorDiv.textContent = message;
        
        formGroup.appendChild(errorDiv);
    }
    
    field.style.borderColor = '#dc3545';
}

function clearFieldError(field) {
    const formGroup = field.closest('.form-group');
    const errorDiv = formGroup.querySelector('.field-error');
    
    if (errorDiv) {
        errorDiv.remove();
    }
    
    field.style.borderColor = '#e1e5e9';
}

function clearErrors() {
    const errorDivs = document.querySelectorAll('.field-error');
    errorDivs.forEach(div => div.remove());
    
    const inputs = document.querySelectorAll('.form-group input, .form-group textarea');
    inputs.forEach(input => {
        input.style.borderColor = '#e1e5e9';
    });
}

function showError(fieldName, message) {
    const field = document.getElementById(fieldName);
    if (field) {
        showFieldError(field, message);
    }
}
</script>
