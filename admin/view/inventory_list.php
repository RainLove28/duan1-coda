<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-warehouse"></i> Quản lý Tồn kho</h1>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="updateAllStock()">
                <i class="fas fa-sync"></i> Cập nhật tồn kho
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

    <!-- Thống kê tồn kho -->
    <div class="inventory-stats">
        <div class="stat-card">
            <div class="stat-icon out-of-stock">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <h3><?= count($outOfStockProducts) ?></h3>
                <p>Hết hàng</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon low-stock">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3><?= count($lowStockProducts) ?></h3>
                <p>Sắp hết hàng (≤5)</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon in-stock">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3><?= count(array_filter($products, function($p) { return $p['SoLuong'] > 5; })) ?></h3>
                <p>Còn hàng</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="stat-info">
                <h3><?= count($products) ?></h3>
                <p>Tổng sản phẩm</p>
            </div>
        </div>
    </div>

    <!-- Cảnh báo hết hàng -->
    <?php if (!empty($outOfStockProducts)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i> 
            <strong>Cảnh báo:</strong> Có <?= count($outOfStockProducts) ?> sản phẩm đã hết hàng!
        </div>
    <?php endif; ?>

    <!-- Cảnh báo tồn kho thấp -->
    <?php if (!empty($lowStockProducts)): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-circle"></i> 
            <strong>Thông báo:</strong> Có <?= count($lowStockProducts) ?> sản phẩm sắp hết hàng!
        </div>
    <?php endif; ?>

    <div class="content-box">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Trạng thái</th>
                        <th>Mức độ cảnh báo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr class="<?= $product['SoLuong'] <= 0 ? 'out-of-stock-row' : ($product['SoLuong'] <= 5 ? 'low-stock-row' : '') ?>">
                                <td><?= $product['MaSP'] ?></td>
                                <td><?= htmlspecialchars($product['TenSanPham']) ?></td>
                                <td><?= htmlspecialchars($product['TenDanhMuc']) ?></td>
                                <td><?= number_format($product['Gia']) ?> đ</td>
                                <td>
                                    <span class="stock-quantity <?= $product['SoLuong'] <= 0 ? 'zero-stock' : ($product['SoLuong'] <= 5 ? 'low-stock' : 'normal-stock') ?>">
                                        <?= $product['SoLuong'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $statusText = $product['TrangThai'] == 1 ? 'Còn hàng' : 'Hết hàng';
                                    $statusClass = $product['TrangThai'] == 1 ? 'status-active' : 'status-inactive';
                                    ?>
                                    <span class="status-badge <?= $statusClass ?>">
                                        <i class="fas <?= $product['TrangThai'] == 1 ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                                        <?= htmlspecialchars($statusText) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($product['SoLuong'] <= 0): ?>
                                        <span class="warning-badge critical">
                                            <i class="fas fa-times-circle"></i> Hết hàng
                                        </span>
                                    <?php elseif ($product['SoLuong'] <= 5): ?>
                                        <span class="warning-badge warning">
                                            <i class="fas fa-exclamation-triangle"></i> Sắp hết
                                        </span>
                                    <?php else: ?>
                                        <span class="warning-badge safe">
                                            <i class="fas fa-check-circle"></i> Bình thường
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="action-buttons">
                                    <button class="btn btn-primary btn-sm" 
                                            onclick="addStock(<?= $product['MaSP'] ?>, '<?= htmlspecialchars($product['TenSanPham']) ?>', <?= $product['SoLuong'] ?>)"
                                            title="Nhập kho">
                                        <i class="fas fa-plus"></i> Nhập kho
                                    </button>
                                    <button class="btn btn-edit btn-sm" 
                                            onclick="updateStock(<?= $product['MaSP'] ?>, '<?= htmlspecialchars($product['TenSanPham']) ?>', <?= $product['SoLuong'] ?>)"
                                            title="Cập nhật số lượng">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="index.php?page=editpropage&id=<?= $product['MaSP'] ?>" 
                                       class="btn btn-secondary btn-sm" title="Chi tiết sản phẩm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có sản phẩm nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal cập nhật tồn kho -->
<div id="updateStockModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> Cập nhật tồn kho</h3>
            <span class="close" onclick="closeModal('updateStockModal')">&times;</span>
        </div>
        <form method="POST" action="index.php?page=updatestock">
            <input type="hidden" id="stockProductId" name="MaSP">
            <input type="hidden" id="stockAction" name="action" value="update">
            <div class="modal-body">
                <div class="form-group">
                    <label>Tên sản phẩm:</label>
                    <span id="stockProductName" class="product-name"></span>
                </div>
                <div class="form-group">
                    <label for="currentStock">Số lượng hiện tại:</label>
                    <span id="currentStock" class="current-stock"></span>
                </div>
                <div class="form-group">
                    <label for="newStock">Số lượng mới <span class="required">*</span></label>
                    <input type="number" id="newStock" name="SoLuong" min="0" required>
                </div>
                <div class="form-group">
                    <label for="stockNote">Ghi chú (tùy chọn)</label>
                    <textarea id="stockNote" name="GhiChu" rows="3" placeholder="Lý do thay đổi tồn kho..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('updateStockModal')">Hủy</button>
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal nhập kho -->
<div id="addStockModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-plus"></i> Nhập kho</h3>
            <span class="close" onclick="closeModal('addStockModal')">&times;</span>
        </div>
        <form method="POST" action="index.php?page=addstock">
            <input type="hidden" id="addStockProductId" name="MaSP">
            <div class="modal-body">
                <div class="form-group">
                    <label>Tên sản phẩm:</label>
                    <span id="addStockProductName" class="product-name"></span>
                </div>
                <div class="form-group">
                    <label for="addCurrentStock">Số lượng hiện tại:</label>
                    <span id="addCurrentStock" class="current-stock"></span>
                </div>
                <div class="form-group">
                    <label for="addQuantity">Số lượng nhập thêm <span class="required">*</span></label>
                    <input type="number" id="addQuantity" name="SoLuongThem" min="1" required>
                </div>
                <div class="form-group">
                    <label for="addStockNote">Ghi chú nhập kho</label>
                    <textarea id="addStockNote" name="GhiChu" rows="3" placeholder="Ghi chú về lô hàng nhập..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addStockModal')">Hủy</button>
                <button type="submit" class="btn btn-primary">Nhập kho</button>
            </div>
        </form>
    </div>
</div>

<style>
.inventory-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 10px;
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
    font-size: 20px;
    color: white;
}

.stat-icon.out-of-stock { background: #e74c3c; }
.stat-icon.low-stock { background: #f39c12; }
.stat-icon.in-stock { background: #27ae60; }
.stat-icon.total { background: #3498db; }

.stat-info h3 {
    font-size: 24px;
    margin: 0;
    color: #2c3e50;
}

.stat-info p {
    margin: 5px 0 0;
    color: #7f8c8d;
    font-size: 14px;
}

.out-of-stock-row {
    background-color: #ffeaa7 !important;
}

.low-stock-row {
    background-color: #fdcb6e !important;
}

.stock-quantity {
    padding: 5px 10px;
    border-radius: 15px;
    font-weight: bold;
    font-size: 14px;
}

.stock-quantity.zero-stock {
    background: #e74c3c;
    color: white;
}

.stock-quantity.low-stock {
    background: #f39c12;
    color: white;
}

.stock-quantity.normal-stock {
    background: #27ae60;
    color: white;
}

.warning-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.warning-badge.critical {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    animation: pulse 2s infinite;
}

.warning-badge.warning {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
}

.warning-badge.safe {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Status badges */
.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.status-badge.status-active {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
}

.status-badge.status-inactive {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    color: white;
}

/* Action buttons improvements */
.action-buttons {
    white-space: nowrap;
}

.action-buttons .btn {
    margin: 0 2px;
    padding: 6px 10px;
    border-radius: 15px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 12px;
}

.btn-primary {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2980b9, #21618c);
    transform: translateY(-1px);
}

.btn-edit {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
}

.btn-edit:hover {
    background: linear-gradient(135deg, #e67e22, #d35400);
    transform: translateY(-1px);
}

.btn-secondary {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    color: white;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #7f8c8d, #6c7b7d);
    transform: translateY(-1px);
    text-decoration: none;
    color: white;
}

.product-name {
    font-weight: bold;
    color: #2c3e50;
}

.current-stock {
    font-size: 18px;
    font-weight: bold;
    color: #e74c3c;
}

.alert-warning {
    background: #fff3cd;
    border-color: #ffeaa7;
    color: #856404;
}

.header-actions {
    display: flex;
    gap: 10px;
}
</style>

<script>
function updateStock(productId, productName, currentStock) {
    document.getElementById('stockProductId').value = productId;
    document.getElementById('stockProductName').textContent = productName;
    document.getElementById('currentStock').textContent = currentStock;
    document.getElementById('newStock').value = currentStock;
    openModal('updateStockModal');
}

function addStock(productId, productName, currentStock) {
    document.getElementById('addStockProductId').value = productId;
    document.getElementById('addStockProductName').textContent = productName;
    document.getElementById('addCurrentStock').textContent = currentStock;
    document.getElementById('addQuantity').value = '';
    openModal('addStockModal');
}

function updateAllStock() {
    if (confirm('Bạn có chắc chắn muốn cập nhật tự động trạng thái tồn kho cho tất cả sản phẩm?')) {
        window.location.href = 'index.php?page=updateallstock';
    }
}
</script>
