<?php
header('location: site/index.php');
if (isset($_GET['page']) && $_GET['page'] === 'login.php') {
    include 'view/login.php';
}
?>