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
    <link rel="stylesheet" href="../public/css/login.css" />
    <style>
        /* Simple User Dropdown CSS */
        .user-dropdown-simple {
            position: relative;
            display: inline-block;
        }
        
        .user-info {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #333;
            padding: 8px 12px;
            border-radius: 8px;
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .user-info:hover {
            background: #e9ecef;
        }
        
        .user-info span {
            font-size: 14px;
            font-weight: 500;
        }
        
        .user-info .fa-chevron-down {
            font-size: 12px;
            transition: transform 0.3s ease;
        }
        
        .user-menu-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            min-width: 220px;
            z-index: 999999;
            display: none;
            margin-top: 5px;
        }
        
        .user-info:hover .fa-chevron-down {
            transform: rotate(180deg);
        }
        
        .user-info:hover .user-menu-dropdown {
            display: block !important;
        }
        
        .user-menu-dropdown a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s ease;
        }
        
        .user-menu-dropdown a:last-child {
            border-bottom: none;
        }
        
        .user-menu-dropdown a:hover {
            background: #f8f9fa;
            color: #333;
            text-decoration: none;
        }
        
        .user-menu-dropdown a[href*="logout"]:hover {
            background: #fee;
            color: #dc3545;
        }
        
        .user-menu-dropdown i {
            width: 16px;
            text-align: center;
        }
        
        .dropdown-item:last-child {
            border-bottom: none;
        }
        
        .dropdown-item:hover {
            background: #f8f9fa;
            text-decoration: none;
            color: #333;
        }
        
        .dropdown-item.logout-item:hover {
            background: #fee;
            color: #dc3545;
        }
        
        .dropdown-item i {
            width: 16px;
            text-align: center;
        }
        
        .dropdown-item span {
            flex: 1;
        }
    </style>
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
                    <form class="search-box" method="GET" action="index.php">
                        <input type="hidden" name="page" value="filter">
                        <input type="text" name="keyword" placeholder="Tìm sản phẩm, danh mục mong muốn ..."
                            value="<?= $_GET['keyword'] ?? '' ?>">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div class="header-top-right">
                    <div class="cart">
                        <a href="#" class="cart-link">
                            <i class="fas fa-home"></i>
                            <span>Hệ thống cửa hàng</span></a>
                    </div>
                    <div class="cart">
                        <a href="/cart"><i class="fas fa-heart"></i></a>
                    </div>
                    <div class="cart user-menu">
                        <?php 
                        // Kiểm tra session nghiêm ngặt để tránh hiển thị sai
                        $isLoggedIn = false;
                        if (isset($_SESSION['user']) && 
                            is_array($_SESSION['user']) && 
                            isset($_SESSION['user']['fullname']) &&
                            !empty(trim($_SESSION['user']['fullname'])) &&
                            isset($_SESSION['user']['id']) &&
                            !empty($_SESSION['user']['id'])) {
                            $isLoggedIn = true;
                            $firstName = explode(' ', trim($_SESSION['user']['fullname']))[0];
                        }
                        
                        if ($isLoggedIn): ?>
                            <!-- Simple dropdown with pure CSS hover -->
                            <div class="user-dropdown-simple">
                                <div class="user-info">
                                    <i class="fas fa-user"></i>
                                    <span>Xin chào, <?= htmlspecialchars($firstName) ?></span>
                                    <i class="fas fa-chevron-down"></i>
                                    
                                    <!-- Dropdown menu inside user-info -->
                                    <div class="user-menu-dropdown">
                                        <a href="?page=ChiTietTaiKhoan.php">
                                            <i class="fas fa-user-circle"></i> Thông tin tài khoản
                                        </a>
                                        <a href="?page=logout" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?');">
                                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="?page=login"><i class="fas fa-user"></i></a>
                        <?php endif; ?>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Simple dropdown script loaded');
    
    // Simple search form validation
    const searchForm = document.querySelector('.search-box');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const keyword = this.querySelector('input[name="keyword"]').value.trim();
            if (keyword.length < 2) {
                e.preventDefault();
                alert('Vui lòng nhập ít nhất 2 ký tự để tìm kiếm');
            }
        });
    }
    
    // Check if user dropdown exists
    const userDropdown = document.querySelector('.user-dropdown-simple');
    const userInfo = document.querySelector('.user-info');
    const dropdown = document.querySelector('.user-menu-dropdown');
    
    console.log('User dropdown elements:');
    console.log('userDropdown:', userDropdown);
    console.log('userInfo:', userInfo);
    console.log('dropdown:', dropdown);
    
    if (userInfo) {
        console.log('User is logged in, dropdown should work with CSS hover');
    } else {
        console.log('User not logged in');
    }
});
</script>
<script src="../public/JS/header.js"></script>

</html>