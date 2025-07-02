<?php
    class ProductController{
        private $productModel;
        //Tạo thuộc tính
        //Tạo hàm khởi tạo
        public function __construct(){
            require_once('../site/model/ProductModel.php');
            $this->productModel = new ProductModel();
            
        }
        //Tạo phương thức
        public function renderProduct(){
            $products = $this->productModel-> getALLPro();
            //print_r($products);
            require_once('view/product.php'); 
        }
        public function renderAddProduct(){
            include_once('view/addpro.php');

        }
        public function addProduct($data){
            $this->productModel->addPro($data);
            header('Location: index.php?page=product');
        }
        public function renderEditProduct($id){
            $product =$this ->productModel ->getProById($id);
            //print_r($product);
            include_once('view/editpro.php');
        }
        public function editProduct($data){
            $this->productModel->editPro($data);
            header('location: index.php?page=product');
        }
        public function delete($data){
            $this->productModel->deletePro($data['id']);
            header('location: index.php?page=product');
        }

       


    }
?>