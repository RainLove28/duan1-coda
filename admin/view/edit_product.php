<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-edit"></i> Chỉnh sửa sản phẩm</h1>
        <button class="btn btn-secondary" onclick="window.location.href='index.php?page=product'">
            <i class="fas fa-arrow-left"></i> Quay lại
        </button>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if ($product): ?>
    <div class="content-box">
        <form method="POST" action="index.php?page=editpro&id=<?= $product['MaSP'] ?>" enctype="multipart/form-data">
            <div class="form-container">
                <div class="form-row">
                    <div class="form-group">
                        <label for="TenSP">Tên sản phẩm <span class="required">*</span></label>
                        <input type="text" id="TenSP" name="TenSP" value="<?= htmlspecialchars($product['TenSP']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="DanhMuc">Danh mục <span class="required">*</span></label>
                        <select id="DanhMuc" name="DanhMuc" required>
                            <option value="">Chọn danh mục</option>
                            <?php if (isset($categories) && !empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['TenDanhMuc']) ?>" 
                                            <?= $category['TenDanhMuc'] == $product['DanhMuc'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['TenDanhMuc']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">Không có danh mục nào</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="Gia">Giá <span class="required">*</span></label>
                        <input type="number" id="Gia" name="Gia" min="0" step="1000" value="<?= $product['Gia'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="SoLuong">Số lượng <span class="required">*</span></label>
                        <input type="number" id="SoLuong" name="SoLuong" min="0" value="<?= $product['SoLuong'] ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="HinhAnh">Hình ảnh mới (để trống nếu không đổi)</label>
                    <input type="file" id="HinhAnh" name="HinhAnh" accept="image/*">
                    <small class="form-text">Chỉ chấp nhận file ảnh (jpg, png, gif)</small>
                    <?php if (!empty($product['HinhAnh'])): ?>
                        <div class="current-image">
                            <label>Hình ảnh hiện tại:</label>
                            <img src="../public/img/<?= $product['HinhAnh'] ?>" 
                                 alt="<?= htmlspecialchars($product['TenSP']) ?>" 
                                 style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 5px; margin-top: 10px;">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="MoTa">Mô tả sản phẩm</label>
                    <textarea id="MoTa" name="MoTa" rows="5" placeholder="Nhập mô tả chi tiết về sản phẩm..."><?= htmlspecialchars($product['MoTa']) ?></textarea>
                </div>

                <div class="form-footer">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php?page=product'">
                        <i class="fas fa-times"></i> Hủy
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Cập nhật sản phẩm
                    </button>
                </div>
            </div>
        </form>
    </div>
    <?php else: ?>
    <div class="content-box">
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> Không tìm thấy sản phẩm này!
        </div>
        <div class="text-center">
            <button class="btn btn-primary" onclick="window.location.href='index.php?page=product'">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách sản phẩm
            </button>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
/* Override main-content để có thể scroll */
.main-content {
    padding: 30px;
    flex: 1;
    height: calc(100vh - 80px); /* Trừ đi chiều cao của top-header */
    overflow-y: auto; /* Cho phép scroll dọc */
    overflow-x: hidden; /* Ẩn scroll ngang */
    scroll-behavior: smooth; /* Scroll mượt mà */
}

/* Custom scrollbar */
.main-content::-webkit-scrollbar {
    width: 8px;
}

.main-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.main-content::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.main-content::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}

.content-box {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: visible; /* Đảm bảo content không bị cắt */
    margin-bottom: 30px; /* Thêm margin bottom để scroll tốt hơn */
}

.form-container {
    padding: 30px;
    max-width: 800px;
    margin: 0 auto; /* Center form */
}

.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.form-row .form-group {
    flex: 1;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
}

.required {
    color: #e74c3c;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #2ecc71;
    box-shadow: 0 0 0 2px rgba(46, 204, 113, 0.2);
}

.form-text {
    display: block;
    margin-top: 5px;
    color: #666;
    font-size: 12px;
}

.current-image {
    margin-top: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 5px;
}

.current-image label {
    margin-bottom: 10px;
    font-weight: 500;
    color: #555;
}

.form-footer {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 15px;
    justify-content: flex-end;
}

/* Responsive */
@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
        gap: 0;
    }
    
    .form-container {
        padding: 20px;
    }
    
    .form-footer {
        flex-direction: column-reverse;
    }
    
    .form-footer .btn {
        width: 100%;
    }
    
    .current-image img {
        max-width: 100%;
        height: auto;
    }
}
</style>
