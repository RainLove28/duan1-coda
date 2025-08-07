<?php
class CategoryController{
    private $CategoryModel;
    public function __construct(){
        include_once('../layout/model/CategoryModel.php');
        $this->CategoryModel = new categoryModel();

    }
    public function renderCategory(){
        $categoryAll = $this ->CategoryModel ->getAllPro();
        
        require_once('view/category.php');
    }
    public function renderAddCategory(){
        include_once('view/addCate.php');
    }
    public function addCategory($data){
        $this->CategoryModel -> addcate($data);
        header('Location: index.php?page=category');
    }
    public function renderEditCategory($id){
        // print_r($id);
        $category= $this->CategoryModel ->getCateById($id);
        include_once('view/editcate.php');
    }
    public function editCategory($data){
        $this->CategoryModel ->editCate($data);
        header('location: index.php?page=category');
    }
   
    public function deleteCategory($data) {
        $this->CategoryModel ->deleteCate($data);
        header('location: index.php?page=category');
    }
}






?>