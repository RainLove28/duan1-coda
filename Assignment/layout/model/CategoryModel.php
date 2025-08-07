<?php
require_once('Database.php');
//Ham lay tat ca san pham
class CategoryModel{
    public function getAllPro(){
        $sql = "SELECT * FROM danhmuc";
 return Database::getInstance()->getAll($sql);
}
public function addcate($data){
    
    $sql="INSERT INTO DanhMuc(TenDanhMuc,HinhAnh)
    VALUES(? ,?  )";
    $params=array_values($data);
    return Database::getInstance()->execute($sql,$params);
}
public function getCateById($id){
    $sql="SELECT * FROM DanhMuc WHERE id=$id";
    return Database::getInstance()->getOne($sql);
}
public function editCate($data){
    $sql="UPDATE DanhMuc SET TenDanhMuc=?,HinhAnh=? WHERE id=?";
    $params=array_values($data);
    return Database::getInstance()->execute($sql,$params);
}
public function deleteCate($data){
    $sql = "DELETE FROM DanhMuc WHERE id = ?";
    
    // Nếu $data là chuỗi hoặc số nguyên, gói nó vào mảng
    $params = is_array($data) ? array_values($data) : [$data];
    
    return Database::getInstance()->execute($sql, $params);
}
}
 








?>