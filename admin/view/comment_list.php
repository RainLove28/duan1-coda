<div class="main-content">
    <div class="content-header">
        <h1><i class="fas fa-comments"></i> Quản lý Bình luận</h1>
         <button class="btn btn-success" onclick="openModal('addCommentModal')">
            <i class="fas fa-plus"></i> Thêm bình luận
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
                <input type="hidden" name="page" value="Comment">
                <input type="text" name="search" placeholder="Tìm kiếm bình luận..." 
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
                        <th>MaBL</th>
                        <th>MaSP</th>
                        <th>MaTK</th>
                        <th>NoiDung</th>
                        <th>DanhGia</th>
                        <th>TrangThai</th>
                        <th>NgayBinhLuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                            <tr>
                                <td><?= $comment['MaBL'] ?></td>
                                <td><?= $comment['MaSP'] ?></td>
                                <td><?= $comment['MaTK'] ?></td>
                                <td><?= htmlspecialchars($comment['NoiDung']) ?></td>
                                <td><?= $comment['DanhGia'] ?></td>
                                <td><?= $comment['TrangThai'] ?></td>
                                <td><?= $comment['NgayBinhLuan'] ?></td>
                                 <td class="action-buttons">
                                    <button class="btn btn-edit btn-sm" 
                                            onclick="editComment(<?= $comment['MaBL'] ?>, '<?= htmlspecialchars($comment['NoiDung']) ?>', <?= $comment['DanhGia'] ?>, '<?= $comment['TrangThai'] ?>', <?= $comment['MaTK'] ?>, <?= $comment['MaSP'] ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-delete btn-sm" 
                                            onclick="confirmDelete('Comment', <?= $comment['MaBL'] ?>, '<?= htmlspecialchars($comment['NoiDung']) ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Không có bình luận nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
                            
                    

<!-- Add Comment Modal -->
<div id="addCommentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-plus"></i> Thêm Bình luận mới</h3>
            <span class="close" onclick="closeModal('addCommentModal')">&times;</span>
        </div>
        <form action="index.php?page=addComment" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <label for="MaSP">Mã sản phẩm <span class="required">*</span></label>
                    <input type="text" id="MaSP" name="MaSP" required>
                </div>
                <div class="form-group">
                    <label for="NoiDung">Nội Dung Bình Luận</label>
                    <textarea id="NoiDung" name="NoiDung" rows="4" placeholder="Nội dung bình luận..."></textarea>
                </div>
                <div class="form-group">
                    <label for="DanhGia">Đánh Giá</label>
                    <select id="DanhGia" name="DanhGia">
                        <option value="1">1 sao</option>
                        <option value="2">2 sao</option>
                        <option value="3">3 sao</option>
                        <option value="4">4 sao</option>
                        <option value="5">5 sao</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addCommentModal')">Hủy</button>
                <button type="submit" class="btn btn-success">Thêm bình luận</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Comment Modal -->
<div id="editCommentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> Chỉnh sửa bình luận</h3>
            <span class="close" onclick="closeModal('editCommentModal')">&times;</span>
        </div>
        <form method="post" action="index.php?page=editComment" enctype="multipart/form-data">
            <input type="hidden" id="editCommentId" name="id">
            <input type="hidden" id="editMaTK" name="MaTK">
            <input type="hidden" id="editMaSP" name="MaSP">
            <div class="modal-body">
                <div class="form-group">
                    <label for="editNoiDung">Nội Dung Bình Luận <span class="required">*</span></label>
                    <textarea id="editNoiDung" name="NoiDung" rows="4" placeholder="Nội dung bình luận..."></textarea>
                </div>
                <div class="form-group">
                    <label for="editDanhGia">Đánh Giá</label>
                    <select id="editDanhGia" name="DanhGia">
                        <option value="1">1 sao</option>
                        <option value="2">2 sao</option>
                        <option value="3">3 sao</option>
                        <option value="4">4 sao</option>
                        <option value="5">5 sao</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editTrangThai">Trạng Thái</label>
                    <select id="editTrangThai" name="TrangThai">
                        <option value="Chờ duyệt">Chờ duyệt</option>
                        <option value="Hiển thị">Hiển thị</option>
                        <option value="Không hoạt động">Không hoạt động</option>
                    </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editCommentModal')">Hủy</button>
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
function editComment(id, noiDung, danhGia, trangThai, maTK, maSP) {
    document.getElementById('editCommentId').value = id;
    document.getElementById('editNoiDung').value = noiDung;
    document.getElementById('editDanhGia').value = danhGia;
    document.getElementById('editTrangThai').value = trangThai;
    document.getElementById('editMaTK').value = maTK;
    document.getElementById('editMaSP').value = maSP;
    openModal('editCommentModal');
}

function confirmDelete(type, id, name) {
    if (confirm(`Bạn có chắc chắn muốn xóa bình luận "${name}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `index.php?page=deleteComment`;

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
