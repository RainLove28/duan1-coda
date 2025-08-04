<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hệ thống cửa hàng Cỏ Mềm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
    <link rel="stylesheet" href="../public/css/shop1.css" />

    <style>
    .shop-card img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
    </style>
</head>

<body>
    <div class="Container-fluid">
        <div class="shop-info" style="display: flex;
  justify-content: space-between;
  background: #f5f5f5;
  padding: 50px;
  margin: 24px 0;
  border-radius: 12px;">
            <div class="stats">
                <div><b>79</b><br>Cửa hàng trên toàn quốc</div>
                <div><b>5.000+</b><br>Khách được phục vụ mỗi ngày</div>
                <div><b>9:00 - 21:30</b><br>Kể cả chủ nhật và ngày lễ</div>
            </div>
            <div class="banner">
                <img src="../public/img/banner-store-new.png" alt="Mỹ phẩm thiên nhiên Lành & Thật">
            </div>
        </div>
        <div class="container">
            <div class="main-content">
                <aside class="sidebar">
                    <div class="store-finder">
                        <h3 class="title">TÌM CỬA HÀNG CỎ MỀM</h3>

                        <div class="select-wrapper">
                            <select class="region-select">
                                <option value="" disabled selected hidden>Tất cả vùng/miền</option>
                                <option>Tất cả vùng/miền</option>
                                <option>Miền Bắc</option>
                                <option>Miền Trung</option>
                                <option>Miền Nam</option>
                            </select>

                            <select>
                                <option value="" disabled selected hidden>Tất cả tỉnh/TP</option>
                                <option>Tất cả tỉnh/TP</option>
                                <option>Hồ Chí Minh</option>
                                <option>Hà Nội</option>
                                <option>Đà Nẵng</option>
                            </select>

                            <select>
                                <option>Tất cả Quận/Huyện</option>
                                <option>Quận 1</option>
                                <option>Quận 3</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <h3>Cỏ Mềm chào đón bạn ghé thăm:</h3>
                    <div class="shop-list">
                        <ul>
                            <li>243 Thống Nhất, Dĩ An, Bình Dương</li>
                            <li>108 Bến Hoàng Minh, Hải Nam</li>
                            <li>209 Xuyết, Phú Nhuận, Hồ Chí Minh</li>
                            <li>223 Trần Hưng Đạo, Nam Định</li>
                            <li>330 Hoàng Diệu, Đà Nẵng</li>
                            <li>22 Nguyễn Văn Tiếp, Tiền Giang</li>
                            <li>...và nhiều địa chỉ khác</li>
                        </ul>
                    </div>
                </aside>
                <section class="shop-grid">
                    <h3>Có 79 cửa hàng trên toàn quốc</h3>
                    <div class="shops">
                        <!-- Shop Card Example -->
                        <div class="shop-card">
                            <img src="../public/img/CH01_sp.webp" alt="Cửa hàng Cỏ Mềm"
                                style="width: 100%; height: auto; object-fit: cover;">
                            <div class="info">
                                <div class="phone">0977806245</div>
                                <div class="name">Cỏ Mềm Phú Yên</div>
                                <div class="address">243 Thống Nhất, Dĩ An, Bình Dương</div>
                            </div>
                        </div>
                        <div class="shop-card">
                            <img src="../public/img/CH02_sp.webp" alt="Cửa hàng Cỏ Mềm"
                                style="width: 100%; height: auto; object-fit: cover;">
                            <div class="info">
                                <div class="phone">0915052431</div>
                                <div class="name">Cỏ Mềm Long Thành, Đồng Nai</div>
                                <div class="address">243 Thống Nhất, Long Thành, Đồng Nai</div>
                            </div>
                        </div>
                        <!-- ...Thêm các shop-card khác tương tự... -->
                    </div>
                    <div class="pagination">
                        <button class="active">1</button>
                        <button>2</button>
                        <button>3</button>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
    // Xử lý cuộn trang
    let lastScrollTop = 0;
    const navbar = document.getElementById('navbar');

    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

        if (currentScroll > lastScrollTop) {
            navbar.style.top = "-200px"; // Ẩn khi cuộn xuống
        } else {
            navbar.style.top = "0"; // Hiện khi cuộn lên
        }
        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    });

    // Hiển thị pure-item khi hover vào title-san-pham (menu cha)
    document.querySelectorAll('.title-san-pham').forEach(item => { // Lặp qua từng menu cha
        const pureItem = item.querySelector('.pure-item'); // Lấy menu con tương ứng
        item.addEventListener('mouseenter', () => { // Khi hover vào menu cha
            if (pureItem) {
                pureItem.style.display = 'flex'; // Hiện menu con
                // Luôn active li đầu và hiện sản phẩm đầu tiên
                const lis = pureItem.querySelectorAll(
                    '.pure-item-left ul li'); // Lấy tất cả mục bên trái
                const rights = pureItem.querySelectorAll(
                    '.pure-item-right'); // Lấy tất cả phần sản phẩm bên phải
                lis.forEach(l => l.classList.remove('active')); // Bỏ active tất cả li
                rights.forEach(r => r.style.display = 'none'); // Ẩn tất cả sản phẩm bên phải
                const firstLi = pureItem.querySelector(
                    '.pure-item-left ul li:first-child'); // Lấy li đầu tiên
                const firstRight = pureItem.querySelector(
                    '.pure-item-right.right-1'); // Lấy sản phẩm đầu tiên
                if (firstLi) firstLi.classList.add('active'); // Active li đầu tiên
                if (firstRight) firstRight.style.display = 'grid'; // Hiện sản phẩm đầu tiên
            }
        });
        item.addEventListener('mouseleave', () => { // Khi rời chuột khỏi menu cha
            if (pureItem) pureItem.style.display = 'none'; // Ẩn menu con
        });
    });

    // Xử lý hover bên trong pure-item (menu con)
    document.querySelectorAll('.pure-item').forEach(menu => { // Lặp qua từng menu con
        const lis = menu.querySelectorAll('.pure-item-left ul li'); // Lấy tất cả mục bên trái
        const rights = menu.querySelectorAll('.pure-item-right'); // Lấy tất cả phần sản phẩm bên phải

        // Xử lý hover từng li bên trái
        lis.forEach((li, idx) => { // Lặp qua từng li bên trái
            li.addEventListener('mouseenter', function() { // Khi hover vào từng li
                rights.forEach(r => r.style.display = 'none'); // Ẩn tất cả sản phẩm bên phải
                const right = menu.querySelector('.pure-item-right.right-' + (idx +
                    1)); // Lấy sản phẩm tương ứng
                if (right) right.style.display = 'grid'; // Hiện sản phẩm tương ứng
                lis.forEach(l => l.classList.remove('active')); // Bỏ active tất cả li
                li.classList.add('active'); // Active li đang hover
            });
        });
    });
    </script>
</body>

</html>