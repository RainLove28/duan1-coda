<div class="dashboard">
    <div class="page-header">
        <h2><i class="bi bi-house-door-fill"></i> Dashboard</h2>
        <p class="text-muted">Tổng quan hệ thống</p>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-primary">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="stat-content">
                <h3><?= $stats['total_products'] ?></h3>
                <p>Sản phẩm</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-success">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-content">
                <h3><?= $stats['total_customers'] ?></h3>
                <p>Khách hàng</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-warning">
                <i class="bi bi-cart-fill"></i>
            </div>
            <div class="stat-content">
                <h3><?= $stats['total_orders'] ?></h3>
                <p>Đơn hàng</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-info">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="stat-content">
                <h3><?= number_format($stats['total_revenue']) ?></h3>
                <p>Doanh thu (VNĐ)</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Biểu đồ doanh thu -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-graph-up"></i> Doanh thu theo tháng</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Sản phẩm bán chạy -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-trophy"></i> Sản phẩm bán chạy</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($topProducts)): ?>
                        <?php foreach ($topProducts as $index => $product): ?>
                            <div class="top-product-item">
                                <div class="product-rank"><?= $index + 1 ?></div>
                                <div class="product-info">
                                    <h6><?= htmlspecialchars($product['TenSanpham']) ?></h6>
                                    <p>Đã bán: <?= $product['total_sold'] ?> | 
                                       Doanh thu: <?= number_format($product['total_revenue']) ?> VNĐ</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Chưa có dữ liệu</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Đơn hàng gần đây -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-clock-history"></i> Đơn hàng gần đây</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mã ĐH</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recentOrders)): ?>
                                    <?php foreach ($recentOrders as $order): ?>
                                        <tr>
                                            <td><strong>#<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></strong></td>
                                            <td><?= htmlspecialchars($order['HoTen']) ?></td>
                                            <td><?= number_format($order['TongTien']) ?> VNĐ</td>
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
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Chưa có đơn hàng nào</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Biểu đồ doanh thu
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            <?php 
            if (!empty($monthlyRevenue)) {
                foreach ($monthlyRevenue as $data) {
                    echo '"Tháng ' . $data['month'] . '/' . $data['year'] . '",';
                }
            } else {
                echo '"Chưa có dữ liệu"';
            }
            ?>
        ],
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: [
                <?php 
                if (!empty($monthlyRevenue)) {
                    foreach ($monthlyRevenue as $data) {
                        echo $data['revenue'] . ',';
                    }
                } else {
                    echo '0';
                }
                ?>
            ],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Doanh thu 12 tháng gần đây'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value, index, values) {
                        return new Intl.NumberFormat('vi-VN').format(value) + ' VNĐ';
                    }
                }
            }
        }
    }
});
</script>

<style>
.dashboard {
    padding: 20px;
}

.page-header {
    margin-bottom: 30px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.page-header h2 {
    margin: 0;
    color: #333;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 20px;
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

.stat-content h3 {
    margin: 0 0 5px 0;
    font-size: 28px;
    font-weight: 700;
    color: #333;
}

.stat-content p {
    margin: 0;
    color: #666;
    font-size: 14px;
    font-weight: 500;
}

.bg-primary { background: #007bff !important; }
.bg-success { background: #28a745 !important; }
.bg-warning { background: #ffc107 !important; }
.bg-info { background: #17a2b8 !important; }
.bg-danger { background: #dc3545 !important; }

.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: none;
}

.card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #eee;
    padding: 15px 20px;
    border-radius: 8px 8px 0 0;
}

.card-header h5 {
    margin: 0;
    color: #333;
    font-weight: 600;
}

.card-body {
    padding: 20px;
}

.top-product-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}

.top-product-item:last-child {
    border-bottom: none;
}

.product-rank {
    width: 30px;
    height: 30px;
    background: #007bff;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
}

.product-info h6 {
    margin: 0 0 5px 0;
    font-size: 14px;
    font-weight: 600;
    color: #333;
}

.product-info p {
    margin: 0;
    font-size: 12px;
    color: #666;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
}

.col-md-8 {
    flex: 0 0 66.666667%;
    max-width: 66.666667%;
    padding: 0 15px;
}

.col-md-4 {
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
    padding: 0 15px;
}

.col-12 {
    flex: 0 0 100%;
    max-width: 100%;
    padding: 0 15px;
}

.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}

.table th,
.table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #333;
}

.table-hover tbody tr:hover {
    background: #f8f9fa;
}

.badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
    color: white;
}

.btn {
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    transition: all 0.3s;
    border: 1px solid transparent;
}

.btn-outline-primary {
    border-color: #007bff;
    color: #007bff;
    background: transparent;
}

.btn-outline-primary:hover {
    background: #007bff;
    color: white;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .col-md-8,
    .col-md-4 {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }
}
</style>
