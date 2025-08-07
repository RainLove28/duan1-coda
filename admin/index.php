<?php
ob_start();
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] != 1){
    header('Location: login.php');
    exit;
}



include_once('view/header.php');
require_once('controller/BaseController.php');
require_once('controller/CategoryController.php');
require_once('controller/ProductController.php');
require_once('controller/UserController.php');
require_once('controller/OrderController.php');
require_once('controller/CommentController.php');
require_once('controller/InventoryController.php');
require_once('controller/VoucherController.php');

$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? '';

// Xử lý action trước
if (!empty($action)) {
    switch($action) {
        case "addUser":
            $userController = new UserController();
            $userController->addUser($_POST);
            exit;
            break;
            
        case "editUser":
            $userController = new UserController();
            $userController->editUser($_POST);
            exit;
            break;
            
        case "deleteUser":
            $userController = new UserController();
            $userController->delete();
            exit;
            break;
            
        case "updateStock":
            $productController = new ProductController();
            $result = $productController->updateStock($_POST['product_id'], $_POST['quantity'], $_POST['operation'] ?? 'decrease');
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $result !== false,
                'new_stock' => $result
            ]);
            exit;
            break;
            
        case "updateAllProductStatus":
            $productController = new ProductController();
            $result = $productController->updateAllProductStatus();
            
            $_SESSION['success'] = 'Đã cập nhật trạng thái tất cả sản phẩm';
            header('Location: index.php?page=product');
            exit;
            break;
            
        case "addproduct":
            $data = $_POST;
            if (!empty($_FILES['HinhAnh']['name'])) {
                $uploadDir = "../public/img/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
                if (move_uploaded_file($_FILES["HinhAnh"]['tmp_name'], $uploadDir . $_FILES['HinhAnh']['name'])) {
                    // Upload thành công
                } else {
                    $_SESSION['error'] = 'Không thể upload hình ảnh';
                    header('Location: index.php?page=product');
                    exit;
                }
            }
            $productController = new ProductController();
            $productController->addProduct($data);
            exit;
            break;
            
        case "editproduct":
            $data = $_POST;
            if (!empty($_FILES['HinhAnh']['name'])) {
                $uploadDir = "../public/img/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
                if (move_uploaded_file($_FILES["HinhAnh"]['tmp_name'], $uploadDir . $_FILES['HinhAnh']['name'])) {
                    // Upload thành công
                } else {
                    $_SESSION['error'] = 'Không thể upload hình ảnh';
                    header('Location: index.php?page=product');
                    exit;
                }
            }
            $productController = new ProductController();
            $productController->editProduct($data);
            exit;
            break;
    }
}

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
            if (!empty($_FILES['HinhAnh']['name'])) {
                $uploadDir = "../public/img/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
                if (move_uploaded_file($_FILES["HinhAnh"]['tmp_name'], $uploadDir . $_FILES['HinhAnh']['name'])) {
                    // Upload thành công
                } else {
                    $_SESSION['error'] = 'Không thể upload hình ảnh';
                    header('Location: index.php?page=addpropage');
                    exit;
                }
            } else {
                $data['HinhAnh'] = '';
            }
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
                 $uploadDir = "../public/img/";
                 if (!is_dir($uploadDir)) {
                     mkdir($uploadDir, 0777, true);
                 }
                 $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
                 if (move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $uploadDir . $_FILES['HinhAnh']['name'])) {
                     // Upload thành công
                 } else {
                     $_SESSION['error'] = 'Không thể upload hình ảnh';
                     header('Location: index.php?page=editpropage&id=' . $_GET['id']);
                     exit;
                 }
             } else {
                 $data['HinhAnh'] = '';
             }
            $data['id'] = $_GET['id'];
            $productController = new ProductController();
            $productController->editProduct($data);
            break;
            
    case "deleteppro":
        $data = $_POST;
        $productController = new ProductController();
        $productController->delete($data);
        break;
        
    // Quản lý danh mục
    case "Category":
        $categoryController = new CategoryController();
        $categoryController->index();
        break;

    case "addcate":
        $data = $_POST;
        $categoryController = new CategoryController();
        $categoryController->add();
        break;
    case "editCategory":
        $categoryController = new CategoryController();
        $categoryController->edit();
        break;

    case "deleteCategory":
        $categoryController = new CategoryController();
        $categoryController->delete();
        break;
        
    // Quản lý người dùng
    case "User":
        $userController = new UserController();
        $userController->index();
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
        $inventoryController->index();
        break;
        
    case "add_stock":
        $inventoryController = new InventoryController();
        $inventoryController->addStock();
        break;
        
    case "remove_stock":
        $inventoryController = new InventoryController();
        $inventoryController->removeStock();
        break;
        
    case "update_all_status":
        $inventoryController = new InventoryController();
        $inventoryController->updateAllStatus();
        break;
        
    case "check_stock":
        $inventoryController = new InventoryController();
        $inventoryController->checkStock();
        break;    
   
    // Quản lý bình luận
    case "Comment":
        $CommentController = new CommentController();
        $CommentController->index();
        break;
    case "addComment":
        $CommentController = new CommentController();
        $CommentController->add();
        break;
    case "editComment":
        $CommentController = new CommentController();
        $CommentController->edit();
        break;
    case "deleteComment":
        $CommentController = new CommentController();
        $CommentController->delete();
        break;
    // Quản lý mã giảm giá
case "Voucher":
    $VoucherController = new VoucherController();
    $VoucherController->index();
    break;

case "addVoucher":
    $VoucherController = new VoucherController();
    $VoucherController->add();
    break;

case "editVoucher":
    $VoucherController = new VoucherController();
    $VoucherController->edit(); // Chức năng edit cần có trong controller
    break;

case "deleteVoucher":
    $VoucherController = new VoucherController();
    $VoucherController->delete();
    break;

        } 
include_once('view/footer.php');
 ob_end_flush(); ?>