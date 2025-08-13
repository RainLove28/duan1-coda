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
        // Hiển thị dashboard tồn kho mặc định
        $this->showDashboard();
    }
    
    /**
     * Hiển thị dashboard tồn kho
     */
    public function showDashboard() {
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
        
        // Debug: log data counts
        error_log("Low stock products count: " . count($lowStockProducts));
        error_log("Out of stock products count: " . count($outOfStockProducts));
        error_log("Total low stock: " . $totalLowStockProducts);
        error_log("Total out of stock: " . $totalOutOfStockProducts);
        
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
     * Hiển thị danh sách tất cả sản phẩm với phân trang
     */
    public function listAll() {
        // Lấy thông số phân trang từ URL
        $page = max(1, (int)($_GET['page_num'] ?? 1));
        $limit = 15; // Số sản phẩm trên 1 trang
        $offset = ($page - 1) * $limit;
        
        // Lấy từ khóa tìm kiếm
        $search = $_GET['search'] ?? '';
        
        // Lấy bộ lọc trạng thái
        $statusFilter = $_GET['status'] ?? '';
        
        // Lấy bộ lọc theo danh mục
        $categoryFilter = $_GET['category'] ?? '';
        
        // Lấy tổng số sản phẩm để tính phân trang
        $totalProducts = $this->inventoryManager->countAllProducts($search, $statusFilter, $categoryFilter);
        $totalPages = ceil($totalProducts / $limit);
        
        // Lấy danh sách sản phẩm với phân trang
        $products = $this->inventoryManager->getAllProductsPaginated($limit, $offset, $search, $statusFilter, $categoryFilter);
        
        // Lấy danh sách danh mục để hiển thị trong bộ lọc
        $categories = $this->inventoryManager->getAllCategories();
        
        // Thông tin phân trang
        $pagination = [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_products' => $totalProducts,
            'limit' => $limit,
            'search' => $search,
            'status_filter' => $statusFilter,
            'category_filter' => $categoryFilter
        ];
        
        include __DIR__ . '/../view/inventory_list_paginated.php';
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
