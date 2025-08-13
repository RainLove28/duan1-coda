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
            
            if (!$this->validateRequired($data, ['MaSP', 'NoiDung', 'Ratting'])) {
                $this->redirect('Comment', 'Thông tin không được để trống', 'error');
            }

            // Lấy MaTK từ session, ưu tiên 'id' trước rồi mới 'MaTK'
            $maTK = $_SESSION['user']['id'] ?? $_SESSION['user']['MaTK'] ?? null;
            
            // Debug logging
            error_log("Comment Add - Session user data: " . print_r($_SESSION['user'] ?? 'No user in session', true));
            error_log("Comment Add - MaTK value: " . ($maTK ?? 'NULL'));
            error_log("Comment Add - Data: " . print_r($data, true));
            
            // Kiểm tra xem có MaTK hợp lệ không
            if (empty($maTK)) {
                error_log("Comment Add - ERROR: Empty MaTK");
                $this->redirect('Comment', 'Không tìm thấy thông tin người dùng. MaTK: ' . ($maTK ?? 'null'), 'error');
                return;
            }
            
            $thoiGian = date('Y-m-d H:i:s');
            
            $sql = "INSERT INTO binhluan (MaSP, MaTK, NoiDung, Ratting, ThoiGian) VALUES (?, ?, ?, ?, ?)";
            $success = $this->execute($sql, [
                $data['MaSP'],
                $maTK,
                $data['NoiDung'],
                $data['Ratting'],
                $thoiGian
            ]);
            
            $message = $success ? 'Thêm bình luận thành công' : 'Thêm bình luận thất bại';
            $type = $success ? 'success' : 'error';
            $this->redirect('Comment', $message, $type);
        }
    }
    
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);
            
            if (!$this->validateRequired($data, ['id', 'MaSP', 'NoiDung', 'Ratting'])) {
                $this->redirect('Comment', 'Thông tin không hợp lệ', 'error');
            }

            // Lấy MaTK từ data hoặc session
            $maTK = $data['MaTK'] ?? $_SESSION['user']['id'] ?? $_SESSION['user']['MaTK'] ?? null;
            
            if (empty($maTK)) {
                $this->redirect('Comment', 'Không tìm thấy thông tin người dùng', 'error');
                return;
            }

            $sql = "UPDATE binhluan SET MaSP = ?, MaTK = ?, NoiDung = ?, Ratting = ? WHERE MaBL = ?";
            $success = $this->execute($sql, [
                $data['MaSP'],
                $maTK,
                $data['NoiDung'],
                $data['Ratting'],
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
    
    // Method cho admin routes
    public function renderCommentList() {
        $search = $_GET['search'] ?? '';
        
        if ($search) {
            $sql = "SELECT bl.*, sp.TenSP, u.fullname 
                    FROM binhluan bl 
                    JOIN sanpham sp ON bl.MaSP = sp.MaSP 
                    JOIN users u ON bl.MaTK = u.id 
                    WHERE bl.NoiDung LIKE ? OR sp.TenSP LIKE ? 
                    ORDER BY bl.MaBL DESC";
            $comments = $this->getAll($sql, ['%' . $search . '%', '%' . $search . '%']);
        } else {
            $sql = "SELECT bl.*, sp.TenSP, u.fullname 
                    FROM binhluan bl 
                    JOIN sanpham sp ON bl.MaSP = sp.MaSP 
                    JOIN users u ON bl.MaTK = u.id 
                    ORDER BY bl.MaBL DESC";
            $comments = $this->getAll($sql);
        }

        include __DIR__ . '/../view/comment_list.php';
    }
    
    public function deleteComment($id) {
        try {
            $sql = "DELETE FROM binhluan WHERE MaBL = ?";
            $this->execute($sql, [$id]);
            $_SESSION['success'] = 'Xóa bình luận thành công!';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        header('Location: index.php?page=comment_list');
    }
    
    public function toggleCommentStatus($id) {
        try {
            // Giả sử có cột TrangThai trong bảng binhluan
            $comment = $this->getOne("SELECT * FROM binhluan WHERE MaBL = ?", [$id]);
            $newStatus = ($comment['TrangThai'] == 'Hiển thị') ? 'Ẩn' : 'Hiển thị';
            
            $sql = "UPDATE binhluan SET TrangThai = ? WHERE MaBL = ?";
            $this->execute($sql, [$newStatus, $id]);
            $_SESSION['success'] = 'Cập nhật trạng thái bình luận thành công!';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        header('Location: index.php?page=comment_list');
    }
}
?>
