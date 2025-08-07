<?php
require_once __DIR__ . '/config.php';

class Database {
    private static $instance = null;
    private $conn;
    
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;

    // Private constructor để ngăn tạo instance trực tiếp
    private function __construct() {
        $this->connect();
    }

    // Ngăn clone
    private function __clone() {}

    // Ngăn unserialize
    public function __wakeup() {}

    // Singleton instance
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Kết nối database
    private function connect() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            die("Lỗi kết nối database: " . $exception->getMessage());
        }
    }

    // Lấy connection
    public function getConnection() {
        return $this->conn;
    }

    // Dùng cho câu lệnh SQL dạng INSERT, UPDATE hoặc DELETE
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    // Dùng cho câu lệnh SELECT - lấy tất cả
    public function getAll($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }

    // Dùng cho câu lệnh SELECT - lấy một record
    public function getOne($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    // Lấy ID của record vừa insert
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }

    // Bắt đầu transaction
    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    // Commit transaction
    public function commit() {
        return $this->conn->commit();
    }

    // Rollback transaction
    public function rollback() {
        return $this->conn->rollback();
    }
}
?>
