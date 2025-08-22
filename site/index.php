<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Bắt đầu output buffering để tránh lỗi "headers already sent"
ob_start();

$page = $_GET['page'] ?? 'home';

// Khởi tạo database và baseUrl cho SiteController
require_once('model/database.php');
$db = Database::getInstance();
$baseUrl = 'http://localhost/PHP1/new/duan1-coda/site/';

require_once('controller/ProductController.php');
$productController = new ProductController();

// Xử lý các case cần redirect trước khi render header
switch($page){
    case 'login':
        // Clean output buffer trước khi render login page
        ob_clean();
        require_once("view/login.php");
        exit; // Dừng execution để không load header/footer
        break;
    case 'forgot-password':
        // Clean output buffer trước khi render forgot password page
        ob_clean();
        require_once("forgot-password.php");
        exit; // Dừng execution để không load header/footer
        break;
    case 'logout':
        // Clean output buffer trước khi redirect
        ob_clean();
        
        // Xóa toàn bộ session
        $_SESSION = array();
        
        // Xóa session cookie nếu có
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy session và chuyển hướng
        session_destroy();
        header('Location: index.php?page=home');
        exit;
        break;
}

// Render header cho các trang khác
$productController->renderHeader();
switch($page){
        case 'home':
            $productController->renderHome();
            break;
        case 'filter':
        $productController->filterProduct();
        break;
        case 'vecomem':
            require_once("view/vecomem.php");
            break;
        case 'giohang':
            require_once('controller/SiteController.php');
            $siteController = new SiteController($baseUrl, $db);
            $siteController->giohang();
            break;
        case 'cart':
            require_once('controller/SiteController.php');
            $siteController = new SiteController($baseUrl, $db);
            $siteController->cart();
            break;
        case 'updateCartQuantity':
            require_once('controller/SiteController.php');
            $siteController = new SiteController($baseUrl, $db);
            $siteController->updateCartQuantity();
            break;
        case 'thanhtoan':
            require_once('controller/SiteController.php');
            $siteController = new SiteController($baseUrl, $db);
            $siteController->thanhtoan();
            break;
        case 'createOrder':
            require_once('controller/SiteController.php');
            $siteController = new SiteController($baseUrl, $db);
            $siteController->createOrder();
            break;
        case 'removeItemCart':
            require_once('controller/SiteController.php');
            $siteController = new SiteController($baseUrl, $db);
            $siteController->removeItemCart();
            break;
        case 'product':           
            if (isset($_GET['category'])) {
                $productController->renderProductByCategory($_GET['category']);
            }
            break;
        case 'product-details':
            $id = $_GET['id'] ?? 0;         
            $productController->productDetail();
            break;
        case 'ChiTietTaiKhoan.php':
            require_once("view/ChiTietTaiKhoan.php");
            break;
        // case "registerpage":
        //     require_once('controller/UserController.php');
        //     $userController = new UserController();
        //     $userController -> renderRegister();
        //     break;
        // case "register":
        //     $data= $_POST;
        //     require_once('controller/UserController.php');
        //     $userController = new UserController();
        //     $userController ->register($data);
        //     break;
        default:
        
    }
    require_once("view/footer.php");
    
    // Flush output buffer
    ob_end_flush();
?>