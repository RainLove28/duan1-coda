<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    $page= $_GET['page'] ?? 'home';
    require_once('controller/ProductController.php');
     $productController = new ProductController();
     // Gọi header (bao gồm cả dữ liệu sản phẩm cho menu)
$productController->renderHeader();
    switch($page){
        case 'home':  
            $productController -> renderHome();
            break;
        case 'shop':
            require_once("view/shop.php");
            break;
        case 'vecomem':
            require_once("view/vecomem.php");
            break;
        case 'giohang':
            require_once("view/giohang.php");
            break;
            case 'thanhtoan':
            require_once("view/thanhtoan.php");
            break;
        case 'product':           
           if (isset($_GET['category'])) {
        $productController->renderProductByCategory($_GET['category']);
    }
             break;
        case 'product-details':
            $id=$_GET['id'];         
            $productController -> productDetail();
            $productController -> proDetail($id);
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
        // case "loginpage":
        //     require_once('controller/UserController.php');
        //     $userController = new UserController();
        //     $userController -> renderLogin();
        //     break;
        // case "login":
        //     $data= $_POST;
        //     require_once('controller/UserController.php');
        //     $userController = new UserController();
        //     $userController ->login($data);
        //     break;
        // case "logout":
        //     require_once('controller/UserController.php');
        //     $userController = new UserController();
        //     $userController ->logout();
        //     break;
        default:
        
    }
    require_once("view/footer.php");

?>