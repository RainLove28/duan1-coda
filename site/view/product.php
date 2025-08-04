<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <link rel="stylesheet" href="../public/css/sale.css" />
    <style>
    .sale-product-title {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 8px;
        color: #222;
        min-height: 40px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.4em;
        max-height: 2.8em;
    }

    .sale-main {
        display: flex;
        align-items: flex-start;
        /* Giúp sidebar cao theo nội dung riêng */
    }

    .li-title:last-child {
        margin-bottom: 0;
        border-bottom: none;
    }
    </style>
</head>

<body>
    <div class="Container-fluid">
        <div class="sale-container">
            <nav class="sale-breadcrumb">
                <a href=""><i class="fas fa-house-user"></i></i> Trang Chủ</a>
                <span>/</span>
                <a href="">Sản phẩm</a>
            </nav>
            <div class="sale-main">
                <!-- Sidebar -->
                <aside class="sale-sidebar">
                    <h3 class="sidebar-title">DANH MỤC SẢN PHẨM</h3>
                    <ul class="sidebar-menu">
                        <li class=" li-title">
                            <div class="sidebar-title-sale">
                                <a href="?page=product&category=Sale">Sale</a>
                                <a href="" class="toggle-menu"><img src="../public/img/Vector.png" alt=""></a>
                            </div>
                            <ul class="hidden">
                                <li><a href="?page=product&category=Combo chăm sóc da">- Combo chăm sóc da</a></li>
                                <li><a href="?page=product&category=Combo chăm sóc tóc">- Combo chăm sóc tóc</a></li>
                                <li><a href="?page=product&category=Combo chăm sóc môi">- Combo chăm sóc môi</a></li>
                                <li><a href="?page=product&category=Combo khác">- Combo khác</a></li>
                            </ul>
                        </li>
                        <!-- Trang điểm -->
                        <li class=" li-title">
                            <div class="sidebar-title-sale">
                                <a href="?page=product&category=Trang điểm">Trang điểm</a>
                                <a href="" class="toggle-menu"><img src="../public/img/Vector.png" alt=""></a>
                            </div>
                            <ul class="hidden">
                                <li><a href="?page=product&category=Son dưỡng môi">- Son dưỡng môi</a></li>
                                <li><a href="?page=product&category=Son màu">- Son màu</a></li>
                                <li><a href="?page=product&category=Tẩy da chết môi">- Tẩy da chết môi</a></li>
                                <li><a href="?page=product&category=Kem nền">- Kem nền</a></li>
                                <li><a href="?page=product&category=Kem má">- Kem má</a></li>
                            </ul>
                        </li>
                        <!-- Da -->
                        <li class=" li-title">
                            <div class="sidebar-title-sale">
                                <a href="?page=product&category=Da">Da</a>
                                <a href="" class="toggle-menu"> <img src="../public/img/Vector.png" alt=""></a>
                            </div>
                            <ul class="hidden">
                                <li><a href="?page=product&category=Tẩy trang - rửa mặt">- Tẩy trang - rửa mặt</a></li>
                                <li><a href="?page=product&category=Toner - xịt khoáng">- Toner - xịt khoáng</a></li>
                                <li><a href="?page=product&category=Dưỡng da">- Dưỡng da</a></li>
                                <li><a href="?page=product&category=Kem chống nắng">- Kem chống nắng</a></li>
                            </ul>
                        </li>
                        <!-- Tóc -->
                        <li class=" li-title">
                            <div class="sidebar-title-sale">
                                <a href="?page=product&category=Tóc">Tóc</a>
                                <a href="" class="toggle-menu"><img src="../public/img/Vector.png" alt=""></a>
                            </div>
                            <ul class="hidden">
                                <li><a href="?page=product&category=Sản phẩm gội đầu">- Sản phẩm gội đầu</a></li>
                                <li><a href="?page=product&category=Sản phẩm dưỡng tóc">- Sản phẩm dưỡng tóc</a></li>
                            </ul>
                        </li>
                        <!-- Làm đẹp đường uống -->
                        <li class=" li-title">
                            <div class="sidebar-title-sale">
                                <a href="?page=product&category=Làm đẹp đường uống">Làm đẹp đường uống</a>
                                <a href="" class="toggle-menu"><img src="../public/img/Vector.png" alt=""></a>
                            </div>
                            <ul class="hidden">
                                <li><a href="?page=product&category=Làm đẹp đường uống">- Làm đẹp đường uống</a></li>
                            </ul>
                        </li>
                        <!-- Cơ thể -->
                        <li class=" li-title">
                            <div class="sidebar-title-sale">
                                <a href="?page=product&category=Cơ thể">Cơ thể</a>
                                <a href="" class="toggle-menu"><img src="../public/img/Vector.png" alt=""></a>
                            </div>
                            <ul class="hidden">
                                <li><a href="?page=product&category=Xà bông thiên nhiên">- Xà bông thiên nhiên</a></li>
                                <li><a href="?page=product&category=Sữa tắm thiên nhiên">- Sữa tắm thiên nhiên</a></li>
                                <li><a href="?page=product&category=Tẩy da chết body">- Tẩy da chết body</a></li>
                                <li><a href="?page=product&category=Dưỡng thể">- Dưỡng thể</a></li>
                                <li><a href="?page=product&category=Chăm sóc răng miệng">- Chăm sóc răng miệng</a></li>
                            </ul>
                        </li>
                        <!-- Em bé -->
                        <li class=" li-title">
                            <div class="sidebar-title-sale">
                                <a href="?page=product&category=Em bé">Em bé</a>
                                <a href="" class="toggle-menu"><img src="../public/img/Vector.png" alt=""></a>
                            </div>
                            <ul class="hidden">
                                <li><a href="?page=product&category=Tắm bé">- Tắm bé</a></li>
                                <li><a href="?page=product&category=Chăm sóc bé">- Chăm sóc bé</a></li>
                            </ul>
                        </li>
                        <!-- Hương thơm -->
                        <li class=" li-title">
                            <div class="sidebar-title-sale">
                                <a href="?page=product&category=Hương thơm">Hương thơm</a>
                                <a href="" class="toggle-menu"><img src="../public/img/Vector.png" alt=""></a>
                            </div>
                            <ul class="hidden">
                                <li><a href="?page=product&category=Tinh dầu nhỏ giọt nguyên chất">- Tinh dầu nhỏ giọt
                                        nguyên chất</a></li>
                                <li><a href="?page=product&category=Tinh dầu trị liệu">- Tinh dầu trị liệu</a></li>
                                <li><a href="?page=product&category=Tinh dầu treo thông minh">- Tinh dầu treo thông
                                        minh</a></li>
                                <li><a href="?page=product&category=Nước hoa khô">- Nước hoa khô</a></li>
                                <li><a href="?page=product&category=Nước hoa dạng xịt">- Nước hoa dạng xịt</a></li>
                            </ul>
                        </li>
                        <!-- Qùa tặng -->
                        <li class=" li-title">
                            <div class="sidebar-title-sale">
                                <a href="?page=product&category=Quà tặng">Quà tặng</a>
                                <a href="" class="toggle-menu"><img src="../public/img/Vector.png" alt=""></a>
                            </div>
                            <ul class="hidden">
                                <li><a href="?page=product&category=Dưới 300k">- Dưới 300k</a></li>
                                <li><a href="?page=product&category=Dưới 500k">- Dưới 500k</a></li>
                                <li><a href="?page=product&category=Dưới 800k">- Dưới 800k</a></li>
                            </ul>
                        </li>
                        <!-- Bộ sản phẩm -->
                        <li class=" li-title">
                            <div class="sidebar-title-sale">
                                <a href="?page=product&category=Bộ sản phẩm">Bộ sản phẩm</a>
                                <a href="" class="toggle-menu"><img src="../public/img/Vector.png" alt=""></a>
                            </div>
                            <ul class="hidden">
                                <li><a href="?page=product&category=Bộ chăm sóc da ngừa lão hóa">- Bộ chăm sóc da ngừa
                                        lão hóa</a></li>
                                <li><a href="?page=product&category=Bộ chăm sóc da rau má">- Bộ chăm sóc da Rau má</a>
                                </li>
                                <li><a href="?page=product&category=Bộ chăm sóc da Tơ tằm">- Bộ chăm sóc da Tơ tằm</a>
                                </li>
                                <li><a href="?page=product&category=Bộ chăm sóc da Sơ-Ri">- Bộ chăm sóc da Sơ-Ri</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Khác -->
                        <li class=" li-title">
                            <div class="sidebar-title-sale">
                                <a href="?page=product&category=Khác">Khác</a>
                                <a href="" class="toggle-menu"><img src="../public/img/Vector.png" alt=""></a>
                            </div>
                            <ul class="hidden">
                                <li><a href="?page=product&category=Chăm sóc nhà cửa">- Chăm sóc nhà cửa</a></li>
                                <li><a href="?page=product&category=Túi vải bảo vệ mối trường">- Túi vải bảo vệ môi
                                        trường</a></li>
                            </ul>
                        </li>
                    </ul>
                </aside>
                <!-- Main content -->
                <section class="sale-content">
                    <div class="sale-title">
                        <img src="../public/img/son-duong-moi.webp" alt="" style="height: 32px;vertical-align: middle;">
                        <span><?= htmlspecialchars($categoryName) ?></span>
                    </div>
                    <div class="sale-products">
                        <!-- Một sản phẩm -->
                        <?php foreach($products as $product): ?>
                        <div class="sale-product">
                            <?php if (!empty($product['GiaSale']) && !empty($product['DonGia'])): 
                                 $discount = round((($product['GiaSale'] - $product['DonGia']) / $product['GiaSale']) * 100);
                             ?>
                            <div class="sale-badge">-<?= $discount ?>%</div>
                            <?php endif; ?>

                            <a href="index.php?page=product-details&id=<?= $product['MaSP'] ?>">
                                <img src="<?= $product['HinhAnh'] ?>" alt="<?= $product['TenSanPham'] ?>">
                            </a>

                            <div class="sale-product-title"><?= $product['TenSanPham'] ?></div>

                            <div class="sale-product-price">
                                <?php if (!is_null($product['DonGia'])): ?>
                                <span class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?>đ</span>
                                <?php endif; ?>

                                <?php if (!is_null($product['GiaSale'])): ?>
                                <span class="old-price"><?= number_format($product['GiaSale'], 0, ',', '.') ?>đ</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>


                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
<script src="../public/JS/header.js"></script>
<script>
// Khi toàn bộ nội dung trang đã được load xong
document.addEventListener("DOMContentLoaded", function() {
    // Lấy tham số trên URL, ví dụ: ?page=product&category=Sale
    const urlParams = new URLSearchParams(window.location.search);
    const currentCategory = urlParams.get("category"); // Lấy giá trị của category

    // Lấy tất cả các mục cha trong menu sidebar (các thẻ <li> trực tiếp thuộc .sidebar-menu)
    const menuItems = document.querySelectorAll(".sidebar-menu > li");

    // Duyệt qua từng mục cha
    menuItems.forEach(function(li) {
        const titleLink = li.querySelector(
            ".sidebar-title-sale > a:first-child"); // link tiêu đề chính (danh mục cha)
        const submenu = li.querySelector("ul"); // danh sách con
        const img = li.querySelector(
            ".toggle-menu img"); // hình icon toggle (Vector.png hoặc Vector1.png)

        // Lấy tất cả các link trong danh mục con (nếu có)
        const childLinks = submenu ? submenu.querySelectorAll("a") : [];

        // === TRƯỜNG HỢP: Nếu category hiện tại là danh mục cha ===
        if (
            currentCategory &&
            titleLink &&
            currentCategory.toLowerCase().trim() === titleLink.textContent.toLowerCase().trim()
        ) {
            // Hiển thị submenu của danh mục cha
            submenu.classList.remove("hidden");
            // Đổi icon mũi tên xuống
            img.src = "../public/img/Vector1.png";
        }

        // === TRƯỜNG HỢP: Nếu category hiện tại là danh mục con ===
        childLinks.forEach(function(childLink) {
            // Lấy text nội dung và loại bỏ dấu gạch đầu dòng nếu có ("- Combo chăm sóc da" → "Combo chăm sóc da")
            const text = childLink.textContent.replace(/^- /, "").trim();

            // So sánh với currentCategory để kiểm tra khớp
            if (
                currentCategory &&
                currentCategory.toLowerCase().trim() === text.toLowerCase().trim()
            ) {
                // Hiển thị submenu của danh mục cha tương ứng
                submenu.classList.remove("hidden");
                // Đổi icon mũi tên xuống
                img.src = "../public/img/Vector1.png";
            }
        });
    });

    // === BẮT SỰ KIỆN CLICK VÀO ICON MỞ/ĐÓNG MENU ===
    document.querySelectorAll(".sidebar-title-sale .toggle-menu").forEach(function(btn) {
        btn.addEventListener("click", function(e) {
            e.preventDefault(); // Ngăn sự kiện mặc định của <a>

            const ul = btn.parentElement.nextElementSibling; // tìm thẻ <ul> kế tiếp
            const img = btn.querySelector("img"); // icon toggle

            if (ul) {
                // Toggle ẩn/hiện danh sách con
                ul.classList.toggle("hidden");

                // Thay đổi icon dựa vào trạng thái ẩn/hiện
                img.src = ul.classList.contains("hidden") ?
                    "../public/img/Vector.png" // Mũi tên phải (đã ẩn)
                    :
                    "../public/img/Vector1.png"; // Mũi tên xuống (đang mở)
            }
        });
    });
});
</script>


</html>