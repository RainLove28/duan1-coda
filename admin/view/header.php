<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;1,300&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="../public/css/styleadmin1.css">
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
   <div class="row">
       <div class="col-md-2 ">
           <div class="logo"><h1 class="text-center"><span>SNEAKER </span><span class="text-white">ADMIN</span></h1></div>
           <hr>
           <p><i class="bi bi-house-door-fill me-2"></i><a href="?page=dashboard"> Dashboard</a></p>
           <p><i class="bi bi-pie-chart-fill me-2"></i><a href="?page=statistic"> Quản lý thống kê</a></p>
           <p><i class="bi bi-tag-fill me-2"></i><a href="?page=Category"> Quản lý danh mục</a></p>
           <p><i class="bi bi-box-seam me-2"></i><a href="?page=product"> Quản lý sản phẩm</a></p>
           <p><i class="bi bi-people-fill me-2"></i><a href="?page=user_list"> Quản lý người dùng</a></p>
           <p><i class="bi bi-cart-fill me-2"></i><a href="?page=order_list"> Quản lý đơn hàng</a></p>
           <p><i class="bi bi-chat-left-text-fill me-2"></i><a href="?page=comment"> Quản lý bình luận</a></p>
           <hr>
           <div class="logout">          
           <?php if(isset($_SESSION['khachhang'])) { ?>
                    <a href="../site/?page=logout">Đăng xuất</a>
                     <?php } else { ?>
                    <a href="?page=loginpage">Đăng nhập</a>
                        <?php } ?>
           </div>
       </div>
       <div class="col-md-10">
           <div class="top">
               <p>TRANG QUẢN TRỊ SNEAKERDAILY</p>
               <div><span>Admin</span><img width="30px" height="30px" src="../public/img/pexels-faheem-ahamad-422934800-16432389.jpg" alt=""></div>
           </div>
           <div class="content">

