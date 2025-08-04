<?php
class ProductController{
    private $ProductModel;
    public function __construct(){
        include_once('../layout/model/ProductModel.php');
        $this->productModel = new ProductModel();

    }
    public function renderProduct(){
        $productAll = $this -> productModel ->getAllPro();
        // print_r($productAll);
        require_once('view/product.php');
    }
    public function renderAddProduct(){
        include_once('view/addPro.php');
    }
    public function addProduct($data){
        $this->productModel -> addpro($data);
        header('Location: index.php?page=product');
    }
    public function renderEditProduct($id){
        print_r($id);
        $product= $this->productModel ->getProById($id);
        include_once('view/editpro.php');
    }
    public function editProduct($data){
        $this->productModel ->editPro($data);
        header('location: index.php?page=product');
    }
   
    public function deleteProduct($data) {
        $this->productModel ->deletePro($data);
        header('location: index.php?page=product');
    }
}








?>