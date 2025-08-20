<?php
   class Database{
       private $host = "localhost";
       private $username = "root";
       private $password = "";
       private $database = "duan2(1)";
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
       
       // Thêm method getConnection() để tương thích với admin
       public function getConnection() {
           return $this->conn;
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
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            //Lấy tất cả dữ liệu
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("SQL Error in getAll: " . $e->getMessage());
            error_log("SQL Query: " . $sql);
            error_log("SQL Params: " . json_encode($params));
            throw $e; // Re-throw để caller có thể handle
        }
       }


       public function getOne($sql, $params = []){
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("SQL Error in getOne: " . $e->getMessage());
            error_log("SQL Query: " . $sql);
            error_log("SQL Params: " . json_encode($params));
            throw $e; // Re-throw để caller có thể handle
        }
       }
       
       // Transaction methods
       public function beginTransaction() {
           return $this->conn->beginTransaction();
       }
       
       public function commit() {
           return $this->conn->commit();
       }
       
       public function rollback() {
           return $this->conn->rollBack(); // PDO uses rollBack() with capital B
       }
       
       // Method để check transaction status
       public function inTransaction() {
           return $this->conn->inTransaction();
       }
   }