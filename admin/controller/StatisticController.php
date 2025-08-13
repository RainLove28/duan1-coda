<?php
require_once __DIR__ . '/BaseController.php';

class StatisticController extends BaseController {
    
    public function renderStatistic() {
        // Thống kê tổng quan
        $totalUsers = $this->getTotalUsers();
        $totalCategories = $this->getTotalCategories();
        $totalProducts = $this->getTotalProducts();
        $totalOrders = $this->getTotalOrders();
        $totalRevenue = $this->getTotalRevenue();
        $recentUsers = $this->getRecentUsers();
        $recentProducts = $this->getRecentProducts();
        $recentOrders = $this->getRecentOrders();
        
        include __DIR__ . '/../view/dashboard.php';
    }
    
    private function getTotalUsers() {
        $sql = "SELECT COUNT(*) as total FROM users WHERE role = 'user'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    private function getTotalCategories() {
        $sql = "SELECT COUNT(*) as total FROM danhmuc";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    private function getTotalProducts() {
        $sql = "SELECT COUNT(*) as total FROM sanpham";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    private function getRecentUsers() {
        $sql = "SELECT * FROM users WHERE role = 'user' ORDER BY created_at DESC LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function getRecentProducts() {
        $sql = "SELECT s.*, d.TenDM as DanhMuc FROM sanpham s 
                LEFT JOIN danhmuc d ON s.MaDM = d.MaDM 
                ORDER BY s.MaSP DESC LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function getTotalOrders() {
        try {
            $sql = "SELECT COUNT(*) as total FROM donhang";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            error_log("Error getting total orders: " . $e->getMessage());
            return 0;
        }
    }
    
    private function getTotalRevenue() {
        try {
            $sql = "SELECT SUM(TongTien) as revenue FROM donhang WHERE TrangThai != 'cancelled'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['revenue'] ?? 0;
        } catch (Exception $e) {
            error_log("Error getting total revenue: " . $e->getMessage());
            return 0;
        }
    }
    
    private function getRecentOrders() {
        try {
            $sql = "SELECT d.*, u.fullname as TenKhachHang FROM donhang d 
                    LEFT JOIN users u ON d.MaTK = u.id 
                    ORDER BY d.NgayDat DESC LIMIT 5";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting recent orders: " . $e->getMessage());
            return [];
        }
    }
}
?>
