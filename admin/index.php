<?php
session_start();
if(!isset($_SESSION['khachhang']['vaitro']) || $_SESSION['khachhang']['vaitro']!=1){
    header('Location: ../site/index.php?page=loginpage');
}

include_once('view/header.php');
require_once('controller/CategoryController.php');
require_once('controller/ProductController.php');
require_once('controller/UserController.php');
require_once('controller/OrderController.php');
$page = $_GET['page'] ?? 'dashboard';
switch($page){
    
    case "dashboard":
        require_once('controller/StatisticController.php');
        $statisticController = new StatisticController();
        $statisticController->renderStatistic();
        break;
        
    // Quản lý sản phẩm
    case "product":
            $productController = new ProductController();
            $productController-> renderProduct();
        break;
   
    case "addpropage":
            $productController = new ProductController();
            $productController ->renderAddProduct();
        break;
        
    case "addpro":
            $data = $_POST;
            $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
            move_uploaded_file($_FILES["HinhAnh"]['tmp_name'],"../public/img/".$_FILES['HinhAnh']['name']);
            $productController = new ProductController();
            $productController->addProduct($data);
        break;
        
    case "editpropage":
            $id=$_GET['id'];
            $productController = new ProductController();
            $productController ->renderEditProduct($id);
            break;
        
    case "editpro":
             $data = $_POST;
             $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
            move_uploaded_file($_FILES['HinhAnh']['tmp_name'],"../public/img/".$_FILES['HinhAnh']['name']);
            $data['id'] = $_GET['id'];
            $productController = new ProductController();
            $productController->editProduct($data);
            break;
            
    case "deleteppro":
        $data['id'] = $_GET['id'];
        $productController = new ProductController();
        $productController->delete($data);
        break;
        
    // Quản lý danh mục
    case "Category":
        $categoryController = new CategoryController();
        $categoryController->renderCategory();
        break;

    case "addCategory":
        $categoryController = new CategoryController();
        $categoryController->renderAddCategory();
        break;
    
    case "addCate":
        $data = $_POST;
        $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
        move_uploaded_file($_FILES['HinhAnh']['tmp_name'],"../public/img/".$_FILES['HinhAnh']['name']);
        $categoryController = new CategoryController();
        $categoryController->addCate($data);
        break;

    case "editCate":
        $data = $_POST;
        $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
        move_uploaded_file($_FILES['HinhAnh']['tmp_name'],"../public/img/".$_FILES['HinhAnh']['name']);
        $data['id'] = $_GET['id'];
        $categoryController = new CategoryController();
        $categoryController->editCate($data);
        break;
    
    case "editCategory":
        $id = $_GET['id'];
        $categoryController = new CategoryController();
        $categoryController->renderEditCategory($id);
        break;

    case "DeleteCategory":
        $data['id'] = $_GET['id'];
        $categoryController = new CategoryController();
        $categoryController->DeleteCategory($data);
        break;
        
    // Quản lý người dùng
    case "user_list":
        $userController = new UserController();
        $userController->renderUserList();
        break;
        
    case "add_user":
        $userController = new UserController();
        $userController->renderAddUser();
        break;
        
    case "add_user_process":
        $userController = new UserController();
        $userController->addUser($_POST);
        break;
        
    case "edit_user":
        $id = $_GET['id'];
        $userController = new UserController();
        $userController->renderEditUser($id);
        break;
        
    case "edit_user_process":
        $userController = new UserController();
        $userController->editUser($_POST);
        break;
        
    case "delete_user":
        $id = $_GET['id'];
        $userController = new UserController();
        $userController->deleteUser($id);
        break;
        
    case "toggle_user_status":
        $id = $_GET['id'];
        $userController = new UserController();
        $userController->toggleUserStatus($id);
        break;
        
    // Quản lý đơn hàng
    case "order_list":
        $orderController = new OrderController();
        $orderController->renderOrderList();
        break;
        
    case "order_detail":
        $id = $_GET['id'];
        $orderController = new OrderController();
        $orderController->renderOrderDetail($id);
        break;
        
    case "update_order_status":
        $orderController = new OrderController();
        $orderController->updateOrderStatus();
        break;
        
    case "export_orders":
        $orderController = new OrderController();
        $orderController->exportOrders();
        break;    
   
            

        } 
include_once('view/footer.php');





?>