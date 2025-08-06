<?php
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] != 1) {
    header('Location: simple_login.php');
    exit;
}

$page = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - CODAA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
            color: #333;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h2 {
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 14px;
            opacity: 0.8;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            padding-left: 30px;
        }

        .sidebar-menu i {
            margin-right: 15px;
            font-size: 16px;
            width: 20px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 20px;
        }

        .top-bar {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .user-info {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        .content-area {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .dashboard-card.users {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }

        .dashboard-card.products {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
        }

        .dashboard-card.orders {
            background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
        }

        .dashboard-card i {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .dashboard-card h3 {
            margin-bottom: 10px;
            font-size: 24px;
        }

        .dashboard-card p {
            font-size: 16px;
            opacity: 0.9;
        }

        .quick-actions {
            margin-top: 30px;
        }

        .quick-actions h3 {
            margin-bottom: 20px;
            color: #333;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .action-btn {
            background: #667eea;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s ease;
        }

        .action-btn:hover {
            background: #5a6fd8;
        }

        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .welcome-section h1 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>🎛️ CODAA</h2>
                <p>Admin Panel</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="?page=dashboard" class="<?= $page == 'dashboard' ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a></li>
                <li><a href="?page=users" class="<?= $page == 'users' ? 'active' : '' ?>">
                    <i class="fas fa-users"></i> Quản lý Users
                </a></li>
                <li><a href="?page=products" class="<?= $page == 'products' ? 'active' : '' ?>">
                    <i class="fas fa-box"></i> Quản lý Products
                </a></li>
                <li><a href="?page=orders" class="<?= $page == 'orders' ? 'active' : '' ?>">
                    <i class="fas fa-shopping-cart"></i> Quản lý Orders
                </a></li>
                <li><a href="?page=categories" class="<?= $page == 'categories' ? 'active' : '' ?>">
                    <i class="fas fa-tags"></i> Quản lý Categories
                </a></li>
                <li><a href="?page=comments" class="<?= $page == 'comments' ? 'active' : '' ?>">
                    <i class="fas fa-comments"></i> Quản lý Comments
                </a></li>
                <li><a href="?page=inventory" class="<?= $page == 'inventory' ? 'active' : '' ?>">
                    <i class="fas fa-warehouse"></i> Quản lý Kho
                </a></li>
                <li><a href="?page=statistics" class="<?= $page == 'statistics' ? 'active' : '' ?>">
                    <i class="fas fa-chart-bar"></i> Thống kê
                </a></li>
                <li style="border-top: 2px solid rgba(255,255,255,0.2); margin-top: 10px; padding-top: 10px;">
                    <a href="index.php" style="background: rgba(231,76,60,0.2);">
                        <i class="fas fa-cogs"></i> Admin Cũ (Full Features)
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <h2>
                    <?php
                    $titles = [
                        'dashboard' => '📊 Dashboard',
                        'users' => '👥 Quản lý Users',
                        'products' => '📦 Quản lý Products',
                        'orders' => '🛒 Quản lý Orders',
                        'categories' => '📂 Quản lý Categories',
                        'comments' => '💬 Quản lý Comments',
                        'inventory' => '📦 Quản lý Kho',
                        'statistics' => '📈 Thống kê'
                    ];
                    echo $titles[$page] ?? '📊 Dashboard';
                    ?>
                </h2>
                <div class="user-info">
                    <span>👋 Xin chào, <strong><?= $_SESSION['user']['HoTen'] ?></strong></span>
                    <a href="logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <?php if ($page == 'dashboard'): ?>
                    <!-- Dashboard Content -->
                    <div class="welcome-section">
                        <h1>🎉 Chào mừng đến với Admin Panel!</h1>
                        <p>Quản lý toàn bộ hệ thống CODAA từ đây</p>
                    </div>

                    <div class="dashboard-cards">
                        <div class="dashboard-card users" onclick="location.href='?page=users'">
                            <i class="fas fa-users"></i>
                            <h3>Users</h3>
                            <p>Quản lý tài khoản</p>
                        </div>
                        <div class="dashboard-card products" onclick="location.href='?page=products'">
                            <i class="fas fa-box"></i>
                            <h3>Products</h3>
                            <p>Quản lý sản phẩm</p>
                        </div>
                        <div class="dashboard-card orders" onclick="location.href='?page=orders'">
                            <i class="fas fa-shopping-cart"></i>
                            <h3>Orders</h3>
                            <p>Quản lý đơn hàng</p>
                        </div>
                        <div class="dashboard-card" onclick="location.href='?page=categories'">
                            <i class="fas fa-tags"></i>
                            <h3>Categories</h3>
                            <p>Quản lý danh mục</p>
                        </div>
                    </div>

                    <div class="quick-actions">
                        <h3>⚡ Thao tác nhanh</h3>
                        <div class="action-buttons">
                            <a href="index.php" class="action-btn" style="background: #e74c3c;">
                                <i class="fas fa-cogs"></i> Vào Admin Cũ (Đầy đủ chức năng)
                            </a>
                            <a href="?page=users&action=add" class="action-btn">
                                <i class="fas fa-user-plus"></i> Thêm User
                            </a>
                            <a href="?page=products&action=add" class="action-btn">
                                <i class="fas fa-plus"></i> Thêm Product
                            </a>
                            <a href="?page=categories&action=add" class="action-btn">
                                <i class="fas fa-tag"></i> Thêm Category
                            </a>
                            <a href="?page=statistics" class="action-btn">
                                <i class="fas fa-chart-line"></i> Xem Thống kê
                            </a>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- Other Pages Content -->
                    <div style="text-align: center; padding: 50px; background: #f8f9fa; border-radius: 10px;">
                        <h2>🚧 Trang "<?= ucfirst($page) ?>" đang được phát triển</h2>
                        <p style="margin: 20px 0; color: #666;">Chức năng này sẽ được hoàn thiện trong thời gian tới.</p>
                        <a href="?page=dashboard" class="action-btn">
                            <i class="fas fa-home"></i> Về Dashboard
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Highlight active menu item
            const currentPage = '<?= $page ?>';
            const menuItems = document.querySelectorAll('.sidebar-menu a');
            
            menuItems.forEach(item => {
                if (item.href.includes('page=' + currentPage)) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
