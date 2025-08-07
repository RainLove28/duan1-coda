<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Đơn Giản</title>
    <link rel="stylesheet" href="../public/css/style1.css">
    
   
</head>
<body>

<header>
    <div class="container1">

        <img class="h-10" height="60" src="../public/img/icon1.png" alt="" width="200"/>    
<div class="phandau">
<nav>
    <a href="?page=home">Trang Chủ</a>
    <a href="?page=product">Sản phẩm</a>
    <a href="?page=about">Giới Thiệu</a>
    <a href="?page=contact">Liên Hệ</a>
    <?php if(isset($_SESSION['user'])) { ?>
        <a href="?page=logout">Đăng xuất</a>
    <?php } else { ?>
        <a href="?page=loginpage">Đăng nhập</a>
    <?php } ?>
</nav>
</div>
</div>
</header>

