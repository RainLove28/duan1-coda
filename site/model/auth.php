<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// ...existing code...
require_once __DIR__ . '/database.php';

class Auth {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function register($username, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        return $this->db->execute($sql, [$username, $hashed_password]);
    }

    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $user = $this->db->getOne($sql, [$username]);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }

    public function generateOTP() {
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        return $otp;
    }

    public function verifyOTP($otp) {
        return isset($_SESSION['otp']) && $_SESSION['otp'] === $otp;
    }
}
?>