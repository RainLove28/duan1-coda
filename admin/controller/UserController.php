<?php
require_once __DIR__ . '/BaseController.php';

class UserController extends BaseController {
    
    public function index() {
        $search = $_GET['search'] ?? '';
        $users = $this->getAllUsers($search);
        
        include __DIR__ . '/../view/user_list.php';
    }
    
    public function renderAddUser() {
        // Redirect back to user list since we use modal
        header('Location: index.php?page=User');
    }
    
    public function renderEditUser($id) {
        // Redirect back to user list since we use modal  
        header('Location: index.php?page=User');
    }
    
    public function addUser($data) {
        try {
            $data = $this->sanitize($data);
            
            if (!$this->validateRequired($data, ['fullname', 'email', 'username', 'password'])) {
                $this->redirect('User', 'Vui lòng nhập đầy đủ thông tin bắt buộc!', 'error');
            }
            
            // Kiểm tra email đã tồn tại
            $checkEmailSql = "SELECT COUNT(*) as count FROM users WHERE email = ?";
            $emailResult = $this->getOne($checkEmailSql, [$data['email']]);
            
            if ($emailResult['count'] > 0) {
                $this->redirect('User', 'Email đã tồn tại!', 'error');
            }
            
            // Kiểm tra username đã tồn tại
            $checkUsernameSql = "SELECT COUNT(*) as count FROM users WHERE username = ?";
            $usernameResult = $this->getOne($checkUsernameSql, [$data['username']]);
            
            if ($usernameResult['count'] > 0) {
                $this->redirect('User', 'Tên đăng nhập đã tồn tại!', 'error');
            }
            
            // Thêm user mới
            $sql = "INSERT INTO users (fullname, email, username, password, mobile, role, address, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $role = ($data['role'] == 'admin') ? 'admin' : 'user';
            
            $success = $this->execute($sql, [
                $data['fullname'],
                $data['email'],
                $data['username'],
                $data['password'],
                $data['mobile'] ?? '',
                $role,
                $data['address'] ?? '',
                $data['status'] ?? 1
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
            if (empty($data['id']) || empty($data['fullname']) || empty($data['email']) || empty($data['username'])) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
                header('Location: index.php?page=User');
                return;
            }
            
            $query = "UPDATE users SET fullname = ?, email = ?, username = ?, mobile = ?, role = ?, address = ?, status = ?";
            $params = [
                $data['fullname'],
                $data['email'],
                $data['username'],
                $data['mobile'] ?? '',
                ($data['role'] == 'admin') ? 'admin' : 'user',
                $data['address'] ?? '',
                $data['status'] ?? 'Hoạt động'
            ];
            
            // Chỉ cập nhật mật khẩu nếu có nhập
            if (!empty($data['password'])) {
                $query .= ", password = ?";
                $params[] = $data['password'];
            }
            
            $query .= " WHERE id = ?";
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
            $checkAdmin = "SELECT COUNT(*) FROM users WHERE role = 'admin' AND id != ?";
            $stmt = $this->conn->prepare($checkAdmin);
            $stmt->execute([$data['id']]);
            
            $user = $this->getUserById($data['id']);
            if ($user && $user['role'] == 'admin' && $stmt->fetchColumn() == 0) {
                $_SESSION['error'] = 'Không thể xóa admin cuối cùng!';
                header('Location: index.php?page=User');
                return;
            }
            
            $query = "DELETE FROM users WHERE id = ?";
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
                $sql = "SELECT * FROM users WHERE fullname LIKE ? OR email LIKE ? OR username LIKE ? ORDER BY id DESC";
                $searchParam = '%' . $search . '%';
                return $this->getAll($sql, [$searchParam, $searchParam, $searchParam]);
            } else {
                $sql = "SELECT * FROM users ORDER BY id DESC";
                return $this->getAll($sql);
            }
        } catch (Exception $e) {
            return [];
        }
    }
    
    private function getUserById($id) {
        try {
            $query = "SELECT * FROM users WHERE id = ?";
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
                $query = "DELETE FROM users WHERE id = ?";
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
