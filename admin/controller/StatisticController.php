<?php
require_once __DIR__ . '/BaseController.php';

class StatisticController extends BaseController {
    
    public function renderStatistic() {
        // Thống kê tổng quan
        $totalUsers = $this->getTotalUsers();
        $totalCategories = $this->getTotalCategories();
        $totalProducts = $this->getTotalProducts();
        $recentUsers = $this->getRecentUsers();
        $recentProducts = $this->getRecentProducts();
        
        include __DIR__ . '/../view/dashboard.php';
    }
    
    private function getTotalUsers() {
        $sql = "SELECT COUNT(*) as total FROM taikhoan WHERE VaiTro = 0";
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
        $sql = "SELECT * FROM taikhoan WHERE VaiTro = 0 ORDER BY NgayDangKy DESC LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function getRecentProducts() {
        $sql = "SELECT * FROM sanpham ORDER BY MaSP DESC LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
