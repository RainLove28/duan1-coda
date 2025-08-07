<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>docment</title>
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet" />
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <link rel="stylesheet" href="/New folder/duan1-coda/public/css/login.css" />
</head>

<body>
    <div class="Container-fluid">
        <!-- header navbar -->
        <div class="header" id="navbar">
            <div class="header-top">
                <div class="header-top-left">
                    <a href="?page=home"><img src="../public/img/logo.png" alt="Logo" /></a>
                </div>
                <div class="header-top-main">
                    <div class="menu">
                        <a href="?page=product&category=Kem chống nắng">Kem Chống Nắng</a>
                        <span>|</span>
                        <a href="?page=product&category=Tẩy trang - rửa mặt">Tẩy Trang</a>
                        <span>|</span>
                        <a href="?page=product&category=Toner - xịt khoáng">Toner</a>
                        <span>|</span>
                        <a href="?page=product&category=Son màu">Son màu</a>
                        <span>|</span>
                        <a href="?page=product&category=Sản phẩm gội đầu">Dầu Gội</a>
                    </div>
                    <div class="search-box">
                        <input type="text" placeholder="Tìm sản phẩm, danh mục mong muốn ..." />
                        <button><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="header-top-right">
                    <div class="cart">
                        <a href="?page=shop" class="cart-link">
                            <i class="fas fa-home"></i>
                            <span>Hệ thống cửa hàng</span></a>
                    </div>
                    <div class="cart">
                        <a href="/cart"><i class="fas fa-heart"></i></a>
                    </div>
                    <div class="cart">
                        <a href="?page=login.php"><i class="fas fa-user"></i></a>
                    </div>
                    <div class="cart">
                        <a href="?page=giohang" class="cart-link">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Header-bottom -->
            <div class="header-bottom">
                <ul class="pure-list" id="pure-list">
                    <li class="title-san-pham">
                        <a href="?page=product&category=Sale">Sale</a>
                        <div class="pure-item">
                            <div class="pure-item-left">
                                <ul class="pure-list-item">
                                    <li>
                                        <a href="index.php?page=product&category=Combo chăm sóc da">Combo chăm sóc
                                            da</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Combo chăm sóc tóc">Combo chăm sóc
                                            tóc</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Combo chăm sóc môi">Combo chăm sóc
                                            môi</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Combo khác">Combo khác</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- Nội dung combo chăm sóc da -->
                            <div class="pure-item-right right-1">
                                <?php if (!empty($ComboDaProducts)): ?>
                                <?php foreach (array_slice($ComboDaProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>

                            </div>
                            <!-- Nội dung combo chăm sóc tóc -->
                            <div class="pure-item-right right-2">
                                <?php if (!empty($ComboTocProducts)): ?>
                                <?php foreach (array_slice($ComboTocProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>

                            </div>
                            <!-- Nội dung combo chăm sóc môi -->
                            <div class="pure-item-right right-3">
                                <?php if (!empty($ComboMoiProducts)): ?>
                                <?php foreach (array_slice($ComboMoiProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung combo khác -->
                            <div class="pure-item-right right-4">
                                <?php if (!empty($ComboKhacProducts)): ?>
                                <?php foreach (array_slice($ComboKhacProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>

                        </div>
                    </li>
                    <!-- title-san-pham -->
                    <li class="title-san-pham">
                        <a href="index.php?page=product&category=Trang điểm">Trang Điểm</a>
                        <div class="pure-item">
                            <div class="pure-item-left">
                                <ul class="pure-list-item">
                                    <li>
                                        <a href="index.php?page=product&category=Son dưỡng môi">Son dưỡng môi</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Son màu">Son màu</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Tẩy da chết môi">Tẩy da chết môi</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Kem nền">Kem nền</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Kem má">Kem má</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- Nội dung son dưỡng môi -->
                            <div class="pure-item-right right-1">
                                <?php if (!empty($SonDuongMoiProducts)): ?>
                                <?php foreach (array_slice($SonDuongMoiProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung son màu -->
                            <div class="pure-item-right right-2">
                                <?php if (!empty($SonMauProducts)): ?>
                                <?php foreach (array_slice($SonMauProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung tẩy da chết môi -->
                            <div class="pure-item-right right-3">
                                <?php if (!empty($TayDaChetMoiProducts)): ?>
                                <?php foreach (array_slice($TayDaChetMoiProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung kem nền -->
                            <div class="pure-item-right right-4">
                                <?php if (!empty($KemNenProducts)): ?>
                                <?php foreach (array_slice($KemNenProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung kem má -->
                            <div class="pure-item-right right-5">
                                <?php if (!empty($KemMaProducts)): ?>
                                <?php foreach (array_slice($KemMaProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                    </li>
                    <li class="title-san-pham">
                        <a href="index.php?page=product&category=Da">Da</a>
                        <div class="pure-item">
                            <div class="pure-item-left">
                                <ul class="pure-list-item">
                                    <li>
                                        <a href="index.php?page=product&category=Tẩy trang - rửa mặt">Tẩy trang - rửa
                                            mặt</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Toner - xịt khoáng">Toner - xịt
                                            khoáng</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Dưỡng da">Dưỡng da</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Kem chống nắng">Kem chống nắng</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- Nội dung tẩy trang- rửa mặt -->
                            <div class="pure-item-right right-1">
                                <?php if (!empty($TayTrangProducts)): ?>
                                <?php foreach (array_slice($TayTrangProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung Toner - xịt khoáng -->
                            <div class="pure-item-right right-2">
                                <?php if (!empty($TonerXitKhoangProducts)): ?>
                                <?php foreach (array_slice($TonerXitKhoangProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung dưỡng da-->
                            <div class="pure-item-right right-3">
                                <?php if (!empty($DuongDaProducts)): ?>
                                <?php foreach (array_slice($DuongDaProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung kem chống nắng-->
                            <div class="pure-item-right right-4">
                                <?php if (!empty($KemChongNangProducts)): ?>
                                <?php foreach (array_slice($KemChongNangProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                    </li>
                    <li class="title-san-pham">
                        <a href="index.php?page=product&category=Tóc">Tóc</a>
                        <div class="pure-item">
                            <div class="pure-item-left">
                                <ul class="pure-list-item">
                                    <li>
                                        <a href="index.php?page=product&category=Sản phẩm gội đầu">Sản phẩm gội đầu</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Sản phẩm dưỡng tóc">Sản phẩm dưỡng
                                            tóc</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- Nội dung sản phẩm gội đầu -->
                            <div class="pure-item-right right-1">
                                <?php if (!empty($GoiDauProducts)): ?>
                                <?php foreach (array_slice($GoiDauProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung sản phẩm dưỡng tóc -->
                            <div class="pure-item-right right-2">
                                <?php if (!empty($DuongTocProducts)): ?>
                                <?php foreach (array_slice($DuongTocProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                    </li>
                    <li class="title-san-pham">
                        <a href="index.php?page=product&category=Làm đẹp đường uống">Làm Đẹp Đường Uống</a>
                        <div class="pure-item">
                            <div class="pure-item-left">
                                <ul class="pure-list-item">
                                    <li>
                                        <a href="index.php?page=product&category=Làm đẹp đường uống">Làm đẹp đường
                                            uống</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- Nội dung làm đẹp đường uống -->
                            <div class="pure-item-right right-1">
                                <?php if (!empty($LamDepDuongUongProducts)): ?>
                                <?php foreach (array_slice($LamDepDuongUongProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                    </li>
                    <li class="title-san-pham">
                        <a href="index.php?page=product&category=Cơ thể">Cơ Thể</a>
                        <div class="pure-item">
                            <div class="pure-item-left">
                                <ul class="pure-list-item">
                                    <li>
                                        <a href="index.php?page=product&category=Xà bông thiên nhiên">Xà bông thiên
                                            nhiên</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Sữa tắm thiên nhiên">Sữa tắm thiên
                                            nhiên</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Dưỡng thể">Dưỡng thể</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Tẩy da chết body">Tẩy da chết body</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Chăm sóc răng miệng">Chăm sóc răng
                                            miệng</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- Nội dung tẩy trang- rửa mặt -->
                            <div class="pure-item-right right-1">
                                <?php if (!empty($XaBongThienNhienProducts)): ?>
                                <?php foreach (array_slice($XaBongThienNhienProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung Toner - xịt khoáng -->
                            <div class="pure-item-right right-2">
                                <?php if (!empty($SuaTamThienNhienProducts)): ?>
                                <?php foreach (array_slice($SuaTamThienNhienProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung dưỡng da-->
                            <div class="pure-item-right right-3">
                                <?php if (!empty($DuongTheProducts)): ?>
                                <?php foreach (array_slice($DuongTheProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung kem chống nắng-->
                            <div class="pure-item-right right-4">
                                <?php if (!empty($TayDaChetBodyProducts)): ?>
                                <?php foreach (array_slice($TayDaChetBodyProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung kem chống nắng-->
                            <div class="pure-item-right right-5">
                                <?php if (!empty($ChamSocRangMiengProducts)): ?>
                                <?php foreach (array_slice($ChamSocRangMiengProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                    </li>
                    <li class="title-san-pham">
                        <a href="index.php?page=product&category=Em bé">Em Bé</a>
                        <div class="pure-item">
                            <div class="pure-item-left">
                                <ul class="pure-list-item">
                                    <li>
                                        <a href="index.php?page=product&category=Tắm bé">Tắm bé</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Chăm sóc bé">Chăm sóc bé</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- Nội dung tắm bé -->
                            <div class="pure-item-right right-1">
                                <?php if (!empty($TamBeProducts)): ?>
                                <?php foreach (array_slice($TamBeProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung chăm sóc bé -->
                            <div class="pure-item-right right-2">
                                <?php if (!empty($ChamSocBeProducts)): ?>
                                <?php foreach (array_slice($ChamSocBeProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                    </li>
                    <li class="title-san-pham">
                        <a href="index.php?page=product&category=Hương thơm">Hương Thơm</a>
                        <div class="pure-item">
                            <div class="pure-item-left">
                                <ul class="pure-list-item">
                                    <li>
                                        <a href="index.php?page=product&category=Tinh dầu nhỏ giọt nguyên chất">Tinh dầu
                                            nhỏ giọt nguyên chất</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Tinh dầu trị liệu">Tinh dầu trị
                                            liệu</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Tinh dầu treo thông minh">Tinh dầu treo
                                            thông minh</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- Nội dung tẩy trang- rửa mặt -->
                            <div class="pure-item-right right-1">
                                <?php if (!empty($TinhDauNhoGiotProducts)): ?>
                                <?php foreach (array_slice($TinhDauNhoGiotProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung Toner - xịt khoáng -->
                            <div class="pure-item-right right-2">
                                <?php if (!empty($TinhDauTriLieuProducts)): ?>
                                <?php foreach (array_slice($TinhDauTriLieuProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung dưỡng da-->
                            <div class="pure-item-right right-3">
                                <?php if (!empty($TinhDauTreoThongMinhProducts)): ?>
                                <?php foreach (array_slice($TinhDauTreoThongMinhProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                    <li class="title-san-pham">
                        <a href="index.php?page=product&category=Quà tặng">Quà Tặng</a>
                        <div class="pure-item">
                            <div class="pure-item-left">
                                <ul class="pure-list-item">
                                    <li>
                                        <a href="index.php?page=product&category=Dưới 300k">Dưới 300k</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Dưới 500k">Dưới 500k</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="?page=product&category=Dưới 800k">Dưới 800k</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- Nội dung tắm bé -->
                            <div class="pure-item-right right-1">
                                <?php if (!empty($Duoi300Products)): ?>
                                <?php foreach (array_slice($Duoi300Products, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung tắm bé -->
                            <div class="pure-item-right right-2">
                                <?php if (!empty($Duoi500Products)): ?>
                                <?php foreach (array_slice($Duoi500Products, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung chăm sóc bé -->
                            <div class="pure-item-right right-3">
                                <?php if (!empty($Duoi800Products)): ?>
                                <?php foreach (array_slice($Duoi800Products, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                    </li>
                    <li class="title-san-pham">
                        <a href="index.php?page=product&category=Bộ sản phẩm">Bộ Sản Phẩm</a>
                        <div class="pure-item">
                            <div class="pure-item-left">
                                <ul class="pure-list-item">
                                    <li>
                                        <a href="index.php?page=product&category=Bộ chăm sóc da ngừa lão hóa">Bộ chăm
                                            sóc da ngừa lão hóa</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Bộ chăm sóc da rau má">Bộ chăm sóc da
                                            Rau Má</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Bộ chăm sóc da tơ tằm">Bộ chăm sóc da
                                            tơ tắm</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="index.php?page=product&category=Bộ chăm sóc da Sơ-Ri">Bộ chăm sóc da
                                            Sơ-Ri</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- Nội dung tẩy trang- rửa mặt -->
                            <div class="pure-item-right right-1">
                                <?php if (!empty($ChamSocDaNguaLaoHoaProducts)): ?>
                                <?php foreach (array_slice($ChamSocDaNguaLaoHoaProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung Toner - xịt khoáng -->
                            <div class="pure-item-right right-2">
                                <?php if (!empty($BoChamSocRauMaProducts)): ?>
                                <?php foreach (array_slice($BoChamSocRauMaProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung dưỡng da-->
                            <div class="pure-item-right right-3">
                                <?php if (!empty($BoChamSocDaToTamProducts)): ?>
                                <?php foreach (array_slice($BoChamSocDaToTamProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung kem chống nắng-->
                            <div class="pure-item-right right-4">
                                <?php if (!empty($BoChamSocDaSoRiProducts)): ?>
                                <?php foreach (array_slice($BoChamSocDaSoRiProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>

                            </div>
                    </li>
                    <li class="title-san-pham">
                        <a href="?page=product&category=Khác">Khác</a>
                        <div class="pure-item">
                            <div class="pure-item-left">
                                <ul class="pure-list-item">
                                    <li>
                                        <a href="?page=product&category=Chăm sóc nhà cửa">Chăm sóc nhà cửa</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                    <li>
                                        <a href="?page=product&category=Túi vải bảo vệ môi trường">Túi vải bảo vệ môi
                                            trường</a>
                                        <i class="fas fa-greater-than"></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- Nội dung tẩy trang- rửa mặt -->
                            <div class="pure-item-right right-1">
                                <?php if (!empty($ChamSocNhaCuaProducts)): ?>
                                <?php foreach (array_slice($ChamSocNhaCuaProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                            <!-- Nội dung Toner - xịt khoáng -->
                            <div class="pure-item-right right-2">
                                <?php if (!empty($TuiVaiBaoVeMoiTruongProducts)): ?>
                                <?php foreach (array_slice($TuiVaiBaoVeMoiTruongProducts, 0, 4) as $product): ?>
                                <div class="pure-item-right-content-skin">
                                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                                     ?>
                                    <div class="sale-badge">-<?= $discount ?>%</div>
                                    <?php endif; ?>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                                    </a>
                                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                        <p><?= $product['TenSanPham'] ?></p>
                                    </a>
                                    <div class="pure-item-price-info">
                                        <span
                                            class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                        <?php if (!empty($product['GiaSale'])): ?>
                                        <span
                                            class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p style="color: red; padding: 10px;">Không có sản phẩm để hiển thị.</p>
                                <?php endif; ?>
                            </div>
                    </li>
                    <li class="title-san-pham">
                        <a href="?page=vecomem">Về Aura Beauty</a>
                    </li>
                </ul>
            </div>
        </div>
</body>

<script src="../public/JS/header.js"></script>

</html>