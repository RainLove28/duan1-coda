<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/css/sale.css" />
</head>
<style>
.title {
    width: 80%;
    margin: 13% auto;
    font-family: "Inter", serif;
}

.title-1 {
    width: 80%;
    margin: 0 auto;
    font-family: "Inter", serif;
    color: red;
}

.title-1 p {
    color: red;
    font-size: 16px;
}

h1 {
    color: #4c503d;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
}

.sale-products {
    width: 80%;
    margin: 0 auto;
}

.sale-product {
    width: 100%;
    margin: 1%;
    float: left;
    background-color: #fff;
    border-radius: 8px;
    padding: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

p {
    font-family: "Inter", serif;
    font-size: 14px;
    color: #345;
    font-weight: 400;
}

b {
    font-weight: 600;
    font-size: 14px;
    text-transform: none;
}
</style>

<body>

</body>

</html>
<div class="title">
    <h1>Sản phẩm</h1>
    <p>Kết quả tìm kiếm cho từ khóa: "<b> <?= htmlspecialchars($keyword) ?></b> "</p>
</div>

<?php if (empty($products)): ?>
<div class="title-1">
    <p>Không tìm thấy sản phẩm nào.</p>
</div>
<?php else: ?>
<div class="sale-products">
    <?php foreach ($products as $product): ?>
    <div class="sale-product">
        <?php 
                $giaSale = $product['GiaSale'] ?? null;
                $donGia = $product['DonGia'] ?? null;

                if (!empty($giaSale) && !empty($donGia) && $giaSale > $donGia): 
                    $discount = round((($giaSale - $donGia) / $giaSale) * 100);
                ?>
        <div class="sale-badge">-<?= $discount ?>%</div>
        <?php endif; ?>

        <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?? 0 ?>">
            <img src="<?= htmlspecialchars($product['HinhAnh'] ?? 'public/images/no-image.png') ?>"
                alt="<?= htmlspecialchars($product['TenSanPham'] ?? 'Sản phẩm') ?>">
        </a>

        <div class="sale-product-title"><?= htmlspecialchars($product['TenSanPham'] ?? 'Tên sản phẩm') ?></div>

        <div class="sale-product-price">
            <?php if (!is_null($donGia)): ?>
            <span class="price"><?= number_format($donGia, 0, ',', '.') ?>đ</span>
            <?php endif; ?>

            <?php if (!is_null($giaSale)): ?>
            <span class="old-price"><?= number_format($giaSale, 0, ',', '.') ?>đ</span>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>