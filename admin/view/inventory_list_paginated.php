<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-warehouse"></i> Quản lý Tồn kho - Danh sách Sản phẩm</h1>
        <div class="header-actions">
            <a href="index.php?page=inventory&view=dashboard" class="btn btn-secondary">
                <i class="fas fa-chart-bar"></i> Dashboard
            </a>
            <button class="btn btn-success" onclick="openModal('addStockModal')">
                <i class="fas fa-plus"></i> Nhập kho
            </button>
            <button class="btn btn-warning" onclick="openModal('removeStockModal')">
                <i class="fas fa-minus"></i> Xuất kho
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

    <!-- Bộ lọc và tìm kiếm -->
    <div class="filter-section">
        <form method="GET" action="index.php" class="filter-form">
            <input type="hidden" name="page" value="inventory">
            <input type="hidden" name="action" value="list">
            
            <div class="filter-row">
                <div class="filter-group">
                    <label for="search">Tìm kiếm:</label>
                    <input type="text" id="search" name="search" value="<?= htmlspecialchars($pagination['search']) ?>" 
                           placeholder="Tên sản phẩm, mô tả, danh mục...">
                </div>
                
                <div class="filter-group">
                    <label for="status">Trạng thái tồn kho:</label>
                    <select id="status" name="status">
                        <option value="">Tất cả</option>
                        <option value="con_hang" <?= $pagination['status_filter'] === 'con_hang' ? 'selected' : '' ?>>Còn hàng (>10)</option>
                        <option value="sap_het" <?= $pagination['status_filter'] === 'sap_het' ? 'selected' : '' ?>>Sắp hết (1-10)</option>
                        <option value="het_hang" <?= $pagination['status_filter'] === 'het_hang' ? 'selected' : '' ?>>Hết hàng (0)</option>
                        <option value="ngung_ban" <?= $pagination['status_filter'] === 'ngung_ban' ? 'selected' : '' ?>>Ngừng bán</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="category">Danh mục:</label>
                    <select id="category" name="category">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['MaDanhMuc'] ?>" 
                                    <?= $pagination['category_filter'] == $category['MaDanhMuc'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['TenDanhMuc']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Lọc
                    </button>
                    <a href="index.php?page=inventory&action=list" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Xóa bộ lọc
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Thông tin phân trang -->
    <div class="pagination-info">
        <span class="results-count">
            Hiển thị <?= min($pagination['limit'], $pagination['total_products']) ?> trong tổng số <?= number_format($pagination['total_products']) ?> sản phẩm
        </span>
        <span class="page-info">
            Trang <?= $pagination['current_page'] ?> / <?= $pagination['total_pages'] ?>
        </span>
    </div>

    <!-- Bảng danh sách sản phẩm -->
    <div class="table-container">
        <table class="data-table inventory-table">
            <thead>
                <tr>
                    <th>Mã SP</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá bán</th>
                    <th>Số lượng tồn</th>
                    <th>Trạng thái</th>
                    <th>Cảnh báo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><strong><?= $product['MaSP'] ?></strong></td>
                            <td>
                                <div class="product-image">
                                    <?php if (!empty($product['HinhAnh'])): ?>
                                        <img src="../public/img/<?= htmlspecialchars($product['HinhAnh']) ?>" 
                                             alt="<?= htmlspecialchars($product['TenSanPham']) ?>"
                                             class="product-thumb">
                                    <?php else: ?>
                                        <div class="no-image">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="product-name">
                                    <strong><?= htmlspecialchars($product['TenSanPham']) ?></strong>
                                    <?php if (!empty($product['MoTa'])): ?>
                                        <small class="product-desc"><?= htmlspecialchars(substr($product['MoTa'], 0, 50)) ?>...</small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($product['TenDanhMuc']) ?></td>
                            <td class="price"><?= number_format($product['Gia']) ?> đ</td>
                            <td>
                                <span class="stock-quantity <?= $product['SoLuong'] <= 0 ? 'zero-stock' : ($product['SoLuong'] <= 10 ? 'low-stock' : 'normal-stock') ?>">
                                    <?= number_format($product['SoLuong']) ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                $statusClass = '';
                                $statusIcon = '';
                                $statusText = $product['TrangThai'];
                                
                                switch($product['TrangThai']) {
                                    case 'Còn hàng':
                                        $statusClass = 'status-active';
                                        $statusIcon = 'fa-check-circle';
                                        break;
                                    case 'Hết hàng':
                                        $statusClass = 'status-inactive';
                                        $statusIcon = 'fa-times-circle';
                                        break;
                                    case 'Ngừng bán':
                                        $statusClass = 'status-disabled';
                                        $statusIcon = 'fa-ban';
                                        break;
                                    default:
                                        $statusClass = 'status-unknown';
                                        $statusIcon = 'fa-question-circle';
                                }
                                ?>
                                <span class="status-badge <?= $statusClass ?>">
                                    <i class="fas <?= $statusIcon ?>"></i>
                                    <?= htmlspecialchars($statusText) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($product['SoLuong'] <= 0): ?>
                                    <span class="warning-badge critical">
                                        <i class="fas fa-times-circle"></i> Hết hàng
                                    </span>
                                <?php elseif ($product['SoLuong'] <= 10): ?>
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
                                <button class="btn btn-success btn-sm" 
                                        onclick="addStock(<?= $product['MaSP'] ?>, '<?= htmlspecialchars($product['TenSanPham']) ?>', <?= $product['SoLuong'] ?>)"
                                        title="Nhập kho">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button class="btn btn-warning btn-sm" 
                                        onclick="removeStock(<?= $product['MaSP'] ?>, '<?= htmlspecialchars($product['TenSanPham']) ?>', <?= $product['SoLuong'] ?>)"
                                        title="Xuất kho"
                                        <?= $product['SoLuong'] <= 0 ? 'disabled' : '' ?>>
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button class="btn btn-edit btn-sm" 
                                        onclick="updateStock(<?= $product['MaSP'] ?>, '<?= htmlspecialchars($product['TenSanPham']) ?>', <?= $product['SoLuong'] ?>)"
                                        title="Cập nhật số lượng">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="index.php?page=editpropage&id=<?= $product['MaSP'] ?>" 
                                   class="btn btn-info btn-sm" title="Chi tiết sản phẩm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="no-data">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <h3>Không tìm thấy sản phẩm</h3>
                                <p>Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <?php if ($pagination['total_pages'] > 1): ?>
        <div class="pagination-container">
            <div class="pagination">
                <?php
                $current = $pagination['current_page'];
                $total = $pagination['total_pages'];
                $search = $pagination['search'];
                $status = $pagination['status_filter'];
                $category = $pagination['category_filter'];
                
                // Tạo URL base cho phân trang
                $baseUrl = "index.php?page=inventory&action=list";
                if (!empty($search)) $baseUrl .= "&search=" . urlencode($search);
                if (!empty($status)) $baseUrl .= "&status=" . urlencode($status);
                if (!empty($category)) $baseUrl .= "&category=" . urlencode($category);
                ?>
                
                <!-- Nút Previous -->
                <?php if ($current > 1): ?>
                    <a href="<?= $baseUrl ?>&page_num=<?= $current - 1 ?>" class="page-link prev">
                        <i class="fas fa-chevron-left"></i> Trước
                    </a>
                <?php endif; ?>
                
                <!-- Các trang -->
                <?php
                $start = max(1, $current - 2);
                $end = min($total, $current + 2);
                
                if ($start > 1): ?>
                    <a href="<?= $baseUrl ?>&page_num=1" class="page-link">1</a>
                    <?php if ($start > 2): ?>
                        <span class="page-ellipsis">...</span>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php for ($i = $start; $i <= $end; $i++): ?>
                    <?php if ($i == $current): ?>
                        <span class="page-link active"><?= $i ?></span>
                    <?php else: ?>
                        <a href="<?= $baseUrl ?>&page_num=<?= $i ?>" class="page-link"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <?php if ($end < $total): ?>
                    <?php if ($end < $total - 1): ?>
                        <span class="page-ellipsis">...</span>
                    <?php endif; ?>
                    <a href="<?= $baseUrl ?>&page_num=<?= $total ?>" class="page-link"><?= $total ?></a>
                <?php endif; ?>
                
                <!-- Nút Next -->
                <?php if ($current < $total): ?>
                    <a href="<?= $baseUrl ?>&page_num=<?= $current + 1 ?>" class="page-link next">
                        Sau <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Jump to page -->
            <div class="page-jump">
                <form method="GET" action="index.php" class="jump-form">
                    <input type="hidden" name="page" value="inventory">
                    <input type="hidden" name="action" value="list">
                    <?php if (!empty($search)): ?>
                        <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                    <?php endif; ?>
                    <?php if (!empty($status)): ?>
                        <input type="hidden" name="status" value="<?= htmlspecialchars($status) ?>">
                    <?php endif; ?>
                    <?php if (!empty($category)): ?>
                        <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
                    <?php endif; ?>
                    
                    <label for="page_jump">Đến trang:</label>
                    <input type="number" id="page_jump" name="page_num" min="1" max="<?= $total ?>" 
                           value="<?= $current ?>" class="page-input">
                    <button type="submit" class="btn btn-sm btn-primary">Đi</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal nhập kho -->
<div id="addStockModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-plus"></i> Nhập kho</h3>
            <span class="close" onclick="closeModal('addStockModal')">&times;</span>
        </div>
        <form method="POST" action="index.php?page=inventory&action=addStock">
            <div class="modal-body">
                <div class="form-group">
                    <label for="addStockProductId">Mã sản phẩm <span class="required">*</span></label>
                    <input type="number" id="addStockProductId" name="product_id" required readonly>
                </div>
                
                <div class="form-group">
                    <label for="addStockProductName">Tên sản phẩm</label>
                    <input type="text" id="addStockProductName" readonly class="readonly-field">
                </div>
                
                <div class="form-group">
                    <label for="addStockCurrentQty">Số lượng hiện tại</label>
                    <input type="number" id="addStockCurrentQty" readonly class="readonly-field">
                </div>
                
                <div class="form-group">
                    <label for="addStockQuantity">Số lượng nhập <span class="required">*</span></label>
                    <input type="number" id="addStockQuantity" name="quantity" required min="1" step="1">
                </div>
                
                <div class="form-group">
                    <label for="addStockNote">Ghi chú</label>
                    <textarea id="addStockNote" name="note" rows="3" placeholder="Ghi chú về lần nhập kho này..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addStockModal')">Hủy</button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nhập kho
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal xuất kho -->
<div id="removeStockModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-minus"></i> Xuất kho</h3>
            <span class="close" onclick="closeModal('removeStockModal')">&times;</span>
        </div>
        <form method="POST" action="index.php?page=inventory&action=removeStock">
            <div class="modal-body">
                <div class="form-group">
                    <label for="removeStockProductId">Mã sản phẩm <span class="required">*</span></label>
                    <input type="number" id="removeStockProductId" name="product_id" required readonly>
                </div>
                
                <div class="form-group">
                    <label for="removeStockProductName">Tên sản phẩm</label>
                    <input type="text" id="removeStockProductName" readonly class="readonly-field">
                </div>
                
                <div class="form-group">
                    <label for="removeStockCurrentQty">Số lượng hiện tại</label>
                    <input type="number" id="removeStockCurrentQty" readonly class="readonly-field">
                </div>
                
                <div class="form-group">
                    <label for="removeStockQuantity">Số lượng xuất <span class="required">*</span></label>
                    <input type="number" id="removeStockQuantity" name="quantity" required min="1" step="1">
                </div>
                
                <div class="form-group">
                    <label for="removeStockNote">Ghi chú</label>
                    <textarea id="removeStockNote" name="note" rows="3" placeholder="Ghi chú về lần xuất kho này..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('removeStockModal')">Hủy</button>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-minus"></i> Xuất kho
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal cập nhật số lượng -->
<div id="updateStockModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> Cập nhật số lượng tồn kho</h3>
            <span class="close" onclick="closeModal('updateStockModal')">&times;</span>
        </div>
        <form method="POST" action="index.php?page=product&action=updateStock">
            <div class="modal-body">
                <div class="form-group">
                    <label for="updateStockProductId">Mã sản phẩm <span class="required">*</span></label>
                    <input type="number" id="updateStockProductId" name="product_id" required readonly>
                </div>
                
                <div class="form-group">
                    <label for="updateStockProductName">Tên sản phẩm</label>
                    <input type="text" id="updateStockProductName" readonly class="readonly-field">
                </div>
                
                <div class="form-group">
                    <label for="updateStockCurrentQty">Số lượng hiện tại</label>
                    <input type="number" id="updateStockCurrentQty" readonly class="readonly-field">
                </div>
                
                <div class="form-group">
                    <label for="updateStockNewQty">Số lượng mới <span class="required">*</span></label>
                    <input type="number" id="updateStockNewQty" name="new_quantity" required min="0" step="1">
                </div>
                
                <div class="form-group">
                    <label for="updateStockNote">Lý do cập nhật</label>
                    <textarea id="updateStockNote" name="note" rows="3" placeholder="Lý do cập nhật số lượng tồn kho..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('updateStockModal')">Hủy</button>
                <button type="submit" class="btn btn-edit">
                    <i class="fas fa-save"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Filter Section Styling */
.filter-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: end;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.filter-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #2c3e50;
}

.filter-group input,
.filter-group select {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
}

.filter-actions {
    display: flex;
    gap: 10px;
}

/* Pagination Info */
.pagination-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding: 10px 0;
    color: #666;
    font-size: 14px;
}

.results-count {
    font-weight: 600;
}

/* Product Image */
.product-image {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    overflow: hidden;
    background: #f8f9fa;
}

.product-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    color: #ccc;
    font-size: 20px;
}

/* Product Name */
.product-name strong {
    display: block;
    margin-bottom: 3px;
}

.product-desc {
    color: #666;
    font-style: italic;
    display: block;
}

/* Stock Quantity */
.stock-quantity {
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 600;
}

.zero-stock {
    background: #fee;
    color: #d73527;
}

.low-stock {
    background: #fff3cd;
    color: #856404;
}

.normal-stock {
    background: #d4edda;
    color: #155724;
}

/* Status Badges */
.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-inactive {
    background: #f8d7da;
    color: #721c24;
}

.status-disabled {
    background: #e2e3e5;
    color: #6c757d;
}

/* Warning Badges */
.warning-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.warning-badge.critical {
    background: #f8d7da;
    color: #721c24;
}

.warning-badge.warning {
    background: #fff3cd;
    color: #856404;
}

.warning-badge.safe {
    background: #d4edda;
    color: #155724;
}

/* Table Styling */
.table-container {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 15px 12px;
    font-size: 13px;
    border: none;
}

.data-table tbody td {
    border-bottom: 1px solid #e9ecef;
    background: white;
    padding: 15px 12px;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background: #f8f9fa;
}

/* Action Buttons */
.action-buttons {
    white-space: nowrap;
}

.action-buttons .btn {
    margin: 0 2px;
    padding: 6px 10px;
    border-radius: 4px;
    font-size: 12px;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding: 20px 0;
}

.pagination {
    display: flex;
    gap: 5px;
    align-items: center;
}

.page-link {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
}

.page-link:hover {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.page-link.active {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.page-ellipsis {
    padding: 8px 4px;
    color: #666;
}

.page-jump {
    display: flex;
    align-items: center;
    gap: 10px;
}

.page-input {
    width: 60px;
    padding: 6px 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-align: center;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #666;
}

.empty-state i {
    font-size: 48px;
    color: #ccc;
    margin-bottom: 15px;
}

.empty-state h3 {
    margin-bottom: 10px;
    color: #333;
}

/* Price styling */
.price {
    font-weight: 600;
    color: #28a745;
}

/* Responsive */
@media (max-width: 768px) {
    .filter-row {
        flex-direction: column;
    }
    
    .filter-group {
        min-width: 100%;
    }
    
    .pagination-container {
        flex-direction: column;
        gap: 15px;
    }
    
    .data-table {
        font-size: 12px;
    }
    
    .data-table th,
    .data-table td {
        padding: 8px 6px;
    }
}
</style>

<script>
// Modal functions
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Stock management functions
function addStock(productId, productName, currentQty) {
    document.getElementById('addStockProductId').value = productId;
    document.getElementById('addStockProductName').value = productName;
    document.getElementById('addStockCurrentQty').value = currentQty;
    document.getElementById('addStockQuantity').value = '';
    document.getElementById('addStockNote').value = '';
    openModal('addStockModal');
}

function removeStock(productId, productName, currentQty) {
    if (currentQty <= 0) {
        alert('Sản phẩm đã hết hàng, không thể xuất kho!');
        return;
    }
    
    document.getElementById('removeStockProductId').value = productId;
    document.getElementById('removeStockProductName').value = productName;
    document.getElementById('removeStockCurrentQty').value = currentQty;
    document.getElementById('removeStockQuantity').value = '';
    document.getElementById('removeStockQuantity').max = currentQty;
    document.getElementById('removeStockNote').value = '';
    openModal('removeStockModal');
}

function updateStock(productId, productName, currentQty) {
    document.getElementById('updateStockProductId').value = productId;
    document.getElementById('updateStockProductName').value = productName;
    document.getElementById('updateStockCurrentQty').value = currentQty;
    document.getElementById('updateStockNewQty').value = currentQty;
    document.getElementById('updateStockNote').value = '';
    openModal('updateStockModal');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
}

// Auto-submit form when enter is pressed in search
document.getElementById('search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        this.form.submit();
    }
});
</script>
