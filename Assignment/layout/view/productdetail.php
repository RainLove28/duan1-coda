
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <link rel="stylesheet" href="public/css/style1.css">
    <style>
        footer{
            clear: both;
        }
    </style>
    
</head>
<body>
    <header>
        <h1>Chi Tiết Sản Phẩm</h1>
    </header>
    <div class="container_cart">
        <div class="product-detail">
            <div class="product-image">
                <img src="../public/img/<?=$product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" width="300">
            </div>
            <div class="product-info">
                <h2><?= $product['TenSanPham'] ?></h2>
                <p style="font-weight: bold;"><?= $product['description'] ?></p>
                <p style="font-size: 24px;">Giá: <?= number_format($product['Gia'], 0, ',', '.') ?> đ</p>
                <p style="font-size: 22px; color: red;">Giá khuyến mãi: <?= number_format($product['GiaSale'], 0, ',', '.') ?> đ</p>
                <button class="order-button">Đặt Hàng</button>
            </div>
        </div>

        <div class="related-products">
  <h3>Sản phẩm liên quan</h3>
  <div class="product-box">
    <?php if (!empty($relatedProducts) && is_array($relatedProducts)): ?>
      <?php foreach ($relatedProducts as $rp): ?>
        <div class="product-item">
          <img src="../public/img/<?= htmlspecialchars($rp['HinhAnh']) ?>" width="150">
          <h4><?= htmlspecialchars($rp['TenSanPham']) ?></h4>
          <p>Giá: <?= number_format($rp['Gia'],0,',','.') ?> đ</p>
          <p>Sale: <?= number_format($rp['GiaSale'],0,',','.') ?> đ</p>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Không có sản phẩm liên quan.</p>
    <?php endif; ?>
  </div>
</div>
    </div>
    
    
</body>
</html>
