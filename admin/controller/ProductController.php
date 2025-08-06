<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/InventoryManager.php';

class ProductController extends BaseController {
    private $inventoryManager;

    public function __construct() {
        parent::__construct();
        $this->inventoryManager = new InventoryManager();
    }
    
    public function renderProduct() {
        $search = $_GET['search'] ?? '';
        
        if ($search) {
            $sql = "SELECT * FROM sanpham WHERE TenSP LIKE ? ORDER BY MaSP DESC";
            $products = $this->getAll($sql, ['%' . $search . '%']);
        } else {
            $sql = "SELECT * FROM sanpham ORDER BY MaSP DESC";
            $products = $this->getAll($sql);
        }
        
        include __DIR__ . '/../view/product_list.php';
    }
    
    public function renderAddProduct() {
        try {
            // Get categories for dropdown
            $sql = "SELECT * FROM danhmuc ORDER BY TenDanhMuc";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            include __DIR__ . '/../view/add_product.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?page=product');
            exit;
        }
    }
    
    public function addProduct($data) {
        try {
            // Thêm sản phẩm với số lượng ban đầu
            $quantity = intval($data['SoLuong'] ?? 0);
            $status = $quantity > 0 ? 'Còn hàng' : 'Hết hàng';
            
            $sql = "INSERT INTO sanpham (TenSP, MoTa, Gia, SoLuong, HinhAnh, DanhMuc, TrangThai) 
                    VALUES (:tenSP, :moTa, :gia, :soLuong, :hinhAnh, :danhMuc, :trangThai)";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute([
                ':tenSP' => $data['TenSP'] ?? '',
                ':moTa' => $data['MoTa'] ?? '',
                ':gia' => $data['Gia'] ?? 0,
                ':soLuong' => $quantity,
                ':hinhAnh' => $data['HinhAnh'] ?? '',
                ':danhMuc' => $data['DanhMuc'] ?? '',
                ':trangThai' => $status
            ]);
            
            // Lấy ID sản phẩm vừa tạo
            $productId = $this->conn->lastInsertId();
            
            // Cập nhật trạng thái tự động thông qua InventoryManager
            $this->inventoryManager->updateProductStatus($productId);
            
            $_SESSION['success'] = 'Thêm sản phẩm thành công';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        header('Location: index.php?page=product');
        exit;
    }
    
    public function renderEditProduct($id) {
        try {
            // Get product
            $sql = "SELECT * FROM sanpham WHERE MaSP = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Get categories for dropdown
            $sql = "SELECT * FROM danhmuc ORDER BY TenDanhMuc";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            include __DIR__ . '/../view/edit_product.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?page=product');
            exit;
        }
    }
    
    public function editProduct($data) {
        try {
            // Xác định trạng thái dựa trên số lượng
            $quantity = intval($data['SoLuong'] ?? 0);
            $status = $quantity > 0 ? 'Còn hàng' : 'Hết hàng';
            
            $sql = "UPDATE sanpham SET TenSP = :tenSP, MoTa = :moTa, Gia = :gia, SoLuong = :soLuong, DanhMuc = :danhMuc, TrangThai = :trangThai";
            
            // Only update image if new one is uploaded
            if (!empty($data['HinhAnh'])) {
                $sql .= ", HinhAnh = :hinhAnh";
            }
            
            $sql .= " WHERE MaSP = :id";
            
            $stmt = $this->conn->prepare($sql);
            
            $params = [
                ':tenSP' => $data['TenSP'] ?? '',
                ':moTa' => $data['MoTa'] ?? '',
                ':gia' => $data['Gia'] ?? 0,
                ':soLuong' => $quantity,
                ':danhMuc' => $data['DanhMuc'] ?? '',
                ':trangThai' => $status,
                ':id' => $data['MaSP']
            ];
            
            if (!empty($data['HinhAnh'])) {
                $params[':hinhAnh'] = $data['HinhAnh'];
            }
            
            $stmt->execute($params);
            
            $_SESSION['success'] = 'Cập nhật sản phẩm thành công';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        header('Location: index.php?page=product');
        exit;
    }
    
    public function delete($data) {
        try {
            $sql = "DELETE FROM sanpham WHERE MaSP = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $data['id']]);
            
            $_SESSION['success'] = 'Xóa sản phẩm thành công';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        header('Location: index.php?page=product');
        exit;
    }
    
    /**
     * Tự động cập nhật trạng thái sản phẩm dựa trên số lượng
     */
    public function updateProductStatus($productId, $quantity) {
        try {
            $status = 'Còn hàng';
            
            if ($quantity <= 0) {
                $status = 'Hết hàng';
            }
            
            $sql = "UPDATE sanpham SET TrangThai = :status WHERE MaSP = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':status' => $status,
                ':id' => $productId
            ]);
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Cập nhật số lượng sản phẩm (thường dùng khi có đơn hàng)
     */
    public function updateStock($productId, $quantity, $operation = 'decrease') {
        try {
            // Lấy số lượng hiện tại
            $sql = "SELECT SoLuong FROM sanpham WHERE MaSP = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $productId]);
            $currentStock = $stmt->fetchColumn();
            
            if ($currentStock === false) {
                return false; // Sản phẩm không tồn tại
            }
            
            // Tính số lượng mới
            if ($operation === 'decrease') {
                $newStock = max(0, $currentStock - $quantity);
            } else {
                $newStock = $currentStock + $quantity;
            }
            
            // Cập nhật số lượng
            $sql = "UPDATE sanpham SET SoLuong = :quantity WHERE MaSP = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':quantity' => $newStock,
                ':id' => $productId
            ]);
            
            // Tự động cập nhật trạng thái
            $this->updateProductStatus($productId, $newStock);
            
            return $newStock;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Lấy thông tin tồn kho của sản phẩm
     */
    public function getStockInfo($productId) {
        try {
            $sql = "SELECT MaSP, TenSP, SoLuong, TrangThai FROM sanpham WHERE MaSP = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                $product['is_available'] = ($product['SoLuong'] > 0 && $product['TrangThai'] === 'Còn hàng');
                return $product;
            }
            
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Lấy danh sách sản phẩm sắp hết hàng (số lượng <= ngưỡng cảnh báo)
     */
    public function getLowStockProducts($threshold = 5) {
        try {
            $sql = "SELECT MaSP, TenSP, SoLuong, TrangThai FROM sanpham 
                    WHERE SoLuong <= :threshold AND TrangThai != 'Ngừng bán' 
                    ORDER BY SoLuong ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':threshold' => $threshold]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Tự động cập nhật tất cả trạng thái sản phẩm
     */
    public function updateAllProductStatus() {
        try {
            $sql = "UPDATE sanpham SET TrangThai = CASE 
                        WHEN SoLuong > 0 AND TrangThai != 'Ngừng bán' THEN 'Còn hàng'
                        WHEN SoLuong <= 0 AND TrangThai != 'Ngừng bán' THEN 'Hết hàng'
                        ELSE TrangThai
                    END";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
