<?php
// Debug: kiểm tra dữ liệu
echo "<!-- DEBUG INFO -->";
echo "<!-- Low stock products count: " . count($lowStockProducts ?? []) . " -->";
echo "<!-- Out of stock products count: " . count($outOfStockProducts ?? []) . " -->";
echo "<!-- Stats: " . json_encode($stats ?? []) . " -->";
?>

<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-warehouse"></i> Quản lý Tồn kho</h1>
        <div class="action-buttons">
            <button class="btn btn-success" onclick="openModal('addStockModal')">
                <i class="fas fa-plus"></i> Nhập kho
            </button>
            <button class="btn btn-warning" onclick="openModal('removeStockModal')">
                <i class="fas fa-minus"></i> Xuất kho
            </button>
            <a href="index.php?page=update_all_status" class="btn btn-primary">
                <i class="fas fa-sync"></i> Cập nhật trạng thái
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

    <!-- Thống kê tồn kho -->
    <div class="stats-row">
        <div class="stat-card stat-total">
            <div class="stat-icon">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= number_format($stats['total_products']) ?></div>
                <div class="stat-label">Tổng sản phẩm</div>
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= number_format($stats['in_stock']) ?></div>
                <div class="stat-label">Còn hàng</div>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= number_format($stats['low_stock']) ?></div>
                <div class="stat-label">Sắp hết hàng</div>
            </div>
        </div>

        <div class="stat-card stat-danger">
            <div class="stat-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= number_format($stats['out_of_stock']) ?></div>
                <div class="stat-label">Hết hàng</div>
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= number_format($stats['total_value'], 0, ',', '.') ?>₫</div>
                <div class="stat-label">Giá trị tồn kho</div>
            </div>
        </div>
    </div>

    <!-- Cảnh báo sản phẩm sắp hết hàng -->
    

    <div class="inventory-content">
        <!-- Sản phẩm sắp hết hàng -->
        <div class="content-box" id="low-stock-section">
            <div class="box-header">
                <h3>
                    <i class="fas fa-exclamation-triangle" style="color: #fadb14;"></i> 
                    Sản phẩm sắp hết hàng (≤ 10 sản phẩm)
                    <span class="product-count-badge"><?= number_format($pagination['low_stock']['total_products']) ?> sản phẩm</span>
                </h3>
                <div class="pagination-info">
                    Trang <?= $pagination['low_stock']['current_page'] ?> / <?= $pagination['low_stock']['total_pages'] ?>
                    (<?= count($lowStockProducts) ?> / <?= $pagination['low_stock']['total_products'] ?> sản phẩm)
                </div>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Mã SP</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($lowStockProducts)): ?>
                            <?php foreach ($lowStockProducts as $product): ?>
                                <tr>
                                    <td><?= $product['MaSP'] ?></td>
                                    <td><?= htmlspecialchars($product['TenSP']) ?></td>
                                    <td><?= htmlspecialchars($product['DanhMuc'] ?? 'Chưa phân loại') ?></td>
                                    <td>
                                        <span class="stock-badge stock-low"><?= $product['SoLuong'] ?></span>
                                    </td>
                                    <td><?= number_format($product['Gia'], 0, ',', '.') ?>₫</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" onclick="quickAddStock(<?= $product['MaSP'] ?>, '<?= htmlspecialchars($product['TenSP']) ?>')">
                                            <i class="fas fa-plus"></i> Nhập kho
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Không có sản phẩm nào sắp hết hàng</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Phân trang cho sản phẩm sắp hết hàng -->
            <?php if ($pagination['low_stock']['total_pages'] > 1): ?>
                <div class="pagination-container">
                    <div class="pagination">
                        <?php 
                        $currentPage = $pagination['low_stock']['current_page'];
                        $totalPages = $pagination['low_stock']['total_pages'];
                        $outOfStockPage = $_GET['out_of_stock_page'] ?? 1;
                        ?>
                        
                        <!-- Nút Previous -->
                        <?php if ($currentPage > 1): ?>
                            <a href="?page=inventory&low_stock_page=<?= $currentPage - 1 ?>&out_of_stock_page=<?= $outOfStockPage ?>" class="page-btn">
                                <i class="fas fa-chevron-left"></i> Trước
                            </a>
                        <?php endif; ?>
                        
                        <!-- Các số trang -->
                        <?php
                        $start = max(1, $currentPage - 2);
                        $end = min($totalPages, $currentPage + 2);
                        
                        if ($start > 1) {
                            echo '<a href="?page=inventory&low_stock_page=1&out_of_stock_page=' . $outOfStockPage . '" class="page-btn">1</a>';
                            if ($start > 2) echo '<span class="page-dots">...</span>';
                        }
                        
                        for ($i = $start; $i <= $end; $i++):
                        ?>
                            <a href="?page=inventory&low_stock_page=<?= $i ?>&out_of_stock_page=<?= $outOfStockPage ?>" 
                               class="page-btn <?= $i == $currentPage ? 'active' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>
                        
                        <?php
                        if ($end < $totalPages) {
                            if ($end < $totalPages - 1) echo '<span class="page-dots">...</span>';
                            echo '<a href="?page=inventory&low_stock_page=' . $totalPages . '&out_of_stock_page=' . $outOfStockPage . '" class="page-btn">' . $totalPages . '</a>';
                        }
                        ?>
                        
                        <!-- Nút Next -->
                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?page=inventory&low_stock_page=<?= $currentPage + 1 ?>&out_of_stock_page=<?= $outOfStockPage ?>" class="page-btn">
                                Sau <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="pagination-info">
                        Hiển thị <?= count($lowStockProducts) ?> / <?= $pagination['low_stock']['total_products'] ?> sản phẩm
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sản phẩm hết hàng -->
        <div class="content-box">
            <div class="box-header">
                <h3>
                    <i class="fas fa-times-circle" style="color: #dc3545;"></i> 
                    Sản phẩm hết hàng
                    <span class="product-count-badge danger"><?= number_format($pagination['out_of_stock']['total_products']) ?> sản phẩm</span>
                </h3>
                <div class="pagination-info">
                    Trang <?= $pagination['out_of_stock']['current_page'] ?> / <?= $pagination['out_of_stock']['total_pages'] ?>
                    (<?= count($outOfStockProducts) ?> / <?= $pagination['out_of_stock']['total_products'] ?> sản phẩm)
                </div>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Mã SP</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($outOfStockProducts)): ?>
                            <?php foreach ($outOfStockProducts as $product): ?>
                                <tr>
                                    <td><?= $product['MaSP'] ?></td>
                                    <td><?= htmlspecialchars($product['TenSP']) ?></td>
                                    <td><?= htmlspecialchars($product['DanhMuc'] ?? 'Chưa phân loại') ?></td>
                                    <td><?= number_format($product['Gia'], 0, ',', '.') ?>₫</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" onclick="quickAddStock(<?= $product['MaSP'] ?>, '<?= htmlspecialchars($product['TenSP']) ?>')">
                                            <i class="fas fa-plus"></i> Nhập kho
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Không có sản phẩm nào hết hàng</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Phân trang cho sản phẩm hết hàng -->
            <?php if ($pagination['out_of_stock']['total_pages'] > 1): ?>
                <div class="pagination-container">
                    <div class="pagination">
                        <?php 
                        $currentPage = $pagination['out_of_stock']['current_page'];
                        $totalPages = $pagination['out_of_stock']['total_pages'];
                        $lowStockPage = $_GET['low_stock_page'] ?? 1;
                        ?>
                        
                        <!-- Nút Previous -->
                        <?php if ($currentPage > 1): ?>
                            <a href="?page=inventory&low_stock_page=<?= $lowStockPage ?>&out_of_stock_page=<?= $currentPage - 1 ?>" class="page-btn">
                                <i class="fas fa-chevron-left"></i> Trước
                            </a>
                        <?php endif; ?>
                        
                        <!-- Các số trang -->
                        <?php
                        $start = max(1, $currentPage - 2);
                        $end = min($totalPages, $currentPage + 2);
                        
                        if ($start > 1) {
                            echo '<a href="?page=inventory&low_stock_page=' . $lowStockPage . '&out_of_stock_page=1" class="page-btn">1</a>';
                            if ($start > 2) echo '<span class="page-dots">...</span>';
                        }
                        
                        for ($i = $start; $i <= $end; $i++):
                        ?>
                            <a href="?page=inventory&low_stock_page=<?= $lowStockPage ?>&out_of_stock_page=<?= $i ?>" 
                               class="page-btn <?= $i == $currentPage ? 'active' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>
                        
                        <?php
                        if ($end < $totalPages) {
                            if ($end < $totalPages - 1) echo '<span class="page-dots">...</span>';
                            echo '<a href="?page=inventory&low_stock_page=' . $lowStockPage . '&out_of_stock_page=' . $totalPages . '" class="page-btn">' . $totalPages . '</a>';
                        }
                        ?>
                        
                        <!-- Nút Next -->
                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?page=inventory&low_stock_page=<?= $lowStockPage ?>&out_of_stock_page=<?= $currentPage + 1 ?>" class="page-btn">
                                Sau <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="pagination-info">
                        Hiển thị <?= count($outOfStockProducts) ?> / <?= $pagination['out_of_stock']['total_products'] ?> sản phẩm
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Nhập kho -->
<div id="addStockModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-plus"></i> Nhập kho</h3>
            <span class="close" onclick="closeModal('addStockModal')">&times;</span>
        </div>
        <form method="POST" action="index.php?page=add_stock">
            <div class="modal-body">
                <div class="form-group">
                    <label for="addProductId">Sản phẩm <span class="required">*</span></label>
                    <select id="addProductId" name="product_id" required>
                        <option value="">-- Chọn sản phẩm --</option>
                        <?php
                        $database = Database::getInstance();
                        $db = $database->getConnection();
                        $sql = "SELECT MaSP, TenSP, SoLuong FROM sanpham ORDER BY TenSP ASC";
                        $stmt = $db->prepare($sql);
                        $stmt->execute();
                        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($products as $product):
                        ?>
                            <option value="<?= $product['MaSP'] ?>">
                                <?= htmlspecialchars($product['TenSP']) ?> (Hiện có: <?= $product['SoLuong'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="addQuantity">Số lượng nhập <span class="required">*</span></label>
                    <input type="number" id="addQuantity" name="quantity" min="1" required>
                </div>
                <div class="form-group">
                    <label for="addNote">Ghi chú</label>
                    <textarea id="addNote" name="note" rows="3" placeholder="Lý do nhập kho, nguồn hàng..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addStockModal')">Hủy</button>
                <button type="submit" class="btn btn-success">Nhập kho</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Xuất kho -->
<div id="removeStockModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-minus"></i> Xuất kho</h3>
            <span class="close" onclick="closeModal('removeStockModal')">&times;</span>
        </div>
        <form method="POST" action="index.php?page=remove_stock">
            <div class="modal-body">
                <div class="form-group">
                    <label for="removeProductId">Sản phẩm <span class="required">*</span></label>
                    <select id="removeProductId" name="product_id" required>
                        <option value="">-- Chọn sản phẩm --</option>
                        <?php
                        $database = Database::getInstance();
                        $db = $database->getConnection();
                        $sql = "SELECT MaSP, TenSP, SoLuong FROM sanpham ORDER BY TenSP ASC";
                        $stmt = $db->prepare($sql);
                        $stmt->execute();
                        $allProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($allProducts as $product):
                        ?>
                            <option value="<?= $product['MaSP'] ?>">
                                <?= htmlspecialchars($product['TenSP']) ?> (Hiện có: <?= $product['SoLuong'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="removeQuantity">Số lượng xuất <span class="required">*</span></label>
                    <input type="number" id="removeQuantity" name="quantity" min="1" required>
                </div>
                <div class="form-group">
                    <label for="removeNote">Ghi chú</label>
                    <textarea id="removeNote" name="note" rows="3" placeholder="Lý do xuất kho..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('removeStockModal')">Hủy</button>
                <button type="submit" class="btn btn-warning">Xuất kho</button>
            </div>
        </form>
    </div>
</div>

<style>
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
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

.stat-total .stat-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.stat-success .stat-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.stat-warning .stat-icon { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
.stat-danger .stat-icon { background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%); }
.stat-info .stat-icon { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); }

.stat-number {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.stat-label {
    color: #666;
    font-size: 14px;
}

.inventory-content {
    display: grid;
    gap: 20px;
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

.low-stock-list {
    margin-top: 10px;
}

.low-stock-item {
    padding: 5px 0;
    border-bottom: 1px solid rgba(255,255,255,0.3);
}

.low-stock-item:last-child {
    border-bottom: none;
}

.stock-number {
    font-weight: bold;
    color: #ff6b6b;
}

.stock-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.stock-low {
    background: linear-gradient(135deg, #fde68a 0%, #fef3c7 100%);
    color: #92400e;
    border: 1px solid #fbbf24;
}

/* CSS cho phân trang */
.pagination-container {
    margin: 20px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.pagination {
    display: flex;
    align-items: center;
    gap: 5px;
}

.page-btn {
    padding: 8px 12px;
    border: 1px solid #ddd;
    background: white;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
    transition: all 0.3s ease;
    font-size: 14px;
}

.page-btn:hover {
    background: #f8f9fa;
    border-color: #007bff;
    color: #007bff;
}

.page-btn.active {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.page-dots {
    padding: 8px 4px;
    color: #999;
}

.pagination-info {
    font-size: 14px;
    color: #666;
}

/* CSS cho badge số lượng sản phẩm */
.product-count-badge {
    background: #28a745;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: normal;
    margin-left: 10px;
    display: inline-block;
}

.product-count-badge.danger {
    background: #dc3545;
}

.box-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    flex-wrap: wrap;
}

.box-header h3 {
    margin: 0;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.box-header .pagination-info {
    font-size: 13px;
    color: #666;
    font-weight: normal;
}

/* Highlight cho số lượng tồn kho thấp */
.stock-badge.stock-low {
    background: #ffc107;
    color: #212529;
    font-weight: bold;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

@media (max-width: 768px) {
    .stats-row {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }
    
    .stat-card {
        flex-direction: column;
        text-align: center;
    }
    
    .pagination-container {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .page-btn {
        padding: 6px 8px;
        font-size: 12px;
    }
    
    .box-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .product-count-badge {
        margin-left: 0;
        margin-top: 5px;
    }
}

/* Enhanced Pagination Styles */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background: #f8f9fa;
    border-top: 1px solid #dee2e6;
    border-radius: 0 0 8px 8px;
    margin-top: 0;
}

.pagination {
    display: flex;
    gap: 8px;
    align-items: center;
}

.page-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 10px 15px;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    color: #495057;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    min-width: 44px;
    justify-content: center;
}

.page-btn:hover {
    background: #007bff;
    color: white;
    border-color: #007bff;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,123,255,0.25);
}

.page-btn.active {
    background: #007bff;
    color: white;
    border-color: #007bff;
    box-shadow: 0 2px 4px rgba(0,123,255,0.25);
}

.page-btn:active {
    transform: translateY(0);
}

.page-dots {
    padding: 10px 8px;
    color: #6c757d;
    font-weight: 500;
}

.pagination-info {
    color: #6c757d;
    font-size: 14px;
    font-weight: 500;
}

@media (max-width: 768px) {
    .pagination-container {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .page-btn {
        padding: 8px 12px;
        font-size: 13px;
        min-width: 40px;
    }
}
</style>

<script>
function quickAddStock(productId, productName) {
    document.getElementById('addProductId').value = productId;
    openModal('addStockModal');
}
</script>
