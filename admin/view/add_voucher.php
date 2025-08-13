<?php
if (!isset($voucher)) {
    header('Location: index.php?page=voucher_list');
    exit;
}
?>

<div class="main-content">
    <div class="page-header">
        <h1>Thêm Voucher Mới</h1>
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
            <form method="POST" action="index.php?page=add_voucher_process">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tên voucher *</label>
                            <input type="text" name="Ten" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tiền giảm (VNĐ) *</label>
                            <input type="number" name="TienGiam" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ngày bắt đầu</label>
                            <input type="date" name="NgayBatDau" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ngày kết thúc</label>
                            <input type="date" name="NgayKetThuc" class="form-control" value="<?= date('Y-m-d', strtotime('+30 days')) ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Số lượng</label>
                            <input type="number" name="SoLuong" class="form-control" value="100">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="TrangThai" class="form-control">
                                <option value="Hoạt động">Hoạt động</option>
                                <option value="Tạm dừng">Tạm dừng</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="MoTa" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu voucher
                    </button>
                    <a href="index.php?page=voucher_list" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
