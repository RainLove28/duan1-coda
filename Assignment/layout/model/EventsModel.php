<?php
   require_once('Database.php');
   //Ham lay tat ca san pham
   class EventsModel{
       public function getAllPro(){
           $sql = "SELECT * FROM events";
    return Database::getInstance()->getAll($sql);
       }
       public function getEventsById($id) {
        $sql= "SELECT * FROM events WHERE id=$id";
        return Database::getInstance()->getOne($sql);
    }
   public function deleteEvents($data) {
    $sql = "DELETE FROM events WHERE id=?";
    $params = is_array($data) ? array_values($data) : [$data];
    return Database::getInstance()->execute($sql, $params);
    }
    public function addevents($data){
        $sql = "INSERT INTO events (Ten,Ngay,DiaChi,MoTa,SucChua,HienThi)
        VALUES(?,?,?,?,?,?)";
        $params=array_values($data);
        return Database::getInstance()->execute($sql,$params);
    }
    
    public function editEvents($data){
        $sql = "UPDATE events SET Ten=?,Ngay=?,DiaChi=?,MoTa=?,SucChua=?,HienThi=? WHERE id=?";
        $params = array_values ($data);
        return Database::getInstance()->execute($sql,$params);
    }
    
   }
?>