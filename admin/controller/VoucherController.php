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
        if (!$this->validateRequired($data, ['Ten', 'TienGiam', 'MoTa', 'LoaiGiam'])) {
            $this->redirect('Voucher', 'Thông tin không được để trống', 'error');
        }

        // Validate dữ liệu
        $tienGiam = floatval($data['TienGiam']);
        $loaiGiam = $data['LoaiGiam'];
        
        // Kiểm tra giá trị hợp lệ
        if ($tienGiam <= 0) {
            $this->redirect('Voucher', 'Giá trị giảm phải lớn hơn 0', 'error');
            return;
        }
        
        // Nếu là phần trăm, giá trị phải <= 100
        if ($loaiGiam === 'phan_tram' && $tienGiam > 100) {
            $this->redirect('Voucher', 'Phần trăm giảm giá không được vượt quá 100%', 'error');
            return;
        }

        // Thiết lập mặc định
        $ngayTao = date('Y-m-d H:i:s');
        $trangThai = $data['HoatDong'] ?? 1;
        $ngayHetHan = !empty($data['NgayHetHan']) ? $data['NgayHetHan'] : null;
        $giaTriToiDa = !empty($data['GiaTriToiDa']) ? floatval($data['GiaTriToiDa']) : null;
        $dieuKienToiThieu = !empty($data['DieuKienToiThieu']) ? floatval($data['DieuKienToiThieu']) : null;

        // Thêm dữ liệu vào DB
        $sql = "INSERT INTO voucher (Ten, TienGiam, LoaiGiam, GiaTriToiDa, DieuKienToiThieu, MoTa, NgayTao, NgayHetHan, HoatDong) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $success = $this->execute($sql, [
            $data['Ten'],
            $tienGiam,
            $loaiGiam,
            $giaTriToiDa,
            $dieuKienToiThieu,
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
                return;
            }

            // Kiểm tra các trường bắt buộc
            if (!$this->validateRequired($data, ['Ten', 'TienGiam', 'MoTa', 'LoaiGiam'])) {
                $this->redirect('Voucher', 'Vui lòng điền đầy đủ thông tin', 'error');
                return;
            }

            // Validate dữ liệu
            $tienGiam = floatval($data['TienGiam']);
            $loaiGiam = $data['LoaiGiam'];
            
            // Kiểm tra giá trị hợp lệ
            if ($tienGiam <= 0) {
                $this->redirect('Voucher', 'Giá trị giảm phải lớn hơn 0', 'error');
                return;
            }
            
            // Nếu là phần trăm, giá trị phải <= 100
            if ($loaiGiam === 'phan_tram' && $tienGiam > 100) {
                $this->redirect('Voucher', 'Phần trăm giảm giá không được vượt quá 100%', 'error');
                return;
            }

            // Thiết lập giá trị
            $ngayHetHan = !empty($data['NgayHetHan']) ? $data['NgayHetHan'] : null;
            $giaTriToiDa = !empty($data['GiaTriToiDa']) ? floatval($data['GiaTriToiDa']) : null;
            $dieuKienToiThieu = !empty($data['DieuKienToiThieu']) ? floatval($data['DieuKienToiThieu']) : null;
            $hoatDong = isset($data['HoatDong']) ? intval($data['HoatDong']) : 1;

            // Cập nhật với tất cả các field mới
            $sql = "UPDATE voucher SET Ten = ?, TienGiam = ?, LoaiGiam = ?, GiaTriToiDa = ?, DieuKienToiThieu = ?, MoTa = ?, NgayHetHan = ?, HoatDong = ? WHERE MaGG = ?";
            $success = $this->execute($sql, [
                $data['Ten'],
                $tienGiam,
                $loaiGiam,
                $giaTriToiDa,
                $dieuKienToiThieu,
                $data['MoTa'],
                $ngayHetHan,
                $hoatDong,
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

        $message = $success ? 'Xóa voucher thành công' : 'Xóa voucher thất bại';
        $this->redirect('Voucher', $message, $success ? 'success' : 'error');
    }

    // Methods cho admin routes  
    public function renderVoucherList() {
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
    
    public function renderAddVoucher() {
        include __DIR__ . '/../view/add_voucher.php';
    }
    
    public function addVoucher($data) {
        try {
            if (empty($data['Ten']) || empty($data['TienGiam'])) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
                header('Location: index.php?page=add_voucher');
                return;
            }

            $sql = "INSERT INTO voucher (Ten, TienGiam, MoTa, NgayBatDau, NgayKetThuc, SoLuong, TrangThai) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $this->execute($sql, [
                $data['Ten'],
                $data['TienGiam'],
                $data['MoTa'] ?? '',
                $data['NgayBatDau'] ?? date('Y-m-d'),
                $data['NgayKetThuc'] ?? date('Y-m-d', strtotime('+30 days')),
                $data['SoLuong'] ?? 100,
                'Hoạt động'
            ]);
            
            $_SESSION['success'] = 'Thêm voucher thành công!';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        header('Location: index.php?page=voucher_list');
    }
    
    public function renderEditVoucher($id) {
        $voucher = $this->getOne("SELECT * FROM voucher WHERE MaGG = ?", [$id]);
        include __DIR__ . '/../view/edit_voucher.php';
    }
    
    public function editVoucher($data) {
        try {
            $sql = "UPDATE voucher SET Ten = ?, TienGiam = ?, MoTa = ?, NgayBatDau = ?, NgayKetThuc = ?, SoLuong = ?, TrangThai = ? WHERE MaGG = ?";
            
            $this->execute($sql, [
                $data['Ten'],
                $data['TienGiam'],
                $data['MoTa'],
                $data['NgayBatDau'],
                $data['NgayKetThuc'],
                $data['SoLuong'],
                $data['TrangThai'],
                $data['id']
            ]);
            
            $_SESSION['success'] = 'Cập nhật voucher thành công!';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        header('Location: index.php?page=voucher_list');
    }
    
    public function deleteVoucher($id) {
        try {
            $sql = "DELETE FROM voucher WHERE MaGG = ?";
            $this->execute($sql, [$id]);
            $_SESSION['success'] = 'Xóa voucher thành công!';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        header('Location: index.php?page=voucher_list');
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM voucher WHERE MaGG = ?";
        return $this->getOne($sql, [$id]);
    }
    
    /**
     * Tính toán số tiền giảm giá cho đơn hàng
     * @param array $voucher Thông tin voucher
     * @param float $tongTienDonHang Tổng tiền đơn hàng
     * @return array ['success' => bool, 'tienGiam' => float, 'message' => string]
     */
    public function calculateDiscount($voucher, $tongTienDonHang) {
        // Kiểm tra voucher có tồn tại và còn hoạt động
        if (!$voucher || !$voucher['HoatDong']) {
            return ['success' => false, 'tienGiam' => 0, 'message' => 'Mã giảm giá không tồn tại hoặc đã hết hạn'];
        }
        
        // Kiểm tra ngày hết hạn
        if ($voucher['NgayHetHan'] && strtotime($voucher['NgayHetHan']) < time()) {
            return ['success' => false, 'tienGiam' => 0, 'message' => 'Mã giảm giá đã hết hạn'];
        }
        
        // Kiểm tra điều kiện tối thiểu
        if ($voucher['DieuKienToiThieu'] && $tongTienDonHang < $voucher['DieuKienToiThieu']) {
            return ['success' => false, 'tienGiam' => 0, 'message' => 'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($voucher['DieuKienToiThieu']) . 'đ'];
        }
        
        $tienGiam = 0;
        
        if ($voucher['LoaiGiam'] === 'tien') {
            // Giảm theo tiền mặt
            $tienGiam = floatval($voucher['TienGiam']);
            
            // Không được giảm quá tổng tiền đơn hàng
            if ($tienGiam > $tongTienDonHang) {
                $tienGiam = $tongTienDonHang;
            }
            
        } else if ($voucher['LoaiGiam'] === 'phan_tram') {
            // Giảm theo phần trăm
            $phanTram = floatval($voucher['TienGiam']);
            $tienGiam = ($tongTienDonHang * $phanTram) / 100;
            
            // Kiểm tra giá trị tối đa nếu có
            if ($voucher['GiaTriToiDa'] && $tienGiam > $voucher['GiaTriToiDa']) {
                $tienGiam = floatval($voucher['GiaTriToiDa']);
            }
            
            // Không được giảm quá tổng tiền đơn hàng
            if ($tienGiam > $tongTienDonHang) {
                $tienGiam = $tongTienDonHang;
            }
        }
        
        return [
            'success' => true, 
            'tienGiam' => $tienGiam, 
            'message' => 'Áp dụng mã giảm giá thành công. Giảm ' . number_format($tienGiam) . 'đ'
        ];
    }
    
    /**
     * Lấy voucher theo tên/mã
     * @param string $tenVoucher Tên hoặc mã voucher
     * @return array|null
     */
    public function getVoucherByName($tenVoucher) {
        $sql = "SELECT * FROM voucher WHERE Ten = ? AND HoatDong = 1";
        return $this->getOne($sql, [$tenVoucher]);
    }
    
    /**
     * Hiển thị thông tin voucher đẹp cho frontend
     * @param array $voucher
     * @return string
     */
    public function formatVoucherInfo($voucher) {
        if (!$voucher) return '';
        
        $info = $voucher['Ten'] . ' - ';
        
        if ($voucher['LoaiGiam'] === 'tien') {
            $info .= 'Giảm ' . number_format($voucher['TienGiam']) . 'đ';
        } else {
            $info .= 'Giảm ' . $voucher['TienGiam'] . '%';
            if ($voucher['GiaTriToiDa']) {
                $info .= ' (tối đa ' . number_format($voucher['GiaTriToiDa']) . 'đ)';
            }
        }
        
        if ($voucher['DieuKienToiThieu']) {
            $info .= ' - Đơn tối thiểu ' . number_format($voucher['DieuKienToiThieu']) . 'đ';
        }
        
        return $info;
    }
}
?>
