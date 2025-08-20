<?php
require_once '../site/model/database.php';
require_once 'controller/InventoryManager.php';

echo "<h1>Test Inventory Data</h1>";

$inventoryManager = new InventoryManager();

// Test kết nối database
echo "<h2>1. Test Database Connection</h2>";
try {
    $db = Database::getInstance();
    echo "✅ Database connected successfully<br>";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test đếm sản phẩm
echo "<h2>2. Test Product Counts</h2>";
$stats = $inventoryManager->getStockStatistics();
echo "Total products: " . $stats['total_products'] . "<br>";
echo "In stock: " . $stats['in_stock'] . "<br>";
echo "Low stock: " . $stats['low_stock'] . "<br>";
echo "Out of stock: " . $stats['out_of_stock'] . "<br>";

// Test lấy sản phẩm sắp hết
echo "<h2>3. Test Low Stock Products</h2>";
$lowStockProducts = $inventoryManager->getLowStockProductsPaginated(10, 5, 0);
echo "Found " . count($lowStockProducts) . " low stock products:<br>";
foreach ($lowStockProducts as $product) {
    echo "- {$product['TenSP']} (Stock: {$product['SoLuong']})<br>";
}

// Test lấy sản phẩm hết hàng
echo "<h2>4. Test Out of Stock Products</h2>";
$outOfStockProducts = $inventoryManager->getOutOfStockProductsPaginated(5, 0);
echo "Found " . count($outOfStockProducts) . " out of stock products:<br>";
foreach ($outOfStockProducts as $product) {
    echo "- {$product['TenSP']} (Stock: {$product['SoLuong']})<br>";
}

// Test raw query
echo "<h2>5. Test Raw Query</h2>";
$db = Database::getInstance();
$allProducts = $db->getAll("SELECT MaSP, TenSanPham, SoLuong FROM sanpham LIMIT 5");
echo "Found " . count($allProducts) . " products in database:<br>";
foreach ($allProducts as $product) {
    echo "- {$product['TenSanPham']} (Stock: {$product['SoLuong']})<br>";
}
?>
