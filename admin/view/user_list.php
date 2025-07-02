<div class="user-management">
    <div class="page-header">
        <h2><i class="bi bi-people-fill"></i> Quản lý người dùng</h2>
        <a href="?page=add_user" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm người dùng
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            switch ($_GET['success']) {
                case '1': echo 'Thêm người dùng thành công!'; break;
                case '2': echo 'Cập nhật người dùng thành công!'; break;
                case '3': echo 'Xóa người dùng thành công!'; break;
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php
            switch ($_GET['error']) {
                case '1': echo 'Có lỗi xảy ra, vui lòng thử lại!'; break;
                case '2': echo 'Không thể xóa người dùng!'; break;
            }
            ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['HoTen']) ?></td>
                            <td><?= htmlspecialchars($user['Email']) ?></td>
                            <td><?= htmlspecialchars($user['SoDienThoai'] ?? '') ?></td>
                            <td><?= htmlspecialchars($user['DiaChi'] ?? '') ?></td>
                            <td>
                                <span class="badge <?= $user['vaitro'] == 1 ? 'bg-danger' : 'bg-primary' ?>">
                                    <?= $user['vaitro'] == 1 ? 'Admin' : 'Khách hàng' ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= $user['TrangThai'] == 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= $user['TrangThai'] == 'active' ? 'Hoạt động' : 'Không hoạt động' ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="?page=edit_user&id=<?= $user['id'] ?>" 
                                       class="btn btn-sm btn-outline-primary" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    <a href="?page=toggle_user_status&id=<?= $user['id'] ?>" 
                                       class="btn btn-sm btn-outline-warning" 
                                       title="<?= $user['TrangThai'] == 'active' ? 'Vô hiệu hóa' : 'Kích hoạt' ?>">
                                        <i class="bi bi-<?= $user['TrangThai'] == 'active' ? 'lock' : 'unlock' ?>"></i>
                                    </a>
                                    
                                    <?php if ($user['vaitro'] != 1): ?>
                                        <a href="?page=delete_user&id=<?= $user['id'] ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           title="Xóa"
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Không có người dùng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.user-management {
    padding: 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.page-header h2 {
    margin: 0;
    color: #333;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    transition: all 0.3s;
}

.btn-primary {
    background: #007bff;
    color: white;
    border: 1px solid #007bff;
}

.btn-primary:hover {
    background: #0056b3;
}

.alert {
    padding: 12px 16px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table th,
.table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.table th {
    background: #f8f9fa;
    font-weight: 600;
}

.table tr:hover {
    background: #f8f9fa;
}

.badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.bg-primary { background: #007bff !important; color: white; }
.bg-danger { background: #dc3545 !important; color: white; }
.bg-success { background: #28a745 !important; color: white; }
.bg-secondary { background: #6c757d !important; color: white; }

.btn-group {
    display: flex;
    gap: 4px;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 12px;
}

.btn-outline-primary {
    border: 1px solid #007bff;
    color: #007bff;
    background: transparent;
}

.btn-outline-primary:hover {
    background: #007bff;
    color: white;
}

.btn-outline-warning {
    border: 1px solid #ffc107;
    color: #ffc107;
    background: transparent;
}

.btn-outline-warning:hover {
    background: #ffc107;
    color: #212529;
}

.btn-outline-danger {
    border: 1px solid #dc3545;
    color: #dc3545;
    background: transparent;
}

.btn-outline-danger:hover {
    background: #dc3545;
    color: white;
}
</style>
