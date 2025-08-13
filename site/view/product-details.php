<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang chủ</title>
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
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Open+Sans:ital,wght@0,300..800;1,30...lay=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <link rel="stylesheet" href="../public/css/product-details.css" />
</head>
<style>
.main-image img {
    width: 100%;
    height: auto;
}

.main-image {
    border-radius: 0px;
}

/* Success Popup */
.success-popup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.popup-content {
    background: white;
    padding: 30px;
    border-radius: 12px;
    text-align: center;
    max-width: 400px;
    margin: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.popup-icon {
    font-size: 48px;
    color: #28a745;
    margin-bottom: 15px;
}

.popup-title {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.popup-message {
    color: #666;
    margin-bottom: 20px;
    line-height: 1.5;
}

.popup-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.popup-btn {
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.popup-btn.primary {
    background: #007bff;
    color: white;
}

.popup-btn.primary:hover {
    background: #0056b3;
}

.popup-btn.secondary {
    background: #6c757d;
    color: white;
}

.popup-btn.secondary:hover {
    background: #545b62;
}
</style>

<body>

    <div>
        <div class="breadcrumb">
            <div class="product-container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-list">
                        <li><a href="?page=home">Trang chủ</a></li>
                        <li class="active">
                            <?= $products['TenSanPham'] ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="product-detail-container">
            <div class="product-container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-images">
                            <div class="main-image">
                                <img src="<?= $products['HinhAnh'] ?>" alt="Sữa Chống Nắng So-ri Vitamin C"
                                    id="mainProductImage" />

                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="product-info">
                            <h1 class="product-title">
                                <?= $products['TenSanPham'] ?>
                            </h1>

                            <div class="product-price">
                                <span
                                    class="current-price"><?= number_format($products['DonGia'], 0, ',', '.') ?>đ</span>
                                <?php if (!is_null($products['GiaSale'])): ?>
                                <span class="old-price"><?= number_format($products['GiaSale'], 0, ',', '.') ?>đ</span>
                                <?php endif; ?>
                            </div>

                            <div class="product-quantity">
                                <label>Số lượng:</label>
                                <form method="POST" action="?page=cart" class="add-to-cart-form">
                                    <div class="quantity-controls">
                                        <button type="button" class="qty-btn minus">-</button>
                                        <input type="number" name="quantity" value="1" min="1" max="<?= $products['SoLuong'] ?>" class="qty-input" />
                                        <button type="button" class="qty-btn plus">+</button>
                                        
                                        <!-- Hidden inputs cho product info -->
                                        <input type="hidden" name="id" value="<?= $products['MaSP'] ?>">
                                        <input type="hidden" name="name" value="<?= htmlspecialchars($products['TenSanPham']) ?>">
                                        <input type="hidden" name="image" value="<?= $products['HinhAnh'] ?>">
                                        <input type="hidden" name="price" value="<?= $products['DonGia'] ?>">
                                        
                                        <button type="submit" name="addToCart" class="add-to-cart-btn" onclick="return handleAddToCart(event)">
                                            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="product-notice">
                                <p>
                                    <strong>Nếu bạn muốn mua hàng với số lượng lớn, xin vui lòng liên
                                        hệ Hotline:</strong>
                                    <span class="hotline">19006686900</span> hoặc Zalo:
                                    <span class="zalo">0969822511</span>. Aura Beauty chân thành
                                    cảm ơn bạn!
                                </p>
                            </div>

                            <div class="promotion-tag">
                                <span class="promo-icon">%</span>
                                <span class="promo-text">Mã giảm giá</span>
                                <span class="promo-note">(Không áp dụng đồng thời)</span>
                            </div>

                            <div class="shipping-info">
                                <div class="shipping-option">
                                    <h4>Phí Ship</h4>
                                    <ul>
                                        <li>Nội thành Hà Nội - 20.000đ</li>
                                        <li>Các tỉnh còn lại - 25.000đ</li>
                                    </ul>
                                </div>
                                <div class="delivery-time">
                                    <h4>Thời gian ship dự kiến</h4>
                                    <ul>
                                        <li>Hà Nội, TP.HCM: 1 - 2 ngày</li>
                                        <li>Các tỉnh còn lại: 2 - 5 ngày</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-description-section">
            <div class="product-container">
                <div class="description-tabs">
                    <ul class="tab-nav">
                        <li class="tab-item active">
                            <button class="tab-btn" data-tab="info">
                                THÔNG TIN SẢN PHẨM
                            </button>
                        </li>
                        <li class="tab-item">
                            <button class="tab-btn" data-tab="usage">
                                HƯỚNG DẪN SỬ DỤNG
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="info">
                            <div class="product-description">
                                <button class="expand-btn">Xem chi tiết</button>
                                <div class="description-text">
                                    <p>
                                        Sữa chống nắng So-ri Vitamin C Sáng Hồng SPF 50+ Natural
                                        Brightening Sunscreen là sản phẩm dạng sữa mỏng nhẹ. Giúp
                                        chống nắng, bảo vệ da, hạn chế tác hại của tia tử ngoại từ
                                        ánh nắng mặt trời và giúp ngăn ngừa các dấu hiệu của lão
                                        hóa trên da. Góp phần thấm đồng cho da, làm sáng da, giúp
                                        da sáng và khỏe mạnh.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="usage">
                            <div class="usage-steps">
                                <ol>
                                    <li>
                                        <strong>Bước 1:</strong> Lắc đều kem kem trước khi sử dụng
                                        để các thành phần được phân bố đồng đều.
                                    </li>
                                    <li>
                                        <strong>Bước 2:</strong> Lấy một lượng vừa đủ khoảng 1
                                        đồng xu, chấm đều lên 5 điểm trên khuôn mặt (trán, mũi,
                                        hai má, cằm) rồi thoa đều theo chuyển động tròn.
                                    </li>
                                    <li>
                                        <strong>Bước 3:</strong> Để kem thấm thấu hoàn toàn trước
                                        khi tiếp xúc với ánh nắng khoảng 15-20 phút.
                                    </li>
                                    <li>
                                        <strong>Bước 4:</strong> Thoa lại sau mỗi 2-3 giờ hoặc sau
                                        hoạt động ngoài trời nhiều hoặc tiếp xúc với nước để đảm
                                        bảo quá trình bảo vệ da.
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="related-products-section">
            <div class="product-container">
                <h2 class="section-title">SẢN PHẨM LIÊN QUAN</h2>
                <div class="row">
                    <div class="col-md-3">
                        <div class="product-item">
                            <div class="product-image">
                                <img src="../public/img/sp-1.webp"
                                    alt="Sữa Chống Nắng So-ri Vitamin C Sáng Hồng SPF 50+ PA++++" />
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">
                                    Sữa Chống Nắng So-ri Vitamin C Sáng Hồng SPF 50+ PA++++
                                </h3>
                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="rating-count">(0)</span>
                                </div>
                                <div class="product-price">
                                    <span class="price">395.000đ</span>
                                </div>
                                <div class="product-actions">
                                    <button class="btn-buy">Mua ngay</button>
                                    <button class="btn-detail">Xem chi tiết</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="product-item">
                            <div class="product-image">
                                <img src="../public/img/sp-1.webp"
                                    alt="Sữa Chống Nắng Rau Má Kiềm Dầu SPF 50+ PA+++H" />
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">
                                    Sữa Chống Nắng Rau Má Kiềm Dầu SPF 50+ PA+++H
                                </h3>
                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="rating-count">(0)</span>
                                </div>
                                <div class="product-price">
                                    <span class="current-price">512.000đ</span>
                                    <span class="old-price">825.000đ</span>
                                </div>
                                <div class="product-actions">
                                    <button class="btn-buy">Mua ngay</button>
                                    <button class="btn-detail">Xem chi tiết</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="product-item">
                            <div class="product-image">
                                <img src="../public/img/sp-1.webp"
                                    alt="Kem Chống Nắng Vật Lý Tone-up SPF 50+ SPF 50+" />
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">
                                    Kem Chống Nắng Vật Lý Tone-up SPF 50+ SPF 50+
                                </h3>
                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="rating-count">(0)</span>
                                </div>
                                <div class="product-price">
                                    <span class="current-price">512.000đ</span>
                                    <span class="old-price">825.000đ</span>
                                </div>
                                <div class="product-actions">
                                    <button class="btn-buy">Mua ngay</button>
                                    <button class="btn-detail">Xem chi tiết</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="product-item">
                            <div class="product-image">
                                <img src="../public/img/sp-1.webp" alt="Kem Chống Nắng Sâm 1700 SPF 50+" />
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">Kem Chống Nắng Sâm 1700 SPF 50+</h3>
                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="rating-count">(0)</span>
                                </div>
                                <div class="product-price">
                                    <span class="current-price">512.000đ</span>
                                    <span class="old-price">825.000đ</span>
                                </div>
                                <div class="product-actions">
                                    <button class="btn-buy">Mua ngay</button>
                                    <button class="btn-detail">Xem chi tiết</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="more-products-section">
            <div class="product-container">
                <h2 class="section-title">SẢN PHẨM ĐÃ XEM</h2>
                <div class="row">
                    <div class="col-md-3">
                        <div class="product-item">
                            <div class="product-image">
                                <img src="../public/img/sp-1.webp"
                                    alt="Sữa Chống Nắng So-ri Vitamin C Sáng Hồng SPF 50+ PA++++" />
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">
                                    Sữa Chống Nắng So-ri Vitamin C Sáng Hồng SPF 50+ PA++++
                                </h3>
                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="rating-count">(0)</span>
                                </div>
                                <div class="product-price">
                                    <span class="price">395.000đ</span>
                                </div>
                                <div class="product-actions">
                                    <button class="btn-buy">Mua ngay</button>
                                    <button class="btn-detail">Xem chi tiết</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Reviews -->
        <div class="reviews-section">
            <div class="product-container">
                <h2 class="section-title">ĐÁNH GIÁ TỪ KHÁCH HÀNG ĐÃ MUA</h2>
                <div class="review-summary">
                    <div class="overall-rating">
                        <span class="rating-score">0.0</span>
                        <div class="rating-stars">
                            <span class="stars">☆☆☆☆☆</span>
                        </div>
                        <p class="review-count">Theo 0 đánh giá</p>
                    </div>
                    <div class="rating-breakdown">
                        <div class="rating-bar">
                            <span class="stars">★★★★★</span>
                            <div class="bar">
                                <div class="fill" style="width: 0%"></div>
                            </div>
                            <span class="count">(0)</span>
                        </div>
                        <div class="rating-bar">
                            <span class="stars">★★★★☆</span>
                            <div class="bar">
                                <div class="fill" style="width: 0%"></div>
                            </div>
                            <span class="count">(0)</span>
                        </div>
                        <div class="rating-bar">
                            <span class="stars">★★★☆☆</span>
                            <div class="bar">
                                <div class="fill" style="width: 0%"></div>
                            </div>
                            <span class="count">(0)</span>
                        </div>
                        <div class="rating-bar">
                            <span class="stars">★★☆☆☆</span>
                            <div class="bar">
                                <div class="fill" style="width: 0%"></div>
                            </div>
                            <span class="count">(0)</span>
                        </div>
                        <div class="rating-bar">
                            <span class="stars">★☆☆☆☆</span>
                            <div class="bar">
                                <div class="fill" style="width: 0%"></div>
                            </div>
                            <span class="count">(0)</span>
                        </div>
                    </div>
                    <div class="review-action">
                        <button class="write-review-btn">VIẾT ĐÁNH GIÁ ✏️</button>
                    </div>
                </div>

                <div class="review-filters">
                    <label>Lọc đánh giá:</label>
                    <div class="filter-buttons">
                        <button class="filter-btn active">Tất cả</button>
                        <button class="filter-btn">5 ⭐</button>
                        <button class="filter-btn">4 ⭐</button>
                        <button class="filter-btn">3 ⭐</button>
                        <button class="filter-btn">2 ⭐</button>
                        <button class="filter-btn">1 ⭐</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script src="../public/JS/product-details.js"></script>
    <script src="../public/JS/header.js"></script>
    
    <script>
        // Xử lý nút tăng/giảm số lượng
        document.addEventListener('DOMContentLoaded', function() {
            const minusBtn = document.querySelector('.qty-btn.minus');
            const plusBtn = document.querySelector('.qty-btn.plus');
            const qtyInput = document.querySelector('.qty-input');
            const maxQty = parseInt(qtyInput.getAttribute('max'));
            
            minusBtn.addEventListener('click', function() {
                let currentValue = parseInt(qtyInput.value);
                if (currentValue > 1) {
                    qtyInput.value = currentValue - 1;
                }
            });
            
            plusBtn.addEventListener('click', function() {
                let currentValue = parseInt(qtyInput.value);
                if (currentValue < maxQty) {
                    qtyInput.value = currentValue + 1;
                } else {
                    alert('Không thể thêm quá số lượng tồn kho: ' + maxQty);
                }
            });
            
            // Kiểm tra input trực tiếp
            qtyInput.addEventListener('input', function() {
                let value = parseInt(this.value);
                if (value < 1) {
                    this.value = 1;
                } else if (value > maxQty) {
                    this.value = maxQty;
                    alert('Không thể thêm quá số lượng tồn kho: ' + maxQty);
                }
            });
        });
        
        // Xử lý thêm vào giỏ hàng với confirm
        function handleAddToCart(event) {
            const productName = document.querySelector('input[name="name"]').value;
            const quantity = document.querySelector('input[name="quantity"]').value;
            
            // Hiển thị loading
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
            btn.disabled = true;
            
            // Submit form sau 500ms để user thấy loading
            setTimeout(function() {
                // Submit form và redirect đến giỏ hàng
                const form = btn.closest('form');
                form.submit();
            }, 500);
            
            return false; // Ngăn submit form ngay lập tức
        }
        
        // Đóng popup
        function closePopup() {
            document.getElementById('successPopup').style.display = 'none';
        }
        
        // Tự động đóng popup sau 10 giây
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('successPopup');
            if (popup) {
                setTimeout(function() {
                    popup.style.display = 'none';
                }, 10000);
            }
        });
    </script>
</body>

</html>