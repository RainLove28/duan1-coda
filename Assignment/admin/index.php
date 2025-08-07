<?php
session_start();
if(!isset($_SESSION['user']['Vaitro']) || $_SESSION['user']['Vaitro']!=1){
    header('Location: ../frontend/index.php?page=loginpage');
}

require_once('view/header.php');
require_once('controller/ProductController.php');
require_once('controller/CategoryController.php');
require_once('controller/DiscountController.php');
require_once('controller/TransportController.php');
require_once('controller/EventsController.php');

$page=$_GET['page'] ?? "product";
switch($page){
    case "product":
        $productController = new ProductController();
        $productController->renderProduct();
    break;
   
    //Show trang Them san pham
    case "addpropage":
        $productController = new ProductController();
        $productController -> renderAddProduct();
        break;
    //thuc hien Them san pham
    case "addpro":
        $data=$_POST;
        $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
        // print_r($data);
        move_uploaded_file($_FILES['HinhAnh']['tmp_name'],"../public/img/".$_FILES['HinhAnh']['name']);
        $productController = new ProductController();
        $productController -> addProduct($data);
        break;
    case "editpropage":
            $id=$_GET['id'];
            $productController= new ProductController();
            $productController ->renderEditProduct($id);
            break;
    case "editpro":
        $data=$_POST;
        $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
        // print_r($data);
        move_uploaded_file($_FILES['HinhAnh']['tmp_name'],"../public/img/".$_FILES['HinhAnh']['name']);
        $data['id']=$_GET['id'];
        $productController = new ProductController();
        $productController -> editProduct($data);
        break;
   
        
       
    case "deletepro":
        $data['id']=$_GET['id'];
        $productController = new ProductController();
        $productController -> deleteProduct($data);
        
        break;

    case "category":
            $categoryController = new CategoryController();
            $categoryController->renderCategory();
    break;
    case "addcatepage":
        $categoryController = new CategoryController();
        $categoryController->renderAddCategory();
        break;
    case "addcate":
        $data=$_POST;
        $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
        // print_r($data);
        move_uploaded_file($_FILES['HinhAnh']['tmp_name'],"../public/img/".$_FILES['HinhAnh']['name']);
        $categoryController = new CategoryController();
            $categoryController->addCategory($data);
         break;
    case "editcatepage":
        $id=$_GET['id'];
        $categoryController= new CategoryController();
        $categoryController ->renderEditCategory($id);
        break;
    case "editcate":
        $data=$_POST;
        $data['HinhAnh'] = $_FILES['HinhAnh']['name'];
        // print_r($data);
        move_uploaded_file($_FILES['HinhAnh']['tmp_name'],"../public/img/".$_FILES['HinhAnh']['name']);
        $data['id']=$_GET['id'];
        $categoryController = new CategoryController();
        $categoryController -> editCategory($data);
        break;

case "discounts":
            $discountController = new DiscountController();
            $discountController->renderDiscountList();
            break;
    
        
 case "adddiscount":
            $discountController = new DiscountController();
            $discountController->renderAddDiscount();
            break;
    
        
 case "adddiscounts":
            $data = $_POST;
            $discountController = new DiscountController();
            $discountController->adddiscount($data);
            break;
    
        
case "editdiscountpage":
            $id = $_GET['id'];
            $discountController = new DiscountController();
            $discountController->renderEditDiscount($id);
            break;
    
       
case "editdiscount":
            $data = $_POST;
            $data['id'] = $_GET['id']; 
            $discountController = new DiscountController();
            $discountController->editDiscount($data);
            break;
    
       
case "deleteDiscount":
            $data['id']= $_GET['id'];
            $discountController = new DiscountController();
            $discountController-> deleteDiscount($data);
            break;

case "transporter":
                $transportController = new TransportController();
                $transportController->renderTransportList();
                break;
        
            
case "addtransport":
                $transportController = new TransportController();
                $transportController->renderAddTransport();
                break;
        
            
case "addtrans":
                $data = $_POST;
                $transportController = new TransportController();
                $transportController->addtransport($data);
                break;
        
            
case "edittransportpage":
                $id = $_GET['id'];
                $transportController = new TransportController();
                $transportController->renderEditTransport($id);
                break;
        
            
case "edittransport":
                $data = $_POST;
                $data['id'] = $_GET['id']; // Lấy ID từ URL
                $transportController = new TransportController();
                $transportController->editTransport($data);
                break;
        
            
case "deleteTransport":
                $data['id']= $_GET['id'];
                $transportController = new TransportController();
                $transportController-> deleteTransport($data);
                break;


case "events":
            $eventsController = new EventsController();
            $eventsController->renderEventsList();
            break;
                
                    
case "addevents":
            $eventsController = new EventsController();
            $eventsController->renderAddEvents();
            break;
                
                    
case "addeve":
            $data = $_POST;
            $eventsController = new EventsController();
            $eventsController->addevents($data);
            break;
                
                    
case "editeventspage":
            $id = $_GET['id'];
            $eventsController = new EventsController();
            $eventsController->renderEditEvents($id);
            break;
                
                    
case "editevents":
            $data = $_POST;
            $data['id'] = $_GET['id']; // Lấy ID từ URL
            $eventsController = new EventsController();
            $eventsController->editEvents($data);
            break;
                
                   
case "deleteEvents":
            $data['id']= $_GET['id'];
            $eventsController = new EventsController();
            $eventsController-> deleteEvents($data);
            break;
case "logout":
        if(isset($_SESSION['user'])){
            session_destroy();
            header('Location: ../layout/index.php');
        }
        break;
}
require_once('view/footer.php');



?>