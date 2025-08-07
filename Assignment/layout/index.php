<?php 
session_start();

    $page= $_GET['page'] ?? 'home';
    require_once("view/header.php");
    require_once('controller/ProductController.php');
    switch($page){
        case 'home':
            $productController = new ProductController();
            $productController -> renderHome();
            break;
        case 'about':
            require_once("view/about.php");
            break;
        case 'contact':
            require_once("view/contact.php");
            break;
        case 'product':
            $productController = new ProductController();
            $productController -> renderProduct();
             break;
        case 'productdetail':
            $id=$_GET['id'];
            $productController = new ProductController();
            $productController -> productDetail();
            $productController -> proDetail($id);
             break;
        case "registerpage":
            require_once('controller/UserController.php');
            $userController = new UserController();
            $userController -> renderRegister();
            break;
        case "register":
            $data= $_POST;
            require_once('controller/UserController.php');
            $userController = new UserController();
            $userController ->register($data);
            break;
        case "loginpage":
            require_once('controller/UserController.php');
            $userController = new UserController();
            $userController -> renderLogin();
            break;
        case "login":
            $data= $_POST;
            require_once('controller/UserController.php');
            $userController = new UserController();
            $userController ->login($data);
            break;
        case "logout":
            require_once('controller/UserController.php');
            $userController = new UserController();
            $userController ->logout();
            break;
        default:
        
    }
    require_once("view/footer.php");

?>