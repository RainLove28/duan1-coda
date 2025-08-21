<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-box"></i> Quản lý Sản phẩm</h1>
        <div class="action-buttons">
            <button class="btn btn-warning" onclick="updateAllStatus()">
                <i class="fas fa-sync"></i> Cập nhật trang thái
            </button>
            <button class="btn btn-success" onclick="openAddProductModal()">
                <i class="fas fa-plus"></i> Thêm sản phẩm
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

    <?php 
    // Kiểm tra sản phẩm sắp hết hàng
    $lowStockProducts = [];
    $outOfStockProducts = [];
    foreach ($products as $product) {
        if ($product['SoLuong'] <= 0) {
            $outOfStockProducts[] = $product;
        } elseif ($product['SoLuong'] <= 5) {
            $lowStockProducts[] = $product;
        }
    }
    ?>

    <?php if (!empty($outOfStockProducts)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i> 
            <strong>Cảnh báo hết hàng:</strong> 
            Có <?= count($outOfStockProducts) ?> sản phẩm đã hết hàng
        </div>
    <?php endif; ?>

    <?php if (!empty($lowStockProducts)): ?>
        <div class="stock-alert">
            <i class="fas fa-exclamation-triangle"></i> 
            <strong>Cảnh báo tồn kho thấp:</strong> 
            Có <?= count($lowStockProducts) ?> sản phẩm sắp hết hàng (≤ 5 sản phẩm)
        </div>
    <?php endif; ?>

    <div class="content-box">
        <div class="table-controls">
            <form method="GET" action="index.php" class="search-form">
                <input type="hidden" name="page" value="product">
                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." 
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
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= $product['MaSP'] ?></td>
                                <td>
                                    <?php if (!empty($product['HinhAnh'])): ?>
                                        <img src="<?= $product['HinhAnh'] ?>" 
                                             alt="<?= htmlspecialchars($product['TenSanPham']) ?>" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    <?php else: ?>
                                        <div style="width: 50px; height: 50px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
                                            <i class="fas fa-image" style="color: #999;"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($product['TenSanPham']) ?></td>
                                <td><?= htmlspecialchars($product['TenDanhMuc']) ?></td>
                                <td><?= number_format($product['Gia']) ?> đ</td>
                                <td>
                                    <span class="stock-quantity <?= $product['SoLuong'] <= 5 ? 'low-stock' : '' ?>">
                                        <?= $product['SoLuong'] ?>
                                        <?php if ($product['SoLuong'] <= 5 && $product['SoLuong'] > 0): ?>
                                            <i class="fas fa-exclamation-triangle" title="Sắp hết hàng"></i>
                                        <?php elseif ($product['SoLuong'] <= 0): ?>
                                            <i class="fas fa-times-circle" title="Hết hàng"></i>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $statusText = $product['TrangThai'] == 1 ? 'Còn hàng' : 'Hết hàng';
                                    $statusClass = $product['TrangThai'] == 1 ? 'status-con-hang' : 'status-het-hang';
                                    ?>
                                    <span class="status-badge <?= $statusClass ?>">
                                        <?= htmlspecialchars($statusText) ?>
                                    </span>
                                </td>
                                <td class="action-buttons">
                                    <button class="btn btn-edit btn-sm" 
                                            onclick="openEditProductModal(<?= $product['MaSP'] ?>, '<?= htmlspecialchars($product['TenSanPham']) ?>', '<?= htmlspecialchars($product['MoTa']) ?>', <?= $product['Gia'] ?>, <?= $product['SoLuong'] ?>, '<?= $product['MaDM'] ?>')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-delete btn-sm" 
                                            onclick="confirmDelete(<?= $product['MaSP'] ?>, '<?= htmlspecialchars($product['TenSanPham']) ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
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

<style>
.stock-quantity {
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: 500;
}

.stock-quantity.low-stock {
    color: #f39c12;
}

.stock-quantity .fa-exclamation-triangle {
    color: #f39c12;
    animation: pulse 2s infinite;
}

.stock-quantity .fa-times-circle {
    color: #e74c3c;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.stock-alert {
    background: linear-gradient(135deg, #ffeaa7, #fdcb6e);
    border: 1px solid #e17055;
    color: #d63031;
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}
</style>

<script>
function confirmDelete(id, name) {
    if (confirm(`Bạn có chắc chắn muốn xóa sản phẩm "${name}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?page=deleteppro';
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.value = id;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}

// Hàm cập nhật tồn kho
function updateStock(productId, quantity, operation = 'decrease') {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity);
    formData.append('operation', operation);
    
    fetch('index.php?action=updateStock', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Cập nhật tồn kho thành công. Số lượng mới:', data.new_stock);
            // Có thể reload trang hoặc cập nhật UI
            location.reload();
        } else {
            console.error('Lỗi khi cập nhật tồn kho');
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
    });
}

// Hàm kiểm tra tồn kho
function checkStock(productId) {
    // Logic kiểm tra tồn kho có thể được thêm vào đây
    console.log('Kiểm tra tồn kho cho sản phẩm:', productId);
}

// Cập nhật tất cả trạng thái sản phẩm
function updateAllStatus() {
    if (confirm('Bạn có muốn cập nhật lại trạng thái tất cả sản phẩm dựa trên số lượng tồn kho?')) {
        window.location.href = 'index.php?action=updateAllProductStatus';
    }
}

// Mở modal thêm sản phẩm
function openAddProductModal() {
    // Reset form
    document.getElementById('addProductForm').reset();
    openModal('addProductModal');
}

// Mở modal sửa sản phẩm
function openEditProductModal(id, name, description, price, quantity, category) {
    document.getElementById('editProductId').value = id;
    document.getElementById('editTenSanPham').value = name;
    document.getElementById('editMoTa').value = description;
    document.getElementById('editGia').value = price;
    document.getElementById('editSoLuong').value = quantity;
    document.getElementById('editDanhMuc').value = category;
    
    openModal('editProductModal');
}
</script>

<!-- Modal Thêm sản phẩm -->
<div id="addProductModal" class="modal">
    <div class="modal-content modal-large">
        <div class="modal-header">
            <h3><i class="fas fa-plus"></i> Thêm sản phẩm mới</h3>
            <span class="close" onclick="closeModal('addProductModal')">&times;</span>
        </div>
        <form id="addProductForm" method="POST" action="index.php?page=addpro" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label for="addTenSanPham">Tên sản phẩm <span class="required">*</span></label>
                        <input type="text" id="addTenSanPham" name="TenSanPham" required>
                    </div>
                    <div class="form-group">
                        <label for="addDanhMuc">Danh mục <span class="required">*</span></label>
                        <select id="addDanhMuc" name="DanhMuc" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php
                            $database = Database::getInstance();
                            $db = $database->getConnection();
                            $sql = "SELECT MaDM, TenDM FROM danhmuc ORDER BY TenDM ASC";
                            $stmt = $db->prepare($sql);
                            $stmt->execute();
                            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($categories as $category):
                            ?>
                                <option value="<?= htmlspecialchars($category['MaDM']) ?>">
                                    <?= htmlspecialchars($category['TenDM']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="addGia">Giá <span class="required">*</span></label>
                        <input type="number" id="addGia" name="Gia" min="0" step="1000" required>
                    </div>
                    <div class="form-group">
                        <label for="addSoLuong">Số lượng <span class="required">*</span></label>
                        <input type="number" id="addSoLuong" name="SoLuong" min="0" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="addMoTa">Mô tả</label>
                    <textarea id="addMoTa" name="MoTa" rows="4" placeholder="Mô tả chi tiết về sản phẩm..."></textarea>
                </div>
                <div class="form-group">
                    <label for="addHinhAnh">Hình ảnh</label>
                    <input type="file" id="addHinhAnh" name="HinhAnh" accept="image/*">
                    <small class="form-help">Chỉ chấp nhận file JPG, PNG, GIF</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addProductModal')">Hủy</button>
                <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Sửa sản phẩm -->
<div id="editProductModal" class="modal">
    <div class="modal-content modal-large">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> Sửa thông tin sản phẩm</h3>
            <span class="close" onclick="closeModal('editProductModal')">&times;</span>
        </div>
        <form id="editProductForm" method="POST" action="index.php?page=editpro" enctype="multipart/form-data">
            <input type="hidden" id="editProductId" name="MaSP">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label for="editTenSanPham">Tên sản phẩm <span class="required">*</span></label>
                        <input type="text" id="editTenSanPham" name="TenSanPham" required>
                    </div>
                    <div class="form-group">
                        <label for="editDanhMuc">Danh mục <span class="required">*</span></label>
                        <select id="editDanhMuc" name="DanhMuc" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php
                            // Lấy lại danh sách danh mục cho edit form
                            $db = Database::getInstance()->getConnection();
                            $sql = "SELECT MaDM, TenDM FROM danhmuc ORDER BY TenDM ASC";
                            $stmt = $db->prepare($sql);
                            $stmt->execute();
                            $editCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($editCategories as $category): 
                            ?>
                                <option value="<?= htmlspecialchars($category['MaDM']) ?>">
                                    <?= htmlspecialchars($category['TenDM']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="editGia">Giá <span class="required">*</span></label>
                        <input type="number" id="editGia" name="Gia" min="0" step="1000" required>
                    </div>
                    <div class="form-group">
                        <label for="editSoLuong">Số lượng <span class="required">*</span></label>
                        <input type="number" id="editSoLuong" name="SoLuong" min="0" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="editMoTa">Mô tả</label>
                    <textarea id="editMoTa" name="MoTa" rows="4" placeholder="Mô tả chi tiết về sản phẩm..."></textarea>
                </div>
                <div class="form-group">
                    <label for="editHinhAnh">Hình ảnh mới (để trống nếu không đổi)</label>
                    <input type="file" id="editHinhAnh" name="HinhAnh" accept="image/*">
                    <small class="form-help">Chỉ chấp nhận file JPG, PNG, GIF</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editProductModal')">Hủy</button>
                <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
            </div>
        </form>
    </div>
</div>
</div>
