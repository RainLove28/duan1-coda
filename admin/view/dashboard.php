<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card users">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3><?= $totalUsers ?></h3>
                <p>Người dùng</p>
            </div>
        </div>
        
        <div class="stat-card categories">
            <div class="stat-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-content">
                <h3><?= $totalCategories ?></h3>
                <p>Danh mục</p>
            </div>
        </div>
        
        <div class="stat-card products">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <h3><?= $totalProducts ?></h3>
                <p>Sản phẩm</p>
            </div>
        </div>
        
        <div class="stat-card orders">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <h3><?= $totalOrders ?></h3>
                <p>Đơn hàng</p>
            </div>
        </div>
        
        <div class="stat-card revenue">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <h3><?= number_format($totalRevenue, 0, ',', '.') ?>đ</h3>
                <p>Doanh thu</p>
            </div>
        </div>
        
        <div class="stat-card system">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <h3>100%</h3>
                <p>Hệ thống hoạt động</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="dashboard-grid">
        <!-- Recent Users -->
        <div class="content-box">
            <div class="box-header">
                <h3><i class="fas fa-users"></i> Người dùng mới</h3>
                <a href="index.php?page=User" class="btn btn-sm btn-primary">Xem tất cả</a>
            </div>
            <div class="box-content">
                <?php if (!empty($recentUsers)): ?>
                    <div class="list-items">
                        <?php foreach ($recentUsers as $user): ?>
                            <div class="list-item">
                                <div class="item-avatar">
                                    <?= substr($user['fullname'] ?? '', 0, 1) ?>
                                </div>
                                <div class="item-content">
                                    <div class="item-title"><?= htmlspecialchars($user['fullname'] ?? '') ?></div>
                                    <div class="item-subtitle"><?= htmlspecialchars($user['email'] ?? '') ?></div>
                                    <div class="item-time"><?= date('d/m/Y H:i', strtotime($user['created_at'] ?? '')) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center">Chưa có người dùng mới</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="content-box">
            <div class="box-header">
                <h3><i class="fas fa-box"></i> Sản phẩm mới</h3>
                <a href="index.php?page=product" class="btn btn-sm btn-primary">Xem tất cả</a>
            </div>
            <div class="box-content">
                <?php if (!empty($recentProducts)): ?>
                    <div class="list-items">
                        <?php foreach ($recentProducts as $product): ?>
                            <div class="list-item">
                                <div class="item-image">
                                    <?php if (!empty($product['HinhAnh'])): ?>
                                        <img src="../public/img/<?= $product['HinhAnh'] ?>" alt="<?= htmlspecialchars($product['TenSanPham'] ?? '') ?>">
                                    <?php else: ?>
                                        <i class="fas fa-image"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="item-content">
                                    <div class="item-title"><?= htmlspecialchars($product['TenSanPham'] ?? '') ?></div>
                                    <div class="item-subtitle"><?= htmlspecialchars($product['DanhMuc'] ?? '') ?></div>
                                    <div class="item-price"><?= number_format($product['Gia'] ?? $product['DonGia'] ?? 0) ?> đ</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center">Chưa có sản phẩm nào</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Orders -->
    <div class="content-box">
        <div class="box-header">
            <h3><i class="fas fa-shopping-cart"></i> Đơn hàng gần đây</h3>
            <a href="index.php?page=order_list" class="btn btn-sm btn-primary">Xem tất cả</a>
        </div>
        <div class="box-content">
            <?php if (!empty($recentOrders)): ?>
                <div class="table-responsive">
                    <table class="mini-table">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày đặt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td>#<?= $order['MaDH'] ?></td>
                                    <td><?= htmlspecialchars($order['TenKhachHang'] ?? 'N/A') ?></td>
                                    <td><?= number_format($order['TongTien'] ?? 0, 0, ',', '.') ?>đ</td>
                                    <td>
                                        <span class="badge badge-<?= $order['TrangThai'] === 'completed' ? 'success' : ($order['TrangThai'] === 'pending' ? 'warning' : 'danger') ?>">
                                            <?= ucfirst($order['TrangThai'] ?? 'pending') ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($order['NgayDat'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center">Chưa có đơn hàng nào</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="content-box">
        <div class="box-header">
            <h3><i class="fas fa-bolt"></i> Thao tác nhanh</h3>
        </div>
        <div class="box-content">
            <div class="quick-actions">
                <a href="index.php?page=User" class="quick-action">
                    <i class="fas fa-user-plus"></i>
                    <span>Thêm người dùng</span>
                </a>
                <a href="index.php?page=Category" class="quick-action">
                    <i class="fas fa-plus"></i>
                    <span>Thêm danh mục</span>
                </a>
                <a href="index.php?page=product" class="quick-action">
                    <i class="fas fa-box"></i>
                    <span>Thêm sản phẩm</span>
                </a>
                <a href="../" class="quick-action">
                    <i class="fas fa-globe"></i>
                    <span>Xem website</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Thống kê cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 30px 25px;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

/* Màu sắc cho từng loại card */
.stat-card.users {
    border-left-color: #2ecc71;
}

.stat-card.users .stat-icon {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
}

.stat-card.categories {
    border-left-color: #3498db;
}

.stat-card.categories .stat-icon {
    background: linear-gradient(135deg, #3498db, #74b9ff);
}

.stat-card.products {
    border-left-color: #e67e22;
}

.stat-card.products .stat-icon {
    background: linear-gradient(135deg, #e67e22, #f39c12);
}

.stat-card.system {
    border-left-color: #9b59b6;
}

.stat-card.system .stat-icon {
    background: linear-gradient(135deg, #9b59b6, #8e44ad);
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 25px;
    color: white;
    font-size: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.stat-content h3 {
    font-size: 36px;
    font-weight: 700;
    color: #2d3436;
    margin: 0 0 8px 0;
    line-height: 1;
}

.stat-content p {
    color: #636e72;
    margin: 0;
    font-size: 16px;
    font-weight: 500;
}

/* Dashboard grid layout */
.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 30px;
}

.content-box {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.box-header {
    padding: 25px 30px;
    border-bottom: 1px solid #f1f2f6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
}

.box-header h3 {
    margin: 0;
    color: #2d3436;
    font-size: 20px;
    font-weight: 600;
}

.box-header h3 i {
    margin-right: 12px;
    color: #2ecc71;
    font-size: 18px;
}

.box-content {
    padding: 25px 30px;
}

.list-items {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.list-item {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 15px;
    border-radius: 12px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.list-item:hover {
    background: #e3f2fd;
    transform: translateX(5px);
}

.item-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 18px;
    text-transform: uppercase;
    box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
}

.item-image {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    overflow: hidden;
    background: #f1f2f6;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-image i {
    color: #636e72;
    font-size: 20px;
}

.item-content {
    flex: 1;
}

.item-title {
    font-weight: 600;
    color: #2d3436;
    margin-bottom: 4px;
    font-size: 16px;
}

.item-subtitle {
    color: #2ecc71;
    font-size: 14px;
    margin-bottom: 4px;
    font-weight: 500;
}

.item-time {
    color: #b2bec3;
    font-size: 13px;
}

.item-price {
    color: #00b894;
    font-size: 14px;
    font-weight: 600;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.quick-action {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 25px 20px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: 15px;
    text-decoration: none;
    color: #2d3436;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.quick-action:hover {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: white;
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(46, 204, 113, 0.3);
    border-color: #2ecc71;
}

.quick-action i {
    font-size: 28px;
    margin-bottom: 15px;
    transition: transform 0.3s ease;
}

.quick-action:hover i {
    transform: scale(1.1);
}

.quick-action span {
    font-size: 15px;
    font-weight: 600;
    text-align: center;
}

/* Button styling */
.btn-sm {
    padding: 8px 16px;
    font-size: 13px;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #74b9ff, #0984e3);
    color: white;
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0984e3, #2d3436);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(116, 185, 255, 0.4);
}

/* Mini Table */
.mini-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.mini-table th,
.mini-table td {
    padding: 8px 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.mini-table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #333;
}

.mini-table td {
    color: #666;
}

/* Badges */
.badge {
    padding: 4px 8px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-success {
    background: #d4edda;
    color: #155724;
}

.badge-warning {
    background: #fff3cd;
    color: #856404;
}

.badge-danger {
    background: #f8d7da;
    color: #721c24;
}

/* Responsive */
@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .quick-actions {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        padding: 20px 15px;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
        margin-right: 15px;
    }
    
    .stat-content h3 {
        font-size: 24px;
    }
}
</style>
</div>
