<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/InventoryManager.php';
require_once __DIR__ . '/OrderStatusManager.php';

class OrderController extends BaseController {
    private $inventoryManager;

    public function __construct() {
        parent::__construct();
        $this->inventoryManager = new InventoryManager();
    }    public function renderOrderList() {
        $search = $_GET['search'] ?? '';
        
        if ($search) {
            $sql = "SELECT dh.*, u.fullname as HoTen FROM donhang dh 
                    JOIN users u ON dh.MaTK = u.id 
                    WHERE u.fullname LIKE :search OR dh.MaDH LIKE :search 
                    ORDER BY dh.MaDH DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':search', '%' . $search . '%');
        } else {
            $sql = "SELECT dh.*, u.fullname as HoTen FROM donhang dh 
                    JOIN users u ON dh.MaTK = u.id 
                    ORDER BY dh.MaDH DESC";
            $stmt = $this->conn->prepare($sql);
        }
        
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include __DIR__ . '/../view/order_list.php';
    }
    
    public function renderOrderDetail($id) {
        // Get order info
        $sql = "SELECT dh.*, u.fullname as HoTen, u.email as Email FROM donhang dh 
                JOIN users u ON dh.MaTK = u.id 
                WHERE dh.MaDH = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Get order details
        $sql = "SELECT ct.*, sp.TenSanPham as TenSP FROM donhangchitiet ct 
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
            
            // Validate input
            if (empty($id) || empty($newStatus)) {
                $_SESSION['error'] = 'Thông tin không hợp lệ';
                header('Location: index.php?page=order_list');
                exit;
            }
            
            // Validate status
            if (!OrderStatusManager::isValidStatus($newStatus)) {
                $_SESSION['error'] = 'Trạng thái không hợp lệ';
                header('Location: index.php?page=order_list');
                exit;
            }
            
            // Lấy trạng thái hiện tại
            $sql = "SELECT TrangThai FROM donhang WHERE MaDH = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $currentOrder = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$currentOrder) {
                $_SESSION['error'] = 'Không tìm thấy đơn hàng';
                header('Location: index.php?page=order_list');
                exit;
            }
            
            $currentStatus = $currentOrder['TrangThai'];
            
            // Kiểm tra chuyển đổi trạng thái có hợp lệ không
            if (!OrderStatusManager::canTransition($currentStatus, $newStatus)) {
                $reason = OrderStatusManager::getTransitionRestrictionReason($currentStatus, $newStatus);
                $_SESSION['error'] = $reason;
                header('Location: index.php?page=order_list');
                exit;
            }
            
            // Nếu trạng thái không thay đổi
            if ($currentStatus === $newStatus) {
                $_SESSION['info'] = 'Trạng thái đơn hàng không thay đổi';
                header('Location: index.php?page=order_list');
                exit;
            }
            
            // Lấy chi tiết đơn hàng để xử lý tồn kho
            $sql = "SELECT MaSP, SoLuong FROM donhangchitiet WHERE MaDH = ?";
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
            
            // Xử lý tồn kho dựa trên chuyển đổi trạng thái
            $inventoryAction = OrderStatusManager::needsInventoryUpdate($currentStatus, $newStatus);
            
            if ($inventoryAction === 'decrease') {
                // Trừ tồn kho khi xác nhận đơn hàng
                $result = $this->inventoryManager->processOrder($items);
                if (!$result) {
                    $_SESSION['error'] = 'Không đủ tồn kho để xác nhận đơn hàng. Vui lòng kiểm tra lại số lượng sản phẩm.';
                    header('Location: index.php?page=order_list');
                    exit;
                }
            } elseif ($inventoryAction === 'increase') {
                // Hoàn trả tồn kho khi hủy đơn hàng đã xác nhận
                $this->inventoryManager->restoreStock($items);
            }
            
            // Cập nhật trạng thái đơn hàng
            $sql = "UPDATE donhang SET TrangThai = :status WHERE MaDH = :id";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                ':status' => $newStatus,
                ':id' => $id
            ]);
            
            if ($result) {
                $message = OrderStatusManager::getTransitionMessage($currentStatus, $newStatus);
                $_SESSION['success'] = "Đơn hàng #{$id}: " . $message;
                
                // Log activity (có thể thêm vào bảng log nếu cần)
                error_log("Order #{$id} status changed from '{$currentStatus}' to '{$newStatus}' by admin");
            } else {
                $_SESSION['error'] = 'Không thể cập nhật trạng thái đơn hàng';
            }
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            error_log("Error updating order status: " . $e->getMessage());
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
        
        $sql = "SELECT dh.MaDH, u.fullname as HoTen, dh.TongTien, dh.TrangThai, dh.NgayDat 
                FROM donhang dh 
                JOIN users u ON dh.MaTK = u.id 
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
