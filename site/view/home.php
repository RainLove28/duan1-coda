<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
/* Alert styles */
.alert {
    padding: 15px;
    margin: 20px auto;
    border: 1px solid transparent;
    border-radius: 4px;
    max-width: 1200px;
}
.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}
.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}
.alert-dismissible {
    position: relative;
    padding-right: 35px;
}
.alert .close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 15px;
    color: inherit;
    background: none;
    border: none;
    font-size: 21px;
    font-weight: bold;
    cursor: pointer;
}

.product img {
    width: 100%;
    height: 250px;
}

.card-item-content h3 {
    min-height: 40px;
    font-size: 16px;
    font-weight: bold;
    color: #3d640f;
    margin: 10px 0;
    font-family: "Inter", serif;
    text-align: left;
    display: -webkit-box;
    /* Quan trọng */
    -webkit-box-orient: vertical;
    /* Quan trọng */
    -webkit-line-clamp: 2;
    /* Số dòng muốn hiển thị */
    overflow: hidden;
    /* Ẩn phần dư */
    text-overflow: ellipsis;
    /* Hiện ... */
    line-height: 1.4em;
    max-height: 2.8em;
    /* line-height * 2 */
}

.sale-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: #ff8c1a;
    color: #fff;
    font-size: 14px;
    font-weight: bold;
    padding: 2px 10px;
    border-radius: 4px;
}

.product {
    position: relative;
}
</style>

<body>

</body>

</html>
<div class="Container-fluid">

    <!-- Hiển thị thông báo thành công/lỗi -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible">
            <strong>Thành công!</strong> <?= $_SESSION['success'] ?>
            <button type="button" class="close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible">
            <strong>Lỗi!</strong> <?= $_SESSION['error'] ?>
            <button type="button" class="close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- slide -->
    <section>
        <div class="slideshow-container">
            <div class="mySlides">
                <img src="../public/img/banner-1.webp" alt="Slide 1" />
            </div>
            <div class="mySlides">
                <img src="../public/img/banner-2.webp" alt="Slide 2" />
            </div>
            <div class="mySlides">
                <img src="../public/img/banner-3.webp" alt="Slide 3" />
            </div>
            <div class="mySlides">
                <img src="../public/img/banner-4.webp" alt="Slide 4" />
            </div>
            <div class="mySlides">
                <img src="../public/img/banner-5.webp" alt="Slide 5" />
            </div>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
    </section>
    <!-- Start banner sub -->
    <section>
        <div class="banner-sub">
            <div class="banner-sub-item-1">
                <a href="trangchu.html">
                    <img src="../public/img/sub-1.png" alt="Banner Sub 1" />
                    <div class="banner-sub-item-1-content">
                        <span>Ship COD toàn quốc</span>
                        <span>Thanh toán khi nhận hàng. Phí 20 - 25k</span>
                    </div>
                </a>
            </div>
            <div class="banner-sub-item-1">
                <a href="trangchu.html">
                    <img src="../public/img/sub-2.png" alt="Banner Sub 1" />
                    <div class="banner-sub-item-1-content">
                        <span>Miễn phí đổi - trả</span>
                        <span>Đối với sản phẩm lỗi sản xuất hoặc vận chuyển.</span>

                    </div>
                </a>
            </div>
            <div class="banner-sub-item-1">
                <a href="trangchu.html">
                    <img src="../public/img/sub-3.png" alt="Banner Sub 1" />
                    <div class="banner-sub-item-1-content">
                        <span>Ưu đãi thành viên</span>
                        <span>Đăng ký thành viên nhận nhiều ưu đãi lớn.</span>

                    </div>
                </a>
            </div>
            <div class="banner-sub-item-1">
                <a href="trangchu.html">
                    <img src="../public/img/sub-4.png" alt="Banner Sub 1" />
                    <div class="banner-sub-item-1-content">
                        <span>Ưu đãi combo</span>
                        <span>Mua theo combo càng mua càng rẻ.</span>

                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- CARD mới nhất-->
    <section class="card-section">
        <div class="card-headerr ">
            <img src="../public/img/icon-san-pham-moi-ra-mat.png" alt="">
            <h2 class="card-title">Sản phẩm mới ra mắt</h2>
        </div>
        <div class="slider-container">
            <div div class="slide slide-track">
                <!-- 8 sản phẩm -->
                <?php foreach (array_slice($newProducts, 0, 8) as $product): ?>
                <div class="product">
                    <div class="sale-badge">New</div>
                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                    </a>
                    <div class="card-item-content">
                        <h3><?= $product['TenSanPham'] ?></h3>
                        <div class="price-product">
                            <?php if (!is_null($product['DonGia'])): ?>
                            <span class="Newprice"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>

                            <?php if (!is_null($product['GiaSale'])): ?>
                            <span class="Oldprice"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
            <button class="prev-1" onclick="prevSlide(this)">❮</button>
            <button class="next-1" onclick="nextSlide(this)">❯</button>
        </div>
    </section>
    <!-- BANNER SECONDARY -->
    <section>
        <div class="banner-secondary">
            <div class="banner-secondary-item">
                <img src="../public/img/banner-6.webp" alt="">
                <img src="../public/img/banner-7.webp" alt="">
            </div>
    </section>
    <!-- CARD bán chạy -->
    <section class="card-section">
        <div class="card-headerr ">
            <img src="../public/img/ban-chay.jpg" alt="">
            <h2 class="card-title">Sản phẩm bán chạy nhất</h2>
        </div>
        <div class="slider-container">
            <div div class="slide slide-track">
                <!-- 8 sản phẩm -->
                <?php foreach (array_slice($hotProducts, 0, 8) as $product): ?>
                <div class="product">
                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                             ?>
                    <div class="sale-badge">-<?= $discount ?>%</div>
                    <?php endif; ?>

                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                    </a>
                    <div class="card-item-content">
                        <h3><?= $product['TenSanPham'] ?></h3>
                        <div class="price-product">
                            <?php if (!is_null($product['DonGia'])): ?>
                            <span class="Newprice"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>

                            <?php if (!is_null($product['GiaSale'])): ?>
                            <span class="Oldprice"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
            <button class="prev-1" onclick="prevSlide(this)">❮</button>
            <button class="next-1" onclick="nextSlide(this)">❯</button>
        </div>
    </section>
    <!-- CARD chăm sóc da -->
    <section class="card-section">
        <div class="card-headerr ">
            <img src="../public/img/da.png" alt="">
            <h2 class="card-title">Chăm sóc da</h2>
        </div>
        <div class="banner-cham-soc-da">
            <img src="../public/img/home-banner-cham-soc-da-pc_27.webp" alt="">
        </div>
        <div class="slider-container">
            <div div class="slide slide-track">
                <!-- 8 sản phẩm -->
                <?php foreach (array_slice($daProducts, 0, 8) as $product): ?>
                <div class="product">
                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                             ?>
                    <div class="sale-badge">-<?= $discount ?>%</div>
                    <?php endif; ?>

                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                    </a>
                    <div class="card-item-content">
                        <h3><?= $product['TenSanPham'] ?></h3>
                        <div class="price-product">
                            <?php if (!is_null($product['DonGia'])): ?>
                            <span class="Newprice"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>

                            <?php if (!is_null($product['GiaSale'])): ?>
                            <span class="Oldprice"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>


            </div>
            <button class="prev-1" onclick="prevSlide(this)">❮</button>
            <button class="next-1" onclick="nextSlide(this)">❯</button>
        </div>
    </section>
    <!-- CARD khuyến mãi và combo -->
    <section class="card-section">
        <div class="card-headerr ">
            <img src="../public/img/khuyen-mai.png" alt="">
            <h2 class="card-title">Khuyễn mãi và combo</h2>
        </div>
        <div class="slider-container">
            <div div class="slide slide-track">
                <!-- 8 sản phẩm -->
                <?php foreach (array_slice($saleProducts, 0, 8) as $product): ?>
                <div class="product">
                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                             ?>
                    <div class="sale-badge">-<?= $discount ?>%</div>
                    <?php endif; ?>

                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                    </a>
                    <div class="card-item-content">
                        <h3><?= $product['TenSanPham'] ?></h3>
                        <div class="price-product">
                            <?php if (!is_null($product['DonGia'])): ?>
                            <span class="Newprice"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>

                            <?php if (!is_null($product['GiaSale'])): ?>
                            <span class="Oldprice"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>


            </div>
            <button class="prev-1" onclick="prevSlide(this)">❮</button>
            <button class="next-1" onclick="nextSlide(this)">❯</button>
        </div>
    </section>
    <!-- CARD Qùa tặng -->
    <section class="card-section">
        <div class="card-headerr ">
            <img src="../public/img/qua-tang.webp" alt="">
            <h2 class="card-title">Quà tặng</h2>
        </div>
        <div class="slider-container">
            <div div class="slide slide-track">
                <!-- 8 sản phẩm -->
                <?php foreach (array_slice($QuaTangProducts, 0, 8) as $product): ?>
                <div class="product">
                    <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                             ?>
                    <div class="sale-badge">-<?= $discount ?>%</div>
                    <?php endif; ?>

                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                    </a>
                    <div class="card-item-content">
                        <h3><?= $product['TenSanPham'] ?></h3>
                        <div class="price-product">
                            <?php if (!is_null($product['DonGia'])): ?>
                            <span class="Newprice"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>

                            <?php if (!is_null($product['GiaSale'])): ?>
                            <span class="Oldprice"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>



            </div>
            <button class="prev-1" onclick="prevSlide(this)">❮</button>
            <button class="next-1" onclick="nextSlide(this)">❯</button>
        </div>
    </section>
    <!-- CARD chăm son môi -->
    <section class="card-section">
        <div class="card-headerr ">
            <img src="../public/img/son-moi.jpg" alt="">
            <h2 class="card-title">Son môi</h2>
        </div>
        <div class="banner-son-moi">
            <img src="../public/img/banner-son-moi.webp" alt="">
        </div>
        <div class="slider-container">
            <div div class="slide slide-track">
                <!-- 8 sản phẩm -->
                <?php foreach (array_slice($SonMoiProducts, 0, 8) as $product): ?>
                <div class="product">
                    <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                        <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>" />
                    </a>
                    <div class="card-item-content">
                        <h3><?= $product['TenSanPham'] ?></h3>
                        <div class="price-product">
                            <?php if (!is_null($product['DonGia'])): ?>
                            <span class="Newprice"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>

                            <?php if (!is_null($product['GiaSale'])): ?>
                            <span class="Oldprice"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
            <button class="prev-1" onclick="prevSlide(this)">❮</button>
            <button class="next-1" onclick="nextSlide(this)">❯</button>
        </div>
    </section>
    <!-- Chuyện của cỏ -->
    <section>
        <div class="home-abouts">
            <div class="home-abouts-item-1">
                <img src="../public/img/banner-about.webp" alt="Chuyện của cỏ" />
            </div>
            <div class="home-abouts-item-2">
                <h2>Chuyện của cỏ</h2>
                <div class="home-abouts-item-content">
                    <h3>Tôi bắt đầu Ước mơ Xanh của mình, nghiên cứu những sản phẩm thuần tuý, tối giản, chỉ tập
                        trung vào mục
                        đính sử dụng của chính nó.</h3>
                    <p>Nghĩa là nước giặt thì chỉ cần giặt sạch, chứ không cần phải nhiều bọt. Nghĩa là dưỡng da
                        dưỡng tóc thì
                        để da tóc khoẻ từ gốc chứ không cần cảm giác giả mướt tay từ silicon. Tôi từ chối mọi sản
                        phẩm chứa hạt vi
                        nhựa, chỉ dùng cafe xay mịn và muối biển để tẩy tế bào chết. Tôi không dùng những hoá chất
                        tẩy rửa mà thay
                        bằng xà bông dầu dừa và quả bồ hòn xưa cũ...</p>
                    <a href="trangchu.html">XEM THÊM</a>
                </div>
                <div class="home-abouts-item-3">
                    <div class="home-abouts-item-3-1">
                        <img src="../public/img/nhamay2.webp" alt="Chuyện của cỏ" />
                        <h3>Nhà máy sản xuất Cỏ Mềm sản xuất mỹ phẩm theo tiêu chuẩn cGMP</h3>
                    </div>
                    <div class="home-abouts-item-3-1">
                        <img src="../public/img/thuong_hieu.webp" alt="Chuyện của cỏ" />
                        <h3>Giải Thưởng “THƯƠNG HIỆU TRUYỀN CẢM HỨNG” CHÂU Á APEA 2021 Gọi Tên Cỏ Mềm</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner-->
    <section>
        <div class="home-resources">
            <div class="home-resources-item-1">
                <h3>100% Minh bạch nguyên liệu</h3>
                <p>Sản phẩm an LÀNH - Con người chân THẬT</p>
                <a href="trangchu.html">XEM THÊM</a>
            </div>
            <div class="home-resources-item-2">
                <div class="home-product">
                    <img src="../public/img/banner-home-1.webp" alt="">
                    <div class="resources-title">
                        <h3>LÁ BẠC HÀ</h3>
                        <p>Lá Bạc hà được sử dụng trong các sản phẩm mỹ phẩm như: cao dược liệu để gội đầu, lá tắm
                            cho trẻ em,
                            nước
                            súc miệng...
                        </p>
                    </div>
                </div>
                <div class="home-product">
                    <div class="resources-title-1">
                        <h3>TINH DẦU CAM NGỌT</h3>
                        <p>Tinh dầu Cam ngọt được sử dụng trong mỹ phẩm như một thành phần làm thơm, giải tỏa căng
                            thẳng: sáp
                            thơm,
                            tinh dầu treo,
                            kem dưỡng...
                        </p>
                    </div>
                    <img src="../public/img/cam_m_m.webp" alt="">
                </div>
                <div class="home-product">
                    <img src="../public/img/dau-qua-bo_m.webp" alt="">
                    <div class="resources-title-2">
                        <h3>DẦU QUẢ BƠ</h3>
                        <p>Được chiết từ thịt quả bơ chín ngay sau khi thu hoạch bằng phương pháp ép lạnh, phương
                            pháp này giữ
                            được
                            nguyên dinh
                            dưỡng tốt trong dầu.
                        </p>
                    </div>
                </div>
                <div class="home-product">
                    <div class="resources-title-3">
                        <h3>DẦU DỨA</h3>
                        <p>Dầu dừa được chiết xuất từ phần cùi trắng của quả dừa, có thể được tìm thấy trong nhiều
                            loại mỹ phẩm và
                            sản phẩm chăm
                            sóc cá nhân.
                        </p>
                    </div>
                    <img src="../public/img/dau-dua_89_m.webp" alt="">
                </div>
            </div>
        </div>
    </section>

</div>

<script src="../public/JS/header.js"></script>
<script src="../public/JS/slider.js"></script>