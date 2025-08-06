<?php
require_once __DIR__ . '/InventoryManager.php';

class InventoryController {
    private $inventoryManager;
    
    public function __construct() {
        $this->inventoryManager = new InventoryManager();
    }
    
    /**
     * Hiển thị trang quản lý tồn kho
     */
    public function index() {
        // Thông số phân trang cho sản phẩm sắp hết hàng
        $lowStockPage = (int)($_GET['low_stock_page'] ?? 1);
        $lowStockLimit = 10; // Số sản phẩm trên 1 trang
        $lowStockOffset = ($lowStockPage - 1) * $lowStockLimit;
        
        // Thông số phân trang cho sản phẩm hết hàng
        $outOfStockPage = (int)($_GET['out_of_stock_page'] ?? 1);
        $outOfStockLimit = 10;
        $outOfStockOffset = ($outOfStockPage - 1) * $outOfStockLimit;
        
        // Lấy thống kê tồn kho
        $stats = $this->inventoryManager->getStockStatistics();
        
        // Lấy tổng số sản phẩm sắp hết hàng để tính phân trang
        $totalLowStockProducts = $this->inventoryManager->countLowStockProducts(10);
        $totalLowStockPages = ceil($totalLowStockProducts / $lowStockLimit);
        
        // Lấy tổng số sản phẩm hết hàng để tính phân trang
        $totalOutOfStockProducts = $this->inventoryManager->countOutOfStockProducts();
        $totalOutOfStockPages = ceil($totalOutOfStockProducts / $outOfStockLimit);
        
        // Lấy sản phẩm sắp hết hàng với phân trang
        $lowStockProducts = $this->inventoryManager->getLowStockProductsPaginated(10, $lowStockLimit, $lowStockOffset);
        
        // Lấy sản phẩm hết hàng với phân trang
        $outOfStockProducts = $this->inventoryManager->getOutOfStockProductsPaginated($outOfStockLimit, $outOfStockOffset);
        
        // Thông tin phân trang để truyền vào view
        $pagination = [
            'low_stock' => [
                'current_page' => $lowStockPage,
                'total_pages' => $totalLowStockPages,
                'total_products' => $totalLowStockProducts,
                'limit' => $lowStockLimit
            ],
            'out_of_stock' => [
                'current_page' => $outOfStockPage,
                'total_pages' => $totalOutOfStockPages,
                'total_products' => $totalOutOfStockProducts,
                'limit' => $outOfStockLimit
            ]
        ];
        
        include __DIR__ . '/../view/inventory_dashboard.php';
    }
    
    /**
     * Xử lý nhập kho
     */
    public function addStock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? '';
            $quantity = (int)($_POST['quantity'] ?? 0);
            $note = $_POST['note'] ?? '';
            
            if ($productId && $quantity > 0) {
                $result = $this->inventoryManager->addStock($productId, $quantity, $note);
                
                if ($result) {
                    $_SESSION['success'] = "Nhập kho thành công {$quantity} sản phẩm";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi nhập kho";
                }
            } else {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin";
            }
        }
        
        header('Location: index.php?page=inventory');
        exit;
    }
    
    /**
     * Xử lý xuất kho
     */
    public function removeStock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? '';
            $quantity = (int)($_POST['quantity'] ?? 0);
            $note = $_POST['note'] ?? '';
            
            if ($productId && $quantity > 0) {
                $result = $this->inventoryManager->removeStock($productId, $quantity, $note);
                
                if ($result) {
                    $_SESSION['success'] = "Xuất kho thành công {$quantity} sản phẩm";
                } else {
                    $_SESSION['error'] = "Không đủ tồn kho hoặc có lỗi xảy ra";
                }
            } else {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin";
            }
        }
        
        header('Location: index.php?page=inventory');
        exit;
    }
    
    /**
     * Cập nhật trạng thái tự động cho tất cả sản phẩm
     */
    public function updateAllStatus() {
        $result = $this->inventoryManager->updateProductStatus();
        
        if ($result) {
            $_SESSION['success'] = "Đã cập nhật trạng thái tất cả sản phẩm";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật trạng thái";
        }
        
        header('Location: index.php?page=inventory');
        exit;
    }
    
    /**
     * Kiểm tra tồn kho sản phẩm (API)
     */
    public function checkStock() {
        $productId = $_GET['product_id'] ?? '';
        
        if ($productId) {
            $stock = $this->inventoryManager->getProductStock($productId);
            $inStock = $this->inventoryManager->isProductInStock($productId);
            
            header('Content-Type: application/json');
            echo json_encode([
                'product_id' => $productId,
                'stock' => $stock,
                'in_stock' => $inStock,
                'status' => $stock > 0 ? 'available' : 'out_of_stock'
            ]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Product ID required']);
        }
        exit;
    }
    
    /**
     * Lấy danh sách sản phẩm để chọn trong form
     */
    private function getAllProducts() {
        $db = Database::getInstance();
        $db = $database->getConnection();
        
        $sql = "SELECT MaSP, TenSP, SoLuong, TrangThai FROM sanpham ORDER BY TenSP ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Hiển thị form nhập/xuất kho
     */
    public function showStockForm() {
        $products = $this->getAllProducts();
        include __DIR__ . '/../view/stock_form.php';
    }
}
?>
