<?php
require_once __DIR__ . '/../../site/model/database.php';

class InventoryManager {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Tự động cập nhật trạng thái sản phẩm dựa trên số lượng tồn kho
     */
    public function updateProductStatus($productId = null) {
        try {
            if ($productId) {
                // Cập nhật một sản phẩm cụ thể
                $sql = "UPDATE sanpham SET TrangThai = CASE 
                        WHEN SoLuong <= 0 THEN 'Hết hàng'
                        WHEN SoLuong > 0 AND TrangThai != 'Ngừng bán' THEN 'Còn hàng'
                        ELSE TrangThai
                        END 
                        WHERE MaSP = ?";
                return $this->db->execute($sql, [$productId]);
            } else {
                // Cập nhật tất cả sản phẩm
                $sql = "UPDATE sanpham SET TrangThai = CASE 
                        WHEN SoLuong <= 0 THEN 'Hết hàng'
                        WHEN SoLuong > 0 AND TrangThai != 'Ngừng bán' THEN 'Còn hàng'
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
        
        // Tổng số sản phẩm
        $sql = "SELECT COUNT(*) as total FROM sanpham";
        $result = $this->db->getOne($sql);
        $stats['total_products'] = $result['total'];
        
        // Số sản phẩm còn hàng
        $sql = "SELECT COUNT(*) as in_stock FROM sanpham WHERE SoLuong > 0 AND TrangThai = 'Còn hàng'";
        $result = $this->db->getOne($sql);
        $stats['in_stock'] = $result['in_stock'];
        
        // Số sản phẩm hết hàng
        $sql = "SELECT COUNT(*) as out_of_stock FROM sanpham WHERE SoLuong = 0 OR TrangThai = 'Hết hàng'";
        $result = $this->db->getOne($sql);
        $stats['out_of_stock'] = $result['out_of_stock'];
        
        // Số sản phẩm sắp hết hàng (≤ 5)
        $sql = "SELECT COUNT(*) as low_stock FROM sanpham WHERE SoLuong > 0 AND SoLuong <= 5";
        $result = $this->db->getOne($sql);
        $stats['low_stock'] = $result['low_stock'];
        
        // Tổng giá trị tồn kho
        $sql = "SELECT SUM(SoLuong * Gia) as total_value FROM sanpham WHERE SoLuong > 0";
        $result = $this->db->getOne($sql);
        $stats['total_value'] = $result['total_value'] ?? 0;
        
        return $stats;
    }
    
    /**
     * Lấy danh sách sản phẩm sắp hết hàng
     */
    public function getLowStockProducts($threshold = 5) {
        $sql = "SELECT MaSP, TenSP, SoLuong, Gia 
                FROM sanpham 
                WHERE SoLuong > 0 AND SoLuong <= ? AND TrangThai = 'Còn hàng'
                ORDER BY SoLuong ASC";
        return $this->db->getAll($sql, [$threshold]);
    }
    
    /**
     * Lấy danh sách sản phẩm hết hàng
     */
    public function getOutOfStockProducts() {
        $sql = "SELECT MaSP, TenSP, SoLuong, Gia 
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
}
?>
