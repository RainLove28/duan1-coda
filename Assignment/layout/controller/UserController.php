<?php
    class UserController{
        public function __construct(){
            require_once('model/UserModel.php');
            $this-> userModel = new UserModel();
        }
        public function renderRegister(){
            require_once('view/register.php');
        }
        public function register($data){
            print_r($data);
            $result = $this->userModel ->addUser($data);
            if($result){
                header('location: index.php?page=loginpage');
            }else{
                echo "Đăng ký thất bại";
            }
        }
        public function renderLogin(){
            include_once('view/login.php');
        }
        public function login($data){
            // print_r($data);
            $user= $this->userModel ->getUser($data);
            // print_r($user);
            if($user){
                echo "Đăng nhập thành công";
                $_SESSION['user']= $user;
                if($user['Vaitro']==1){
                    header('location: ../admin/index.php');
                }else{
                    header('location: index.php');
                }
            }else{
                echo "Đăng nhập thất bại, hãy nhập lại";
            }
        }
        public function logout(){
            unset($_SESSION['user']);
            header('location: index.php');
        }
    }








?>