<?php
require_once('../site/model/Database.php');

class StatisticController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function renderStatistic() {
        $stats = $this->getOverallStats();
        $monthlyRevenue = $this->getMonthlyRevenue();
        $topProducts = $this->getTopSellingProducts();
        $recentOrders = $this->getRecentOrders();
        
        require_once('view/dashboard.php');
    }
    
    private function getOverallStats() {
        $stats = [];
        
        // Tổng doanh thu
        $sql = "SELECT SUM(TongTien) as total_revenue FROM donhang WHERE TrangThai = 'completed'";
        $result = $this->db->getOne($sql);
        $stats['total_revenue'] = $result['total_revenue'] ?? 0;
        
        // Tổng đơn hàng
        $sql = "SELECT COUNT(*) as total_orders FROM donhang";
        $result = $this->db->getOne($sql);
        $stats['total_orders'] = $result['total_orders'] ?? 0;
        
        // Tổng sản phẩm
        $sql = "SELECT COUNT(*) as total_products FROM sanpham";
        $result = $this->db->getOne($sql);
        $stats['total_products'] = $result['total_products'] ?? 0;
        
        // Tổng khách hàng
        $sql = "SELECT COUNT(*) as total_customers FROM khachhang WHERE vaitro = 0";
        $result = $this->db->getOne($sql);
        $stats['total_customers'] = $result['total_customers'] ?? 0;
        
        return $stats;
    }
    
    private function getMonthlyRevenue() {
        $sql = "SELECT 
                    MONTH(NgayTao) as month, 
                    YEAR(NgayTao) as year,
                    SUM(TongTien) as revenue 
                FROM donhang 
                WHERE TrangThai = 'completed' 
                    AND NgayTao >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
                GROUP BY YEAR(NgayTao), MONTH(NgayTao)
                ORDER BY year, month";
        return $this->db->getAll($sql);
    }
    
    private function getTopSellingProducts() {
        $sql = "SELECT 
                    s.TenSanpham, 
                    s.HinhAnh,
                    SUM(ct.SoLuong) as total_sold,
                    SUM(ct.SoLuong * ct.Gia) as total_revenue
                FROM chitietdonhang ct
                JOIN sanpham s ON ct.IdSanPham = s.id
                JOIN donhang d ON ct.IdDonHang = d.id
                WHERE d.TrangThai = 'completed'
                GROUP BY s.id
                ORDER BY total_sold DESC
                LIMIT 5";
        return $this->db->getAll($sql);
    }
    
    private function getRecentOrders() {
        $sql = "SELECT d.*, kh.HoTen 
                FROM donhang d 
                JOIN khachhang kh ON d.IdKhachHang = kh.id 
                ORDER BY d.NgayTao DESC 
                LIMIT 10";
        return $this->db->getAll($sql);
    }
}
?>
