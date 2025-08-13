<?php
require_once __DIR__ . '/BaseController.php';

class CategoryController extends BaseController {
    
    public function index() {
        $search = $_GET['search'] ?? '';
        
        if ($search) {
            $sql = "SELECT * FROM danhmuc WHERE TenDM LIKE ? ORDER BY MaDM DESC";
            $categories = $this->getAll($sql, ['%' . $search . '%']);
        } else {
            $sql = "SELECT * FROM danhmuc ORDER BY MaDM DESC";
            $categories = $this->getAll($sql);
        }
        
        include __DIR__ . '/../view/category_list.php';
    }
    
    public function renderAddCategory() {
        // Redirect back to category list since we use modal
        header('Location: index.php?page=Category');
    }
    
    public function renderEditCategory($id) {
        // Redirect back to category list since we use modal
        header('Location: index.php?page=Category');
    }
    
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);
            
            if (!$this->validateRequired($data, ['TenDM'])) {
                $this->redirect('Category', 'Tên danh mục không được để trống', 'error');
            }
            
            // Kiểm tra trùng tên
            $checkSql = "SELECT COUNT(*) as count FROM danhmuc WHERE TenDM = ?";
            $result = $this->getOne($checkSql, [$data['TenDM']]);
            
            if ($result['count'] > 0) {
                $this->redirect('Category', 'Tên danh mục đã tồn tại', 'error');
            }
            
            $sql = "INSERT INTO danhmuc(TenDM, MoTa) VALUES(?, ?)";
            $success = $this->execute($sql, [$data['TenDM'], $data['MoTa'] ?? '']);
            
            $message = $success ? 'Thêm danh mục thành công' : 'Thêm danh mục thất bại';
            $type = $success ? 'success' : 'error';
            $this->redirect('Category', $message, $type);
        }
    }
    
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);
            
            if (!$this->validateRequired($data, ['id', 'TenDM'])) {
                $this->redirect('Category', 'Thông tin không hợp lệ', 'error');
            }
            
            // Kiểm tra trùng tên (trừ bản ghi hiện tại)
            $checkSql = "SELECT COUNT(*) as count FROM danhmuc WHERE TenDM = ? AND MaDM != ?";
            $result = $this->getOne($checkSql, [$data['TenDM'], $data['id']]);
            
            if ($result['count'] > 0) {
                $this->redirect('Category', 'Tên danh mục đã tồn tại', 'error');
            }
            
            $sql = "UPDATE danhmuc SET TenDM = ?, MoTa = ? WHERE MaDM = ?";
            $success = $this->execute($sql, [$data['TenDM'], $data['MoTa'] ?? '', $data['id']]);
            
            $message = $success ? 'Cập nhật danh mục thành công' : 'Cập nhật danh mục thất bại';
            $type = $success ? 'success' : 'error';
            $this->redirect('Category', $message, $type);
        }
    }
    
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);
            
            if (!$this->validateRequired($data, ['id'])) {
                $this->redirect('Category', 'ID danh mục không hợp lệ', 'error');
            }
            
            // Kiểm tra xem có sản phẩm nào thuộc danh mục này không
            $checkSql = "SELECT COUNT(*) as count FROM sanpham WHERE MaDM = ?";
            $result = $this->getOne($checkSql, [$data['id']]);
            
            if ($result['count'] > 0) {
                $this->redirect('Category', 'Không thể xóa danh mục này vì còn sản phẩm thuộc danh mục', 'error');
            }
            
            $sql = "DELETE FROM danhmuc WHERE MaDM = ?";
            $success = $this->execute($sql, [$data['id']]);
            
            $message = $success ? 'Xóa danh mục thành công' : 'Xóa danh mục thất bại';
            $type = $success ? 'success' : 'error';
            $this->redirect('Category', $message, $type);
        }
    }
    
    public function getAllCategories() {
        $sql = "SELECT * FROM danhmuc ORDER BY TenDM";
        return $this->getAll($sql);
    }
    
    public function getCategoryById($id) {
        $sql = "SELECT * FROM danhmuc WHERE MaDM = ?";
        return $this->getOne($sql, [$id]);
    }
}
?>
