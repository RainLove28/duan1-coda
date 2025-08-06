<?php
require_once __DIR__ . '/BaseController.php';

class CommentController extends BaseController {
    
    public function index() {
        $search = $_GET['search'] ?? '';
        
        if ($search) {
            $sql = "SELECT * FROM binhluan WHERE NoiDung LIKE ? ORDER BY MaBL DESC";
            $comments = $this->getAll($sql, ['%' . $search . '%']);
        } else {
            $sql = "SELECT * FROM binhluan ORDER BY MaBL DESC";
            $comments = $this->getAll($sql);
        }

        include __DIR__ . '/../view/comment_list.php';
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);
            
            if (!$this->validateRequired($data, ['MaSP', 'NoiDung', 'DanhGia'])) {
                $this->redirect('Comment', 'Thông tin không được để trống', 'error');
            }

            $maTK = $_SESSION['user']['MaTK'] ?? '';
            $trangThai = 'Chờ duyệt';
            $ngayBinhLuan = date('Y-m-d H:i:s');
            
            $sql = "INSERT INTO binhluan (MaSP, MaTK, NoiDung, DanhGia, TrangThai, NgayBinhLuan) VALUES (?, ?, ?, ?, ?, ?)";
            $success = $this->execute($sql, [
                $data['MaSP'],
                $maTK,
                $data['NoiDung'],
                $data['DanhGia'],
                $trangThai,
                $ngayBinhLuan
            ]);
            
            $message = $success ? 'Thêm bình luận thành công' : 'Thêm bình luận thất bại';
            $type = $success ? 'success' : 'error';
            $this->redirect('Comment', $message, $type);
        }
    }
    
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);
            
            if (!$this->validateRequired($data, ['id', 'MaSP', 'NoiDung', 'DanhGia', 'TrangThai'])) {
                $this->redirect('Comment', 'Thông tin không hợp lệ', 'error');
            }

            $sql = "UPDATE binhluan SET MaSP = ?, MaTK = ?, NoiDung = ?, DanhGia = ?, TrangThai = ? WHERE MaBL = ?";
            $success = $this->execute($sql, [
                $data['MaSP'],
                $data['MaTK'] ?? '',
                $data['NoiDung'],
                $data['DanhGia'],
                $data['TrangThai'],
                $data['id']
            ]);

            $message = $success ? 'Cập nhật bình luận thành công' : 'Cập nhật bình luận thất bại';
            $type = $success ? 'success' : 'error';
            $this->redirect('Comment', $message, $type);
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);
            
            if (!$this->validateRequired($data, ['id'])) {
                $this->redirect('Comment', 'ID bình luận không hợp lệ', 'error');
            }

            $sql = "DELETE FROM binhluan WHERE MaBL = ?";
            $success = $this->execute($sql, [$data['id']]);

            $message = $success ? 'Xóa bình luận thành công' : 'Xóa bình luận thất bại';
            $type = $success ? 'success' : 'error';
            $this->redirect('Comment', $message, $type);
        }
    }

    public function getAllComments() {
        $sql = "SELECT * FROM binhluan ORDER BY NgayBinhLuan DESC";
        return $this->getAll($sql);
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM binhluan WHERE MaBL = ?";
        return $this->getOne($sql, [$id]);
    }
}
?>
