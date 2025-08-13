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
            $sql = "SELECT sp.*, dm.TenDM as TenDanhMuc FROM sanpham sp 
                    LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM 
                    WHERE sp.TenSanPham LIKE ? ORDER BY sp.MaSP DESC";
            $products = $this->getAll($sql, ['%' . $search . '%']);
        } else {
            $sql = "SELECT sp.*, dm.TenDM as TenDanhMuc FROM sanpham sp 
                    LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM 
                    ORDER BY sp.MaSP DESC";
            $products = $this->getAll($sql);
        }
        
        include __DIR__ . '/../view/product_list.php';
    }
    
    public function renderAddProduct() {
        try {
            // Get categories for dropdown
            $sql = "SELECT * FROM danhmuc ORDER BY TenDM";
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
            // Thêm sản phẩm với số lượng ban đầu (1 = Còn hàng, 0 = Hết hàng)
            $quantity = intval($data['SoLuong'] ?? 0);
            $status = $quantity > 0 ? 1 : 0;
            
            $sql = "INSERT INTO sanpham (TenSanPham, MoTa, Gia, SoLuong, HinhAnh, MaDM, TrangThai) 
                    VALUES (:tenSP, :moTa, :gia, :soLuong, :hinhAnh, :danhMuc, :trangThai)";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute([
                ':tenSP' => $data['TenSanPham'] ?? '',
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
            // Xác định trạng thái dựa trên số lượng (1 = Còn hàng, 0 = Hết hàng)
            $quantity = intval($data['SoLuong'] ?? 0);
            $status = $quantity > 0 ? 1 : 0;
            
            $sql = "UPDATE sanpham SET TenSanPham = :tenSP, MoTa = :moTa, Gia = :gia, SoLuong = :soLuong, MaDM = :danhMuc, TrangThai = :trangThai";
            
            // Only update image if new one is uploaded
            if (!empty($data['HinhAnh'])) {
                $sql .= ", HinhAnh = :hinhAnh";
            }
            
            $sql .= " WHERE MaSP = :id";
            
            $stmt = $this->conn->prepare($sql);
            
            $params = [
                ':tenSP' => $data['TenSanPham'] ?? '',
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
            $sql = "SELECT MaSP, TenSanPham, SoLuong, TrangThai FROM sanpham WHERE MaSP = :id";
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
            $sql = "SELECT MaSP, TenSanPham, SoLuong, TrangThai FROM sanpham 
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
     * Render trang quản lý tồn kho
     */
    public function renderInventory() {
        try {
            // Lấy tất cả sản phẩm với thông tin tồn kho
            $sql = "SELECT sp.MaSP, sp.TenSanPham, sp.SoLuong, sp.TrangThai, sp.Gia, 
                           dm.TenDM as TenDanhMuc
                    FROM sanpham sp 
                    LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM 
                    ORDER BY sp.SoLuong ASC, sp.TenSanPham";
            $products = $this->getAll($sql);
            
            // Thống kê tồn kho
            $lowStockProducts = $this->getLowStockProducts(5);
            $outOfStockProducts = array_filter($products, function($product) {
                return $product['SoLuong'] <= 0;
            });
            
            include __DIR__ . '/../view/inventory_list.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?page=dashboard');
            exit;
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
    
    public function updateStockManual() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $productId = $_POST['MaSP'] ?? '';
                $newStock = intval($_POST['SoLuong'] ?? 0);
                $note = $_POST['GhiChu'] ?? '';
                
                if (empty($productId)) {
                    $_SESSION['error'] = 'ID sản phẩm không hợp lệ';
                    header('Location: index.php?page=inventory');
                    return;
                }
                
                // Cập nhật số lượng và trạng thái
                $status = $newStock > 0 ? 1 : 0;
                $sql = "UPDATE sanpham SET SoLuong = ?, TrangThai = ? WHERE MaSP = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$newStock, $status, $productId]);
                
                $_SESSION['success'] = 'Cập nhật tồn kho thành công!';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            }
        }
        header('Location: index.php?page=inventory');
    }
    
    public function addStock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $productId = $_POST['MaSP'] ?? '';
                $addQuantity = intval($_POST['SoLuongThem'] ?? 0);
                $note = $_POST['GhiChu'] ?? '';
                
                if (empty($productId) || $addQuantity <= 0) {
                    $_SESSION['error'] = 'Thông tin không hợp lệ';
                    header('Location: index.php?page=inventory');
                    return;
                }
                
                // Lấy số lượng hiện tại
                $sql = "SELECT SoLuong FROM sanpham WHERE MaSP = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$productId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$product) {
                    $_SESSION['error'] = 'Sản phẩm không tồn tại';
                    header('Location: index.php?page=inventory');
                    return;
                }
                
                // Cập nhật số lượng mới
                $newStock = $product['SoLuong'] + $addQuantity;
                $status = $newStock > 0 ? 1 : 0;
                
                $sql = "UPDATE sanpham SET SoLuong = ?, TrangThai = ? WHERE MaSP = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$newStock, $status, $productId]);
                
                $_SESSION['success'] = "Nhập kho thành công! Đã thêm {$addQuantity} sản phẩm.";
            } catch (Exception $e) {
                $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            }
        }
        header('Location: index.php?page=inventory');
    }
    
    public function updateAllStock() {
        try {
            // Cập nhật trạng thái tự động dựa trên số lượng
            $sql = "UPDATE sanpham SET TrangThai = CASE WHEN SoLuong > 0 THEN 1 ELSE 0 END";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            $_SESSION['success'] = 'Cập nhật trạng thái tồn kho tự động thành công!';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        header('Location: index.php?page=inventory');
    }
}
?>
