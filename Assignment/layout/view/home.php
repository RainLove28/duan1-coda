
<main>
<div class="picture">
    <div class="slider">
      <img id="anh" alt="" src="../public/img/hinh8.jpg" / width="100%" >
      
    </div>
  </div>
<div class="container">
    <h2 style="color: red;">Dòng xe Mô tô Nổi bật & HOT</h2>
    <div class="product-box">
        <?php foreach($productHot as $product){ ?>
        <div class="product">
            <img src="../public/img/<?=$product['HinhAnh'] ?>" alt="">
            <h3><?=$product['TenSanPham'] ?></h3>
            <p>Gia goc: <?=$product['Gia'] ?> D</p>
            <p>Gia sale: <?=$product['GiaSale'] ?> D</p>
            <a href="?page=productdetail&id=<?= $product['id'] ?>">
                    <button>Xem chi tiết</button>
                </a>
        </div>
        <?php } ?>
    </div>
</div>
<section class="py-12 bg-gray-100">
   <div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-6">
     ƯU ĐÃI &amp; KHUYẾN MÃI
    </h2>
    <div class="flex justify-center">
     <div class="bg-white shadow-md p-6">
      <img alt="Kawasaki Ride Protection" class="mb-4" height="200" src="https://storage.googleapis.com/a1aa/image/ns0JYP27bRb9R53qsokGXbeL3oOXHVIr63Yhzjv20Ts.jpg" width="300"/>
      <a href="https://kawasakihanoi.vn/more/bang-gia-chuong-trinh-khuyen-mai-xe-tai-kawasaki-long-bien.html" title="KAWASAKI RIDE PROTECTION" class="trans-hover">
        <h3 class="trans-hover">
          KAWASAKI RIDE PROTECTION                                      </h3>
    </a>
      <p class="text-gray-600">
       An tâm tận hưởng niềm vui cùng Kawasaki.
      </p>
     </div>
     <div class="bg-white shadow-md p-6">
      <img alt="Kawasaki Ride Protection" class="mb-4" height="200" src="https://kawasakihanoi.vn/admin/timthumb.php?src=img/upload/e2a9f20e9be1c56b9a6407f2fa35b642.png&amp;;w=300&amp;zc=1" width="300"/>
      <a href="https://kawasakihanoi.vn/more/bang-gia-chuong-trinh-khuyen-mai-xe-tai-kawasaki-long-bien.html" title="BẢNG GIÁ &amp; CHƯƠNG TRÌNH KHUYẾN MẠI XE TẠI KAWASAKI LONG BIÊN" class="trans-hover">
        <h3 class="trans-hover">
            BẢNG GIÁ &amp; CHƯƠNG TRÌNH KHUYẾN MẠI XE TẠI KAWASAKI LONG BIÊN                                        </h3>
    </a>
      <p class="text-gray-600">
        Chương trình ưu đãi các dòng xe PKL Kawasaki tại Kawasaki Long Biên. Bài viết sẽ liên tục được cập nhật mỗi khi có chương trình mới!
      </p>
     </div>
     <div class="bg-white shadow-md p-6">
      <img alt="Kawasaki Ride Protection" class="mb-4" height="200" src="https://kawasakihanoi.vn/admin/timthumb.php?src=img/upload/ef8d74bcea66241d4a714db063c3859f.jpg&amp;;w=300&amp;zc=1" width="300"/>
      <a href="https://kawasakihanoi.vn/more/ninja-500-pre-order-kawasaki-long-bien-chinh-thuc-nhan-coc-ninja-500.html" title="NINJA 500 PRE-ORDER: KAWASAKI LONG BIÊN CHÍNH THỨC NHẬN CỌC NINJA 500 " class="trans-hover">
        <h3 class="trans-hover">
          NINJA 500 PRE-ORDER: KAWASAKI CHÍNH THỨC NHẬN CỌC NINJA 500                                         </h3>
    </a>
      <p class="text-gray-600">
        Cơ hội vàng để trở thành người sở hữu chính thức Ninja 500 đầu tiên tại Việt Nam! Kawasaki chính thức nhận đặt cọc Ninja 500!
      </p>
     </div>
     <div class="bg-white shadow-md p-6">
      <img alt="Kawasaki Ride Protection" class="mb-4" height="200" src="../public/img/hinh13.jpg" width="300"/>
      <a href="https://maxmoto.vn/blackfriday/"  class="trans-hover">
        <h3 class="trans-hover">
          🔥️ 𝐁𝐋𝐀𝐂𝐊 𝐅𝐑𝐈𝐃𝐀𝐘 – 𝐙𝟏𝟎𝟎𝟎 – 𝐁𝐋𝐀𝐂𝐊 𝐅𝐑𝐈𝐃𝐀𝐘 🔥                                      </h3>
    </a>
      <p class="text-gray-600">
        Z1000 ABS: GIÁ ƯU ĐÃI 328.000.000 Z1000 R EDITION : GIÁ ƯU ĐÃI 388.000.000
      </p>
     </div>
     
    </div>
    
   </div>
  </section>
<div class="container">
    <h2>Dòng xe Mô tô Ninja</h2>
    <div class="product-box">
        <?php foreach($proCate1 as $product){ ?>
        <div class="product">
            <img src="../public/img/<?=$product['HinhAnh'] ?>" alt="">
            <h3><?=$product['TenSanPham'] ?></h3>
            <p>Gia goc: <?=$product['Gia'] ?> D</p>
            <p>Gia sale: <?=$product['GiaSale'] ?> D</p>
            <a href="?page=productdetail&id=<?= $product['id'] ?>">
                    <button>Xem chi tiết</button>
                </a>
        </div>
        <?php } ?>
    </div>
</div>
<div class="picture">
    <div class="slider">
      <img id="anh" alt="" src="../public/img/hinh11.jpg" />
      
    </div>
  </div>
<div class="container">
    <h2>Dòng xe Mô tô Z</h2>
    <div class="product-box">
        <?php foreach($proCate2 as $product){ ?>
        <div class="product">
            <img src="../public/img/<?=$product['HinhAnh'] ?>" alt="">
            <h3><?=$product['TenSanPham'] ?></h3>
            <p>Gia goc: <?=$product['Gia'] ?> D</p>
            <p>Gia sale: <?=$product['GiaSale'] ?> D</p>
            <a href="?page=productdetail&id=<?= $product['id'] ?>">
                    <button>Xem chi tiết</button>
                </a>
        </div>
        <?php } ?>
    </div>
</div>
<div class="container">
    <h2>Dòng xe Mô tô Ninja ZX</h2>
    <div class="product-box">
        <?php foreach($proCate3 as $product){ ?>
        <div class="product">
            <img src="../public/img/<?=$product['HinhAnh'] ?>" alt="">
            <h3><?=$product['TenSanPham'] ?></h3>
            <p>Gia goc: <?=$product['Gia'] ?> D</p>
            <p>Gia sale: <?=$product['GiaSale'] ?> D</p>
            <a href="?page=productdetail&id=<?= $product['id'] ?>">
                    <button>Xem chi tiết</button>
                </a>
        </div>
        <?php } ?>
    </div>
</div>
<div class="container">
    <h2>Dòng xe Mô tô JET SKI</h2>
    <div class="product-box">
        <?php foreach($proCate4 as $product){ ?>
        <div class="product">
            <img src="../public/img/<?=$product['HinhAnh'] ?>" alt="">
            <h3><?=$product['TenSanPham'] ?></h3>
            <p>Gia goc: <?=$product['Gia'] ?> D</p>
            <p>Gia sale: <?=$product['GiaSale'] ?> D</p>
            <a href="?page=productdetail&id=<?= $product['id'] ?>">
                    <button>Xem chi tiết</button>
                </a>
        </div>
        <?php } ?>
    </div>
</div>
</main>