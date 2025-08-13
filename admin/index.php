<?php
session_start();

// Kiểm tra đăng nhập admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Nếu chưa đăng nhập hoặc không phải admin, redirect về trang login
    header('Location: ../site/index.php?page=login');
    exit;
}

include_once('view/header.php');
require_once('controller/CategoryController.php');
require_once('controller/ProductController.php');
require_once('controller/UserController.php');
require_once('controller/OrderController.php');
require_once('controller/CommentController.php');
require_once('controller/VoucherController.php');
require_once('controller/InventoryController.php');
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
             if (!empty($_FILES['HinhAnh']['name'])) {
                 $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
                 move_uploaded_file($_FILES['HinhAnh']['tmp_name'],"../public/img/".$_FILES['HinhAnh']['name']);
             }
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
        $categoryController->index();
        break;

    case "addCategory":
        $categoryController = new CategoryController();
        $categoryController->renderAddCategory();
        break;
    
    case "addCate":
        $categoryController = new CategoryController();
        $categoryController->add();
        break;

    case "editCate":
        $categoryController = new CategoryController();
        $categoryController->edit();
        break;
    
    case "editCategory":
        $id = $_GET['id'];
        $categoryController = new CategoryController();
        $categoryController->renderEditCategory($id);
        break;

    case "DeleteCategory":
        $categoryController = new CategoryController();
        $categoryController->delete();
        break;
        
    // Quản lý người dùng
    case "user_list":
        $userController = new UserController();
        $userController->index();
        break;
        
    case "User":
        $userController = new UserController();
        $userController->index();
        break;
        
    case "add_user":
        $userController = new UserController();
        $userController->renderAddUser();
        break;
        
    case "add_user_process":
        $userController = new UserController();
        $userController->add();
        break;
        
    case "edit_user":
        $id = $_GET['id'];
        $userController = new UserController();
        $userController->renderEditUser($id);
        break;
        
    case "edit_user_process":
        $userController = new UserController();
        $userController->edit();
        break;
        
    case "delete_user":
        $userController = new UserController();
        $userController->delete();
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
        
        // Quản lý tồn kho 
    case "inventory":
        $inventoryController = new InventoryController();
        $action = $_GET['action'] ?? 'index';
        
        switch($action) {
            case 'list':
                $inventoryController->listAll();
                break;
            case 'addStock':
                $inventoryController->addStock();
                break;
            case 'removeStock':
                $inventoryController->removeStock();
                break;
            case 'updateStatus':
                $inventoryController->updateAllStatus();
                break;
            default:
                $inventoryController->index();
                break;
        }
        break;    // Quản lý bình luận
    case "comment_list":
        $commentController = new CommentController();
        $commentController->index();
        break;
        
    case "Comment":
        $commentController = new CommentController();
        $action = $_GET['action'] ?? 'index';
        
        switch($action) {
            case 'add':
                $commentController->add();
                break;
            case 'edit':
                $commentController->edit();
                break;
            case 'delete':
                $commentController->delete();
                break;
            default:
                $commentController->index();
                break;
        }
        break;
        
    case "delete_comment":
        $id = $_GET['id'];
        $commentController = new CommentController();
        $commentController->deleteComment($id);
        break;
        
    case "toggle_comment_status":
        $id = $_GET['id'];
        $commentController = new CommentController();
        $commentController->toggleCommentStatus($id);
        break;
        
    // Quản lý voucher
    case "voucher_list":
        $voucherController = new VoucherController();
        $voucherController->index();
        break;
        
    case "Voucher":
        $voucherController = new VoucherController();
        $action = $_GET['action'] ?? 'index';
        
        switch($action) {
            case 'add':
                $voucherController->add();
                break;
            case 'edit':
                $voucherController->edit();
                break;
            case 'delete':
                $voucherController->delete();
                break;
            default:
                $voucherController->index();
                break;
        }
        break;    
   
            

        } 
include_once('view/footer.php');





?>