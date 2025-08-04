<?php
   class Database{
       private $host = "localhost";
       private $username = "root";
       private $password = "";
       private $database = "assignment";
       private $conn;


       //Kiểm tra database đã tạo chưa, để tạo mới Database
       public static $instance;
       public static function getInstance(){
           if(!self::$instance){
               self::$instance = new Database();
           }
           return self::$instance;
       }
      
       public function __construct(){
           try{
               // Tạo kết nối đến database theo phương thức PDO
               $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
               $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               // echo "Connect thành công";
           }catch(PDOException $e){
               echo "Connection failed: ".$e->getMessage();
           }
       }
       // Dùng cho câu lệnh SQL dạng INSERT, UPDATE hoặc DELETE
       public function execute($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            die("Lỗi SQL: " . $e->getMessage()); // In ra lỗi chi tiết
        }
    }
       //Dùng cho câu lệnh SELECT
       public function getAll($sql, $params = []){
           $stmt = $this->conn->prepare($sql);
           $stmt->execute($params);
           //Lấy tất cả dữ liệu
           return $stmt->fetchAll(PDO::FETCH_ASSOC);
       }


       public function getOne($sql){
           $stmt = $this->conn->prepare($sql);
           $stmt->execute();
           //Lấy 1 dữ liệu
           return $stmt->fetch();
       }
   }   
?>
