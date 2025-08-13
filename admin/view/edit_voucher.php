<?php
if (!isset($voucher)) {
    header('Location: index.php?page=voucher_list');
    exit;
}
?>

<div class="main-content">
    <div class="page-header">
        <h1>Sửa Voucher</h1>
        <a href="index.php?page=voucher_list" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="index.php?page=edit_voucher_process&id=<?= $voucher['MaGG'] ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tên voucher *</label>
                            <input type="text" name="Ten" class="form-control" value="<?= htmlspecialchars($voucher['Ten']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tiền giảm (VNĐ) *</label>
                            <input type="number" name="TienGiam" class="form-control" value="<?= $voucher['TienGiam'] ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ngày bắt đầu</label>
                            <input type="date" name="NgayBatDau" class="form-control" value="<?= $voucher['NgayBatDau'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ngày kết thúc</label>
                            <input type="date" name="NgayKetThuc" class="form-control" value="<?= $voucher['NgayKetThuc'] ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Số lượng</label>
                            <input type="number" name="SoLuong" class="form-control" value="<?= $voucher['SoLuong'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="TrangThai" class="form-control">
                                <option value="Hoạt động" <?= $voucher['TrangThai'] == 'Hoạt động' ? 'selected' : '' ?>>Hoạt động</option>
                                <option value="Tạm dừng" <?= $voucher['TrangThai'] == 'Tạm dừng' ? 'selected' : '' ?>>Tạm dừng</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="MoTa" class="form-control" rows="3"><?= htmlspecialchars($voucher['MoTa']) ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật voucher
                    </button>
                    <a href="index.php?page=voucher_list" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
