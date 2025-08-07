<?php
require_once('database.php');
//Ham lay tat ca san pham
class ProductModel{
    public function getAllPro(){
        $sql = "SELECT * FROM sanpham";
 return Database::getInstance()->getAll($sql);
}
//Ham lay san pham noi bat
public function getHotPro(){
    $sql = "SELECT * FROM sanpham Where NoiBat=2 ";
 return Database::getInstance()->getAll($sql);
}
//Ham lay san pham theo id ma danh muc
public function getProByCate($id){
     $sql = "SELECT * FROM sanpham Where idDanhMuc=$id";
     return Database::getInstance()->getAll($sql);
}

// Ham lay san pham theo ten danh muc
public function getProByCateName($tenDM){
    $sql = "
        SELECT sp.* 
        FROM sanpham sp
        JOIN danhmuc dm ON sp.MaDM = dm.MaDM
        WHERE dm.MaDM = (
            SELECT MaDM FROM danhmuc WHERE TenDM = ? LIMIT 1
        )
        OR dm.MaDMCha = (
            SELECT MaDM FROM danhmuc WHERE TenDM = ? LIMIT 1
        )
    ";
    return Database::getInstance()->getAll($sql, [$tenDM, $tenDM]);
}





// public function addPro($data){
    
//     $sql="INSERT INTO SanPham(TenSanPham,Gia,GiaSale,NoiBat,idDanhMuc,HinhAnh)
//     VALUES(? ,? ,? ,? ,? ,? )";
//     $params=array_values($data);
//     return Database::getInstance()->execute($sql,$params);
// }
public function getProById($id){
    $sql="SELECT * FROM sanpham WHERE MaSP=$id";
    return Database::getInstance()->getOne($sql);
}
// public function editPro($data){
//     $sql="UPDATE SanPham SET TenSanPham=?,Gia=?,GiaSale=?,NoiBat=?,idDanhMuc=?,HinhAnh=? WHERE id=?";
//     $params=array_values($data);
//     return Database::getInstance()->execute($sql,$params);
// }
// public function deletePro($data){
//     $sql = "DELETE FROM SanPham WHERE id = ?";
    
//     // Nếu $data là chuỗi hoặc số nguyên, gói nó vào mảng
//     $params = is_array($data) ? array_values($data) : [$data];
    
//     return Database::getInstance()->execute($sql, $params);
// }
public function getProductById($id) {
    $sql="SELECT * FROM sanpham WHERE MaSP=$id";
    
    
    return Database::getInstance()->getOne($sql);
  
}
// public function getRelatedProducts($idDanhMuc, $currentProductId) {
//     $sql = "SELECT * FROM sanpham WHERE idDanhMuc = ? AND id != ? LIMIT 4";
//     return Database::getInstance()->getAll($sql, [$idDanhMuc, $currentProductId]);
// }
}
 








?>