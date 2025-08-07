<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-shopping-cart"></i> Quản lý Đơn hàng</h1>
        <div class="action-buttons">
            <a href="index.php?page=export_orders" class="btn btn-success">
                <i class="fas fa-file-csv"></i> Xuất CSV
            </a>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="content-box">
        <div class="table-controls">
            <form method="GET" action="index.php" class="search-form">
                <input type="hidden" name="page" value="order_list">
                <input type="text" name="search" placeholder="Tìm kiếm theo tên khách hàng hoặc mã đơn hàng..." 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Ngày đặt</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Function để chuyển đổi trạng thái thành CSS class
                    function getStatusClass($status) {
                        $statusMap = [
                            'Chờ xác nhận' => 'chờ-xác-nhận',
                            'Đã xác nhận' => 'đã-xác-nhận', 
                            'Đang giao' => 'đang-giao',
                            'Đã giao' => 'đã-giao',
                            'Đã hủy' => 'đã-hủy'
                        ];
                        return $statusMap[$status] ?? 'unknown';
                    }
                    ?>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['MaDH']) ?></td>
                                <td><?= htmlspecialchars($order['HoTen']) ?></td>
                                <td><?= number_format($order['TongTien'], 0, ',', '.') ?>₫</td>
                                <td>
                                    <span class="status-badge status-<?= getStatusClass($order['TrangThai']) ?>">
                                        <?= htmlspecialchars($order['TrangThai']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($order['DiaChi']) ?></td>
                                <td><?= htmlspecialchars($order['SoDienThoai']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($order['NgayDat'])) ?></td>
                                <td class="action-buttons">
                                    <a href="index.php?page=order_detail&id=<?= $order['MaDH'] ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-edit btn-sm" 
                                            onclick="updateOrderStatus(<?= $order['MaDH'] ?>, '<?= htmlspecialchars($order['TrangThai']) ?>')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có đơn hàng nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Update Order Status Modal -->
<div id="updateStatusModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> Cập nhật trạng thái đơn hàng</h3>
            <span class="close" onclick="closeModal('updateStatusModal')">&times;</span>
        </div>
        <form method="POST" action="index.php?page=update_order_status">
            <input type="hidden" id="updateOrderId" name="id">
            <div class="modal-body">
                <div class="form-group">
                    <label for="orderStatus">Trạng thái đơn hàng</label>
                    <select id="orderStatus" name="status" required>
                        <option value="Chờ xác nhận">Chờ xác nhận</option>
                        <option value="Đã xác nhận">Đã xác nhận</option>
                        <option value="Đang giao">Đang giao</option>
                        <option value="Đã giao">Đã giao</option>
                        <option value="Đã hủy">Đã hủy</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('updateStatusModal')">Hủy</button>
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Override CSS for order status - Force apply */
.status-chờ-xác-nhận { 
    background: linear-gradient(135deg, #fde68a 0%, #fef3c7 100%) !important; 
    color: #92400e !important; 
    border: 1px solid #fbbf24 !important;
    font-weight: 600 !important;
    padding: 8px 12px !important;
    border-radius: 16px !important;
    font-size: 12px !important;
    display: inline-block !important;
    min-width: 90px !important;
    text-align: center !important;
    white-space: nowrap !important;
}

.status-đã-xác-nhận { 
    background: linear-gradient(135deg, #93c5fd 0%, #dbeafe 100%) !important; 
    color: #1e40af !important; 
    border: 1px solid #60a5fa !important;
    font-weight: 600 !important;
    padding: 8px 12px !important;
    border-radius: 16px !important;
    font-size: 12px !important;
    display: inline-block !important;
    min-width: 90px !important;
    text-align: center !important;
    white-space: nowrap !important;
}

.status-đang-giao { 
    background: linear-gradient(135deg, #c084fc 0%, #e9d5ff 100%) !important; 
    color: #7c3aed !important; 
    border: 1px solid #a78bfa !important;
    font-weight: 600 !important;
    padding: 8px 12px !important;
    border-radius: 16px !important;
    font-size: 12px !important;
    display: inline-block !important;
    min-width: 90px !important;
    text-align: center !important;
    white-space: nowrap !important;
}

.status-đã-giao { 
    background: linear-gradient(135deg, #86efac 0%, #d1fae5 100%) !important; 
    color: #065f46 !important; 
    border: 1px solid #4ade80 !important;
    font-weight: 600 !important;
    padding: 8px 12px !important;
    border-radius: 16px !important;
    font-size: 12px !important;
    display: inline-block !important;
    min-width: 90px !important;
    text-align: center !important;
    white-space: nowrap !important;
}

.status-đã-hủy { 
    background: linear-gradient(135deg, #fca5a5 0%, #fed7d7 100%) !important; 
    color: #9b2c2c !important; 
    border: 1px solid #f87171 !important;
    font-weight: 600 !important;
    padding: 8px 12px !important;
    border-radius: 16px !important;
    font-size: 12px !important;
    display: inline-block !important;
    min-width: 90px !important;
    text-align: center !important;
    white-space: nowrap !important;
}
</style>

<script>
function updateOrderStatus(id, currentStatus) {
    document.getElementById('updateOrderId').value = id;
    document.getElementById('orderStatus').value = currentStatus;
    openModal('updateStatusModal');
}
</script>
