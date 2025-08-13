<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-tags"></i> Quản lý Mã Giảm Giá</h1>
        <button class="btn btn-success" onclick="openModal('addVoucherModal')">
            <i class="fas fa-plus"></i> Thêm mã giảm giá
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
                <input type="hidden" name="page" value="Voucher">
                <input type="text" name="search" placeholder="Tìm kiếm tên mã giảm giá..." 
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
                        <th>Mã</th>
                        <th>Tên</th>
                        <th>Loại giảm</th>
                        <th>Giá trị</th>
                        <th>Điều kiện</th>
                        <th>Mô tả</th>
                        <th>Ngày hết hạn</th>
                        <th>Hoạt động</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vouchers as $item): ?>
                        <tr>
                            <td><?= $item['MaGG'] ?></td>
                            <td><?= htmlspecialchars($item['Ten']) ?></td>
                            <td>
                                <?php if (($item['LoaiGiam'] ?? 'tien') === 'phan_tram'): ?>
                                    <span class="badge badge-info">Phần trăm</span>
                                <?php else: ?>
                                    <span class="badge badge-primary">Tiền mặt</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="value-display">
                                    <?php if (($item['LoaiGiam'] ?? 'tien') === 'phan_tram'): ?>
                                        <span class="value-main"><?= $item['TienGiam'] ?>%</span>
                                        <?php if (!empty($item['GiaTriToiDa'])): ?>
                                            <span class="value-sub">Tối đa: <?= number_format($item['GiaTriToiDa']) ?>đ</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="value-main"><?= number_format($item['TienGiam']) ?>đ</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="condition-display">
                                    <?php if (!empty($item['DieuKienToiThieu'])): ?>
                                        Đơn tối thiểu: <span class="condition-value"><?= number_format($item['DieuKienToiThieu']) ?>đ</span>
                                    <?php else: ?>
                                        <span class="text-muted">Không có điều kiện</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($item['MoTa']) ?></td>
                            <td><?= $item['NgayHetHan'] ?></td>
                            <td>
                                <?= $item['HoatDong'] ? '<span class="badge badge-success">Đang hoạt động</span>' : '<span class="badge badge-secondary">Tạm dừng</span>' ?>
                            </td>
                            <td class="action-buttons">
                                <button class="btn btn-edit btn-sm" 
                                        onclick="editVoucher(<?= $item['MaGG'] ?>, '<?= htmlspecialchars($item['Ten']) ?>', '<?= htmlspecialchars($item['TienGiam']) ?>', '<?= htmlspecialchars($item['MoTa']) ?>', '<?= $item['NgayHetHan'] ?>', <?= $item['HoatDong'] ?>, '<?= $item['LoaiGiam'] ?? 'tien' ?>', '<?= $item['GiaTriToiDa'] ?? '' ?>', '<?= $item['DieuKienToiThieu'] ?? '' ?>')">
                                    <i class="fas fa-edit"></i> Sửa
                                </button>
                                <button class="btn btn-delete btn-sm" 
                                        onclick="confirmDeleteVoucher(<?= $item['MaGG'] ?>, '<?= htmlspecialchars($item['Ten']) ?>')">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($vouchers)): ?>
                        <tr><td colspan="9">Không có mã giảm giá nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

                            
                    

<!-- Add Voucher Modal -->
<div id="addVoucherModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-plus"></i> Thêm Mã Giảm Giá Mới</h3>
            <span class="close" onclick="closeModal('addVoucherModal')">&times;</span>
        </div>
        <form action="index.php?page=Voucher&action=add" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <label for="Ten">Tên mã giảm giá <span class="required">*</span></label>
                    <input type="text" id="Ten" name="Ten" required>
                </div>
                
                <div class="form-group">
                    <label for="LoaiGiam">Loại giảm giá <span class="required">*</span></label>
                    <select id="LoaiGiam" name="LoaiGiam" required onchange="toggleDiscountFields()">
                        <option value="tien">Giảm theo tiền mặt (đ)</option>
                        <option value="phan_tram">Giảm theo phần trăm (%)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="TienGiam" id="labelTienGiam">Số tiền giảm (đ) <span class="required">*</span></label>
                    <input type="number" id="TienGiam" name="TienGiam" required min="0" step="0.01">
                </div>
                
                <div class="form-group" id="giaTriToiDaGroup" style="display: none;">
                    <label for="GiaTriToiDa">Giá trị giảm tối đa (đ)</label>
                    <input type="number" id="GiaTriToiDa" name="GiaTriToiDa" min="0" step="0.01" placeholder="Để trống nếu không giới hạn">
                    <small class="text-muted">Chỉ áp dụng cho giảm theo phần trăm</small>
                </div>
                
                <div class="form-group">
                    <label for="DieuKienToiThieu">Điều kiện đơn hàng tối thiểu (đ)</label>
                    <input type="number" id="DieuKienToiThieu" name="DieuKienToiThieu" min="0" step="0.01" placeholder="Để trống nếu không có điều kiện">
                </div>
                
                <div class="form-group">
                    <label for="MoTa">Mô tả</label>
                    <textarea id="MoTa" name="MoTa" rows="3" placeholder="Nhập mô tả..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="NgayHetHan">Ngày hết hạn</label>
                    <input type="datetime-local" id="NgayHetHan" name="NgayHetHan">
                    <small class="text-muted">Để trống nếu không có ngày hết hạn</small>
                </div>
                
                <div class="form-group">
                    <label for="HoatDong">Hoạt động</label>
                    <select id="HoatDong" name="HoatDong">
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addVoucherModal')">Hủy</button>
                <button type="submit" class="btn btn-success">Thêm mã</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Voucher Modal -->
<div id="editVoucherModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> Chỉnh sửa mã giảm giá</h3>
            <span class="close" onclick="closeModal('editVoucherModal')">&times;</span>
        </div>
        <form method="post" action="index.php?page=Voucher&action=edit">
            <input type="hidden" id="editMaGG" name="MaGG">
            <div class="modal-body">
                <div class="form-group">
                    <label for="editTen">Tên mã giảm giá <span class="required">*</span></label>
                    <input type="text" id="editTen" name="Ten" required>
                </div>
                
                <div class="form-group">
                    <label for="editLoaiGiam">Loại giảm giá <span class="required">*</span></label>
                    <select id="editLoaiGiam" name="LoaiGiam" required onchange="toggleEditDiscountFields()">
                        <option value="tien">Giảm theo tiền mặt (đ)</option>
                        <option value="phan_tram">Giảm theo phần trăm (%)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="editTienGiam" id="editLabelTienGiam">Số tiền giảm (đ) <span class="required">*</span></label>
                    <input type="number" id="editTienGiam" name="TienGiam" required min="0" step="0.01">
                </div>
                
                <div class="form-group" id="editGiaTriToiDaGroup" style="display: none;">
                    <label for="editGiaTriToiDa">Giá trị giảm tối đa (đ)</label>
                    <input type="number" id="editGiaTriToiDa" name="GiaTriToiDa" min="0" step="0.01" placeholder="Để trống nếu không giới hạn">
                    <small class="text-muted">Chỉ áp dụng cho giảm theo phần trăm</small>
                </div>
                
                <div class="form-group">
                    <label for="editDieuKienToiThieu">Điều kiện đơn hàng tối thiểu (đ)</label>
                    <input type="number" id="editDieuKienToiThieu" name="DieuKienToiThieu" min="0" step="0.01" placeholder="Để trống nếu không có điều kiện">
                </div>
                
                <div class="form-group">
                    <label for="editMoTa">Mô tả</label>
                    <textarea id="editMoTa" name="MoTa" rows="3" placeholder="Nhập mô tả..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="editNgayHetHan">Ngày hết hạn</label>
                    <input type="datetime-local" id="editNgayHetHan" name="NgayHetHan">
                </div>
                <div class="form-group">
                    <label for="editHoatDong">Hoạt động</label>
                    <select id="editHoatDong" name="HoatDong">
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editVoucherModal')">Hủy</button>
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

/* Modern Badge Styles */
.badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: none;
    letter-spacing: 0.3px;
    border: none;
    min-width: 80px;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Voucher Type Badges */
.badge-info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.badge-info::before {
    content: "📊";
    margin-right: 6px;
    font-size: 14px;
}

.badge-primary {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.badge-primary::before {
    content: "💰";
    margin-right: 6px;
    font-size: 14px;
}

/* Activity Status Badges */
.badge-success {
    background: linear-gradient(135deg, #56CCF2 0%, #2F80ED 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.badge-success::before {
    content: "✅";
    margin-right: 6px;
    font-size: 12px;
}

.badge-secondary {
    background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.badge-secondary::before {
    content: "❌";
    margin-right: 6px;
    font-size: 12px;
}

/* Enhanced Badge Animation */
.badge::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.badge:hover::after {
    left: 100%;
}

/* Text Utilities */
.text-muted {
    color: #6c757d !important;
    font-size: 12px;
    line-height: 1.4;
}

.form-group small {
    display: block;
    margin-top: 5px;
    color: #6c757d;
    font-size: 12px;
    line-height: 1.4;
}

.required {
    color: #dc3545;
    font-weight: bold;
}

/* Table Cell Styling */
.data-table td {
    vertical-align: middle;
    padding: 15px 12px;
}

/* Value Display Styling */
.value-display {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.value-main {
    font-weight: 700;
    font-size: 16px;
    color: #2c3e50;
    margin-bottom: 4px;
}

.value-sub {
    font-size: 11px;
    color: #7f8c8d;
    background: #f8f9fa;
    padding: 2px 6px;
    border-radius: 10px;
    border: 1px solid #e9ecef;
}

/* Condition Display */
.condition-display {
    font-size: 13px;
    line-height: 1.3;
}

.condition-value {
    font-weight: 600;
    color: #e74c3c;
}

/* Responsive Design */
@media (max-width: 768px) {
    .badge {
        font-size: 10px;
        padding: 6px 8px;
        min-width: 60px;
    }
    
    .badge::before {
        margin-right: 3px;
        font-size: 10px;
    }
    
    .value-main {
        font-size: 14px;
    }
    
    .value-sub {
        font-size: 10px;
    }
}

/* Hover Effects for Table Rows */
.data-table tbody tr {
    transition: all 0.3s ease;
}

.data-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-radius: 8px;
}

/* Enhanced Table Styling */
.data-table {
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

.data-table thead th:first-child {
    border-top-left-radius: 10px;
}

.data-table thead th:last-child {
    border-top-right-radius: 10px;
}

.data-table tbody td {
    border-bottom: 1px solid #e9ecef;
    background: white;
    padding: 15px 12px;
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

.data-table tbody tr:last-child td:first-child {
    border-bottom-left-radius: 10px;
}

.data-table tbody tr:last-child td:last-child {
    border-bottom-right-radius: 10px;
}

/* Action Buttons Styling */
.action-buttons {
    white-space: nowrap;
}

.action-buttons .btn {
    margin: 0 3px;
    padding: 8px 12px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.action-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Content Header Enhancements */
.content-header {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 25px 30px;
    border-radius: 15px;
    margin-bottom: 25px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.content-header h1 {
    color: #2c3e50;
    font-weight: 700;
    font-size: 28px;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.content-header h1 i {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-right: 12px;
}

/* Table Controls Styling */
.table-controls {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    border: 1px solid #e9ecef;
}

.search-form {
    display: flex;
    gap: 10px;
    align-items: center;
}

.search-form input[type="text"] {
    flex: 1;
    padding: 12px 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.search-form input[type="text"]:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-form .btn {
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
}

/* Alert Enhancements */
.alert {
    border-radius: 10px;
    padding: 15px 20px;
    margin-bottom: 20px;
    border: none;
    font-weight: 500;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-error {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.alert i {
    margin-right: 8px;
    font-size: 16px;
}
</style>

<script>
// Toggle hiển thị fields dựa trên loại giảm giá
function toggleDiscountFields() {
    const loaiGiam = document.getElementById('LoaiGiam').value;
    const giaTriToiDaGroup = document.getElementById('giaTriToiDaGroup');
    const labelTienGiam = document.getElementById('labelTienGiam');
    const tienGiamInput = document.getElementById('TienGiam');
    
    if (loaiGiam === 'phan_tram') {
        giaTriToiDaGroup.style.display = 'block';
        labelTienGiam.innerHTML = 'Phần trăm giảm (%) <span class="required">*</span>';
        tienGiamInput.setAttribute('max', '100');
        tienGiamInput.setAttribute('placeholder', 'Nhập phần trăm (1-100)');
    } else {
        giaTriToiDaGroup.style.display = 'none';
        labelTienGiam.innerHTML = 'Số tiền giảm (đ) <span class="required">*</span>';
        tienGiamInput.removeAttribute('max');
        tienGiamInput.setAttribute('placeholder', 'Nhập số tiền giảm');
    }
}

// Toggle hiển thị fields cho edit modal dựa trên loại giảm giá
function toggleEditDiscountFields() {
    const loaiGiam = document.getElementById('editLoaiGiam').value;
    const giaTriToiDaGroup = document.getElementById('editGiaTriToiDaGroup');
    const labelTienGiam = document.getElementById('editLabelTienGiam');
    const tienGiamInput = document.getElementById('editTienGiam');
    
    if (loaiGiam === 'phan_tram') {
        giaTriToiDaGroup.style.display = 'block';
        labelTienGiam.innerHTML = 'Phần trăm giảm (%) <span class="required">*</span>';
        tienGiamInput.setAttribute('max', '100');
        tienGiamInput.setAttribute('placeholder', 'Nhập phần trăm (1-100)');
    } else {
        giaTriToiDaGroup.style.display = 'none';
        labelTienGiam.innerHTML = 'Số tiền giảm (đ) <span class="required">*</span>';
        tienGiamInput.removeAttribute('max');
        tienGiamInput.setAttribute('placeholder', 'Nhập số tiền giảm');
    }
}

function editVoucher(maGG, ten, tienGiam, moTa, ngayHetHan, hoatDong, loaiGiam, giaTriToiDa, dieuKienToiThieu) {
    // Populate basic fields
    document.getElementById('editMaGG').value = maGG;
    document.getElementById('editTen').value = ten;
    document.getElementById('editTienGiam').value = tienGiam;
    document.getElementById('editMoTa').value = moTa;
    
    // Xử lý ngày hết hạn
    if (ngayHetHan && ngayHetHan !== '0000-00-00 00:00:00') {
        document.getElementById('editNgayHetHan').value = ngayHetHan.replace(" ", "T");
    }
    
    document.getElementById('editHoatDong').value = hoatDong;
    
    // Set loại giảm giá và trigger field visibility
    document.getElementById('editLoaiGiam').value = loaiGiam || 'tien';
    toggleEditDiscountFields();
    
    // Set giá trị tối đa nếu có
    if (giaTriToiDa && giaTriToiDa !== '') {
        document.getElementById('editGiaTriToiDa').value = giaTriToiDa;
    } else {
        document.getElementById('editGiaTriToiDa').value = '';
    }
    
    // Set điều kiện tối thiểu nếu có
    if (dieuKienToiThieu && dieuKienToiThieu !== '') {
        document.getElementById('editDieuKienToiThieu').value = dieuKienToiThieu;
    } else {
        document.getElementById('editDieuKienToiThieu').value = '';
    }
    
    openModal('editVoucherModal');
}

function confirmDeleteVoucher(id, name) {
    if (confirm(`Bạn có chắc chắn muốn xóa mã "${name}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `index.php?page=Voucher&action=delete`;

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
