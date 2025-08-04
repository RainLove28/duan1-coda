<?php
class ProductController{
    //Tao thuoc tinh
    private $productModel;
    //Tao ham khoi tao
    public function __construct(){
        require_once('model/ProductModel.php');
        $this->productModel = new ProductModel();
        
    }
    //Tao phuong thuc show trang san pham
    public function renderProduct(){
        $productAll = $this->productModel ->getAllPro();
        // print_r($productAll);
        require_once("view/product.php");
    }
    public function productDetail() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $product = $this->productModel->getProductById($id);
            
            if ($product) {
                require_once("view/productdetail.php");
            } else {
                echo "Sản phẩm không tồn tại!";
            }
        } else {
            echo "Không tìm thấy sản phẩm!";
        }
    }
    //Tao phuong thuc show trang chu
    public function renderHome(){
        $productHot = $this->productModel ->getHotPro();
        // San pham theo id danh muc 1 hoac 2
        $proCate1 = $this->productModel -> getProByCate(1);
        $proCate2 = $this->productModel -> getProByCate(2);
        $proCate3 = $this->productModel -> getProByCate(3);
        $proCate4 = $this->productModel -> getProByCate(6);
        // print_r($proCate1);
        require_once("view/home.php");
    }
    public function proDetail($id) {
        $product = $this->productModel->getProById($id);
        if (!$product) {
            echo "Sản phẩm không tồn tại!";
            return;
        }
        $relatedProducts = $this->productModel->getRelatedProducts($product['idDanhMuc'], $id);
    
        // debug
        // var_dump($relatedProducts); exit;
    
        // require đúng đường dẫn
        require_once __DIR__ . '/../view/productdetail.php';
    }
    
}












?>