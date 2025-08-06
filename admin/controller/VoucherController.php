<?php
require_once __DIR__ . '/BaseController.php';

class VoucherController extends BaseController {

    public function index() {
        $search = $_GET['search'] ?? '';

        if ($search) {
            $sql = "SELECT * FROM voucher WHERE Ten LIKE ? ORDER BY MaGG DESC";
            $vouchers = $this->getAll($sql, ['%' . $search . '%']);
        } else {
            $sql = "SELECT * FROM voucher ORDER BY MaGG DESC";
            $vouchers = $this->getAll($sql);
        }

        include __DIR__ . '/../view/voucher_list.php';
    }

   public function add() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $this->sanitize($_POST);

        // Kiểm tra các trường bắt buộc
        if (!$this->validateRequired($data, ['Ten', 'TienGiam', 'MoTa'])) {
            $this->redirect('Voucher', 'Thông tin không được để trống', 'error');
        }

        // Thiết lập mặc định
        $ngayTao = date('Y-m-d H:i:s');
        $trangThai = $data['HoatDong'] ?? 1; // mặc định là hoạt động
        $ngayHetHan = $data['NgayHetHan'] ?? null;

        // Thêm dữ liệu vào DB
        $sql = "INSERT INTO voucher (Ten, TienGiam, MoTa, NgayTao, NgayHetHan, HoatDong) VALUES (?, ?, ?, ?, ?, ?)";
        $success = $this->execute($sql, [
            $data['Ten'],
            $data['TienGiam'],
            $data['MoTa'],
            $ngayTao,
            $ngayHetHan,
            $trangThai
        ]);

        // Gửi thông báo
        $message = $success ? 'Thêm mã giảm giá thành công' : 'Thêm mã giảm giá thất bại';
        $type = $success ? 'success' : 'error';
        $this->redirect('Voucher', $message, $type);
    }
}


    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);
            if (empty($data['MaGG'])) {
                $this->redirect('Voucher', 'Mã giảm giá không hợp lệ', 'error');
            }

            if (!$this->validateRequired($data, ['Ten', 'TienGiam', 'MoTa', 'NgayHetHan', 'HoatDong'])) {
                $this->redirect('Voucher', 'Vui lòng điền đầy đủ thông tin', 'error');
            }

            $sql = "UPDATE voucher SET Ten = ?, TienGiam = ?, MoTa = ?, NgayHetHan = ?, HoatDong = ? WHERE MaGG = ?";
            $success = $this->execute($sql, [
                $data['Ten'],
                $data['TienGiam'],
                $data['MoTa'],
                $data['NgayHetHan'],
                $data['HoatDong'],
                $data['MaGG']
            ]);

            $message = $success ? 'Cập nhật mã giảm giá thành công' : 'Cập nhật thất bại';
            $this->redirect('Voucher', $message, $success ? 'success' : 'error');
        }

        $this->redirect('Voucher', 'Yêu cầu không hợp lệ', 'error');
    }

    public function delete() {
        $id = $_POST['id'] ?? ($_GET['id'] ?? 0);
        $sql = "DELETE FROM voucher WHERE MaGG = ?";
        $success = $this->execute($sql, [$id]);

        $message = $success ? 'Xóa thành công' : 'Xóa thất bại';
        $this->redirect('Voucher', $message, $success ? 'success' : 'error');
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
