<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh toán</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f7f7f7; }
    .checkout-main {
      background: #fff;
      border-radius: 16px;
      padding: 32px 24px;
      display: flex;
      gap: 0;
      border: 2px solid #b39ddb;
      max-width: 1200px;
      margin: 32px auto;
      min-height: 500px;
    }
    .checkout-left {
      flex: 1.2;
      padding-right: 24px;
      border-right: 1px solid #e0e0e0;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }
    .checkout-center {
      flex: 1;
      padding: 0 32px;
      border-right: 1px solid #e0e0e0;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }
    .checkout-right {
      flex: 1.1;
      padding-left: 32px;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }
    .checkout-title { font-weight: bold; font-size: 18px; margin-bottom: 12px; }
    .form-label { font-weight: 500; margin-bottom: 4px; }
    .form-control, textarea.form-control { border-radius: 6px; }
    .pay-method { margin-bottom: 12px; display: flex; align-items: center; }
    .pay-method label { margin-left: 8px; font-size: 16px; }
    .pay-method img { margin-right: 6px; }
    .summary-label { color: #888; }
    .summary-value { font-weight: bold; color: #333; }
    .summary-total { color: #d35400; font-size: 22px; font-weight: bold; }
    .btn-order { background: #388e1c; color: #fff; font-size: 18px; font-weight: bold; border-radius: 6px; padding: 10px 0; width: 100%; border: none; }
    .btn-order:hover { background: #2e6d17; }
    .back-link { color: #388e1c; text-decoration: none; font-size: 16px; margin-bottom: 18px; display: inline-block; background: #eaf7d4; border-radius: 4px; padding: 2px 8px;}
    .voucher-value { color: #d35400; font-weight: bold; }
    .cart-box { background: #f3f3f3; border-radius: 16px; padding: 18px; }
    .cart-title { font-weight: bold; font-size: 18px; margin-bottom: 12px; }
    .cart-row {
      display: flex;
      align-items: center;
      background: #fff;
      border-radius: 10px;
      padding: 12px 16px;
      margin-bottom: 12px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .cart-img { width: 70px; height: 70px; object-fit: cover; border-radius: 8px; margin-right: 18px; background: #fff; }
    .cart-info { flex: 1; }
    .cart-name { font-size: 16px; color: #333; font-weight: 500; }
    .cart-qty { display: flex; align-items: center; gap: 8px; margin: 8px 0; }
    .qty-btn { width: 28px; height: 28px; border: 1px solid #ccc; background: #fff; border-radius: 4px; font-size: 18px; cursor: pointer; }
    .qty-input { width: 36px; text-align: center; border: none; background: #f7f7f7; font-size: 16px; }
    .cart-price { width: 100px; text-align: right; font-size: 16px; color: #388e1c; font-weight: 500; }
    .cart-remove { color: #d35400; background: none; border: none; font-size: 16px; cursor: pointer; margin-left: 8px; }
    @media (max-width: 900px) {
      .checkout-main { flex-direction: column; padding: 12px; }
      .checkout-left, .checkout-center, .checkout-right { border: none; padding: 0; }
      .checkout-center, .checkout-right { margin-top: 24px; }
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <a href="?page=giohang" class="back-link"><img src="../public/group90.png" style="height:18px;vertical-align:middle;margin-right:4px;">Quay lại</a>
  <div class="checkout-main">
    <!-- Form thanh toán -->
    <form method="post" action="?page=createOrder">
      <input type="hidden" name="total_price" value="<?= $totalPrice ?>">
      
      <!-- Thông tin nhận hàng -->
      <div class="checkout-left">
        <div class="checkout-title">Thông tin nhận hàng</div>
        
        <label class="form-label">Họ và Tên</label>
        <input type="text" class="form-control mb-2" name="receiver_name" placeholder="Họ và Tên" 
               value="<?= isset($_SESSION['userInfo']) ? $_SESSION['userInfo']['fullname'] : '' ?>" required>
               
        <label class="form-label">Số điện thoại</label>
        <input type="tel" class="form-control mb-2" name="receiver_mobile" placeholder="Số điện thoại" 
               pattern="[0-9]{10,11}" title="Số điện thoại phải có 10-11 chữ số"
               value="<?= isset($_SESSION['userInfo']) ? $_SESSION['userInfo']['mobile'] : '' ?>" required>
               
        <label class="form-label">Email</label>
        <input type="email" class="form-control mb-2" name="email" placeholder="Email" 
               value="<?= isset($_SESSION['userInfo']) ? $_SESSION['userInfo']['email'] : '' ?>" required>
               
        <div class="checkout-title mt-4">Thông tin địa chỉ</div>
        <label class="form-label">Địa chỉ nhận hàng</label>
        <input type="text" class="form-control mb-2" name="receiver_address" placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required>
        
        <label class="form-label">Ghi Chú</label>
        <textarea class="form-control mb-2" rows="3" name="note" placeholder="Ghi chú cho đơn hàng (không bắt buộc)"></textarea>
      </div>
      <!-- Thanh toán + tổng tiền -->
      <div class="checkout-center">
        <div class="checkout-title">Phương thức thanh toán</div>
        <div class="pay-method">
          <img src="../public/img/m.jpg" style="height:28px;"> 
          <input type="radio" name="payment_method" value="COD" checked> 
          <label>Thanh toán tiền mặt khi nhận hàng</label>
        </div>
        <div class="pay-method">
          <img src="../public/img/b.jpg" style="height:28px;"> 
          <input type="radio" name="payment_method" value="VNPay"> 
          <label>VN Pay</label>
        </div>
        <div class="pay-method">
          <img src="../public/img/n.jpg" style="height:28px;"> 
          <input type="radio" name="payment_method" value="ApplePay"> 
          <label>Apple Pay</label>
        </div>
        
        <div class="d-flex justify-content-between mb-2 mt-4">
          <span class="summary-label">Tổng tiền hàng</span>
          <span class="summary-value"><?= number_format($totalPrice, 0, ',', '.') ?>đ</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="summary-label">Phí vận chuyển</span>
          <span class="summary-value">0đ</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="summary-label">Tổng thanh toán</span>
          <span class="summary-total"><?= number_format($totalPrice, 0, ',', '.') ?>đ</span>
        </div>
        <div class="mb-2" style="font-size:13px;color:#888;">
          Nhấn "Đặt hàng" đồng nghĩa với việc bạn đồng ý và tuân theo <a href="#" style="color:#388e1c;">Điều khoản Aura Beauty</a>
        </div>
        <button class="btn-order mt-2" type="submit">ĐẶT HÀNG</button>
      </div>
      <!-- Giỏ hàng -->
      <div class="checkout-right">
        <div class="cart-box">
          <div class="cart-title">Giỏ hàng của bạn</div>
          <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
              <div class="cart-row">
                <img src="<?= $item['image'] ?>" class="cart-img" alt="<?= htmlspecialchars($item['name']) ?>">
                <div class="cart-info">
                  <div class="cart-name"><?= htmlspecialchars($item['name']) ?></div>
                  <div class="cart-qty">
                    <span>Số lượng: <?= $item['quantity'] ?></span>
                  </div>
                </div>
                <div class="cart-price"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>Giỏ hàng trống</p>
          <?php endif; ?>
        </div>
      </div>
    </form>
  </div>
</div>
</body>
</html>