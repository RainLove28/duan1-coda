<div class="order-detail">
    <div class="page-header">
        <div>
            <h2><i class="bi bi-receipt"></i> Chi tiết đơn hàng #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></h2>
            <p class="text-muted">Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['NgayTao'])) ?></p>
        </div>
        <a href="?page=order_list" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            Cập nhật trạng thái đơn hàng thành công!
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <!-- Thông tin đơn hàng -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="bi bi-info-circle"></i> Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['HoTen']) ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($order['Email']) ?></p>
                            <p><strong>SĐT:</strong> <?= htmlspecialchars($order['SoDienThoai']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Địa chỉ giao hàng:</strong><br>
                               <?= nl2br(htmlspecialchars($order['DiaChi'])) ?></p>
                        </div>
                    </div>
                    <?php if (!empty($order['GhiChu'])): ?>
                    <div class="mt-3">
                        <p><strong>Ghi chú:</strong><br>
                           <?= nl2br(htmlspecialchars($order['GhiChu'])) ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Chi tiết sản phẩm -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-bag"></i> Chi tiết sản phẩm</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Hình ảnh</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $tongTien = 0;
                                foreach ($orderDetails as $detail): 
                                    $thanhTien = $detail['Gia'] * $detail['SoLuong'];
                                    $tongTien += $thanhTien;
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($detail['TenSanpham']) ?></td>
                                        <td>
                                            <img src="../public/img/<?= $detail['HinhAnh'] ?>" 
                                                 alt="<?= htmlspecialchars($detail['TenSanpham']) ?>" 
                                                 class="product-image">
                                        </td>
                                        <td><?= number_format($detail['Gia']) ?> VNĐ</td>
                                        <td><?= $detail['SoLuong'] ?></td>
                                        <td><strong><?= number_format($thanhTien) ?> VNĐ</strong></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-total">
                                    <th colspan="4">Tổng cộng:</th>
                                    <th><?= number_format($order['TongTien']) ?> VNĐ</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Cập nhật trạng thái -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-gear"></i> Cập nhật trạng thái</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="?page=update_order_status">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Trạng thái hiện tại:</label>
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
                            <br>
                            <span class="badge <?= $statusClass[$order['TrangThai']] ?> badge-lg">
                                <?= $statusText[$order['TrangThai']] ?>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Cập nhật trạng thái:</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="">-- Chọn trạng thái --</option>
                                <option value="pending" <?= $order['TrangThai'] == 'pending' ? 'selected' : '' ?>>
                                    Chờ xử lý
                                </option>
                                <option value="confirmed" <?= $order['TrangThai'] == 'confirmed' ? 'selected' : '' ?>>
                                    Đã xác nhận
                                </option>
                                <option value="shipping" <?= $order['TrangThai'] == 'shipping' ? 'selected' : '' ?>>
                                    Đang giao
                                </option>
                                <option value="completed" <?= $order['TrangThai'] == 'completed' ? 'selected' : '' ?>>
                                    Hoàn thành
                                </option>
                                <option value="cancelled" <?= $order['TrangThai'] == 'cancelled' ? 'selected' : '' ?>>
                                    Đã hủy
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle"></i> Cập nhật trạng thái
                        </button>
                    </form>
                </div>
            </div>

            <!-- Thông tin tổng quan -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="bi bi-graph-up"></i> Thông tin tổng quan</h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <span class="label">Tổng tiền:</span>
                        <span class="value"><?= number_format($order['TongTien']) ?> VNĐ</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Số sản phẩm:</span>
                        <span class="value"><?= count($orderDetails) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Ngày cập nhật:</span>
                        <span class="value"><?= date('d/m/Y H:i', strtotime($order['NgayCapNhat'])) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order-detail {
    padding: 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

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

.product-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
}

.table-total {
    background: #f8f9fa;
    font-weight: 600;
}

.badge-lg {
    padding: 8px 16px;
    font-size: 14px;
}

.form-label {
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
}

.form-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    border-bottom: none;
}

.info-item .label {
    color: #666;
    font-weight: 500;
}

.info-item .value {
    font-weight: 600;
    color: #333;
}

.alert {
    padding: 12px 16px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.btn {
    padding: 10px 20px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
    font-weight: 500;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-primary:hover {
    background: #0056b3;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #545b62;
}

.w-100 {
    width: 100%;
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

.col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
}

@media (max-width: 768px) {
    .col-md-8,
    .col-md-4,
    .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .page-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
}
</style>
