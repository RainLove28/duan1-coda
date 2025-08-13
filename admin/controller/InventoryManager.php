<?php
require_once __DIR__ . '/../../site/model/config.php';
require_once __DIR__ . '/../../site/model/database.php';

class InventoryManager {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    /**
     * Đếm số sản phẩm sắp hết hàng
     */
    public function countLowStockProducts($threshold = 10) {
        try {
            $sql = "SELECT COUNT(*) as count FROM sanpham WHERE SoLuong > 0 AND SoLuong <= ?";
            $result = $this->db->getOne($sql, [$threshold]);
            return $result ? $result['count'] : 0;
        } catch (Exception $e) {
            error_log("Lỗi countLowStockProducts: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Đếm số sản phẩm hết hàng
     */
    public function countOutOfStockProducts() {
        try {
            $sql = "SELECT COUNT(*) as count FROM sanpham WHERE SoLuong <= 0";
            $result = $this->db->getOne($sql);
            return $result ? $result['count'] : 0;
        } catch (Exception $e) {
            error_log("Lỗi countOutOfStockProducts: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Tự động cập nhật trạng thái sản phẩm dựa trên số lượng tồn kho
     * TrangThai: 0 = Còn hàng, 1 = Hết hàng, 2 = Ngừng bán
     */
    public function updateProductStatus($productId = null) {
        try {
            if ($productId) {
                // Cập nhật một sản phẩm cụ thể
                $sql = "UPDATE sanpham SET TrangThai = CASE 
                        WHEN SoLuong <= 0 THEN 1
                        WHEN SoLuong > 0 AND TrangThai != 2 THEN 0
                        ELSE TrangThai
                        END 
                        WHERE MaSP = ?";
                return $this->db->execute($sql, [$productId]);
            } else {
                // Cập nhật tất cả sản phẩm
                $sql = "UPDATE sanpham SET TrangThai = CASE 
                        WHEN SoLuong <= 0 THEN 1
                        WHEN SoLuong > 0 AND TrangThai != 2 THEN 0
                        ELSE TrangThai
                        END";
                return $this->db->execute($sql);
            }
        } catch (Exception $e) {
            error_log("Lỗi cập nhật trạng thái: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Kiểm tra sản phẩm còn hàng
     */
    public function isProductInStock($productId) {
        $sql = "SELECT SoLuong FROM sanpham WHERE MaSP = ? AND TrangThai = 'Còn hàng'";
        $result = $this->db->getOne($sql, [$productId]);
        return $result && $result['SoLuong'] > 0;
    }
    
    /**
     * Lấy số lượng tồn kho của sản phẩm
     */
    public function getProductStock($productId) {
        $sql = "SELECT SoLuong FROM sanpham WHERE MaSP = ?";
        $result = $this->db->getOne($sql, [$productId]);
        return $result ? (int)$result['SoLuong'] : 0;
    }
    
    /**
     * Nhập kho (tăng số lượng)
     */
    public function addStock($productId, $quantity, $note = '') {
        try {
            $this->db->beginTransaction();
            
            $sql = "UPDATE sanpham SET SoLuong = SoLuong + ? WHERE MaSP = ?";
            $success = $this->db->execute($sql, [$quantity, $productId]);
            
            if ($success) {
                // Cập nhật trạng thái sau khi nhập kho
                $this->updateProductStatus($productId);
                $this->db->commit();
                return true;
            } else {
                $this->db->rollback();
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Lỗi nhập kho: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Xuất kho (giảm số lượng)
     */
    public function removeStock($productId, $quantity, $note = '') {
        try {
            // Kiểm tra số lượng hiện tại
            $currentStock = $this->getProductStock($productId);
            if ($currentStock < $quantity) {
                return false; // Không đủ hàng để xuất
            }
            
            $this->db->beginTransaction();
            
            $sql = "UPDATE sanpham SET SoLuong = SoLuong - ? WHERE MaSP = ?";
            $success = $this->db->execute($sql, [$quantity, $productId]);
            
            if ($success) {
                // Cập nhật trạng thái sau khi xuất kho
                $this->updateProductStatus($productId);
                $this->db->commit();
                return true;
            } else {
                $this->db->rollback();
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Lỗi xuất kho: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Xử lý đơn hàng (trừ tồn kho cho nhiều sản phẩm)
     */
    public function processOrder($orderItems) {
        try {
            $this->db->beginTransaction();
            
            // Kiểm tra tồn kho trước khi xử lý
            foreach ($orderItems as $item) {
                $currentStock = $this->getProductStock($item['product_id']);
                if ($currentStock < $item['quantity']) {
                    $this->db->rollback();
                    return false; // Không đủ hàng
                }
            }
            
            // Trừ tồn kho cho từng sản phẩm
            foreach ($orderItems as $item) {
                $sql = "UPDATE sanpham SET SoLuong = SoLuong - ? WHERE MaSP = ?";
                $success = $this->db->execute($sql, [$item['quantity'], $item['product_id']]);
                
                if (!$success) {
                    $this->db->rollback();
                    return false;
                }
                
                // Cập nhật trạng thái sản phẩm
                $this->updateProductStatus($item['product_id']);
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Lỗi xử lý đơn hàng: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Lấy thống kê tồn kho
     */
    public function getStockStatistics() {
        $stats = [];
        
        try {
            // Tổng số sản phẩm
            $sql = "SELECT COUNT(*) as total FROM sanpham";
            $result = $this->db->getOne($sql);
            $stats['total_products'] = $result ? $result['total'] : 0;
            
            // Số sản phẩm còn hàng
            $sql = "SELECT COUNT(*) as in_stock FROM sanpham WHERE SoLuong > 0";
            $result = $this->db->getOne($sql);
            $stats['in_stock'] = $result ? $result['in_stock'] : 0;
            
            // Số sản phẩm hết hàng
            $sql = "SELECT COUNT(*) as out_of_stock FROM sanpham WHERE SoLuong <= 0";
            $result = $this->db->getOne($sql);
            $stats['out_of_stock'] = $result ? $result['out_of_stock'] : 0;
            
            // Số sản phẩm sắp hết hàng (≤ 10)
            $sql = "SELECT COUNT(*) as low_stock FROM sanpham WHERE SoLuong > 0 AND SoLuong <= 10";
            $result = $this->db->getOne($sql);
            $stats['low_stock'] = $result ? $result['low_stock'] : 0;
            
            // Tổng giá trị tồn kho
            $sql = "SELECT SUM(SoLuong * Gia) as total_value FROM sanpham WHERE SoLuong > 0";
            $result = $this->db->getOne($sql);
            $stats['total_value'] = $result ? ($result['total_value'] ?? 0) : 0;
            
        } catch (Exception $e) {
            error_log("Lỗi getStockStatistics: " . $e->getMessage());
            // Return default values on error
            $stats = [
                'total_products' => 0,
                'in_stock' => 0,
                'out_of_stock' => 0,
                'low_stock' => 0,
                'total_value' => 0
            ];
        }
        
        return $stats;
    }
    
    /**
     * Lấy danh sách sản phẩm sắp hết hàng
     */
    public function getLowStockProducts($threshold = 10) {
        $sql = "SELECT MaSP, TenSP, SoLuong, Gia, DanhMuc 
                FROM sanpham 
                WHERE SoLuong > 0 AND SoLuong <= ?
                ORDER BY SoLuong ASC";
        return $this->db->getAll($sql, [$threshold]);
    }
    
    /**
     * Lấy danh sách sản phẩm hết hàng
     */
    public function getOutOfStockProducts() {
        $sql = "SELECT MaSP, TenSP, SoLuong, Gia, DanhMuc 
                FROM sanpham 
                WHERE SoLuong = 0 OR TrangThai = 'Hết hàng'
                ORDER BY TenSP ASC";
        return $this->db->getAll($sql);
    }
    
    /**
     * Lấy danh sách tất cả sản phẩm với thông tin tồn kho
     */
    public function getAllProductsWithStock() {
        $sql = "SELECT MaSP, TenSP, SoLuong, Gia, TrangThai, AnhSP, DanhMuc
                FROM sanpham 
                ORDER BY TenSP ASC";
        return $this->db->getAll($sql);
    }
    
    /**
     * Khôi phục tồn kho (khi hủy đơn hàng)
     */
    public function restoreStock($orderItems) {
        try {
            $this->db->beginTransaction();
            
            foreach ($orderItems as $item) {
                $sql = "UPDATE sanpham SET SoLuong = SoLuong + ? WHERE MaSP = ?";
                $success = $this->db->execute($sql, [$item['quantity'], $item['product_id']]);
                
                if (!$success) {
                    $this->db->rollback();
                    return false;
                }
                
                // Cập nhật trạng thái sản phẩm
                $this->updateProductStatus($item['product_id']);
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Lỗi khôi phục tồn kho: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Lấy danh sách sản phẩm sắp hết hàng có phân trang
     */
    public function getLowStockProductsPaginated($threshold = 10, $limit = 10, $offset = 0) {
        try {
            // Join với bảng danhmuc để lấy tên danh mục
            $sql = "SELECT sp.MaSP, sp.TenSanPham as TenSP, dm.TenDM as DanhMuc, sp.SoLuong, sp.DonGia as Gia, sp.TrangThai 
                    FROM sanpham sp 
                    LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM 
                    WHERE sp.SoLuong > 0 AND sp.SoLuong <= ? 
                    ORDER BY sp.SoLuong ASC, sp.TenSanPham ASC
                    LIMIT ? OFFSET ?";
            
            return $this->db->getAll($sql, [$threshold, $limit, $offset]);
        } catch (Exception $e) {
            error_log("Lỗi getLowStockProductsPaginated: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Lấy danh sách sản phẩm hết hàng có phân trang
     */
    public function getOutOfStockProductsPaginated($limit = 10, $offset = 0) {
        try {
            $sql = "SELECT sp.MaSP, sp.TenSanPham as TenSP, dm.TenDM as DanhMuc, sp.SoLuong, sp.DonGia as Gia, sp.TrangThai 
                    FROM sanpham sp 
                    LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM 
                    WHERE sp.SoLuong <= 0 
                    ORDER BY sp.TenSanPham ASC
                    LIMIT ? OFFSET ?";
            
            return $this->db->getAll($sql, [$limit, $offset]);
        } catch (Exception $e) {
            error_log("Lỗi getOutOfStockProductsPaginated: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Lấy tất cả sản phẩm với phân trang và tìm kiếm
     */
    public function getAllProductsPaginated($limit, $offset, $search = '', $statusFilter = '', $categoryFilter = '') {
        $sql = "SELECT sp.MaSP, sp.TenSP as TenSanPham, sp.Gia, sp.SoLuong, sp.TrangThai, sp.HinhAnh,
                       dm.TenDanhMuc, sp.MoTa
                FROM sanpham sp 
                LEFT JOIN danhmuc dm ON sp.MaDanhMuc = dm.MaDanhMuc 
                WHERE 1=1";
        
        $params = [];
        
        // Thêm điều kiện tìm kiếm
        if (!empty($search)) {
            $sql .= " AND (sp.TenSP LIKE ? OR sp.MoTa LIKE ? OR dm.TenDanhMuc LIKE ?)";
            $searchTerm = '%' . $search . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        // Thêm bộ lọc trạng thái
        if (!empty($statusFilter)) {
            if ($statusFilter === 'het_hang') {
                $sql .= " AND sp.SoLuong <= 0";
            } elseif ($statusFilter === 'sap_het') {
                $sql .= " AND sp.SoLuong > 0 AND sp.SoLuong <= 10";
            } elseif ($statusFilter === 'con_hang') {
                $sql .= " AND sp.SoLuong > 10";
            } elseif ($statusFilter === 'ngung_ban') {
                $sql .= " AND sp.TrangThai = 'Ngừng bán'";
            }
        }
        
        // Thêm bộ lọc danh mục
        if (!empty($categoryFilter)) {
            $sql .= " AND sp.MaDanhMuc = ?";
            $params[] = $categoryFilter;
        }
        
        $sql .= " ORDER BY sp.TenSP ASC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi lấy danh sách sản phẩm: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Đếm tổng số sản phẩm (cho phân trang)
     */
    public function countAllProducts($search = '', $statusFilter = '', $categoryFilter = '') {
        $sql = "SELECT COUNT(*) as total 
                FROM sanpham sp 
                LEFT JOIN danhmuc dm ON sp.MaDanhMuc = dm.MaDanhMuc 
                WHERE 1=1";
        
        $params = [];
        
        // Thêm điều kiện tìm kiếm
        if (!empty($search)) {
            $sql .= " AND (sp.TenSP LIKE ? OR sp.MoTa LIKE ? OR dm.TenDanhMuc LIKE ?)";
            $searchTerm = '%' . $search . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        // Thêm bộ lọc trạng thái
        if (!empty($statusFilter)) {
            if ($statusFilter === 'het_hang') {
                $sql .= " AND sp.SoLuong <= 0";
            } elseif ($statusFilter === 'sap_het') {
                $sql .= " AND sp.SoLuong > 0 AND sp.SoLuong <= 10";
            } elseif ($statusFilter === 'con_hang') {
                $sql .= " AND sp.SoLuong > 10";
            } elseif ($statusFilter === 'ngung_ban') {
                $sql .= " AND sp.TrangThai = 'Ngừng bán'";
            }
        }
        
        // Thêm bộ lọc danh mục
        if (!empty($categoryFilter)) {
            $sql .= " AND sp.MaDanhMuc = ?";
            $params[] = $categoryFilter;
        }
        
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (Exception $e) {
            error_log("Lỗi đếm sản phẩm: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Lấy tất cả danh mục để hiển thị trong bộ lọc
     */
    public function getAllCategories() {
        $sql = "SELECT MaDanhMuc, TenDanhMuc FROM danhmuc ORDER BY TenDanhMuc ASC";
        
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi lấy danh sách danh mục: " . $e->getMessage());
            return [];
        }
    }
}
?>
