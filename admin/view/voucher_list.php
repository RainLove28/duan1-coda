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
                        <th>Tiền giảm</th>
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
                            <td><?= htmlspecialchars($item['TienGiam']) ?></td>
                            <td><?= htmlspecialchars($item['MoTa']) ?></td>
                            <td><?= $item['NgayHetHan'] ?></td>
                            <td>
                                <?= $item['HoatDong'] ? '<span class="badge badge-success">Hoạt động</span>' : '<span class="badge badge-secondary">Không</span>' ?>
                            </td>
                            <td class="action-buttons">
                                <button class="btn btn-edit btn-sm" 
                                        onclick="editVoucher(<?= $item['MaGG'] ?>, '<?= htmlspecialchars($item['Ten']) ?>', '<?= htmlspecialchars($item['TienGiam']) ?>', '<?= htmlspecialchars($item['MoTa']) ?>', '<?= $item['NgayHetHan'] ?>', <?= $item['HoatDong'] ?>)">
                                    <i class="fas fa-edit"></i> Sửa
                                </button>
                                <button class="btn btn-delete btn-sm" 
                                        onclick="confirmDeleteVoucher(<?= $item['MaGG'] ?>, '<?= htmlspecialchars($item['Ten']) ?>')">
                                    <i class="fas fa-trash"></i> Xóa
                                </td>
                            
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($vouchers)): ?>
                        <tr><td colspan="7">Không có mã giảm giá nào.</td></tr>
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
                    <label for="TienGiam">Tiền giảm <span class="required">*</span></label>
                    <input type="text" id="TienGiam" name="TienGiam" required>
                </div>
                <div class="form-group">
                    <label for="MoTa">Mô tả</label>
                    <textarea id="MoTa" name="MoTa" rows="3" placeholder="Nhập mô tả..."></textarea>
                </div>
                <div class="form-group">
                    <label for="NgayHetHan">Ngày hết hạn <span class="required">*</span></label>
                    <input type="datetime-local" id="NgayHetHan" name="NgayHetHan" required>
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
                    <label for="editTienGiam">Tiền giảm</label>
                    <input type="text" id="editTienGiam" name="TienGiam">
                </div>
                <div class="form-group">
                    <label for="editMoTa">Mô tả</label>
                    <textarea id="editMoTa" name="MoTa" rows="3"></textarea>
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
</style>

<script>
function editVoucher(maGG, ten, tienGiam, moTa, ngayHetHan, hoatDong) {
    document.getElementById('editMaGG').value = maGG;
    document.getElementById('editTen').value = ten;
    document.getElementById('editTienGiam').value = tienGiam;
    document.getElementById('editMoTa').value = moTa;
    document.getElementById('editNgayHetHan').value = ngayHetHan.replace(" ", "T"); // để khớp input datetime-local
    document.getElementById('editHoatDong').value = hoatDong;
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
