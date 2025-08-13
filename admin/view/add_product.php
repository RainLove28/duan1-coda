<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-plus"></i> Thêm sản phẩm mới</h1>
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

    <div class="content-box">
        <form method="POST" action="index.php?page=addpro" enctype="multipart/form-data">
            <div class="form-container">
                <div class="form-row">
                    <div class="form-group">
                        <label for="TenSanPham">Tên sản phẩm <span class="required">*</span></label>
                        <input type="text" id="TenSanPham" name="TenSanPham" required 
                               placeholder="Nhập tên sản phẩm">
                    </div>
                    <div class="form-group">
                        <label for="DanhMuc">Danh mục <span class="required">*</span></label>
                        <select id="DanhMuc" name="DanhMuc" required>
                            <option value="">Chọn danh mục</option>
                            <?php if (isset($categories) && !empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['MaDM']) ?>">
                                        <?= htmlspecialchars($category['TenDM']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">Không có danh mục nào</option>
                            <?php endif; ?>
                        </select>
                        <small class="form-text">
                            <a href="index.php?page=Category" target="_blank" style="color: #007bff;">
                                <i class="fas fa-plus"></i> Thêm danh mục mới
                            </a>
                        </small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="Gia">Giá (VNĐ) <span class="required">*</span></label>
                        <input type="number" id="Gia" name="Gia" min="0" step="1000" required 
                               placeholder="0">
                        <small class="form-text">Giá tính bằng VNĐ</small>
                    </div>
                    <div class="form-group">
                        <label for="SoLuong">Số lượng <span class="required">*</span></label>
                        <input type="number" id="SoLuong" name="SoLuong" min="0" required 
                               placeholder="0">
                        <small class="form-text">Số lượng tồn kho ban đầu</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="MoTa">Mô tả sản phẩm</label>
                    <textarea id="MoTa" name="MoTa" rows="4" 
                              placeholder="Nhập mô tả chi tiết về sản phẩm..."></textarea>
                </div>

                <div class="form-group">
                    <label for="HinhAnh">Hình ảnh sản phẩm</label>
                    <input type="file" id="HinhAnh" name="HinhAnh" accept="image/*">
                    <small class="form-text">Chấp nhận các định dạng: JPG, JPEG, PNG, GIF. Kích thước tối đa: 5MB</small>
                    
                    <!-- Preview image -->
                    <div id="imagePreview" style="margin-top: 10px; display: none;">
                        <img id="previewImg" src="" alt="Preview" 
                             style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Thêm sản phẩm
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Đặt lại
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.form-container {
    max-width: 800px;
    margin: 0 auto;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.form-text {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
    display: block;
}

.required {
    color: red;
}

.form-actions {
    margin-top: 30px;
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.form-actions .btn {
    margin: 0 10px;
    padding: 12px 30px;
    font-size: 16px;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Preview image before upload
document.getElementById('HinhAnh').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Format price input
document.getElementById('Gia').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    e.target.value = value;
});

// Validate form before submit
document.querySelector('form').addEventListener('submit', function(e) {
    const tenSP = document.getElementById('TenSP').value.trim();
    const danhMuc = document.getElementById('DanhMuc').value;
    const gia = document.getElementById('Gia').value;
    const soLuong = document.getElementById('SoLuong').value;
    
    if (!tenSP) {
        alert('Vui lòng nhập tên sản phẩm');
        e.preventDefault();
        return;
    }
    
    if (!danhMuc) {
        alert('Vui lòng chọn danh mục');
        e.preventDefault();
        return;
    }
    
    if (!gia || gia < 0) {
        alert('Vui lòng nhập giá hợp lệ');
        e.preventDefault();
        return;
    }
    
    if (!soLuong || soLuong < 0) {
        alert('Vui lòng nhập số lượng hợp lệ');
        e.preventDefault();
        return;
    }
});
</script>
