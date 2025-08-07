<?php
   require_once('Database.php');
   //Ham lay tat ca san pham
   class TransportModel{
       public function getAllPro(){
           $sql = "SELECT * FROM transporter";
    return Database::getInstance()->getAll($sql);
       }
       public function getTransportById($id) {
        $sql= "SELECT * FROM transporter WHERE id=$id";
        return Database::getInstance()->getOne($sql);
    }
   public function deleteTransport($data) {
    $sql = "DELETE FROM transporter WHERE id=?";
    $params = is_array($data) ? array_values($data) : [$data];
    return Database::getInstance()->execute($sql, $params);
    }
    public function addtransport($data){
        $sql = "INSERT INTO transporter (Ten,DiaChi,phone,MoTa,HienThi)
        VALUES(?,?,?,?,?)";
        $params=array_values($data);
        return Database::getInstance()->execute($sql,$params);
    }
    
    public function editTransport($data){
        $sql = "UPDATE transporter SET Ten=?,DiaChi=?,phone=?,MoTa=?,HienThi=? WHERE id=?";
        $params = array_values ($data);
        return Database::getInstance()->execute($sql,$params);
    }
    
   }
?>