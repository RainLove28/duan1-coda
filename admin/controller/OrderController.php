<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/InventoryManager.php';

class OrderController extends BaseController {
    private $inventoryManager;

    public function __construct() {
        parent::__construct();
        $this->inventoryManager = new InventoryManager();
    }    public function renderOrderList() {
        $search = $_GET['search'] ?? '';
        
        if ($search) {
            $sql = "SELECT dh.*, tk.HoTen FROM donhang dh 
                    JOIN taikhoan tk ON dh.MaTK = tk.MaTK 
                    WHERE tk.HoTen LIKE :search OR dh.MaDH LIKE :search 
                    ORDER BY dh.MaDH DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':search', '%' . $search . '%');
        } else {
            $sql = "SELECT dh.*, tk.HoTen FROM donhang dh 
                    JOIN taikhoan tk ON dh.MaTK = tk.MaTK 
                    ORDER BY dh.MaDH DESC";
            $stmt = $this->conn->prepare($sql);
        }
        
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include __DIR__ . '/../view/order_list.php';
    }
    
    public function renderOrderDetail($id) {
        // Get order info
        $sql = "SELECT dh.*, tk.HoTen, tk.Email FROM donhang dh 
                JOIN taikhoan tk ON dh.MaTK = tk.MaTK 
                WHERE dh.MaDH = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Get order details
        $sql = "SELECT ct.*, sp.TenSP FROM chitietdonhang ct 
                JOIN sanpham sp ON ct.MaSP = sp.MaSP 
                WHERE ct.MaDH = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include __DIR__ . '/../view/order_detail.php';
    }
    
    public function updateOrderStatus() {
        try {
            $id = $_POST['id'] ?? '';
            $newStatus = $_POST['status'] ?? '';
            
            // Lấy trạng thái hiện tại
            $sql = "SELECT TrangThai FROM donhang WHERE MaDH = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $currentOrder = $stmt->fetch(PDO::FETCH_ASSOC);
            $currentStatus = $currentOrder['TrangThai'];
            
            // Lấy chi tiết đơn hàng
            $sql = "SELECT MaSP, SoLuong FROM chitietdonhang WHERE MaDH = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Chuyển đổi format cho InventoryManager
            $items = [];
            foreach ($orderItems as $item) {
                $items[] = [
                    'product_id' => $item['MaSP'],
                    'quantity' => $item['SoLuong']
                ];
            }
            
            // Xử lý thay đổi tồn kho dựa trên trạng thái
            if ($currentStatus === 'Chờ xác nhận' && $newStatus === 'Đã xác nhận') {
                // Khi xác nhận đơn hàng -> trừ tồn kho
                $result = $this->inventoryManager->processOrder($items);
                if (!$result) {
                    $_SESSION['error'] = 'Không đủ tồn kho để xác nhận đơn hàng';
                    header('Location: index.php?page=order_list');
                    exit;
                }
            } elseif (in_array($currentStatus, ['Đã xác nhận', 'Đang giao']) && $newStatus === 'Đã hủy') {
                // Khi hủy đơn hàng đã xác nhận -> hoàn trả tồn kho
                $this->inventoryManager->restoreStock($items);
            }
            
            // Cập nhật trạng thái đơn hàng
            $sql = "UPDATE donhang SET TrangThai = :status WHERE MaDH = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':status' => $newStatus,
                ':id' => $id
            ]);
            
            $_SESSION['success'] = 'Cập nhật trạng thái đơn hàng thành công';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        header('Location: index.php?page=order_list');
        exit;
    }
    
    public function exportOrders() {
        // Simple CSV export
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Mã ĐH', 'Khách hàng', 'Tổng tiền', 'Trạng thái', 'Ngày đặt']);
        
        $sql = "SELECT dh.MaDH, tk.HoTen, dh.TongTien, dh.TrangThai, dh.NgayDat 
                FROM donhang dh 
                JOIN taikhoan tk ON dh.MaTK = tk.MaTK 
                ORDER BY dh.MaDH DESC";
        
        $orders = $this->db->getAll($sql);
        
        foreach ($orders as $order) {
            fputcsv($output, [
                $order['MaDH'],
                $order['HoTen'],
                number_format($order['TongTien'], 0, ',', '.') . ' VND',
                $order['TrangThai'],
                date('d/m/Y H:i', strtotime($order['NgayDat']))
            ]);
        }
        
        fclose($output);
        exit;
    }
}
?>
