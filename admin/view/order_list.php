<div class="order-management">
    <div class="page-header">
        <h2><i class="bi bi-cart-fill"></i> Quản lý đơn hàng</h2>
        <div class="header-actions">
            <a href="?page=export_orders" class="btn btn-success">
                <i class="bi bi-download"></i> Xuất Excel
            </a>
        </div>
    </div>

    <div class="order-stats">
        <div class="stat-card">
            <div class="stat-icon bg-primary">
                <i class="bi bi-cart"></i>
            </div>
            <div class="stat-info">
                <h3>Tổng đơn hàng</h3>
                <p><?= count($orders) ?></p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-warning">
                <i class="bi bi-clock"></i>
            </div>
            <div class="stat-info">
                <h3>Chờ xử lý</h3>
                <p><?= count(array_filter($orders, function($o) { return $o['TrangThai'] == 'pending'; })) ?></p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-success">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>Hoàn thành</h3>
                <p><?= count(array_filter($orders, function($o) { return $o['TrangThai'] == 'completed'; })) ?></p>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mã ĐH</th>
                    <th>Khách hàng</th>
                    <th>Email</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><strong>#<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></strong></td>
                            <td><?= htmlspecialchars($order['HoTen']) ?></td>
                            <td><?= htmlspecialchars($order['Email']) ?></td>
                            <td><strong><?= number_format($order['TongTien']) ?> VNĐ</strong></td>
                            <td>
                                <?php
                                $statusClass = [
                                    'pending' => 'bg-warning',
                                    'confirmed' => 'bg-info',
                                    'shipping' => 'bg-primary',
                                    'completed' => 'bg-success',
                                    'cancelled' => 'bg-danger'
                                ];
                                
                                $statusText = [
                                    'pending' => 'Chờ xử lý',
                                    'confirmed' => 'Đã xác nhận',
                                    'shipping' => 'Đang giao',
                                    'completed' => 'Hoàn thành',
                                    'cancelled' => 'Đã hủy'
                                ];
                                ?>
                                <span class="badge <?= $statusClass[$order['TrangThai']] ?>">
                                    <?= $statusText[$order['TrangThai']] ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($order['NgayTao'])) ?></td>
                            <td>
                                <a href="?page=order_detail&id=<?= $order['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Không có đơn hàng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.order-management {
    padding: 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.order-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.stat-info h3 {
    margin: 0 0 5px 0;
    font-size: 14px;
    color: #666;
    font-weight: 500;
}

.stat-info p {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #333;
}

.bg-primary { background: #007bff !important; }
.bg-warning { background: #ffc107 !important; }
.bg-success { background: #28a745 !important; }
.bg-info { background: #17a2b8 !important; }
.bg-danger { background: #dc3545 !important; }

.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table th,
.table td {
    padding: 15px 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #333;
}

.table tr:hover {
    background: #f8f9fa;
}

.badge {
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 500;
    color: white;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-success:hover {
    background: #1e7e34;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

.btn-outline-primary {
    border: 1px solid #007bff;
    color: #007bff;
    background: transparent;
}

.btn-outline-primary:hover {
    background: #007bff;
    color: white;
}

@media (max-width: 768px) {
    .order-stats {
        grid-template-columns: 1fr;
    }
    
    .page-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
}
</style>
