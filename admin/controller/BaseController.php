<?php
require_once __DIR__ . '/../../site/model/config.php';
require_once __DIR__ . '/../../site/model/database.php';

/**
 * Base Controller - Lớp cha cho tất cả controller
 * Cung cấp các phương thức chung và database connection
 */
abstract class BaseController {
    protected $db;
    protected $conn; // Thêm này để tương thích với code cũ

    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection(); // Thêm này để tương thích
    }

    /**
     * Thực thi câu lệnh SQL
     */
    protected function execute($sql, $params = []) {
        return $this->db->execute($sql, $params);
    }

    /**
     * Lấy tất cả records
     */
    protected function getAll($sql, $params = []) {
        return $this->db->getAll($sql, $params);
    }

    /**
     * Lấy một record
     */
    protected function getOne($sql, $params = []) {
        return $this->db->getOne($sql, $params);
    }

    /**
     * Redirect với thông báo
     */
    protected function redirect($page, $message = '', $type = 'success') {
        if ($message) {
            $_SESSION[$type] = $message;
        }
        header("Location: index.php?page={$page}");
        exit;
    }

    /**
     * Validate dữ liệu đầu vào
     */
    protected function validateRequired($data, $fields) {
        foreach ($fields as $field) {
            if (empty($data[$field])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Sanitize dữ liệu
     */
    protected function sanitize($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
}
?>
