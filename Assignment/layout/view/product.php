<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản Phẩm</title>
    <link rel="stylesheet" href="public/css/style1.css">
    <style>
        footer{
            clear: both;
        }
    </style>
</head>
<body>


<main>
<div class="container">
    <div class="left-box">
        <h2>Danh Mục</h2>
        <!-- Danh sách danh mục -->
        <ul>
            <li><a href="#">Danh mục Xe Ninja</a></li>
            <li><a href="#">Danh mục Xe Z</a></li>
            <li><a href="#">Danh mục Xe ZX</a></li>
            <li><a href="#">Danh mục Xe JET SKI</a></li>
        </ul>
    </div>

    <div class="right-box">
        <div class="product-list">
            <!-- Danh sách sản phẩm -->
             <?php foreach($productAll as $product) { ?>
            <div class="product">
                <img src="../public/img/<?=$product['HinhAnh'] ?>" alt="">
                <h3><?= $product['TenSanPham'] ?></h3>
                <p>Gia goc: <?=$product['Gia']?></p>
                <p>Gia sale: <?=$product['GiaSale']?></p>
                <a href="?page=productdetail&id=<?= $product['id'] ?>">
                    <button>Xem chi tiết</button>
                </a>
            </div>
            <?php } ?>
        </div>

        <div class="pagination">
            <!-- Phân trang -->
            <a href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <!-- Thêm các trang khác cần hiển thị -->
        </div>
    </div>
</div>
</main>


</body>
</html>
