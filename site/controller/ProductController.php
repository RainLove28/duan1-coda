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
    // public function renderProduct(){
    //     $productAll = $this->productModel ->getAllPro();
    //     // print_r($productAll);
    //     require_once("view/product.php");
    // }

    // Hiển thị sản phẩm theo danh mục
    public function renderProductByCategory($categoryName) {
        $products = $this->productModel->getProByCateName($categoryName);
        require_once 'view/product.php';
    }
    public function productDetail() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $products = $this->productModel->getProById($id);
            
            if ($products) {
                require_once("view/product-details.php");
            } else {
                echo "Sản phẩm không tồn tại!";
            }
        } else {
            echo "Không tìm thấy sản phẩm!";
        }
    }
    //Tao phuong thuc show trang chu
    public function renderHome(){
        $newProducts = $this->productModel->getProByCateName("Sản phẩm mới");
        $hotProducts = $this->productModel->getProByCateName("Sản phẩm bán chạy");
        $daProducts = $this->productModel->getProByCateName("Chăm sóc da");
        $saleProducts = $this->productModel->getProByCateName("Khuyễn mãi và combo");
        $QuaTangProducts = $this->productModel->getProByCateName("Quà tặng");
        $SonMoiProducts = $this->productModel->getProByCateName("Son môi");
        require_once("view/home.php");
    }
     //Tao phuong thuc show header
    public function renderHeader(){
        $newProducts = $this->productModel->getProByCateName("Sản phẩm mới");
        $hotProducts = $this->productModel->getProByCateName("Sản phẩm bán chạy");
        $daProducts = $this->productModel->getProByCateName("Chăm sóc da");
        $saleProducts = $this->productModel->getProByCateName("Khuyễn mãi và combo");
        $QuaTangProducts = $this->productModel->getProByCateName("Quà tặng");
        $SonMoiProducts = $this->productModel->getProByCateName("Son môi");
        $ComboDaProducts = $this->productModel->getProByCateName("Combo chăm sóc da");
        $ComboTocProducts = $this->productModel->getProByCateName("Combo chăm sóc tóc");
        $ComboMoiProducts = $this->productModel->getProByCateName("Combo chăm sóc môi");
        $ComboKhacProducts = $this->productModel->getProByCateName("Combo khác");
        $SonDuongMoiProducts = $this->productModel->getProByCateName("Son dưỡng môi");
        $SonMauProducts = $this->productModel->getProByCateName("Son màu");
        $TayDaChetMoiProducts = $this->productModel->getProByCateName("Tẩy da chết môi");
        $KemNenProducts = $this->productModel->getProByCateName("Kem nền");
        $KemMaProducts = $this->productModel->getProByCateName("Kem má");
        $TayTrangProducts = $this->productModel->getProByCateName("Tẩy trang - rửa mặt");
        $TonerXitKhoangProducts = $this->productModel->getProByCateName("Toner - xịt khoáng");
        $DuongDaProducts = $this->productModel->getProByCateName("Dưỡng da");
        $KemChongNangProducts = $this->productModel->getProByCateName("Kem chống nắng");
        $GoiDauProducts = $this->productModel->getProByCateName("Sản phẩm gội đầu");
        $DuongTocProducts = $this->productModel->getProByCateName("Sản phẩm dưỡng tóc");
        $LamDepDuongUongProducts = $this->productModel->getProByCateName("Làm đẹp đường uống 1");
        $XaBongThienNhienProducts = $this->productModel->getProByCateName("Xà bông thiên nhiên");
        $SuaTamThienNhienProducts = $this->productModel->getProByCateName("Sữa tắm thiên nhiên");
        $DuongTheProducts = $this->productModel->getProByCateName("Dưỡng thể");
        $TayDaChetBodyProducts = $this->productModel->getProByCateName("Tẩy da chết body");
        $ChamSocRangMiengProducts = $this->productModel->getProByCateName("Chăm sóc răng miệng");
        $TamBeProducts = $this->productModel->getProByCateName("Tắm bé");
        $ChamSocBeProducts = $this->productModel->getProByCateName("Chăm sóc bé");
        $TinhDauNhoGiotProducts = $this->productModel->getProByCateName("Tinh dầu nhỏ giọt nguyên chất");
        $TinhDauTriLieuProducts = $this->productModel->getProByCateName("Tinh dầu trị liệu");
        $TinhDauTreoThongMinhProducts = $this->productModel->getProByCateName("Tinh dầu treo thông minh");
        $Duoi300Products = $this->productModel->getProByCateName("Dưới 300k");
        $Duoi500Products = $this->productModel->getProByCateName("Dưới 500k");
        $Duoi800Products = $this->productModel->getProByCateName("Dưới 800k");
        $ChamSocDaNguaLaoHoaProducts = $this->productModel->getProByCateName("Bộ Chăm sóc da ngừa lão hóa");
        $BoChamSocRauMaProducts = $this->productModel->getProByCateName("Bộ Chăm sóc da rau má");
        $BoChamSocDaToTamProducts = $this->productModel->getProByCateName("Bộ Chăm sóc da tơ tằm");
        $BoChamSocDaSoRiProducts = $this->productModel->getProByCateName("Bộ Chăm sóc da Sơ-ri");
        $ChamSocNhaCuaProducts = $this->productModel->getProByCateName("Chăm sóc nhà cửa");
        $TuiVaiBaoVeMoiTruongProducts = $this->productModel->getProByCateName("Túi vải bảo vệ môi trường");
        require_once("view/header.php");
    }
    public function proDetail($id) {
        // $product = $this->productModel->getProById($id);
        // if (!$product) {
        //     echo "Sản phẩm không tồn tại!";
        //     return;
        // }
        // $relatedProducts = $this->productModel->getRelatedProducts($product['idDanhMuc'], $id);
    
        // debug
        // var_dump($relatedProducts); exit;
    
        // require đúng đường dẫn
        require_once  'view/product-details.php';
    }
    
}












?>