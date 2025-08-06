<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>

<div class="user-dashboard">
    <div class="dashboard-header">
        <h1>Xin chào, <?php echo htmlspecialchars($user['HoTen']); ?>!</h1>
        <p>Chào mừng bạn đến với trang cá nhân</p>
    </div>

    <div class="dashboard-stats">
        <div class="stat-card">
            <i class="fas fa-shopping-cart"></i>
            <h3>Đơn hàng</h3>
            <p>5 đơn hàng</p>
        </div>
        
        <div class="stat-card">
            <i class="fas fa-heart"></i>
            <h3>Yêu thích</h3>
            <p>12 sản phẩm</p>
        </div>
        
        <div class="stat-card">
            <i class="fas fa-gift"></i>
            <h3>Điểm thưởng</h3>
            <p>150 điểm</p>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="dashboard-menu">
            <h3>Quản lý tài khoản</h3>
            <ul>
                <li><a href="?page=profile"><i class="fas fa-user"></i> Thông tin cá nhân</a></li>
                <li><a href="?page=orders"><i class="fas fa-shopping-bag"></i> Đơn hàng của tôi</a></li>
                <li><a href="?page=favorites"><i class="fas fa-heart"></i> Sản phẩm yêu thích</a></li>
                <li><a href="?page=addresses"><i class="fas fa-map-marker-alt"></i> Địa chỉ giao hàng</a></li>
                <li><a href="?page=change-password"><i class="fas fa-key"></i> Đổi mật khẩu</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </div>

        <div class="dashboard-main">
            <h3>Đơn hàng gần đây</h3>
            <div class="recent-orders">
                <div class="order-item">
                    <div class="order-info">
                        <h4>Đơn hàng #001</h4>
                        <p>Son dưỡng môi + Combo chăm sóc da</p>
                        <span class="order-status processing">Đang xử lý</span>
                    </div>
                    <div class="order-total">350.000đ</div>
                </div>

                <div class="order-item">
                    <div class="order-info">
                        <h4>Đơn hàng #002</h4>
                        <p>Combo chăm sóc tóc</p>
                        <span class="order-status completed">Hoàn thành</span>
                    </div>
                    <div class="order-total">300.000đ</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.user-dashboard {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    margin-bottom: 30px;
}

.dashboard-header h1 {
    margin: 0 0 10px 0;
    font-size: 28px;
}

.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-card i {
    font-size: 40px;
    color: #667eea;
    margin-bottom: 15px;
}

.stat-card h3 {
    margin: 10px 0;
    color: #333;
}

.stat-card p {
    font-size: 24px;
    font-weight: bold;
    color: #666;
    margin: 0;
}

.dashboard-content {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 30px;
}

.dashboard-menu {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    height: fit-content;
}

.dashboard-menu h3 {
    margin: 0 0 20px 0;
    color: #333;
    border-bottom: 2px solid #eee;
    padding-bottom: 10px;
}

.dashboard-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.dashboard-menu li {
    margin-bottom: 10px;
}

.dashboard-menu a {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    text-decoration: none;
    color: #666;
    border-radius: 8px;
    transition: all 0.3s;
}

.dashboard-menu a:hover {
    background: #f8f9fa;
    color: #667eea;
}

.dashboard-menu i {
    margin-right: 10px;
    width: 20px;
}

.dashboard-main {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.recent-orders {
    margin-top: 20px;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border: 1px solid #eee;
    border-radius: 8px;
    margin-bottom: 15px;
}

.order-info h4 {
    margin: 0 0 5px 0;
    color: #333;
}

.order-info p {
    margin: 0 0 8px 0;
    color: #666;
    font-size: 14px;
}

.order-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}

.order-status.processing {
    background: #fff3cd;
    color: #856404;
}

.order-status.completed {
    background: #d1edff;
    color: #0c5460;
}

.order-total {
    font-size: 18px;
    font-weight: bold;
    color: #667eea;
}

@media (max-width: 768px) {
    .dashboard-content {
        grid-template-columns: 1fr;
    }
    
    .dashboard-stats {
        grid-template-columns: 1fr;
    }
}
</style>
