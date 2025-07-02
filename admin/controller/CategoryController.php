<?php
    class CategoryController {
        private $categoryModel;
        public function __construct () {
            include_once ('../site/model/CategoryModel.php');
            $this -> categoryModel = new CategoryModel();
        }
        public function renderCategory(){
            $categoryAll = $this -> categoryModel ->getAllPro();
            //eprint_r($productAll);
            include_once('view/Category.php');
        }
        public function renderAddCategory() {
            include_once('view/addCategory.php');
        }
        public function addCate($data){
            $this->categoryModel->addCate($data);
            header('Location:index.php?page=Category');
        }
        public function renderEditCategory($id) {
            $category = $this ->categoryModel ->getProById($id);
            include_once('view/editCate.php');
        }
        public function editCate($data){
            $this ->categoryModel ->editCateGory($data);
            header('location: index.php?page=Category');
        }
        public function DeleteCategory($data) {
            $this ->categoryModel->DeleteCategory($data);
            header('location:index.php?page=Category');
        }
    }
?>