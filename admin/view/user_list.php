<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-users"></i> Quản lý Người dùng</h1>
        <button class="btn btn-success" onclick="openModal('addUserModal')">
            <i class="fas fa-plus"></i> Thêm người dùng
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
                <input type="hidden" name="page" value="User">
                <input type="text" name="search" placeholder="Tìm kiếm người dùng..." 
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
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Tên đăng nhập</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th>Ngày đăng ký</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['MaTK'] ?></td>
                                <td><?= htmlspecialchars($user['HoTen']) ?></td>
                                <td><?= htmlspecialchars($user['Email']) ?></td>
                                <td><?= htmlspecialchars($user['TenDangNhap']) ?></td>
                                <td><?= htmlspecialchars($user['SoDienThoai']) ?></td>
                                <td>
                                    <span class="role-badge role-<?= $user['VaiTro'] == 1 ? 'admin' : 'user' ?>">
                                        <?= $user['VaiTro'] == 1 ? 'Admin' : 'Khách hàng' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $user['TrangThai'])) ?>">
                                        <?= htmlspecialchars($user['TrangThai']) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($user['NgayDangKy'])) ?></td>
                                <td class="action-buttons">
                                    <button class="btn btn-edit btn-sm" 
                                            onclick="editUser(<?= $user['MaTK'] ?>, '<?= htmlspecialchars($user['HoTen']) ?>', '<?= htmlspecialchars($user['Email']) ?>', '<?= htmlspecialchars($user['TenDangNhap']) ?>', '<?= htmlspecialchars($user['SoDienThoai']) ?>', '<?= $user['VaiTro'] == 1 ? 'admin' : 'user' ?>', '<?= htmlspecialchars($user['TrangThai']) ?>', '<?= htmlspecialchars($user['DiaChi']) ?>')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-delete btn-sm" 
                                            onclick="confirmDelete('User', <?= $user['MaTK'] ?>, '<?= htmlspecialchars($user['HoTen']) ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
</div>

<!-- Add User Modal -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-plus"></i> Thêm người dùng mới</h3>
            <span class="close" onclick="closeModal('addUserModal')">&times;</span>
        </div>
        <form method="POST" action="index.php?action=addUser">
            <div class="modal-body">
                <div class="form-group">
                    <label for="HoTen">Họ tên <span class="required">*</span></label>
                    <input type="text" id="HoTen" name="HoTen" required>
                </div>
                <div class="form-group">
                    <label for="Email">Email <span class="required">*</span></label>
                    <input type="email" id="Email" name="Email" required>
                </div>
                <div class="form-group">
                    <label for="TenDangNhap">Tên đăng nhập <span class="required">*</span></label>
                    <input type="text" id="TenDangNhap" name="TenDangNhap" required>
                </div>
                <div class="form-group">
                    <label for="MatKhau">Mật khẩu <span class="required">*</span></label>
                    <input type="password" id="MatKhau" name="MatKhau" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="SoDienThoai">Số điện thoại</label>
                        <input type="text" id="SoDienThoai" name="SoDienThoai">
                    </div>
                    <div class="form-group">
                        <label for="VaiTro">Vai trò</label>
                        <select id="VaiTro" name="VaiTro">
                            <option value="user">Khách hàng</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="DiaChi">Địa chỉ</label>
                    <textarea id="DiaChi" name="DiaChi" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="TrangThai">Trạng thái</label>
                    <select id="TrangThai" name="TrangThai">
                        <option value="Hoạt động">Hoạt động</option>
                        <option value="Bị khóa">Bị khóa</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addUserModal')">Hủy</button>
                <button type="submit" class="btn btn-success">Thêm người dùng</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> Chỉnh sửa người dùng</h3>
            <span class="close" onclick="closeModal('editUserModal')">&times;</span>
        </div>
        <form method="POST" action="index.php?action=editUser">
            <input type="hidden" id="editUserId" name="id">
            <div class="modal-body" style="overflow-y: auto !important; max-height: 60vh !important; height: auto !important;">
                <div class="form-group">
                    <label for="editHoTen">Họ tên <span class="required">*</span></label>
                    <input type="text" id="editHoTen" name="HoTen" required>
                </div>
                <div class="form-group">
                    <label for="editEmail">Email <span class="required">*</span></label>
                    <input type="email" id="editEmail" name="Email" required>
                </div>
                <div class="form-group">
                    <label for="editTenDangNhap">Tên đăng nhập <span class="required">*</span></label>
                    <input type="text" id="editTenDangNhap" name="TenDangNhap" required>
                </div>
                <div class="form-group">
                    <label for="editMatKhau">Mật khẩu mới (để trống nếu không đổi)</label>
                    <input type="password" id="editMatKhau" name="MatKhau">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="editSoDienThoai">Số điện thoại</label>
                        <input type="text" id="editSoDienThoai" name="SoDienThoai">
                    </div>
                    <div class="form-group">
                        <label for="editVaiTro">Vai trò</label>
                        <select id="editVaiTro" name="VaiTro">
                            <option value="user">Khách hàng</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="editDiaChi">Địa chỉ</label>
                    <textarea id="editDiaChi" name="DiaChi" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="editTrangThai">Trạng thái</label>
                    <select id="editTrangThai" name="TrangThai">
                        <option value="Hoạt động">Hoạt động</option>
                        <option value="Bị khóa">Bị khóa</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editUserModal')">Hủy</button>
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Fix Modal Scroll Issue */
.modal {
    display: none;
    position: fixed !important;
    z-index: 9999 !important;
    left: 0;
    top: 0;
    width: 100% !important;
    height: 100% !important;
    background: rgba(0,0,0,0.5) !important;
    overflow: auto !important;
}

.modal-content {
    background: white !important;
    margin: 2% auto !important;
    padding: 0 !important;
    border-radius: 10px !important;
    width: 90% !important;
    max-width: 600px !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important;
    max-height: 90vh !important;
    display: flex !important;
    flex-direction: column !important;
}

.modal-body {
    padding: 20px !important;
    overflow-y: auto !important;
    flex: 1 !important;
    max-height: calc(90vh - 140px) !important;
}

.modal-body::-webkit-scrollbar {
    width: 8px !important;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f1f1 !important;
    border-radius: 4px !important;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #888 !important;
    border-radius: 4px !important;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #555 !important;
}


</style>

<script>
function editUser(id, hoTen, email, tenDangNhap, soDienThoai, vaiTro, trangThai, diaChi) {
    document.getElementById('editUserId').value = id;
    document.getElementById('editHoTen').value = hoTen;
    document.getElementById('editEmail').value = email;
    document.getElementById('editTenDangNhap').value = tenDangNhap;
    document.getElementById('editSoDienThoai').value = soDienThoai;
    document.getElementById('editVaiTro').value = vaiTro;
    document.getElementById('editTrangThai').value = trangThai;
    document.getElementById('editDiaChi').value = diaChi;
    
    // Open modal with custom function
    openModalWithScroll('editUserModal');
}

function openModalWithScroll(modalId) {
    const modal = document.getElementById(modalId);
    const modalBody = modal.querySelector('.modal-body');
    
    // Show modal
    modal.style.display = 'block';
    
    // Force scroll properties
    setTimeout(() => {
        modal.style.overflow = 'auto';
        modalBody.style.overflowY = 'auto';
        modalBody.style.maxHeight = 'calc(90vh - 140px)';
        modalBody.scrollTop = 0;
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
        
        console.log('Modal opened with scroll:', {
            modalOverflow: modal.style.overflow,
            bodyOverflow: modalBody.style.overflowY,
            bodyMaxHeight: modalBody.style.maxHeight
        });
    }, 50);
}

function confirmDelete(type, id, name) {
    if (confirm(`Bạn có chắc chắn muốn xóa người dùng "${name}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `index.php?action=delete${type}`;
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.value = id;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}

// Override closeModal function for this page
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Force CSS on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add CSS dynamically
    const style = document.createElement('style');
    style.textContent = `
        .modal-body {
            overflow-y: scroll !important;
            max-height: 60vh !important;
            height: auto !important;
        }
    `;
    document.head.appendChild(style);
    
    console.log('Force CSS applied');
});
</script>
</script>
