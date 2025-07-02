<?php
class OrderController {
    private $orderModel;
    
    public function __construct() {
        require_once('../site/model/OrderModel.php');
        $this->orderModel = new OrderModel();
    }
    
    public function renderOrderList() {
        $orders = $this->orderModel->getAllOrders();
        require_once('view/order_list.php');
    }
    
    public function renderOrderDetail($id) {
        $order = $this->orderModel->getOrderById($id);
        $orderDetails = $this->orderModel->getOrderDetails($id);
        require_once('view/order_detail.php');
    }
    
    public function updateOrderStatus() {
        $orderId = $_POST['order_id'];
        $newStatus = $_POST['status'];
        
        $result = $this->orderModel->updateOrderStatus($orderId, $newStatus);
        
        if ($result) {
            header('Location: index.php?page=order_detail&id=' . $orderId . '&success=1');
        } else {
            header('Location: index.php?page=order_detail&id=' . $orderId . '&error=1');
        }
    }
    
    public function getOrderStatistics() {
        return [
            'total_orders' => $this->getTotalOrders(),
            'pending_orders' => $this->getOrdersByStatus('pending'),
            'completed_orders' => $this->getOrdersByStatus('completed'),
            'total_revenue' => $this->getTotalRevenue()
        ];
    }
    
    private function getTotalOrders() {
        $sql = "SELECT COUNT(*) as total FROM donhang";
        $result = Database::getInstance()->getOne($sql);
        return $result['total'] ?? 0;
    }
    
    private function getOrdersByStatus($status) {
        $sql = "SELECT COUNT(*) as total FROM donhang WHERE TrangThai = ?";
        $result = Database::getInstance()->getOne($sql, [$status]);
        return $result['total'] ?? 0;
    }
    
    private function getTotalRevenue() {
        $sql = "SELECT SUM(TongTien) as total FROM donhang WHERE TrangThai = 'completed'";
        $result = Database::getInstance()->getOne($sql);
        return $result['total'] ?? 0;
    }
    
    public function exportOrders() {
        $orders = $this->orderModel->getAllOrders();
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Header
        fputcsv($output, ['ID', 'Khách hàng', 'Email', 'Tổng tiền', 'Trạng thái', 'Ngày tạo']);
        
        // Data
        foreach ($orders as $order) {
            fputcsv($output, [
                $order['id'],
                $order['HoTen'],
                $order['Email'],
                number_format($order['TongTien']),
                $order['TrangThai'],
                $order['NgayTao']
            ]);
        }
        
        fclose($output);
        exit;
    }
}
?>
