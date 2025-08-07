<?php
   require_once('Database.php');
   //Ham lay tat ca san pham
   class DiscountModel{
       public function getAllPro(){
           $sql = "SELECT * FROM discounts";
    return Database::getInstance()->getAll($sql);
       }
       public function getDiscountById($id) {
        $sql= "SELECT * FROM discounts WHERE id=$id";
        return Database::getInstance()->getOne($sql);
    }
   public function deleteDiscount($data) {
    $sql = "DELETE FROM discounts WHERE id=?";
    $params = is_array($data) ? array_values($data) : [$data];
    return Database::getInstance()->execute($sql, $params);
    }
    public function addDiscount($data){
        $sql = "INSERT INTO discounts (Code,Discount,MoTa,HoatDong)
        VALUES(?,?,?,?)";
        $params=array_values($data);
        return Database::getInstance()->execute($sql,$params);
    }
    
    public function editDiscount($data){
        $sql = "UPDATE discounts SET Code=?,Discount=?,MoTa=?,HoatDong=? WHERE id=?";
        $params = array_values ($data);
        return Database::getInstance()->execute($sql,$params);
    }
    
   }
?>