<?php
class UserController {
    private $userModel;
    
    public function __construct() {
        require_once('../site/model/UserModel.php');
        $this->userModel = new UserModel();
    }
    
    public function renderUserList() {
        $users = $this->getAllUsers();
        require_once('view/user_list.php');
    }
    
    public function renderAddUser() {
        require_once('view/add_user.php');
    }
    
    public function addUser($data) {
        $result = $this->userModel->addUser($data);
        if ($result) {
            header('Location: index.php?page=user_list&success=1');
        } else {
            header('Location: index.php?page=add_user&error=1');
        }
    }
    
    public function renderEditUser($id) {
        $user = $this->getUserById($id);
        require_once('view/edit_user.php');
    }
    
    public function editUser($data) {
        $result = $this->userModel->updateProfile($data['id'], $data);
        if ($result) {
            header('Location: index.php?page=user_list&success=2');
        } else {
            header('Location: index.php?page=edit_user&id=' . $data['id'] . '&error=1');
        }
    }
    
    public function deleteUser($id) {
        $result = $this->deleteUserById($id);
        if ($result) {
            header('Location: index.php?page=user_list&success=3');
        } else {
            header('Location: index.php?page=user_list&error=2');
        }
    }
    
    public function toggleUserStatus($id) {
        $result = $this->toggleStatus($id);
        header('Location: index.php?page=user_list');
    }
    
    private function getAllUsers() {
        $sql = "SELECT id, Email, HoTen, DiaChi, SoDienThoai, vaitro, TrangThai, created_at FROM khachhang ORDER BY created_at DESC";
        return Database::getInstance()->getAll($sql);
    }
    
    private function getUserById($id) {
        $sql = "SELECT * FROM khachhang WHERE id = ?";
        return Database::getInstance()->getOne($sql, [$id]);
    }
    
    private function deleteUserById($id) {
        $sql = "DELETE FROM khachhang WHERE id = ? AND vaitro = 0"; // Không cho xóa admin
        return Database::getInstance()->execute($sql, [$id]);
    }
    
    private function toggleStatus($id) {
        $sql = "UPDATE khachhang SET TrangThai = CASE WHEN TrangThai = 'active' THEN 'inactive' ELSE 'active' END WHERE id = ?";
        return Database::getInstance()->execute($sql, [$id]);
    }
}
?>
