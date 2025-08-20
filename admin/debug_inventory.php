<?php
session_start();
require_once '../site/model/database.php';
require_once 'controller/InventoryManager.php';
require_once 'controller/InventoryController.php';

echo "<h1>DEBUG: Inventory Dashboard</h1>";
echo "<style>
    .debug { background: #f0f0f0; padding: 10px; margin: 10px 0; border-left: 4px solid #007cba; }
    .error { background: #ffe6e6; border-left-color: #dc3545; }
    .success { background: #e6ffe6; border-left-color: #28a745; }
    .warning { background: #fff3cd; border-left-color: #ffc107; }
</style>";

// 1. Test Database Connection
echo "<div class='debug'>";
echo "<h2>1. Database Connection Test</h2>";
try {
    $db = Database::getInstance();
    echo "<div class='success'>✅ Database connected successfully</div>";
} catch (Exception $e) {
    echo "<div class='error'>❌ Database connection failed: " . $e->getMessage() . "</div>";
    exit;
}
echo "</div>";

// 2. Test InventoryManager
echo "<div class='debug'>";
echo "<h2>2. InventoryManager Test</h2>";
try {
    $inventoryManager = new InventoryManager();
    echo "<div class='success'>✅ InventoryManager created successfully</div>";
} catch (Exception $e) {
    echo "<div class='error'>❌ InventoryManager creation failed: " . $e->getMessage() . "</div>";
    exit;
}
echo "</div>";

// 3. Test getStockStatistics
echo "<div class='debug'>";
echo "<h2>3. Stock Statistics Test</h2>";
try {
    $stats = $inventoryManager->getStockStatistics();
    echo "<div class='success'>✅ Stats retrieved successfully:</div>";
    echo "<pre>" . print_r($stats, true) . "</pre>";
} catch (Exception $e) {
    echo "<div class='error'>❌ Stats retrieval failed: " . $e->getMessage() . "</div>";
}
echo "</div>";

// 4. Test getLowStockProductsPaginated với debug
echo "<div class='debug'>";
echo "<h2>4. Low Stock Products Test</h2>";
try {
    echo "<strong>Testing with threshold=10, limit=5, offset=0</strong><br>";
    $lowStockProducts = $inventoryManager->getLowStockProductsPaginated(10, 5, 0);
    echo "<div class='success'>✅ Function executed, returned " . count($lowStockProducts) . " products</div>";
    
    if (!empty($lowStockProducts)) {
        echo "<strong>Products found:</strong><br>";
        foreach ($lowStockProducts as $product) {
            echo "- ID: {$product['MaSP']}, Name: {$product['TenSP']}, Stock: {$product['SoLuong']}<br>";
        }
    } else {
        echo "<div class='warning'>⚠️ No low stock products returned</div>";
        
        // Test với query trực tiếp
        echo "<strong>Testing direct query:</strong><br>";
        $directQuery = $db->getAll("SELECT MaSP, TenSanPham, SoLuong FROM sanpham WHERE SoLuong <= 10 AND SoLuong > 0 LIMIT 5");
        echo "Direct query returned " . count($directQuery) . " products:<br>";
        foreach ($directQuery as $product) {
            echo "- ID: {$product['MaSP']}, Name: {$product['TenSanPham']}, Stock: {$product['SoLuong']}<br>";
        }
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Low stock products test failed: " . $e->getMessage() . "</div>";
}
echo "</div>";

// 5. Test InventoryController
echo "<div class='debug'>";
echo "<h2>5. InventoryController Test</h2>";
try {
    $inventoryController = new InventoryController();
    echo "<div class='success'>✅ InventoryController created successfully</div>";
    
    // Simulate controller logic
    echo "<strong>Simulating controller showDashboard logic:</strong><br>";
    
    $lowStockPage = 1;
    $lowStockLimit = 10;
    $lowStockOffset = 0;
    
    $stats = $inventoryManager->getStockStatistics();
    $totalLowStockProducts = $inventoryManager->countLowStockProducts(10);
    $lowStockProducts = $inventoryManager->getLowStockProductsPaginated(10, $lowStockLimit, $lowStockOffset);
    
    echo "Total low stock products: {$totalLowStockProducts}<br>";
    echo "Low stock products returned: " . count($lowStockProducts) . "<br>";
    
    if (count($lowStockProducts) > 0) {
        echo "<div class='success'>✅ Controller would have data to display</div>";
    } else {
        echo "<div class='warning'>⚠️ Controller would show empty list</div>";
    }
    
} catch (Exception $e) {
    echo "<div class='error'>❌ InventoryController test failed: " . $e->getMessage() . "</div>";
}
echo "</div>";

// 6. Test với threshold khác nhau
echo "<div class='debug'>";
echo "<h2>6. Different Threshold Test</h2>";
$thresholds = [5, 10, 15, 20];
foreach ($thresholds as $threshold) {
    try {
        $count = $inventoryManager->countLowStockProducts($threshold);
        $products = $inventoryManager->getLowStockProductsPaginated($threshold, 3, 0);
        echo "Threshold {$threshold}: Count={$count}, Retrieved=" . count($products) . "<br>";
    } catch (Exception $e) {
        echo "Threshold {$threshold}: ERROR - " . $e->getMessage() . "<br>";
    }
}
echo "</div>";

echo "<h2>Debug Complete</h2>";

// Hiển thị error log gần đây
echo "<div class='debug'>";
echo "<h2>7. Recent Error Logs</h2>";
$errorLog = ini_get('error_log');
if ($errorLog && file_exists($errorLog)) {
    $logs = file($errorLog);
    $recentLogs = array_slice($logs, -20); // 20 dòng cuối
    echo "<pre style='max-height: 300px; overflow-y: auto;'>";
    foreach ($recentLogs as $log) {
        if (strpos($log, 'getLowStockProductsPaginated') !== false || 
            strpos($log, 'SQL:') !== false || 
            strpos($log, 'Parameters:') !== false ||
            strpos($log, 'Result count:') !== false) {
            echo htmlspecialchars($log);
        }
    }
    echo "</pre>";
} else {
    echo "Error log file not found or not accessible.";
}
echo "</div>";

?>
