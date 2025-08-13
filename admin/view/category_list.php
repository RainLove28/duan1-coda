<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-tags"></i> Quản lý Danh mục</h1>
        <button class="btn btn-success" onclick="openModal('addCategoryModal')">
            <i class="fas fa-plus"></i> Thêm danh mục
        </button>
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
                <input type="hidden" name="page" value="Category">
                <input type="text" name="search" placeholder="Tìm kiếm danh mục..." 
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
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Số sản phẩm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <?php
                            // Đếm số sản phẩm trong danh mục
                            $countSql = "SELECT COUNT(*) FROM sanpham WHERE MaDM = :maDM";
                            $countStmt = $this->conn->prepare($countSql);
                            $countStmt->bindParam(':maDM', $category['MaDM']);
                            $countStmt->execute();
                            $productCount = $countStmt->fetchColumn();
                            ?>
                            <tr>
                                <td><?= $category['MaDM'] ?></td>
                                <td><?= htmlspecialchars($category['TenDM']) ?></td>
                                <td><?= htmlspecialchars($category['MoTa'] ?? '') ?></td>
                                <td>
                                    <span class="product-count">
                                        <?= $productCount ?> sản phẩm
                                    </span>
                                </td>
                                <td class="action-buttons">
                                    <button class="btn btn-edit btn-sm" 
                                            onclick="editCategory(<?= $category['MaDM'] ?>, '<?= htmlspecialchars($category['TenDM']) ?>', '<?= htmlspecialchars($category['MoTa'] ?? '') ?>')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-delete btn-sm" 
                                            onclick="confirmDelete('Category', <?= $category['MaDM'] ?>, '<?= htmlspecialchars($category['TenDM']) ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Không có danh mục nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-plus"></i> Thêm danh mục mới</h3>
            <span class="close" onclick="closeModal('addCategoryModal')">&times;</span>
        </div>
        <form action="?page=addCate" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <label for="TenDM">Tên danh mục <span class="required">*</span></label>
                    <input type="text" id="TenDM" name="TenDM" required>
                </div>
                <div class="form-group">
                    <label for="MoTa">Mô tả</label>
                    <textarea id="MoTa" name="MoTa" rows="4" placeholder="Mô tả về danh mục..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addCategoryModal')">Hủy</button>
                <button type="submit" class="btn btn-success">Thêm danh mục</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> Chỉnh sửa danh mục</h3>
            <span class="close" onclick="closeModal('editCategoryModal')">&times;</span>
        </div>
        <form method="post" action="index.php?page=editCate" enctype="multipart/form-data">
            <input type="hidden" id="editCategoryId" name="id">
            <div class="modal-body">
                <div class="form-group">
                    <label for="editTenDM">Tên danh mục <span class="required">*</span></label>
                    <input type="text" id="editTenDM" name="TenDM" required>
                </div>
                <div class="form-group">
                    <label for="editMoTa">Mô tả</label>
                    <textarea id="editMoTa" name="MoTa" rows="4" placeholder="Mô tả về danh mục..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editCategoryModal')">Hủy</button>
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

<style>
.product-count {
    color: #666;
    font-size: 13px;
    background: #f0f0f0;
    padding: 2px 6px;
    border-radius: 10px;
}
</style>

<script>
function editCategory(id, tenDM, moTa) {
    document.getElementById('editCategoryId').value = id;
    document.getElementById('editTenDM').value = tenDM;
    document.getElementById('editMoTa').value = moTa;
    openModal('editCategoryModal');
}

function confirmDelete(type, id, name) {
    if (confirm(`Bạn có chắc chắn muốn xóa danh mục "${name}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `index.php?page=DeleteCategory`;
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.value = id;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
