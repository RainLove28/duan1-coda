<?php
// Thông báo thành công/lỗi
if (isset($_SESSION['cart_message'])) {
    $message = $_SESSION['cart_message'];
    echo '<div class="alert alert-' . $message['type'] . '">';
    echo '<i class="fas fa-check-circle"></i> ' . $message['message'];
    echo '</div>';
    unset($_SESSION['cart_message']);
}
?>

<style>
    body {
        background: #f7f7f7;
    }
    
    /* Thông báo */
    .alert {
        max-width: 1200px;
        margin: 20px auto;
        padding: 15px 20px;
        border-radius: 8px;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .alert.success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert .close-btn {
        margin-left: auto;
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        color: inherit;
    }

    /* .cart-main { display: flex; gap: 32px; max-width: 1200px; margin: 32px auto; } */
    .cart-left {
        flex: 2;
    }

    .cart-right {
        flex: 1;
    }

    .cart-table {
        background: #fff;
        border-radius: 12px;
        padding: 0 0 24px 0;
    }

    .cart-header {
        padding: 18px 32px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
    }

    .cart-header label {
        margin-left: 8px;
        font-size: 17px;
        font-weight: 500;
    }

    .cart-row {
        display: flex;
        align-items: center;
        padding: 24px 32px;
        border-bottom: 1px solid #eee;
    }

    .cart-row:last-child {
        border-bottom: none;
    }

    .cart-checkbox {
        margin-right: 12px;
        width: 18px;
        height: 18px;
        accent-color: #388e1c;
    }

    .cart-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 18px;
        background: #fff;
    }

    .cart-info {
        flex: 1;
    }

    .cart-name {
        font-size: 18px;
        color: #333;
        font-weight: 500;
        line-height: 1.4;
    }

    .cart-price {
        width: 120px;
        text-align: right;
        font-size: 18px;
        color: #333;
    }

    .cart-qty {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-left: 24px;
    }

    .qty-btn {
        width: 32px;
        height: 32px;
        border: 1px solid #ccc;
        background: #fff;
        border-radius: 6px;
        font-size: 20px;
        cursor: pointer;
    }

    .qty-input {
        width: 40px;
        text-align: center;
        border: none;
        background: #f7f7f7;
        font-size: 18px;
    }

    .cart-total {
        width: 120px;
        text-align: right;
        font-weight: bold;
        color: #388e1c;
        margin-left: 24px;
        font-size: 18px;
    }

    .cart-remove {
        margin-left: 18px;
        color: #fff;
        background: #388e1c;
        border: none;
        border-radius: 6px;
        padding: 8px 24px;
        font-size: 17px;
        cursor: pointer;
        font-weight: 500;
    }

    .cart-summary {
        background: #fff;
        border-radius: 12px;
        padding: 32px 32px 24px 32px;
        min-width: 340px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .summary-row.voucher-row {
        gap: 18px;
        margin-bottom: 28px;
    }

    .voucher-label {
        font-size: 18px;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .voucher-select {
        width: 200px;
        font-size: 18px;
        height: 44px;
        padding: 8px 12px;
    }

    .summary-label {
        color: #888;
        font-size: 18px;
    }

    .summary-value {
        font-weight: bold;
        color: #333;
        font-size: 18px;
    }

    .summary-total {
        color: #d35400;
        font-size: 22px;
        font-weight: bold;
    }

    .btn-buy {
        background: #388e1c;
        color: #fff;
        font-size: 22px;
        font-weight: bold;
        border-radius: 8px;
        padding: 14px 0;
        width: 100%;
        border: none;
        margin-top: 24px;
    }

    .btn-buy:hover {
        background: #2e6d17;
    }
    </style>
</head>

<body>
    <!-- Thông báo thành công -->
    <?php if (isset($_SESSION['cart_message'])): ?>
        <div class="alert <?= $_SESSION['cart_message']['type'] ?>">
            <i class="fas fa-check-circle"></i>
            <?= $_SESSION['cart_message']['message'] ?>
            <button class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
        <?php unset($_SESSION['cart_message']); ?>
    <?php endif; ?>
    
    <div class="cart-main">
        <div class="cart-left">
            <div class="cart-table">
                <div class="cart-header">
                    <input type="checkbox" id="select-all" checked>
                    <label for="select-all">Chọn tất cả (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)</label>
                </div>
                
                <?php 
                $totalPrice = 0;
                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): 
                ?>
                    <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                        <div class="cart-row">
                            <input type="checkbox" class="cart-checkbox" checked>
                            <img src="<?= $item['image'] ?>" class="cart-img" alt="<?= htmlspecialchars($item['name']) ?>">
                            <div class="cart-info">
                                <div class="cart-name"><?= htmlspecialchars($item['name']) ?></div>
                                <div style="color:#888;font-size:15px;">Mã SP: <?= $id ?></div>
                            </div>
                            <div class="cart-price"><?= number_format($item['price'], 0, ',', '.') ?> đ</div>
                            <div class="cart-qty">
                                <button class="qty-btn" onclick="changeQuantity(<?= $id ?>, -1)">-</button>
                                <input type="text" id="qty-<?= $id ?>" class="qty-input" value="<?= $item['quantity'] ?>" readonly>
                                <button class="qty-btn" onclick="changeQuantity(<?= $id ?>, 1)">+</button>
                            </div>
                            <div class="cart-total"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ</div>
                            <a href="?page=removeItemCart&id=<?= $id ?>">
                                <button class="cart-remove">Xóa</button>
                            </a>
                        </div>
                        <?php $totalPrice += $item['price'] * $item['quantity']; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="cart-row">
                        <div style="text-align: center; padding: 40px; color: #888;">
                            Giỏ hàng trống. <a href="?page=home">Tiếp tục mua sắm</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="cart-right">
            <div class="cart-summary">
                <div class="summary-row voucher-row">
                    <span class="voucher-label">🎁 Mã Voucher</span>
                    <select class="form-select voucher-select">
                        <option>--Chọn--</option>
                        <option>Giảm 10.000đ</option>
                        <option>Giảm 20.000đ</option>
                    </select>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Tổng tiền hàng</span>
                    <span class="summary-value"><?= number_format($totalPrice, 0, ',', '.') ?> đ</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Phí vận chuyển</span>
                    <span class="summary-value">0 đ</span>
                </div>
                <div class="summary-row" style="border-top:1px solid #eee;padding-top:18px;">
                    <span class="summary-label">Cần thanh toán</span>
                    <span class="summary-total"><?= number_format($totalPrice, 0, ',', '.') ?> đ</span>
                </div>
                <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                    <a href="?page=thanhtoan">
                        <button class="btn-buy">Thanh toán</button>
                    </a>
                <?php else: ?>
                    <a href="?page=product">
                        <button class="btn-buy" style="background: #888;">Tiếp tục mua sắm</button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function changeQuantity(productId, change) {
            // Tìm input quantity của sản phẩm cụ thể
            const quantityInput = document.querySelector(`#qty-${productId}`);
            if (quantityInput) {
                const currentQuantity = parseInt(quantityInput.value) || 0;
                const newQuantity = currentQuantity + change;
                
                if (newQuantity > 0) {
                    window.location.href = `?page=updateCartQuantity&id=${productId}&quantity=${newQuantity}`;
                } else {
                    // Nếu quantity = 0, xóa sản phẩm
                    if (confirm('Bạn có muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                        window.location.href = `?page=removeItemCart&id=${productId}`;
                    }
                }
            }
        }
    </script>