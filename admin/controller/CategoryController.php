<?php
require_once __DIR__ . '/BaseController.php';

class CategoryController extends BaseController {
    
    public function index() {
        $search = $_GET['search'] ?? '';
        
        if ($search) {
            $sql = "SELECT * FROM danhmuc WHERE TenDanhMuc LIKE ? ORDER BY MaDanhMuc DESC";
            $categories = $this->getAll($sql, ['%' . $search . '%']);
        } else {
            $sql = "SELECT * FROM danhmuc ORDER BY MaDanhMuc DESC";
            $categories = $this->getAll($sql);
        }
        
        include __DIR__ . '/../view/category_list.php';
    }
    
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);
            
            if (!$this->validateRequired($data, ['TenDanhMuc'])) {
                $this->redirect('Category', 'Tên danh mục không được để trống', 'error');
            }
            
            // Kiểm tra trùng tên
            $checkSql = "SELECT COUNT(*) as count FROM danhmuc WHERE TenDanhMuc = ?";
            $result = $this->getOne($checkSql, [$data['TenDanhMuc']]);
            
            if ($result['count'] > 0) {
                $this->redirect('Category', 'Tên danh mục đã tồn tại', 'error');
            }
            
            $sql = "INSERT INTO danhmuc(TenDanhMuc, MoTa) VALUES(?, ?)";
            $success = $this->execute($sql, [$data['TenDanhMuc'], $data['MoTa'] ?? '']);
            
            $message = $success ? 'Thêm danh mục thành công' : 'Thêm danh mục thất bại';
            $type = $success ? 'success' : 'error';
            $this->redirect('Category', $message, $type);
        }
    }
    
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);
            
            if (!$this->validateRequired($data, ['id', 'TenDanhMuc'])) {
                $this->redirect('Category', 'Thông tin không hợp lệ', 'error');
            }
            
            // Kiểm tra trùng tên (trừ bản ghi hiện tại)
            $checkSql = "SELECT COUNT(*) as count FROM danhmuc WHERE TenDanhMuc = ? AND MaDanhMuc != ?";
            $result = $this->getOne($checkSql, [$data['TenDanhMuc'], $data['id']]);
            
            if ($result['count'] > 0) {
                $this->redirect('Category', 'Tên danh mục đã tồn tại', 'error');
            }
            
            $sql = "UPDATE danhmuc SET TenDanhMuc = ?, MoTa = ? WHERE MaDanhMuc = ?";
            $success = $this->execute($sql, [$data['TenDanhMuc'], $data['MoTa'] ?? '', $data['id']]);
            
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
            $checkSql = "SELECT COUNT(*) as count FROM sanpham WHERE DanhMuc = (SELECT TenDanhMuc FROM danhmuc WHERE MaDanhMuc = ?)";
            $result = $this->getOne($checkSql, [$data['id']]);
            
            if ($result['count'] > 0) {
                $this->redirect('Category', 'Không thể xóa danh mục này vì còn sản phẩm thuộc danh mục', 'error');
            }
            
            $sql = "DELETE FROM danhmuc WHERE MaDanhMuc = ?";
            $success = $this->execute($sql, [$data['id']]);
            
            $message = $success ? 'Xóa danh mục thành công' : 'Xóa danh mục thất bại';
            $type = $success ? 'success' : 'error';
            $this->redirect('Category', $message, $type);
        }
    }
    
    public function getAllCategories() {
        $sql = "SELECT * FROM danhmuc ORDER BY TenDanhMuc";
        return $this->getAll($sql);
    }
    
    public function getCategoryById($id) {
        $sql = "SELECT * FROM danhmuc WHERE MaDanhMuc = ?";
        return $this->getOne($sql, [$id]);
    }
}
?>
