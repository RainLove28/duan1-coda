<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$baseUrl = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER["REQUEST_URI"] . '?') . '/';
//var_dump($_SESSION['userInfo']);
require_once 'site/model/config.php';
require_once 'site/model/database copy.php';

// Sử dụng Singleton Database
$db = Database::getInstance();

// Chèn file SiteController.php có class SiteController
require_once 'site/controller/SiteController.php';
// khởi tạo đối tượng controller từ lớp SiteController. Đây chính là bộ điều khiển
$controller = new SiteController($baseUrl, $db);

// Chèn header
include 'site/view/header.php';

// chèn các nội dung chính của trang
if (!isset($_GET['page'])) {
  //include 'Views/home.php';
  $controller->index(); // sẽ gọi include 'Views/home.php'; như dòng trên
} else {
  //include 'Views/'. $_GET['page'] .'.php';
  $page = $_GET['page'];
  $controller->$page();
}

// chèn footer
include 'site/view/footer.php';