<?php
require_once __DIR__ . '/BaseController.php';

class UserController extends BaseController {
    
    public function index() {
        $search = $_GET['search'] ?? '';
        $users = $this->getAllUsers($search);
        
        include __DIR__ . '/../view/user_list.php';
    }
    
    public function addUser($data) {
        try {
            $data = $this->sanitize($data);
            
            if (!$this->validateRequired($data, ['HoTen', 'Email', 'TenDangNhap', 'MatKhau'])) {
                $this->redirect('User', 'Vui lòng nhập đầy đủ thông tin bắt buộc!', 'error');
            }
            
            // Kiểm tra email đã tồn tại
            $checkEmailSql = "SELECT COUNT(*) as count FROM taikhoan WHERE Email = ?";
            $emailResult = $this->getOne($checkEmailSql, [$data['Email']]);
            
            if ($emailResult['count'] > 0) {
                $this->redirect('User', 'Email đã tồn tại!', 'error');
            }
            
            // Kiểm tra username đã tồn tại
            $checkUsernameSql = "SELECT COUNT(*) as count FROM taikhoan WHERE TenDangNhap = ?";
            $usernameResult = $this->getOne($checkUsernameSql, [$data['TenDangNhap']]);
            
            if ($usernameResult['count'] > 0) {
                $this->redirect('User', 'Tên đăng nhập đã tồn tại!', 'error');
            }
            
            // Thêm user mới
            $sql = "INSERT INTO taikhoan (HoTen, Email, TenDangNhap, MatKhau, SoDienThoai, VaiTro, DiaChi, TrangThai) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $vaiTro = ($data['VaiTro'] == 'admin') ? 1 : 0;
            
            $success = $this->execute($sql, [
                $data['HoTen'],
                $data['Email'],
                $data['TenDangNhap'],
                $data['MatKhau'],
                $data['SoDienThoai'] ?? '',
                $vaiTro,
                $data['DiaChi'] ?? '',
                1 // TrangThai mặc định là active
            ]);
            
            $message = $success ? 'Thêm người dùng thành công!' : 'Thêm người dùng thất bại!';
            $type = $success ? 'success' : 'error';
            $this->redirect('User', $message, $type);
            
        } catch (Exception $e) {
            $this->redirect('User', 'Có lỗi xảy ra: ' . $e->getMessage(), 'error');
        }
    }
    
    public function editUser($data) {
        try {
            if (empty($data['id']) || empty($data['HoTen']) || empty($data['Email']) || empty($data['TenDangNhap'])) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
                header('Location: index.php?page=User');
                return;
            }
            
            $query = "UPDATE taikhoan SET HoTen = ?, Email = ?, TenDangNhap = ?, SoDienThoai = ?, VaiTro = ?, DiaChi = ?, TrangThai = ?";
            $params = [
                $data['HoTen'],
                $data['Email'],
                $data['TenDangNhap'],
                $data['SoDienThoai'] ?? '',
                ($data['VaiTro'] == 'admin') ? 1 : 0,
                $data['DiaChi'] ?? '',
                $data['TrangThai'] ?? 'Hoạt động'
            ];
            
            // Chỉ cập nhật mật khẩu nếu có nhập
            if (!empty($data['MatKhau'])) {
                $query .= ", MatKhau = ?";
                $params[] = $data['MatKhau'];
            }
            
            $query .= " WHERE MaTK = ?";
            $params[] = $data['id'];
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            
            $_SESSION['success'] = 'Cập nhật người dùng thành công!';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        header('Location: index.php?page=User');
    }
    
    public function deleteUser($data) {
        try {
            if (empty($data['id'])) {
                $_SESSION['error'] = 'ID người dùng không hợp lệ!';
                header('Location: index.php?page=User');
                return;
            }
            
            // Không cho xóa admin cuối cùng
            $checkAdmin = "SELECT COUNT(*) FROM taikhoan WHERE VaiTro = 1 AND MaTK != ?";
            $stmt = $this->conn->prepare($checkAdmin);
            $stmt->execute([$data['id']]);
            
            $user = $this->getUserById($data['id']);
            if ($user && $user['VaiTro'] == 1 && $stmt->fetchColumn() == 0) {
                $_SESSION['error'] = 'Không thể xóa admin cuối cùng!';
                header('Location: index.php?page=User');
                return;
            }
            
            $query = "DELETE FROM taikhoan WHERE MaTK = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$data['id']]);
            
            $_SESSION['success'] = 'Xóa người dùng thành công!';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        header('Location: index.php?page=User');
    }
    
    private function getAllUsers($search = '') {
        try {
            if (!empty($search)) {
                $sql = "SELECT * FROM taikhoan WHERE HoTen LIKE ? OR Email LIKE ? OR TenDangNhap LIKE ? ORDER BY MaTK DESC";
                $searchParam = '%' . $search . '%';
                return $this->getAll($sql, [$searchParam, $searchParam, $searchParam]);
            } else {
                $sql = "SELECT * FROM taikhoan ORDER BY MaTK DESC";
                return $this->getAll($sql);
            }
        } catch (Exception $e) {
            return [];
        }
    }
    
    private function getUserById($id) {
        try {
            $query = "SELECT * FROM taikhoan WHERE MaTK = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->addUser($_POST);
        } else {
            $_SESSION['error'] = 'Invalid request method';
            header('Location: index.php?page=User');
        }
    }
    
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->editUser($_POST);
        } else {
            $_SESSION['error'] = 'Invalid request method';
            header('Location: index.php?page=User');
        }
    }
    
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            
            if (empty($id)) {
                $_SESSION['error'] = 'ID không hợp lệ';
                header('Location: index.php?page=User');
                return;
            }
            
            try {
                $query = "DELETE FROM taikhoan WHERE MaTK = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$id]);
                
                $_SESSION['success'] = 'Xóa người dùng thành công!';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            }
            
            header('Location: index.php?page=User');
        }
    }
}
?>
