<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-file-invoice"></i> Chi tiết đơn hàng #<?= $order['MaDH'] ?></h1>
        <div class="action-buttons">
            <a href="index.php?page=order_list" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <button class="btn btn-success" onclick="updateOrderStatus(<?= $order['MaDH'] ?>, '<?= htmlspecialchars($order['TrangThai']) ?>')">
                <i class="fas fa-edit"></i> Cập nhật trạng thái
            </button>
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

    <?php if ($order): ?>
        <div class="row">
            <!-- Order Information -->
            <div class="col-md-6">
                <div class="content-box">
                    <div class="box-header">
                        <h3><i class="fas fa-info-circle"></i> Thông tin đơn hàng</h3>
                    </div>
                    <div class="box-content">
                        <div class="info-row">
                            <strong>Mã đơn hàng:</strong> #<?= $order['MaDH'] ?>
                        </div>
                        <div class="info-row">
                            <strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['NgayDat'])) ?>
                        </div>
                        <div class="info-row">
                            <strong>Trạng thái:</strong>
                            <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $order['TrangThai'])) ?>">
                                <?= htmlspecialchars($order['TrangThai']) ?>
                            </span>
                        </div>
                        <div class="info-row">
                            <strong>Tổng tiền:</strong> 
                            <span class="total-amount"><?= number_format($order['TongTien'], 0, ',', '.') ?>₫</span>
                        </div>
                        <?php if (!empty($order['GhiChu'])): ?>
                        <div class="info-row">
                            <strong>Ghi chú:</strong> <?= htmlspecialchars($order['GhiChu']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="col-md-6">
                <div class="content-box">
                    <div class="box-header">
                        <h3><i class="fas fa-user"></i> Thông tin khách hàng</h3>
                    </div>
                    <div class="box-content">
                        <div class="info-row">
                            <strong>Họ tên:</strong> <?= htmlspecialchars($order['HoTen']) ?>
                        </div>
                        <div class="info-row">
                            <strong>Email:</strong> <?= htmlspecialchars($order['Email']) ?>
                        </div>
                        <div class="info-row">
                            <strong>Số điện thoại:</strong> <?= htmlspecialchars($order['SoDienThoai']) ?>
                        </div>
                        <div class="info-row">
                            <strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($order['DiaChi']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="content-box">
            <div class="box-header">
                <h3><i class="fas fa-list"></i> Chi tiết sản phẩm</h3>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orderDetails)): ?>
                            <?php 
                            $subtotal = 0;
                            foreach ($orderDetails as $detail): 
                                $itemTotal = $detail['DonGia'] * $detail['SoLuong'];
                                $subtotal += $itemTotal;
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($detail['TenSP']) ?></td>
                                    <td><?= number_format($detail['DonGia'], 0, ',', '.') ?>₫</td>
                                    <td><?= $detail['SoLuong'] ?></td>
                                    <td><?= number_format($itemTotal, 0, ',', '.') ?>₫</td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="total-row">
                                <td colspan="3"><strong>Tổng cộng:</strong></td>
                                <td><strong><?= number_format($subtotal, 0, ',', '.') ?>₫</strong></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Không có sản phẩm nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> Không tìm thấy đơn hàng!
        </div>
    <?php endif; ?>
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
.row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.col-md-6 {
    flex: 1;
}

.box-header {
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
    background: #f8f9fa;
}

.box-header h3 {
    margin: 0;
    color: #333;
    font-size: 16px;
}

.box-content {
    padding: 20px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-row:last-child {
    border-bottom: none;
}

.total-amount {
    font-size: 18px;
    font-weight: bold;
    color: #2ecc71;
}

.total-row {
    background: #f8f9fa;
    font-weight: bold;
}

@media (max-width: 768px) {
    .row {
        flex-direction: column;
    }
    
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
}
</style>

<script>
function updateOrderStatus(id, currentStatus) {
    document.getElementById('updateOrderId').value = id;
    document.getElementById('orderStatus').value = currentStatus;
    openModal('updateStatusModal');
}
</script>
